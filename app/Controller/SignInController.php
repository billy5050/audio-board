<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class SignInController extends AppController { 
    public function index() {
        $this->autoLayout = false;
        $this->render('/Board/SignIn');
    }
    
    public function SignIn() {
        if ($this->request->is('post')) {
            debug($this->request->data);
            $email = $this->request->data['User']['email'];
            $password = $this->request->data['User']['password'];
            
            // 入力されたパスワードをハッシュ化して比較
            $hashedPassword = Security::hash($password, 'sha256', true);
            $user = $this->User->find('first', [
                'conditions' => ['email' => $email, 'password' => $hashedPassword]
            ]);
            
            if ($user) {
                // 認証成功
                $this->Session->write('Auth.User', $user['User']);
                $this->Session->write('User.user_name', $user['User']['user_name']);
                $this->Session->setFlash('ログイン成功しました！');
                $this->redirect(['controller' => 'Board', 'action' => 'Top']);
                $popularThreads = $this->Thread->find('all', [
                    'order' => ['Thread.view_count' => 'DESC'],
                    'limit' => 5
                ]);
                if (!empty($popularThreads)) {
                    foreach ($popularThreads as $thread) {
                        echo h($thread['Thread']['title']);
                        // 他のスレッド情報を表示
                    }
                } else {
                    echo '<p>現在、人気スレッドはありません。</p>';
                }
            } else {
                // 認証失敗
                $this->Session->setFlash('ログインに失敗しました。メールアドレスまたはパスワードが間違っています。');
                $this->render('/Board/SignIn');
            }
        }
    }
}
