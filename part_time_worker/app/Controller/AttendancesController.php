<?php
class AttendancesController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'add'); // インデックスと追加アクションを許可
    }

    public function index($workerId) {
        if ($workerId === null) {
            $workerId = $this->Auth->user('id'); // ログインしているユーザーのIDを取得
            return $this->redirect(array('action' => 'index', $workerId)); // ユーザーIDをURLに追加してリダイレクト
        }
        $this->set('workerId', $workerId); // ビューにユーザーIDを渡す
        $this->set('attendances', $this->Attendance->find('all'));
    }

    public function checkIn($workerId) {
        $this->Attendance->create();
        $this->Attendance->save(array(
            'Attendance' => array(
                'part_time_worker_id' => $workerId,
                'check_in' => date('Y-m-d H:i:s')
            )
        ));
        $this->Flash->success(__('Checked in successfully.'));
        return $this->redirect(array('action' => 'index', $workerId));
    }

    public function checkOut($workerId) {
        $attendance = $this->Attendance->find('first', array(
            'conditions' => array(
                'Attendance.part_time_worker_id' => $workerId,
                'Attendance.check_out' => null
            ),
            'order' => array('Attendance.check_in' => 'DESC')
        ));
        if ($attendance) {
            $attendance['Attendance']['check_out'] = date('Y-m-d H:i:s');
            $this->Attendance->save($attendance);
            $this->Flash->success(__('Checked out successfully.'));
        } else {
            $this->Flash->error(__('No check-in record found.'));
        }
        return $this->redirect(array('action' => 'index', $workerId));
    }

    public function break() {
        // 休憩処理をここに記述
        $this->Flash->success(__('Break started successfully.'));
        return $this->redirect(array('action' => 'index', $workerId));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Attendance->create();
            if ($this->Attendance->save($this->request->data)) {
                $this->Flash->success(__('The attendance has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to add the attendance.'));
        }
        $partTimeWorkers = $this->Attendance->PartTimeWorker->find('list');
        $this->set(compact('partTimeWorkers'));
    }
}