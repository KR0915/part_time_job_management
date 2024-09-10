<?php
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class AdminsController extends AppController {
    public function login() {
        if ($this->request->is('post')) {
            $email = $this->request->data['Admin']['email'];
            $password = $this->request->data['Admin']['password'];
            $passwordHasher = new BlowfishPasswordHasher();

            // デバッグ用ログ出力
            CakeLog::write('debug', 'Email: ' . $email);

            $adminUser = $this->Admin->find('first', array(
                'conditions' => array(
                    'Admin.email' => $email,
                    'Admin.password' => $password
                )
            ));

            if (!empty($adminUser)) {
                // ログイン成功
                $this->Session->write('Auth.Admin', $adminUser['Admin']);
                return $this->redirect(array('controller' => 'admins', 'action' => 'index'));
            } else {
                // ログイン失敗
                $this->Flash->error(__('Invalid email or password, try again'));
            }
        }
    }

    public function logout() {
        $this->Auth->logout();
        $this->Session->setFlash(__('You have been logged out.'));
        return $this->redirect('/part_time_workers/login');
    }

    public function index() {
        // Your code here
    }
}