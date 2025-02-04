<?php
App::uses('AppModel', 'Model');

class Thread extends AppModel {
    public $actsAs = ['Containable'];
    public $hasAndBelongsToMany = [
        'Tag' => [
            'className' => 'Tag',
            'joinTable' => 'threads_tags',
            'foreignKey' => 'thread_id',
            'associationForeignKey' => 'tag_id',
            'unique' => true
        ]
    ];
    
    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'created_by'
        ]
    ];
    
    public $hasMany = [
        'Post' => [
            'className' => 'Post',
            'foreignKey' => 'thread_id',
            //'dependent' => true // スレッド削除時に関連投稿も削除する場合
        ]
    ];
}