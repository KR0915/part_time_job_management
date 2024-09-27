<?php
// app/Controller/PartTimeWorkersController.php
class PartTimeWorkersController extends AppController {
    public $uses = array('PartTimeWorker', 'Attendance','Company'); // 使用するモデルを指定

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
            $companyStatus = $this->Company->find('first', array(
                'fields' => array('Company.status'),
                'conditions' => array(
                    'Company.id' => $worker['PartTimeWorker']['company_id'],
                )
            ));
            
            
            if ($worker && $companyStatus['Company']['status'] == 'active') {
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
        $this->Auth->logout();
        $this->Session->setFlash(__('You have been logged out.'));
        return $this->redirect('/part_time_workers/login');
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

    public function workHistory($workerId) {
        $this->log('workHistoryアクションが呼び出されました。', 'debug');
        $this->log('workerId: ' . $workerId, 'debug');
        // 必要なデータを取得してビューに渡す
        $this->set('workerId', $workerId);
        $this->set('attendances', $this->Attendance->find('all', array(
            'conditions' => array(
                'Attendance.part_time_worker_id' => $workerId,
                'Attendance.check_in >=' => date('Y-m-01'), // 今月の初日
                'Attendance.check_in <=' => date('Y-m-t')   // 今月の最終日
            ),
            'order' => array('Attendance.check_in' => 'ASC') // 日付を降順で取得
        )));
        $this->log('attendances: ' . print_r($attendances, true), 'debug');
    }
}
