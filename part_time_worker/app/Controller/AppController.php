<?php
// app/Controller/AppController.php
class AppController extends Controller {
    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'attendances', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'part_time_workers', 'action' => 'login'),
            'loginAction' => array('controller' => 'part_time_workers', 'action' => 'login'), // ログインURLを正しいものに設定
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish',
                    'fields' => array(
                        'username' => 'email',
                        'password' => 'password'
                    )
                )
            )
        )
    );

    public function beforeFilter() {
        $this->Auth->allow('login', 'add');
    }
}