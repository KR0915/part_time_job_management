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
        // 出勤情報を取得
        $submittedTimesheets = $this->SubmittedTimesheet->find('all', array(
            'conditions' => array(
                'SubmittedTimesheet.part_time_worker_id' => $workerId,
            ),
            'fields' => array('SubmittedTimesheet.date')
        ));

        // 日付のみの配列を作成
        $submittedDates = Hash::extract($submittedTimesheets, '{n}.SubmittedTimesheet.date');

        // ビューにデータを渡す
        $this->set(compact('submittedDates', 'workerId'));
    }

    public function editSubmittedTimesheet($workerId, $date) {
        // 出勤情報を取得
        $submittedTimesheet = $this->SubmittedTimesheet->find('first', array(
            'conditions' => array(
                'SubmittedTimesheet.part_time_worker_id' => $workerId,
                'SubmittedTimesheet.date' => $date
            )
        ));
    
        // POSTまたはPUTリクエストの場合、データを保存
        if ($this->request->is(array('post', 'put'))) {
            // 既存のデータがある場合、そのIDを設定
            if (!empty($submittedTimesheet)) {
                $this->SubmittedTimesheet->id = $submittedTimesheet['SubmittedTimesheet']['id'];
            } else {
                $this->SubmittedTimesheet->create();
            }
    
            // リクエストデータにworkerIdとdateを設定
            $this->request->data['SubmittedTimesheet']['part_time_worker_id'] = $workerId;
            $this->request->data['SubmittedTimesheet']['date'] = $date;
    
            // 時間フィールドをY-m-d H:i:s形式に変換して保存
            if (!empty($this->request->data['SubmittedTimesheet']['check_in'])) {
                $this->request->data['SubmittedTimesheet']['check_in'] = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->request->data['SubmittedTimesheet']['check_in']));
            }
            if (!empty($this->request->data['SubmittedTimesheet']['check_out'])) {
                $this->request->data['SubmittedTimesheet']['check_out'] = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->request->data['SubmittedTimesheet']['check_out']));
            }
            if (!empty($this->request->data['SubmittedTimesheet']['break_start'])) {
                $this->request->data['SubmittedTimesheet']['break_start'] = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->request->data['SubmittedTimesheet']['break_start']));
            }
            if (!empty($this->request->data['SubmittedTimesheet']['break_end'])) {
                $this->request->data['SubmittedTimesheet']['break_end'] = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->request->data['SubmittedTimesheet']['break_end']));
            }
    
            // データを保存
            if ($this->SubmittedTimesheet->validates()) {
                if ($this->SubmittedTimesheet->save($this->request->data)) {
                    $this->Session->setFlash(__('出勤情報が更新されました。'));
                    return $this->redirect(array('action' => 'submitTimesheet', $workerId));
                }
                $this->Flash->error(__('出勤情報の更新に失敗しました。もう一度お試しください。'));
            } else {
                $this->Flash->error(__('バリデーションエラーがあります。もう一度お試しください。'));
            }
        }
    
        // 初期データをフォームに設定
        if (!$this->request->data) {
            if (!empty($submittedTimesheet)) {
                // 時間フィールドをHH:MM形式に変換
                $submittedTimesheet['SubmittedTimesheet']['check_in'] = !empty($submittedTimesheet['SubmittedTimesheet']['check_in']) ? (new DateTime($submittedTimesheet['SubmittedTimesheet']['check_in']))->format('H:i') : '';
                $submittedTimesheet['SubmittedTimesheet']['check_out'] = !empty($submittedTimesheet['SubmittedTimesheet']['check_out']) ? (new DateTime($submittedTimesheet['SubmittedTimesheet']['check_out']))->format('H:i') : '';
                $submittedTimesheet['SubmittedTimesheet']['break_start'] = !empty($submittedTimesheet['SubmittedTimesheet']['break_start']) ? (new DateTime($submittedTimesheet['SubmittedTimesheet']['break_start']))->format('H:i') : '';
                $submittedTimesheet['SubmittedTimesheet']['break_end'] = !empty($submittedTimesheet['SubmittedTimesheet']['break_end']) ? (new DateTime($submittedTimesheet['SubmittedTimesheet']['break_end']))->format('H:i') : '';
                $this->request->data = $submittedTimesheet;
            }
        }
    
        $submittedTimesheetId = !empty($submittedTimesheet) ? $submittedTimesheet['SubmittedTimesheet']['id'] : null;
        $this->set(compact('workerId', 'submittedTimesheetId', 'date'));
    }

    public function deleteSubmittedTimesheet($workerId, $date) {
        if ($this->request->is('post')) {
            // 日付形式のsubmittedTimesheetIdを使用して出勤簿を取得
            $submittedTimesheet = $this->SubmittedTimesheet->find('first', array(
                'conditions' => array(
                    'SubmittedTimesheet.part_time_worker_id' => $workerId,
                    'SubmittedTimesheet.date' => $date
                )
            ));
    
            if ($submittedTimesheet) {
                // 出勤簿が存在する場合、削除を実行
                if ($this->SubmittedTimesheet->delete($submittedTimesheet['SubmittedTimesheet']['id'])) {
                    $this->Flash->success(__('出勤簿が削除されました。'));
                } else {
                    $this->Flash->error(__('出勤簿の削除に失敗しました。'));
                }
            } else {
                $this->Flash->error(__('指定された出勤簿が見つかりません。'));
            }
        }
        return $this->redirect(array('controller' => 'Attendances', 'action' => 'calendar', $workerId));
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