<?php
App::uses('AppModel', 'Model');
 
class User extends AppModel {
    public function beforeSave($options = []) {
        if (isset($this->data[$this->alias]['password'])) {
            // パスワードをハッシュ化
            $this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'], 'sha256', true);
            $this->data[$this->alias]['confirm_password'] = Security::hash($this->data[$this->alias]['confirm_password'], 'sha256', true);
        }
        return true;
    }
    public $hasMany = [
        'Thread' => [
            'className' => 'Thread',
            'foreignKey' => 'created_by'
        ],
        'Post' => [
            'className' => 'Post',
            'foreignKey' => 'created_by'
        ]
    ];
    
    public $validate = array(
        'email' => array(
            'rule' => 'email',
            'message' => '正しい形式で入力してください。'
        ),
        'password' => array(
            'rule' => array('minLength', '8'),
            'message' => '8文字以上で設定してください'
        ),
        
    );
    //検証中
//     public function afterSave($created, $options = array()) {
//         // 既存ユーザが更新された場合にのみチェックする
//         if (!$created && isset($this->data[$this->alias]['invalid_flag']) && $this->data[$this->alias]['invalid_flag'] == 1) {
//             // 現在のユーザーID（更新されたユーザーのID）
//             $userId = $this->id;
            
//             // Threadモデルと Postモデルを使用しているので、
//             // まずはロードする（もし自動で関連付けがない場合）
//             $this->Thread->updateAll(
//                 ['Thread.invalid_flag' => 1],
//                 ['Thread.created_by' => $userId]
//                 );
//             $this->Post->updateAll(
//                 ['Post.invalid_flag' => 1],
//                 ['Post.created_by' => $userId]
//                 );
//         }
//         return true;
//     }
}
