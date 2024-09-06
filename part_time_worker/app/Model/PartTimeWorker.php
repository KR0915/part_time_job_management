<?php
// app/Model/PartTimeWorker.php
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class PartTimeWorker extends AppModel {
    public $hasMany = array('Attendance');
    public $validate = array(
        'name' => array(
            'rule' => 'notBlank'
        ),
        'email' => array(
            'rule' => 'notBlank'
        ),
        'password' => array(
            'rule' => 'notBlank'
        )
    );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}