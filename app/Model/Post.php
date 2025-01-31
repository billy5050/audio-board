<?php
App::uses('AppModel', 'Model');

class Post extends AppModel {
    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'created_by'
        ],
        'Thread' => [
            'className' => 'Thread',
            'foreignKey' => 'thread_id'
        ]
    ];
}