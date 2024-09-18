<?php
App::uses('AppController', 'Controller');

class ConfirmedTimesheetsController extends AppController {
    public $helpers = array('Form');
    public $uses = array('ConfirmedTimesheet', 'SubmittedTimesheet','PartTimeWorker'); // モデルを使用

    public function index() {
        // デフォルトは現在の年と月
        $year = $this->request->query('year') ?: date('Y');
        $month = $this->request->query('month') ?: date('m');

        // 選択された年と月の日付を計算
        $selectedDate = new DateTime("$year-$month-01");

        // 選択された月の最初の日と最後の日を取得
        $firstDayOfMonth = $selectedDate->format('Y-m-01');
        $lastDayOfMonth = $selectedDate->format('Y-m-t');

        // 月名を取得
        $monthName = $selectedDate->format('F Y');

        // ログインしているユーザーのIDを取得
        $userId = $this->Auth->user('id');

        // ログインしているユーザーのその月の出勤開始時間と終了時間を取得
        $confirmData = $this->ConfirmedTimesheet->find('all', array(
            'conditions' => array(
                'ConfirmedTimesheet.part_time_worker_id' => $userId,
                'ConfirmedTimesheet.date >=' => $firstDayOfMonth,
                'ConfirmedTimesheet.date <=' => $lastDayOfMonth
            )
        ));

        // カレンダーのデータをビューに渡す
        $this->set(compact('firstDayOfMonth', 'lastDayOfMonth', 'monthName', 'year', 'month','confirmData'));
    }

    public function edit($year, $month, $day) {
        // 指定された日付の勤怠データを取得
        $date = "$year-$month-$day";
        $timesheet = $this->SubmittedTimesheet->find('all', array(
            'conditions' => array(
                'SubmittedTimesheet.date' => $date,
            ),
            'contain' => array('PartTimeWorker', 'ConfirmedTimesheet') // PartTimeWorkerとConfirmedTimesheetのデータを含める
        ));
        $confirmedData=$this->ConfirmedTimesheet->find('all',array(
            'conditions'=>array('ConfirmedTimesheet.date'=>$date),
            'contain' => array('PartTimeWorker','SubmittedTimesheet')
        ));

        // ビューにデータを渡す
        $this->set(compact('timesheet', 'date','confirmedData'));
    }

    public function save($date=null) {
        if ($this->request->is('post')) {
            if (!$date) {
                $date = $this->request->data['ConfirmedTimesheet'][array_key_first($this->request->data['ConfirmedTimesheet'])]['date'];
            }
            $this->ConfirmedTimesheet->deleteAll(array('ConfirmedTimesheet.date' => $date));
            $data = $this->request->data['ConfirmedTimesheet'];
            $newData = isset($this->request->data['NewConfirmedTimesheet']) ? $this->request->data['NewConfirmedTimesheet'] : null;
            $date = isset($newData['date']) ? $newData['date'] : null;

            // 既存の勤怠データの保存
            foreach ($data as $submittedTimesheetId => $confirmedData) {
                if (!empty($confirmedData['confirmed'])) {
                    $this->ConfirmedTimesheet->create();
                    $this->ConfirmedTimesheet->save(array(
                        'submitted_timesheet_id' => $submittedTimesheetId,
                        'part_time_worker_id' => $confirmedData['part_time_worker_id'],
                        'date' => $confirmedData['date'],
                        'check_in' => $confirmedData['check_in'],
                        'check_out' => $confirmedData['check_out'],
                        'break_start' => $confirmedData['break_start'],
                        'break_end' => $confirmedData['break_end'],
                        'submitted_timesheet_id' => $confirmedData['submitted_timesheet_id'],
                        'confirmed' => 1
                    ));
                }
            }
            $this->Flash->success('勤怠データが保存されました。');
            // $dateから年と月を取得
            $date = $this->request->data['ConfirmedTimesheet'][array_key_first($this->request->data['ConfirmedTimesheet'])]['date'];
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));

            // リダイレクト
            return $this->redirect(array('controller' => 'confirmedTimesheets', 'action' => 'index', '?' => array('year' => $year, 'month' => $month)));
        }
    }
}