<?php
class SubmittedTimesheet extends AppModel {
    public $name = 'SubmittedTimesheet';
    public $belongsTo = array('PartTimeWorker');

    public $validate = array(
        'check_in' => array(
            'rule' => 'notBlank',
            'message' => '出勤時間を入力してください。'
        ),
        'check_out' => array(
            'rule' => 'notBlank',
            'message' => '退勤時間を入力してください。'
        ),
        'check_times' => array(
            'rule' => array('validateTimes'),
            'message' => '時間の順序が正しくありません。'
        )
    );

    public function validateTimes($check) {
        $checkIn = isset($this->data[$this->alias]['check_in']) ? strtotime($this->data[$this->alias]['check_in']) : null;
        $checkOut = isset($this->data[$this->alias]['check_out']) ? strtotime($this->data[$this->alias]['check_out']) : null;
        $breakStart = isset($this->data[$this->alias]['break_start']) ? strtotime($this->data[$this->alias]['break_start']) : null;
        $breakEnd = isset($this->data[$this->alias]['break_end']) ? strtotime($this->data[$this->alias]['break_end']) : null;
        debug($checkIn);
        debug($checkOut);
        // 出勤時間と退勤時間の順序をチェック
        if ($checkIn >= $checkOut) {
            return false;
        }

        // 休憩開始時間と休憩終了時間の順序をチェック
        if ($breakStart >= $breakEnd) {
            return false;
        }

        // 出勤時間と休憩開始時間の順序をチェック
        if ($checkIn <= $breakStart) {
            return false;
        }

        // 休憩終了時間と退勤時間の順序をチェック
        if ($breakEnd <= $checkOut) {
            return false;
        }

        if ($breakEnd >= $checkIn) {
            return false;
        }

        if ($breakStart >= $checkOut) {
            return false;
        }

        return true;
    }
}