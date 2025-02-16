<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller', 'User');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $components = ['DebugKit.Toolbar','Session','Auth'];
    public $uses = ['User', 'Post', 'Thread', 'Tag', 'Contact'];
    
    public function beforeFilter() {
        parent::beforeFilter();
        Configure::load('ngLists');
//         debug(Configure::read('NgLists'));
        
        $this->Auth->authError = false;
        // 認証不要のアクションを許可
        $this->Auth->allow(['login', 'logout', 'SignIn', 'SignUp', 'top', 'display', 'about', 'view','viewCnt', 'alllist', 'search', 'tagSearch']);
        
    }
    
    public function _getFormData() {
        $genres = $this->Tag->find('list', [
            'conditions' => ['type' => 1], // 1 はジャンル
            'fields' => ['id', 'name']
        ]);
        $priceRanges = $this->Tag->find('list', [
            'conditions' => ['type' => 0], // 0 は価格帯
            'fields' => ['id', 'name']
        ]);
        
        $genresCounts = $this->Tag->find('all', [
            'conditions' => ['Tag.type' => 1],
            'fields' => [
                'Tag.id',
                'Tag.name',
                'COUNT(DISTINCT ThreadsTag.thread_id) AS thread_count'
            ],
            'joins' => [
                [
                    'table' => 'threads_tags',
                    'alias' => 'ThreadsTag',
                    'type' => 'LEFT',
                    'conditions' => ['ThreadsTag.tag_id = Tag.id']
                ],
                [
                    'table' => 'threads',
                    'alias' => 'Thread',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Thread.id = ThreadsTag.thread_id',
                        'Thread.invalid_flag' => 0
                    ]
                ],
                // INNER JOINに変更
                [
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'INNER',
                    'conditions' => [
                        'User.id = Thread.created_by',
                        'User.invalid_flag' => 0
                    ]
                ]
            ],
            'group' => ['Tag.id'],
            'order' => ['Tag.id' => 'ASC']
        ]);
        
        
        $priceCounts = $this->Tag->find('all', [
            'conditions' => ['Tag.type' => 0],
            'fields' => [
                'Tag.id',
                'Tag.name',
                'COUNT(DISTINCT ThreadsTag.thread_id) AS thread_count'
            ],
            'joins' => [
                [
                    'table' => 'threads_tags',
                    'alias' => 'ThreadsTag',
                    'type' => 'LEFT',
                    'conditions' => ['ThreadsTag.tag_id = Tag.id']
                ],
                [
                    'table' => 'threads',
                    'alias' => 'Thread',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Thread.id = ThreadsTag.thread_id',
                        'Thread.invalid_flag' => 0
                    ]
                ],
                // INNER JOINに変更
                [
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'INNER',
                    'conditions' => [
                        'User.id = Thread.created_by',
                        'User.invalid_flag' => 0
                    ]
                ]
            ],
            'group' => ['Tag.id'],
            'order' => ['Tag.id' => 'ASC']
        ]);
        
        
        $userLists = $this->User->find('all');
//         debug($genresCounts);
//         exit;
        // ジャンルと価格帯を統合して options を作成
        $options = $genres + $priceRanges;
        
        return compact('genres', 'priceRanges', 'genresCounts', 'priceCounts', 'userLists', 'options');
    }
    
    public function _getThreadsCounts($thread_id) {
        $threadCounts = $this->Post->find('all', [
            'fields' => [
                'Post.thread_id',
                'COUNT(Post.content) AS comment_count'
            ],
            'conditions' => [
                'Post.thread_id'    => $thread_id,
                'Post.invalid_flag' => 0  // Postが有効なもののみ
            ],
            'joins' => [
                [
                    'table'      => 'users',
                    'alias'      => 'PostUser',  // エイリアス名を変更
                    'type'       => 'INNER',
                    'conditions' => [
                        'PostUser.id = Post.created_by',
                        'PostUser.invalid_flag' => 0  // Userが有効なもののみ
                    ]
                ]
            ],
            'group' => ['Post.thread_id']
        ]);
        
        return $threadCounts;
    }
    
    
    public function _getThreads($type = 'latest', $limit = 5) {
        $conditions = [];
        $order = [];
        
        if ($type === 'latest') {
            $order = ['Thread.created_at' => 'DESC'];
        } elseif ($type === 'popular') {
            $order = ['Thread.view_count' => 'DESC'];
        }
        
        return $this->Thread->find('all', [
            'contain' => ['Tag'], // 関連するタグ情報を取得,
            'conditions' => ['invalid_flag' => '0'],
            'order' => $order,
            'limit' => $limit,
        ]);
    }
}
