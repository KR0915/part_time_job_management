<?php
App::uses('AppController', 'Controller');

class ManagersController extends AppController {
    public $components = array(
        'Session',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'Manager',
                    'fields' => array(
                        'username' => 'email',
                        'password' => 'password'
                    )
                )
            ),
            'loginRedirect' => array('controller' => 'managers', 'action' => 'dashboard'),
            'logoutRedirect' => array('controller' => 'managers', 'action' => 'login'),
            'authError' => 'You must be logged in to view this page.',
            'loginError' => 'Invalid email or password, try again.'
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'logout');
    }

    public function login() {
        if ($this->request->is('post')) {
            $email = $this->request->data['Manager']['email'];
            $password = $this->request->data['Manager']['password'];

            // デバッグ用ログ出力
            CakeLog::write('debug', 'Email: ' . $email);

            $manager = $this->Manager->find('first', array(
                'conditions' => array(
                    'Manager.email' => $email,
                    'Manager.password' => $password
                )
            ));

            if (!empty($manager)) {
                // ログイン成功
                $this->Auth->login($manager['Manager']);
                return $this->redirect(array('controller' => 'managers', 'action' => 'dashboard',$manager['Manager']['id']));
            } else {
                // ログイン失敗
                $this->Flash->error(__('Invalid email or password, try again'));
            }
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function dashboard($manager_id) {
        if (!$manager_id) {
            throw new NotFoundException(__('Invalid manager'));
        }

        // ダッシュボードのロジックをここに追加
        $this->set('manager_id', $manager_id);
    }

    public function index() {
        // インデックスページのロジックをここに追加
    }
}