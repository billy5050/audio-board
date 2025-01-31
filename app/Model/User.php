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
    
}