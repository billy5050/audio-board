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
            try {
                $dataSource->begin(); // トランザクション開始
                $this->User->create();
                $Pass = $this->request->data['User']['password'];
                $comfPass = $this->request->data['User']['confirm_password'];
                
                if (empty($this->request->data['User']['email']) || empty($this->request->data['User']['user_name'])) {
                    throw new Exception('メールアドレス、またはユーザーネームを入力してください。');
                }
                
                if ($Pass !== $comfPass) {
                    throw new Exception('パスワードが一致しませんでした。もう一度入力してください。');
                }
                
                if (!$this->User->save($this->request->data)) {
                    throw new Exception('データの保存に失敗しました。');
                }
                
                $dataSource->commit(); // コミット
                $this->Session->setFlash('データが正常に保存されました！');
                return $this->redirect(['controller' => 'SignIn', 'action' => 'index']);
                
            } catch (PDOException $e) {
                $dataSource->rollback(); // エラー発生時はロールバック
                // 重複エラーの場合
                if ($e->getCode() == 23000) {
                    $this->Session->setFlash('このメールアドレスはすでに登録されています。');
                } else {
                    $this->Session->setFlash($e->getMessage());
                }
                return $this->render('/Board/Signup');
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
                return $this->render('/Board/Signup');
            }
        }
    }
    
}
