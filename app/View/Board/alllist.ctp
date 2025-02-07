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
<h1>スレッド一覧</h1>
<p class = "user_message"><?= h($userName)?>さん、ようこそ！</p>
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
    
<!-- すべてのスレッド -->
<h3>すべてのスレッド</h3>
<ul class="thread-list">
<?php foreach ($allThreads as $thread): ?>
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
            foreach ($allLists as $threadCount) {
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

<br>
<!-- ページネーションリンク -->
<div class="pagination">
    <?= $this->Paginator->prev('« 前へ', null, null, ['class' => 'disabled']) ?>
    <?= $this->Paginator->numbers(['modulus' => 5]) ?>
    <?= $this->Paginator->next('次へ »', null, null, ['class' => 'disabled']) ?>
</div>
<p>全 <?= $this->Paginator->counter(['format' => '%count% 件']) ?> のスレッド</p>
</body>
</html>