<!DOCTYPE html>
<html lang="ja">
	<head>
		<?= $this->Html->charset(); ?>
		<?= $this->Html->meta('viewport', 'width=device-width, initial-scale=1'); ?>
		<?= $this->Html->css(['reset', 'style']); ?>
		<?= $this->fetch('meta'); ?>
		<?= $this->fetch('css'); ?>
		<?= $this->fetch('script'); ?>
	</head>
<body>
<h1>オーディオ掲示板</h1>
<div class = "user_message">
	<p><?= h($userName)?>さん、ようこそ！</p>
	<?php
	// ユーザー名を取得
	$userName = $this->Session->read('User.user_name');
	
	if ($userName): ?>
		<a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'mypage']); ?>">マイページはこちら</a>
	<?php else: ?>
	<?php endif; ?>
</div>
    <header>
        <div class="container">
            <nav>
                <ul>
                    <li><?= $this->Html->link('ホーム', ['controller' => 'Board', 'action' => 'top']); ?></li>
                    <?php
						$userName = $this->Session->read('User.user_name'); // セッションからユーザー名を取得
						if (empty($userName)) {
							echo '<li>'.$this->Html->link('ログイン', ['controller' => 'Users', 'action' => 'login']) .'</li>';
                    	}else{
                    	}
                    ?>
                    <li><?= $this->Html->link('スレッド一覧', ['controller' => 'Threads', 'action' => 'allList']); ?></li>
                    <?php
						$userName = $this->Session->read('User.user_name'); // セッションからユーザー名を取得
						if ($userName) {
                    		echo '<li>' .$this->Html->link('新規スレッド作成', ['controller' => 'Threads', 'action' => 'index']). '</li>';
                    		echo '<li>' .$this->Html->link('お問い合わせ',['controller' => 'Board', 'action' => 'contactForm']). '</li>';
                    	}else{
                    		echo '<li>' . '<b>' ."🔒ログインで解放". '</b>' .'</li>';
                    	}
                    ?>
                    <li><?= $this->Html->link('ログアウト',['controller' => 'Users', 'action' => 'logout']);?></li>
                </ul>
            </nav>
        </div>
    </header>
<div class="search-form">
	<h2 class="search-title">スレッド検索</h2>
	<div class="search-box">
		<?= $this->Form->create('Thread', ['url' => ['controller' => 'Threads', 'action' => 'search']]) ?>
		    <?= $this->Form->input('keyword', ['label' => 'キーワードを入力', 'placeholder' => '例: コスパ最強イヤホン']) ?>
		    <p></p>
		    <?= $this->Form->button(__('検索')) ?>
		<?= $this->Form->end() ?>
	</div>
</div>
<?php if (!empty($results)): ?>
    <h2>「<?= h($keyword); ?>」の検索結果</h2>
    <ul>
        <?php foreach ($results as $result): ?>
        	<?php 
			    // スレッドが無効か、スレッド作成者が無効ならスキップ
			    $isThreadInvalid = $result['Thread']['invalid_flag'] != 0;
			    $isThreadOwnerInvalid = false;
			    foreach ($userLists as $user) {
			        if ($user['User']['id'] === $result['Thread']['created_by'] && $user['User']['invalid_flag'] != 0) {
			            $isThreadOwnerInvalid = true;
			            break; // ループを抜ける
			        }
			    }
			    if ($isThreadInvalid || $isThreadOwnerInvalid) {
			        continue; // スキップ
			    }
			?>
            <li>
                <a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'view', $result['Thread']['id']]); ?>">
                    <?= h($result['Thread']['title']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
<?php endif; ?>
<?php if (!empty($threads)): ?>
    <h2>「<?= h($tagName) ?>」に関連するスレッド</h2>
    <ul class="threads-list">
        <?php foreach ($threads as $thread): ?>
        	<?php 
			    // スレッドが無効か、スレッド作成者が無効ならスキップ
			    $isThreadInvalid = $thread['Thread']['invalid_flag'] != 0;
			    $isThreadOwnerInvalid = false;
			    foreach ($userLists as $user) {
			        if ($user['User']['id'] === $thread['Thread']['created_by'] && $user['User']['invalid_flag'] != 0) {
			            $isThreadOwnerInvalid = true;
			            break; // ループを抜ける
			        }
			    }
			    if ($isThreadInvalid || $isThreadOwnerInvalid) {
			        continue; // スキップ
			    }
			?>
            <li>
                <?= $this->Html->link(h($thread['Thread']['title']), ['action' => 'view', $thread['Thread']['id']]) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
<?php endif; ?>
<p></p>
<nav>
<div class="tags-tabs">
    <h3>ジャンル</h3>
    <ul class="thread-list2">
	    <?php foreach ($genresCounts as $tag): ?>
	        <li>
	            <a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'tagSearch', $tag['Tag']['id']]) ?>">
	                <?= h($tag['Tag']['name']) ?> (<?= h($tag[0]['thread_count']) ?>)
	            </a>
	        </li>
	    <?php endforeach; ?>
    </ul>

    <h3>価格帯</h3>
    <ul>
	    <?php foreach ($priceCounts as $tag): ?>
	        <li>
	            <a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'tagSearch', $tag['Tag']['id']]) ?>">
	                <?= h($tag['Tag']['name']) ?> (<?= h($tag[0]['thread_count']) ?>)
	            </a>
	        </li>
	    <?php endforeach; ?>
    </ul>
