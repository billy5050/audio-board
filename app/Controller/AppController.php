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
            'conditions' => ['type' => 1],
            'fields' => [
                'Tag.id',
                'Tag.name',
                'COUNT(ThreadsTag.thread_id) AS thread_count'
            ],
            'joins' => [
                [
                    'table' => 'threads_tags', // 中間テーブル
                    'alias' => 'ThreadsTag',
                    'type' => 'LEFT',
                    'conditions' => ['ThreadsTag.tag_id = Tag.id']
                ]
            ],
            'group' => ['Tag.id'], // タグごとに集計
            'order' => ['Tag.id' => 'ASC'] // 必要に応じて並び替え
        ]);
        $priceCounts = $this->Tag->find('all', [
            'conditions' => ['type' => 0],
            'fields' => [
                'Tag.id',
                'Tag.name',
                'COUNT(ThreadsTag.thread_id) AS thread_count'
            ],
            'joins' => [
                [
                    'table' => 'threads_tags', // 中間テーブル
                    'alias' => 'ThreadsTag',
                    'type' => 'LEFT',
                    'conditions' => ['ThreadsTag.tag_id = Tag.id']
                ]
            ],
            'group' => ['Tag.id'], // タグごとに集計
            'order' => ['Tag.id' => 'ASC'] // 必要に応じて並び替え
        ]);
        
        // ジャンルと価格帯を統合して options を作成
        $options = $genres + $priceRanges;
        
        return compact('genres', 'priceRanges', 'genresCounts', 'priceCounts', 'options');
    }
    
    //検証中
    public function _getThreadsCounts($thread_id) {
        $threadCounts = $this->Post->find('all', [
            'fields' => [
                'Post.thread_id',
                'COUNT(Post.content) AS comment_count'
            ],
            'conditions' => ['Post.thread_id' => $thread_id],
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
            'contain' => ['Tag'], // 関連するタグ情報を取得
            'order' => $order,
            'limit' => $limit,
        ]);
    }
}
