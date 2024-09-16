<?php
App::uses('AppController', 'Controller');

class PartTimeWorkersController extends AppController {
    public $uses = array('PartTimeWorker', 'Manager');

    public function index($manager_id) {
        // part_time_workersテーブルから全てのレコードを取得
        $partTimeWorkers = $this->PartTimeWorker->find('all');
        // ビューにデータを渡す
        $this->set('partTimeWorkers', $partTimeWorkers);
        $this->set('manager_id', $manager_id);
    }

    public function add($manager_id){
        // POSTメソッドの場合の処理
        if ($this->request->is('post')) {
            // データを保存
            $this->PartTimeWorker->create();
            if ($this->PartTimeWorker->save($this->request->data)) {
                $this->Flash->success(__('The part-time worker has been saved.'));
                return $this->redirect(array('action' => 'index', $manager_id));
            }
            $this->Flash->error(__('Unable to add the part-time worker.'));
        }

        $manager = $this->Manager->find('first', array(
            'fields' => array('company_id'),
            'conditions' => array('Manager.id' => $manager_id)
        ));
        $companyId = $manager['Manager']['company_id'];
        $this->set(compact('manager_id', 'companyId'));
    }

    public function edit($id = null, $manager_id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid part-time worker'));
        }

        $partTimeWorker = $this->PartTimeWorker->findById($id);
        if (!$partTimeWorker) {
            throw new NotFoundException(__('Invalid part-time worker'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->PartTimeWorker->id = $id;
            if ($this->PartTimeWorker->save($this->request->data)) {
                $this->Flash->success(__('The part-time worker has been updated.'));
                return $this->redirect(array('action' => 'index', $manager_id));
            }
            $this->Flash->error(__('Unable to update the part-time worker.'));
        }

        if (!$this->request->data) {
            $this->request->data = $partTimeWorker;
        }
        $this->set('manager_id', $manager_id);

        $manager = $this->Manager->find('first', array(
            'fields' => array('company_id'),
            'conditions' => array('Manager.id' => $manager_id)
        ));
        $companyId = $manager['Manager']['company_id'];
        $this->set(compact('manager_id', 'companyId'));
    }

    public function delete($id = null, $manager_id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid part-time worker'));
        }
    
        $this->request->allowMethod('post', 'delete');
    
        $partTimeWorker = $this->PartTimeWorker->findById($id);
        if (!$partTimeWorker) {
            throw new NotFoundException(__('Invalid part-time worker'));
        }
    
        if ($this->PartTimeWorker->delete($id)) {
            $this->Flash->success(__('The part-time worker with id: %s has been deleted.', h($id)));
        } else {
            $this->Flash->error(__('The part-time worker could not be deleted.'));
        }
    
        return $this->redirect(array('action' => 'index', $manager_id));
    }
}
