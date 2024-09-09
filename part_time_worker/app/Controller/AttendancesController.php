<?php
class AttendancesController extends AppController {
    public $uses = array('Attendance', 'SubmittedTimesheet', 'ConfirmedTimesheet');

    public function checkIn($workerId) {
        $this->Attendance->create();
        if ($this->Attendance->save(array(
            'Attendance' => array(
                'part_time_worker_id' => $workerId,
                'check_in' => date('Y-m-d H:i:s')
            )
        ))) {
            $this->Session->setFlash(__('Checked in successfully.'), 'default', array('class' => 'success'));
            return $this->redirect(array('controller' => 'attendances', 'action' => 'index', $workerId));
        } else {
            $this->Session->setFlash(__('Check-in failed.'), 'default', array('class' => 'error'));
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
            // 休憩開始時間が存在し、休憩終了時間が存在しない場合は退勤できない
            if (!empty($attendance['Attendance']['break_start']) && empty($attendance['Attendance']['break_end'])) {
                $this->Session->setFlash(__('Cannot check out while on break.'), 'default', array('class' => 'error'));
            } else {
                $this->Attendance->id = $attendance['Attendance']['id'];
                if ($this->Attendance->saveField('check_out', date('Y-m-d H:i:s'))) {
                    $this->Session->setFlash(__('Checked out successfully.'), 'default', array('class' => 'success'));
                } else {
                    $this->Session->setFlash(__('Check-out failed.'), 'default', array('class' => 'error'));
                }
            }
        } else {
            $this->Session->setFlash(__('No check-in record found.'), 'default', array('class' => 'error'));
        }
        return $this->redirect(array('controller' => 'attendances', 'action' => 'index', $workerId));
    }
    
    public function breakStart($workerId) {
        $attendance = $this->Attendance->find('first', array(
            'conditions' => array(
                'Attendance.part_time_worker_id' => $workerId,
                'Attendance.check_out' => null
            ),
            'order' => array('Attendance.check_in' => 'desc')
        ));
        if ($attendance) {
            $this->Attendance->id = $attendance['Attendance']['id'];
            if ($this->Attendance->saveField('break_start', date('Y-m-d H:i:s'))) {
                $this->Session->setFlash(__('Break started successfully.'), 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__('Break start failed.'), 'default', array('class' => 'error'));
            }
        } else {
            $this->Session->setFlash(__('No check-in record found to start break.'), 'default', array('class' => 'error'));
        }
        return $this->redirect(array('controller' => 'attendances', 'action' => 'index', $workerId));
    }

    public function breakEnd($workerId) {
        $attendance = $this->Attendance->find('first', array(
            'conditions' => array(
                'Attendance.part_time_worker_id' => $workerId,
                'Attendance.break_end' => null,
                'Attendance.break_start !=' => null
            ),
            'order' => array('Attendance.break_start' => 'desc')
        ));
        if ($attendance) {
            $this->Attendance->id = $attendance['Attendance']['id'];
            if ($this->Attendance->saveField('break_end', date('Y-m-d H:i:s'))) {
                $this->Session->setFlash(__('Break ended successfully.'), 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__('Break end failed.'), 'default', array('class' => 'error'));
            }
        } else {
            $this->Session->setFlash(__('No break record found to end.'), 'default', array('class' => 'error'));
        }
        return $this->redirect(array('controller' => 'attendances', 'action' => 'index', $workerId));
    }

    public function submitTimesheet($workerId) {
        $this->set('workerId', $workerId);
        if ($this->request->is('post')) {
            $data = $this->request->data['SubmittedTimesheet'];
            $data['part_time_worker_id'] = $workerId; // ルートから渡されたworkerIdを使用

            $this->log('Worker ID: ' . $workerId, 'debug');
            $this->log('Submitted Data: ' . print_r($data, true), 'debug');
    
            if ($this->SubmittedTimesheet->save($data)) {
                $this->Session->setFlash(__('出勤情報が保存されました。'), 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__('出勤情報の保存に失敗しました。'), 'default', array('class' => 'error'));
            }
        }
    }

    public function calendar($workerId) {
        $attendances = $this->Attendance->find('all', array(
            'conditions' => array('Attendance.part_time_worker_id' => $workerId)
        ));
        $confirmedTimesheets = $this->ConfirmedTimesheet->find('all', array(
            'conditions' => array('ConfirmedTimesheet.part_time_worker_id' => $workerId)
        ));
        $this->set(compact('attendances', 'confirmedTimesheets', 'workerId'));
    }
    
    public function index($workerId) {
        $today = date('Y-m-d');
        $this->set('workerId', $workerId);
        $this->set('attendances', $this->Attendance->find('all', array(
            'conditions' => array(
                'Attendance.part_time_worker_id' => $workerId,
                'DATE(Attendance.check_in)' => $today
            )
        )));
    }
}