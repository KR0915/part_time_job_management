<?php
class ConfirmedTimesheet extends AppModel {
    public $name = 'ConfirmedTimesheet';
    public $belongsTo = array('PartTimeWorker');
}