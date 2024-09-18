<?php
class ConfirmedTimesheet extends AppModel {
    public $name = 'ConfirmedTimesheet';
    public $useTable = 'confirmed_timesheets'; // テーブル名を指定

    public $belongsTo = array(
        'SubmittedTimesheet' => array(
            'className' => 'SubmittedTimesheet',
            'foreignKey' => 'submitted_timesheet_id'
        ),
        'PartTimeWorker' => array(
            'className' => 'PartTimeWorker',
            'foreignKey' => 'part_time_worker_id'
        )
    );
}