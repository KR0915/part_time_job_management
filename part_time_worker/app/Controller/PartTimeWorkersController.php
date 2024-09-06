<?php
// app/Controller/PartTimeWorkersController.php
class PartTimeWorkersController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'add');
    }

    public function login() {

        $this->layout = 'login';

        if ($this->request->is('post')) {
            $email = $this->request->data['PartTimeWorker']['email'];
            $password = $this->request->data['PartTimeWorker']['password'];

            $hashedPassword = Security::hash($password, 'blowfish', false);
            
            // PartTimeWorkerモデルを使用してemailとpasswordを確認
            $worker = $this->PartTimeWorker->find('first', array(
                'conditions' => array(
                    'PartTimeWorker.email' => $email,
                    'PartTimeWorker.password' => $password
                )
            ));
            
            if ($worker) {
                // ログイン成功時のリダイレクト先を指定
                $this->Auth->login($worker['PartTimeWorker']);
                $workerId = $worker['PartTimeWorker']['id'];
                return $this->redirect(array('controller' => 'attendances', 'action' => 'index', $workerId));
            } else {
                $this->Session->setFlash(__('Invalid email or password, try again'), 'default', array('class' => 'error'));
            }
        }
        // 明示的にビューをレンダリング
        $this->render('login');
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    
    public function index() {
        $this->set('partTimeWorkers', $this->PartTimeWorker->find('all'));
    }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid part-time worker'));
        }

        $partTimeWorker = $this->PartTimeWorker->findById($id);
        if (!$partTimeWorker) {
            throw new NotFoundException(__('Invalid part-time worker'));
        }
        $this->set('partTimeWorker', $partTimeWorker);
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->PartTimeWorker->create();
            if ($this->PartTimeWorker->save($this->request->data)) {
                $this->Flash->success(__('The part-time worker has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to add the part-time worker.'));
        }
    }
}
