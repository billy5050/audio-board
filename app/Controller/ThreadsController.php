<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class ThreadsController extends AppController {   
    public $components = array('Paginator');
    
    public function index() {
        $this->autoLayout = false;
        $formData = $this->_getFormData(); // フォームデータを設定
        $this->set($formData);
        $this->render('/Board/add');
    }
    
    public function search() {
        if ($this->request->is('post')) {
            $userName = !empty($this->Auth->user('user_name')) ? $this->Auth->user('user_name') : 'ゲスト';
            $keyword = trim($this->request->data['Thread']['keyword']);
            
            if (!empty($keyword)) {
                $conditions = [
                    'Thread.title LIKE' => '%' . mb_convert_kana($keyword, 's') . '%'
                    ,'Thread.invalid_flag' => '0'
                ];
                $results = $this->Thread->find('all', [
                    'conditions' => $conditions,
                    'order' => ['Thread.created_at' => 'DESC']
                ]);
                
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
                $userLists = $this->User->find('all');
                $formData = $this->_getFormData();
                $this->set(array_merge(compact('results', 'keyword', 'latestThreads', 'popularThreads', 'latestLists', 'popularLists', 'userName', 'userLists'), $formData));
                $this->render('/Board/Top');
            } else {
                return $this->redirect(['controller' => 'Threads', 'action' => 'allList']);
            }
        }
    }
    
    public function tagSearch($tagId = null) {
        if (!$tagId) {
            throw new NotFoundException(__('タグが見つかりません'));
        }
        
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
        
        $threads = $this->Thread->find('all', [
            'contain' => ['Tag'], // 関連するタグ情報を取得
            'joins' => [
                [
                    'table' => 'threads_tags',
                    'alias' => 'ThreadsTag',
                    'type' => 'INNER',
                    'conditions' => ['ThreadsTag.thread_id = Thread.id']
                ],
                [
                    'table' => 'tags',
                    'alias' => 'Tag',
                    'type' => 'INNER',
                    'conditions' => ['Tag.id = ThreadsTag.tag_id']
                ],
            ],
            'conditions' => ['Tag.id' => $tagId
                ,'Thread.invalid_flag' => '0'],
        ]);
        
        $userLists = $this->User->find('all');
        $tagName = $this->Thread->Tag->field('name', ['id' => $tagId]);
        $formData = $this->_getFormData();
        $this->set(array_merge(compact('threads', 'tagName', 'userName', 'userLists', 'latestThreads', 'popularThreads','latestLists', 'popularLists'), $formData));
        $this->render('/Board/Top');
    }
    
    public function mypage(){
        // ログイン中のユーザーIDを取得
        $userId = $this->Auth->user('id');
        if (!$userId) {
            $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        
        // 自分が作成したスレッド一覧を取得
        $myThreads = $this->Thread->find('all', [
            'conditions' => ['Thread.created_by' => $userId
                            ,'Thread.invalid_flag' => '0'
                            ],
            'order' => ['Thread.created_at' => 'DESC']
        ]);
        
        // 自分が投稿したコメント一覧を取得
        $myComments = $this->Post->find('all', [
            'conditions' => ['Post.created_by' => $userId
                            ,'Post.invalid_flag' => '0'
                            ],
            'order' => ['Post.created_at' => 'DESC'],
            'contain' => ['Thread']
        ]);
        
        // 検証中
        $userLists = $this->User->find('all');
        
        // データをビューに渡す
        $this->set(compact('myThreads', 'myComments', 'userLists'));
        $this->render('/Board/mypage');
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $userId = $this->Auth->user('id');// ユーザーがログインしている場合、ログインユーザーのidを取得
            $dataSource = $this->Thread->getDataSource();
            $dataSource->begin();//トランザクション開始
            try{
                $this->Thread->create();
                $this->request->data['Thread']['created_by'] = $userId;
                
                // Threadの保存
                if ($this->Thread->save($this->request->data)) {
                    // スレッド作成後、tags_threadsテーブルにタグIDを挿入
                    $threadId = $this->Thread->id; // 新しく作成されたスレッドのID
                    $tagIds = $this->request->data['Tags']['_ids']; // 選択されたタグIDの配列
                    
                    $tagsThreadsData = [];
                    foreach ($tagIds as $tagId) {
                        // tags_threadsにスレッドIDとタグIDを挿入
                        $tagsThreadsData[] = [
                            'thread_id' => $threadId,
                            'tag_id' => $tagId
                        ];
                    }                     
                    if ($this->Thread->ThreadsTag->saveAll($tagsThreadsData)) {
                        $dataSource->commit();
                        $this->Session->setFlash('スレッドが作成されました！');
                        echo'スレッドが作成されました！';
                        return $this->redirect(['controller' => 'Board', 'action' => 'top']);
                    }
                } else {
                throw new Exception('スレッドの保存に失敗しました。');
                }
            }catch (Exception $e){
                $dataSource->rollback();//保存のエラー時ロールバック
                $this->Session->setFlash($e->getMessage());
            }
        }
    }
    
    public function view($id = null) {
        if (!$id || !$this->Thread->exists($id)) {
            throw new NotFoundException(__('Invalid thread'));
        }
        // スレッドデータを取得
        $thread = $this->Thread->find('first', [
            'conditions' => ['Thread.id' => $id
                            ,'Thread.invalid_flag' => '0'],
            'contain' => [
                'User', // スレッド作成者の情報
                'Post' => ['User' // 各コメントの投稿者の情報も取得
                          ],
                'Tag'
            ]
        ]);
        $userLists = $this->User->find('all');
        $this->set(compact('thread', 'userLists'));
        $this->render('/Board/view');
    }
    
    public function viewCnt($id = null) {
        if (!$id || !$this->Thread->exists($id)) {
            throw new NotFoundException(__('Invalid thread'));
        }
        
        //閲覧数をカウントアップ   
        $this->Thread->updateAll(
            ['Thread.view_count' => 'Thread.view_count + 1'],
            ['Thread.id' => $id]
            );
        
        // スレッドデータを取得
        $thread = $this->Thread->find('first', [
            'conditions' => ['Thread.id' => $id
                            ,'Thread.invalid_flag' => '0'
                            ],
            'contain' => [
                'User', // スレッド作成者の情報
                'Post' => [
                    'User' // 各コメントの投稿者の情報も取得
                ],
                'Tag'
            ]
        ]);
        $userLists = $this->User->find('all');
        $this->set(compact('thread', 'userLists')); 
        $this->render('/Board/view');  
    }
    
    public function allList() {
        if (!empty($this->Auth->user('user_name'))) {
            $userName = $this->Auth->user('user_name');
        }else {
            $userName = 'ゲスト';
        }
        
        $this->Paginator->settings = array(
            'limit' => 10,  // 1ページあたりの表示件数
            'order' => array('Thread.created_at' => 'desc')  // 新しいスレッド順
        );
        
        $allThreads = $this->Paginator->paginate('Thread');
        $allLists = [];
        foreach($allThreads as $thread){
            array_push($allLists, $this->_getThreadsCounts($thread['Thread']['id']));
        }
        $userLists = $this->User->find('all');
        $this->set(compact('allThreads', 'allLists', 'userName', 'userLists'));
        $this->render('/Board/alllist');
    }
    
    public function comment() {
        if ($this->request->is('post')) {
            $userId = $this->Auth->user('id');// ユーザーがログインしている場合、ログインユーザーのidを取得
            $dataSource = $this->Post->getDataSource();
            $dataSource->begin();//トランザクション開始
            try{
                $this->Post->create();
                $data = $this->request->data;
                // 画像の処理
                if (!empty($data['Post']['image']['tmp_name'])) {
                    $file = $data['Post']['image'];
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $filename = uniqid() . '.' . $ext; // ユニークなファイル名を作成
                    $uploadPath = WWW_ROOT . 'img/uploads/' . $filename;
                    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                        $data['Post']['image_path'] = 'img/uploads/' . $filename; // DBにはパスのみ保存
                    }else{
                        debug("ファイルの移動に失敗しました: " . $uploadPath);
                        exit;
                    }
                }
                $data['Post']['created_by'] = $userId;
                
                $ngLists = Configure::read('NgLists');
                
                // 投稿内容から不適切ワードを置換
                foreach ($ngLists as $ngWord) {
                    if (stripos($data['Post']['content'], $ngWord) !== false) {
                        // NGワードを *** に置換
                        $data['Post']['content'] = str_ireplace($ngWord, '***', $data['Post']['content']);
                    }
                }
                
                // ループが終わった後に保存する
                if ($this->Post->save($data)) {
                    $dataSource->commit();
                    $this->Session->setFlash('コメントを投稿しました！');
                    // スレッドIDを取得し、viewメソッドにリダイレクト
                    $threadId = $this->request->data['Post']['thread_id'];
                    return $this->redirect(['controller' => 'Threads', 'action' => 'view', $threadId]);
                }
            }catch (Exception $e){
                $dataSource->rollback();//保存のエラー時ロールバック
                $this->Session->setFlash($e->getMessage());
            }
        }
    }
}