<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class BoardController extends AppController {
    
    public function index() {
        $this->autoLayout = false;
        $this->render('/Board/SignIn');
    }
    
    public function top() {
        $userName = !empty($this->Auth->user('user_name')) ? $this->Auth->user('user_name') : 'ゲスト';
        
        $latestThreads = $this->_getThreads('latest');
        $popularThreads = $this->_getThreads('popular');
         
        $latestLists = [];
        foreach($latestThreads as $thread){            
            array_push($latestLists, $this->_getThreadsCounts($thread['Thread']['id']));
        }
        
        $popularLists = [];
        foreach($popularThreads as $thread){
            array_push($popularLists, $this->_getThreadsCounts($thread['Thread']['id']));
        }
        $formData = $this->_getFormData();        
        $tags = $this->Thread->Tag->find('list', [
            'fields' => ['Tag.id', 'Tag.name'],
            'order' => ['Tag.id' => 'ASC']
        ]);
        $userLists = $this->User->find('all');
        $this->set(array_merge(compact('latestThreads', 'popularThreads', 'latestLists', 'popularLists', 'userName', 'userLists', 'tags'), $formData));
        $this->render('/Board/Top');
    }
    
    public function contact() {
        if ($this->request->is('post')) {
            $userId = $this->Auth->user('id');
            $dataSource = $this->Contact->getDataSource();
            //トランザクション開始
            $dataSource->begin();
            
            try {
                $this->Contact->create();
                $this->request->data['Contact']['user_id'] = $userId;
                
                if ($this->Contact->save($this->request->data)) {
                    //トランザクションをコミット
                    $dataSource->commit();
                    $this->Session->setFlash('データが正常に送信されました！');
                    $this->redirect(['controller' => 'Board', 'action' => 'contactForm']);
                } else {
                    //保存のエラー時ロールバック
                    $dataSource->rollback();
                    $this->Session->setFlash('データの送信に失敗しました。');
                }
            } catch (Exception $e) {
                //保存のエラー時ロールバック
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }
    }
    
    public function contactForm() {
        $this->render('/Board/Contact');
    }
}