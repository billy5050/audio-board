<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class UsersController extends AppController {   
    public function login() {
        $this->render('/Board/SignIn'); // ログインページを表示
    }
          
    public function logout() {
        // ログアウト処理
        $this->Auth->logout();
        $this->Session->delete('Auth.User');
        $this->Session->destroy();
        
        // ログアウト後に明示的にログイン画面にリダイレクト
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
    
}