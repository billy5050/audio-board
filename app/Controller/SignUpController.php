<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class SignUpController extends AppController {
    public function about() {
        $this->autoLayout = false;
        $this->render('/Board/Signup');
    }

    public function SignUp() {
        if ($this->request->is('post')) {
            $dataSource = $this->User->getDataSource();
            $dataSource->begin();//トランザクション開始
            debug($this->request->data);//データベースデバック
            
            $this->User->create();
            $Pass = $this->request->data['User']['password'];
            $comfPass = $this->request->data['User']['confirm_password'];
            
            if ($Pass === $comfPass) {
                if ($this->User->save($this->request->data)) {
                    $dataSource->commit();//トランザクションをコミット
                    $this->Session->setFlash('データが正常に保存されました！');
                    $this->redirect(['controller' => 'SignIn', 'action' => 'index']);
                } else {
                    $dataSource->rollback();//保存のエラー時ロールバック
                    $this->Session->setFlash('データの保存に失敗しました。');
                }
            }else {
                $dataSource->rollback();//パスワード不一致時ロールバック
                $this->Session->setFlash('パスワードが一致しませんでした。もう一度入力してください。');
            }
        }
    }
}