</div>
</nav>
<!-- すべてのスレッド -->
<h3>最新のスレッド</h3>
<?php if (!empty($latestThreads)): ?>
	<ul class="thread-list">
	<?php foreach ($latestThreads as $thread): ?>
		<?php 
		    // スレッドが無効か、スレッド作成者が無効ならスキップ
		    $isThreadInvalid = $thread['Thread']['invalid_flag'] != 0;
		    $isThreadOwnerInvalid = false;
		    foreach ($userLists as $user) {
		        if ($user['User']['id'] === $thread['Thread']['created_by'] && $user['User']['invalid_flag'] != 0) {
		            $isThreadOwnerInvalid = true;
		            break; // ループを抜ける
		        }
		    }
		    if ($isThreadInvalid || $isThreadOwnerInvalid) {
		        continue; // スキップ
		    }
		?>
	    <li>
	        <a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'viewCnt', $thread['Thread']['id']]) ?>">
	            <?= h($thread['Thread']['title']) ?>
	            <?php
	            // デフォルト値 (コメントがない場合は 0)
	            $commentCount = 0;
	
	            // スレッド ID に対応するコメント数を検索
	            foreach ($latestLists as $threadCount) {
	                if (!empty($threadCount[0]['Post']['thread_id']) && $threadCount[0]['Post']['thread_id'] == $thread['Thread']['id']) {
	                    $commentCount = !empty($threadCount[0][0]['comment_count']) ? $threadCount[0][0]['comment_count'] : 0;
	                    break; // 該当スレッドが見つかったらループを抜ける
	                }
	            }
	            ?>
	            (<?= h($commentCount) ?>)
	        </a>
	        <?php if (!empty($thread['Tag'])): ?>
	            <ul>
	                <?php foreach ($thread['Tag'] as $tag): ?>
	                    <li><?= h($tag['name']) ?></li>
	                <?php endforeach; ?>
	            </ul>
	        <?php endif; ?>
	    </li>
	<?php endforeach; ?>
	</ul>
	<?php else:?>
		<?= h('現在最新のスレッド情報はありません。');?>
<?php endif; ?>
<h2></h2>
<h3>人気のスレッド</h3>
<?php if (!empty($popularThreads)): ?>
	<ul class="thread-list">
	<?php foreach ($popularThreads as $thread): ?>
		<?php 
		    // スレッドが無効か、スレッド作成者が無効ならスキップ
		    $isThreadInvalid = $thread['Thread']['invalid_flag'] != 0;
		    $isThreadOwnerInvalid = false;
		    foreach ($userLists as $user) {
		        if ($user['User']['id'] === $thread['Thread']['created_by'] && $user['User']['invalid_flag'] != 0) {
		            $isThreadOwnerInvalid = true;
		            break; // ループを抜ける
		        }
		    }
		    if ($isThreadInvalid || $isThreadOwnerInvalid) {
		        continue; // スキップ
		    }
		?>
	    <li>
	        <a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'viewCnt', $thread['Thread']['id']]) ?>">
	            <?= h($thread['Thread']['title']) ?>
	            <?php
	            // デフォルト値 (コメントがない場合は 0)
	            $commentCount = 0;
	
	            // スレッド ID に対応するコメント数を検索
	            foreach ($popularLists as $threadCount) {
	                if (!empty($threadCount[0]['Post']['thread_id']) && $threadCount[0]['Post']['thread_id'] == $thread['Thread']['id']) {
	                    $commentCount = !empty($threadCount[0][0]['comment_count']) ? $threadCount[0][0]['comment_count'] : 0;
	                    break; // 該当スレッドが見つかったらループを抜ける
	                }
	            }
	            ?>
	            (<?= h($commentCount) ?>)
	        </a>
	        <ul>
	            <?php foreach ($thread['Tag'] as $tag): ?>
	                <li><?= h($tag['name']) ?></li>
	            <?php endforeach; ?>
	        </ul>
	        (<?= h($thread['Thread']['view_count']) ?> 閲覧)
	    </li>
	<?php endforeach; ?>
	</ul>
	<?php else:?>
		<?= h('現在人気のスレッド情報はありません。');?>
<?php endif; ?>

<div class="add-button">
	<?= $this->Html->link('スレッド一覧', ['controller' => 'Threads', 'action' => 'allList']); ?>
</div>
<br>
</body>
</html>