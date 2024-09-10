<?php
App::uses('AppController', 'Controller');

class CompaniesController extends AppController {
    public function index() {
        $this->set('companies', $this->Company->find('all'));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Company->create();
            if ($this->Company->save($this->request->data)) {
                $this->Flash->success(__('The company has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to add the company.'));
        }
    }

    public function delete($id) {
        if ($this->request->is('post')) {
            if ($this->Company->delete($id)) {
                $this->Flash->success(__('The company has been deleted.'));
            } else {
                $this->Flash->error(__('Unable to delete the company.'));
            }
            return $this->redirect(array('action' => 'index'));
        }
    }

    public function deactivate($id) {
        $this->Company->id = $id;
        if ($this->Company->saveField('status', 'inactive')) {
            $this->Flash->success(__('The company has been deactivated.'));
        } else {
            $this->Flash->error(__('Unable to deactivate the company.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
}