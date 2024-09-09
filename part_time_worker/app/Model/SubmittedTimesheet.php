<?php
class SubmittedTimesheet extends AppModel {
    public $name = 'SubmittedTimesheet';
    public $belongsTo = array('PartTimeWorker');
}