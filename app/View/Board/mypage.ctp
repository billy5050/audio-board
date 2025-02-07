<!DOCTYPE html>
<html lang="ja">
<head>
	<head>
		<?= $this->Html->charset(); ?>
		<?= $this->Html->meta('viewport', 'width=device-width, initial-scale=1'); ?>
		<?= $this->Html->css(['reset', 'style']); ?>
		<?= $this->fetch('meta'); ?>
		<?= $this->fetch('css'); ?>
		<?= $this->fetch('script'); ?>
	</head>
</head>
<body>
    <header>
        <div class="container">
            <h1 class="site-title">オーディオ掲示板</h1>
            <nav>
                <ul>
                    <li><?= $this->Html->link('TOP', ['controller' => 'Board', 'action' => 'top']); ?></li>
                    <li><?= $this->Html->link('スレッド一覧', ['controller' => 'Threads', 'action' => 'allList']); ?></li>
                </ul>
            </nav>
        </div>
    </header>
	<div class="mypage-container">
	    <h1>マイページ</h1>
	    <!-- 自分が作成したスレッド一覧 -->
	    <section class="my-threads">
	        <h2>自分が作成したスレッド</h2>
	        <?php if (!empty($myThreads)): ?>
	            <ul>
	                <?php foreach ($myThreads as $thread): ?>
	                    <li>
	                        <a href="<?php echo $this->Html->url(['controller' => 'Threads', 'action' => 'view', $thread['Thread']['id']]); ?>">
	                            <?php echo h($thread['Thread']['title']); ?>
	                        </a>
	                        <small>作成日: <?php echo h($thread['Thread']['created_at']); ?></small>
	                    </li>
	                <?php endforeach; ?>
	            </ul>
	        <?php else: ?>
	            <p>作成したスレッドはありません。</p>
	        <?php endif; ?>
	    </section>
	
	    <!-- 自分がしたコメント一覧 -->
	    <section class="my-comments">
			<h2>自分が投稿したコメント</h2>
			<?php if (!empty($myComments)): ?>
			    <ul>
					<?php foreach ($myComments as $comment): ?>
					    <?php 
					        // スレッドが無効か、スレッド作成者が無効ならスキップ
					        $isThreadInvalid = $comment['Thread']['invalid_flag'] != 0;
					        $isThreadOwnerInvalid = false;
					        foreach ($userLists as $user) {
					            if ($user['User']['id'] === $comment['Thread']['created_by'] && $user['User']['invalid_flag'] != 0) {
					                $isThreadOwnerInvalid = true;
					                break; // ループを抜ける
					            }
					        }
					        if ($isThreadInvalid || $isThreadOwnerInvalid) {
					            continue; // スキップ
					        }
					    ?>
					
					    <li>
					        <p><?php echo nl2br(h($comment['Post']['content'])); ?></p>
					        <small>
					            コメント先: 
					            <a href="<?php echo $this->Html->url(['controller' => 'Threads', 'action' => 'view', $comment['Thread']['id']]); ?>">
					                <?php echo h($comment['Thread']['title']); ?>
					            </a>
					            (投稿日時: <?php echo h($comment['Post']['created_at']); ?>)
					        </small>
					    </li>
					<?php endforeach; ?>
			    </ul>
			<?php else: ?>
			    <p>投稿したコメントはありません。</p>
			<?php endif; ?>
	    </section>
	</div>

</body>
</html>