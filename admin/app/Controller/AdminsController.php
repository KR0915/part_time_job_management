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

    public function list() {
        $conditions = array();

        if ($this->request->is('get') && !empty($this->request->query('name'))) {
            $conditions['Admin.username LIKE'] = '%' . $this->request->query('name') . '%';
        }

        $this->set('admins', $this->Admin->find('all', array(
            'conditions' => $conditions
        )));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Admin->create();
            if ($this->Admin->save($this->request->data)) {
                $this->Flash->success(__('The company has been saved.'));
                return $this->redirect(array('action' => 'list'));
            }
            $this->Flash->error(__('Unable to add the company.'));
        }
    }

    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid company'));
        }

        $admin = $this->Admin->findById($id);
        if (!$admin) {
            throw new NotFoundException(__('Invalid company'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->Admin->id = $id;
            if ($this->Admin->save($this->request->data)) {
                $this->Flash->success(__('Your company has been updated.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to update your company.'));
        }

        if (!$this->request->data) {
            $this->request->data = $admin;
        }
    }

    public function delete($id) {
        if ($this->request->is('post')) {
            if ($this->Admin->delete($id)) {
                $this->Flash->success(__('The company has been deleted.'));
            } else {
                $this->Flash->error(__('Unable to delete the company.'));
            }
            return $this->redirect(array('action' => 'list'));
        }
    }

    public function index() {
        // Your code here
    }
}