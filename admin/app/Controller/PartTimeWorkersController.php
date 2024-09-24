<?php
class PartTimeWorkersController extends AppController {
    public $uses = array('PartTimeWorker', 'Company', 'Manager', 'Admin');

    public function index() {
        $conditions = array();
    
        if ($this->request->is('post') || $this->request->is('get')) {
            $search = $this->request->query('search');
            if (!empty($search)) {
                $conditions['OR'] = array(
                    'PartTimeWorker.name LIKE' => '%' . $search . '%',
                    'PartTimeWorker.email LIKE' => '%' . $search . '%'
                );
            }
        }
    
        $this->set('partTimeWorkers', $this->PartTimeWorker->find('all', array(
            'conditions' => $conditions
        )));
    }

    public function add(){
        if($this->request->is('post')){
            $this->PartTimeWorker->create();
            if($this->PartTimeWorker->save($this->request->data)){
                $this->Flash->success(__('アルバイトを追加しました'));
                return $this->redirect(array('action'=>'index'));
            }
            $this->Flash->error(__('アルバイトの追加に失敗しました'));
        }

        $companies = $this->Company->find('list');
        $this->set(compact('companies'));
    }


    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('無効なパートタイムワーカー'));
        }

        $partTimeWorker = $this->PartTimeWorker->findById($id);
        if (!$partTimeWorker) {
            throw new NotFoundException(__('無効なパートタイムワーカー'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->PartTimeWorker->id = $id;
            if ($this->PartTimeWorker->save($this->request->data)) {
                $this->Flash->success(__('パートタイムワーカーが更新されました。'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('パートタイムワーカーの更新に失敗しました。もう一度お試しください。'));
        }

        if (!$this->request->data) {
            $this->request->data = $partTimeWorker;
        }

        $companies = $this->Company->find('list');
        $this->set(compact('companies'));
    }

    public function delete($id = null) {
        if (!$id) {
            throw new NotFoundException(__('無効なパートタイムワーカー'));
        }

        $this->request->allowMethod(['post', 'delete']);

        $partTimeWorker = $this->PartTimeWorker->findById($id);
        if (!$partTimeWorker) {
            throw new NotFoundException(__('無効なパートタイムワーカー'));
        }

        if ($this->PartTimeWorker->delete($id)) {
            $this->Flash->success(__('パートタイムワーカーが削除されました。'));
        } else {
            $this->Flash->error(__('パートタイムワーカーの削除に失敗しました。もう一度お試しください。'));
        }

        return $this->redirect(array('action' => 'index'));
    }
}
