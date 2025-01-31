<?php
App::uses('AppModel', 'Model');

class Tag extends AppModel {
    public $hasAndBelongsToMany = [
        'Thread' => [
            'className' => 'Thread',
            'joinTable' => 'threads_tags',
            'foreignKey' => 'tag_id',
            'associationForeignKey' => 'thread_id',
            'unique' => true
        ]
    ];
}