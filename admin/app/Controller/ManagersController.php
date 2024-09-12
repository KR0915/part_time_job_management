<?php
App::uses('AppController', 'Controller');

class ManagersController extends AppController {
    public $helpers = array('Html', 'Form');
    public $uses = array('Manager', 'Company'); // ManagerとCompanyモデルをロード

    public function index() {
        $managers = $this->Manager->find('all');
        $companies = $this->Company->find('list', array(
            'fields' => array('id', 'name')
        ));

        // 各マネージャーに会社名を追加
        foreach ($managers as &$manager) {
            $companyId = $manager['Manager']['company_id'];
            $manager['Manager']['company_name'] = isset($companies[$companyId]) ? $companies[$companyId] : 'N/A';
        }

        $this->set(compact('managers'));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Manager->create();
            if ($this->Manager->save($this->request->data)) {
                $this->Flash->success(__('The manager has been saved.'));
                return $this->redirect(array('action' => 'index', 'admin' => true));
            }
            $this->Flash->error(__('Unable to add the manager.'));
        }

        // Companiesリストを取得してビューに渡す
        $companies = $this->Company->find('list');
        $this->set(compact('companies'));
    }

    public function edit($id = null) {
        $companies = $this->Company->find('list', array(
            'fields' => array('Company.id', 'Company.name')
        ));
        $this->set(compact('companies'));
        
        if (!$id) {
            throw new NotFoundException(__('Invalid company'));
        }

        $manager = $this->Manager->findById($id);
        if (!$manager) {
            throw new NotFoundException(__('Invalid company'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->Manager->id = $id;
            if ($this->Manager->save($this->request->data)) {
                $this->Flash->success(__('Your company has been updated.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to update your company.'));
        }

        if (!$this->request->data) {
            $this->request->data = $manager;
        }
    }
}