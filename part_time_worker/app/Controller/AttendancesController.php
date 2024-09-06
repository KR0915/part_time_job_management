<?php
class AttendancesController extends AppController {
    public function checkIn($workerId) {
        $this->Attendance->create();
        if ($this->Attendance->save(array(
            'Attendance' => array(
                'part_time_worker_id' => $workerId,
                'check_in' => date('Y-m-d H:i:s')
            )
        ))) {
            $this->Session->setFlash(__('Checked in successfully.'), 'default', array('class' => 'success'));
            // リダイレクト先を指定
            return $this->redirect(array('controller' => 'attendances', 'action' => 'index', $workerId));
        } else {
            $this->Session->setFlash(__('Check-in failed.'), 'default', array('class' => 'error'));
            // リダイレクト先を指定
            return $this->redirect(array('controller' => 'attendances', 'action' => 'index', $workerId));
        }
    }

    public function checkOut($workerId) {
        $attendance = $this->Attendance->find('first', array(
            'conditions' => array(
                'Attendance.part_time_worker_id' => $workerId,
                'Attendance.check_out' => null
            )
        ));
        if ($attendance) {
            $this->Attendance->id = $attendance['Attendance']['id'];
            if ($this->Attendance->saveField('check_out', date('Y-m-d H:i:s'))) {
                $this->Session->setFlash(__('Checked out successfully.'), 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__('Check-out failed.'), 'default', array('class' => 'error'));
            }
        } else {
            $this->Session->setFlash(__('No check-in record found.'), 'default', array('class' => 'error'));
        }
        // リダイレクト先を指定
        return $this->redirect(array('controller' => 'attendances', 'action' => 'index', $workerId));
    }
    
    public function break($workerId) {
        // 休憩の処理を追加
        $this->Session->setFlash(__('Break started successfully.'), 'default', array('class' => 'success'));
        // リダイレクト先を指定
        return $this->redirect(array('controller' => 'attendances', 'action' => 'index', $workerId));
    }

    public function index($workerId) {
        // 必要なデータを取得してビューに渡す
        $this->set('workerId', $workerId);
        $this->set('attendances', $this->Attendance->find('all', array(
            'conditions' => array('Attendance.part_time_worker_id' => $workerId)
        )));
    }
}