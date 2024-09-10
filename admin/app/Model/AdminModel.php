<?php
App::uses('Security', 'Utility');

class Admin extends AppModel {
    public $name = 'Admin';
    public $validate = array(
        'email' => array(
            'rule' => 'email',
            'message' => 'Please enter a valid email address'
        ),
        'password' => array(
            'rule' => 'notBlank',
            'message' => 'Please enter your password'
        )
    );
}