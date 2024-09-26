<?php
class AttendancesController extends AppController {
    public $uses = array('Attendance', 'PartTimeWorker', 'Manager');

    public function index() {
        $manager_id = $this->Auth->user('id');
        $company = $this->Manager->find('first', array(
            'fields' => array('company_id'),
            'conditions' => array('Manager.id' => $manager_id)
        ));
        $companyId = $company['Manager']['company_id'];
        $partTimeWorkers = $this->PartTimeWorker->find('all', array(
            'fields' => array('id'),
            'conditions' => array('PartTimeWorker.company_id' => $companyId)
        ));
        // パートタイムワーカーのIDを配列に変換
        $partTimeWorkerIds = Hash::extract($partTimeWorkers, '{n}.PartTimeWorker.id');
        // 年と月のパラメータを取得
        $year = isset($this->request->query['year']) ? $this->request->query['year'] : date('Y');
        $month = isset($this->request->query['month']) ? $this->request->query['month'] : date('m');
        $searchName = isset($this->request->query['search_name']) ? $this->request->query['search_name'] : '';

        // 月の最初と最後の日を取得
        $firstDayOfMonth = "$year-$month-01";
        $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

        // 検索条件を設定
        $conditions = array(
            'Attendance.check_in >=' => $firstDayOfMonth,
            'Attendance.check_out <=' => $lastDayOfMonth,
            'Attendance.part_time_worker_id' => $partTimeWorkerIds
        );
        if (!empty($searchName)) {
            $conditions['PartTimeWorker.name LIKE'] = '%' . $searchName . '%';
        }

        // AttendancesとPartTimeWorkersを結合してデータを取得
        $attendances = $this->Attendance->find('all', array(
            'fields' => array(
                'Attendance.*',
                'PartTimeWorker.name',
                'PartTimeWorker.hourly_wage'
            ),
            'conditions' => $conditions,
            'joins' => array(
                array(
                    'table' => 'part_time_workers',
                    'alias' => 'PartTimeWorker',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Attendance.part_time_worker_id = PartTimeWorker.id'
                    )
                )
            ),
            'order' => array('PartTimeWorker.name' => 'ASC')
        ));

        // 人ごとの勤怠データを整理し、合計出勤時間と給与を計算
        $workersData = [];
        foreach ($attendances as $attendance) {
            $workerId = $attendance['Attendance']['part_time_worker_id'];
            if (!isset($workersData[$workerId])) {
                $workersData[$workerId] = [
                    'name' => $attendance['PartTimeWorker']['name'],
                    'hourly_wage' => $attendance['PartTimeWorker']['hourly_wage'],
                    'attendances' => [],
                    'totalWorkDurationInHours' => 0,
                    'totalSalary' => 0
                ];
            }

            $checkIn = new DateTime($attendance['Attendance']['check_in']);
            $checkOut = new DateTime($attendance['Attendance']['check_out']);
            $breakStart = new DateTime($attendance['Attendance']['break_start']);
            $breakEnd = new DateTime($attendance['Attendance']['break_end']);

            // 勤務時間を計算（休憩時間を引く）
            $workDuration = $checkOut->diff($checkIn);
            $breakDuration = $breakEnd->diff($breakStart);
            $workDurationInHours = ($workDuration->h + $workDuration->i / 60) - ($breakDuration->h + $breakDuration->i / 60);

            // 給与を計算
            $salary = $workDurationInHours * $attendance['PartTimeWorker']['hourly_wage'];
            $attendance['Attendance']['salary'] = $salary;

            // 勤怠データを追加
            $workersData[$workerId]['attendances'][] = $attendance['Attendance'];
            $workersData[$workerId]['totalWorkDurationInHours'] += $workDurationInHours;
            $workersData[$workerId]['totalSalary'] += $salary;
        }

        $this->set(compact('workersData', 'year', 'month', 'searchName'));
    }
}