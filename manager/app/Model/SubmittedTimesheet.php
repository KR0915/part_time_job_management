<?php
App::uses('AppModel', 'Model');

class SubmittedTimesheet extends AppModel {
    public $name = 'SubmittedTimesheet';
    public $useTable = 'submitted_timesheets'; // テーブル名を指定

    public $belongsTo = array(
        'PartTimeWorker' => array(
            'className' => 'PartTimeWorker',
            'foreignKey' => 'part_time_worker_id'
        )
    );
        // 'ConfirmedTimesheet' => array(
        //     'className' => 'ConfirmedTimesheet',
        //     'foreignKey' => 'part_time_worker_id'
        // )
        public $hasOne = array(
            'ConfirmedTimesheet' => array(
                'className' => 'ConfirmedTimesheet',
                'foreignKey' => 'submitted_timesheet_id'
            )
        );
}