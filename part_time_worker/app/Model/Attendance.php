<?php
// app/Model/Attendance.php

class Attendance extends AppModel {
    public $belongsTo = array(
        'PartTimeWorker' => array(
            'className' => 'PartTimeWorker',
            'foreignKey' => 'part_time_worker_id'
        )
    );
}