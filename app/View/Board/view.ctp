<!DOCTYPE html>
<html lang="ja">
<head>
    <?= $this->Html->charset(); ?>
    <?= $this->Html->meta('viewport', 'width=device-width, initial-scale=1'); ?>
    <?= $this->Html->css(['reset', 'style']); ?>
    <title><?= h($thread['Thread']['title']); ?> - 掲示板</title>
</head>
<body>
    <header>
        <div class="container">
            <h1 class="site-title"><a href="<?= $this->Html->url('/') ?>">オーディオ掲示板</a></h1>
            <nav>
                <ul>
                    <li><?= $this->Html->link('TOP', ['controller' => 'Board', 'action' => 'top']); ?></li>
                    <li><?= $this->Html->link('スレッド一覧', ['controller' => 'Threads', 'action' => 'allList']); ?></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <!-- スレッドのタイトル -->
        <h1><?= h($thread['Thread']['title']); ?></h1>

        <!-- スレッドの詳細情報 -->
        <section class="thread-details">
            <p><strong>作成者:</strong> <?= h($thread['User']['user_name']); ?></p>
            <p><strong>作成日時:</strong> <?= h($thread['Thread']['created_at']); ?></p>
            <p><strong>更新日時:</strong> <?= h($thread['Thread']['updated_at']); ?></p>
        </section>
        <?php if (!empty($thread['Tag'])): ?>
            <ul class="thread-list2">
                <?php foreach ($thread['Tag'] as $tag): ?>
                    <li><?= h($tag['name']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

<section class="thread-comments">
    <h2>コメント一覧</h2>
    <?php if (!empty($thread['Post'])): ?>
        <ul class="comments-list">
            <?php $cnt = 1; ?>
            <?php foreach ($thread['Post'] as $post): ?>
                <li class="comment-item" id="comment-<?= h($cnt); ?>">
                    <div class="comment-header">
                        <span class="comment-number"><?= h($cnt); ?>.</span>
                        <strong>ユーザー名:</strong> <?= h($post['User']['user_name']); ?>
                        <strong> 投稿日時:</strong> <?= h($post['created_at']); ?>
                    </div>
					<div class="comment-body">
						<p>
						    <?php
						        // コメント内の @番号 を #comment-番号 へのリンクに変換
						        $commentContent = preg_replace_callback('/@(\d+)/', function ($matches) {
						            return '<a href="#comment-' . h($matches[1]) . '">@' . h($matches[1]) . '</a>';
						        }, h($post['content']));
						
						        // 変換後のコメントを出力（改行も適用）
						        echo nl2br($commentContent);
						    ?>
						</p>
					</div>
                </li>
                <?php $cnt++; ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>コメントはまだありません。</p>
    <?php endif; ?>
</section>

<section class="comment-form">
<?php
// ユーザー名を取得
$userName = $this->Session->read('User.user_name');

if ($userName): ?>
    <h2>コメントを投稿する</h2>
    <?= $this->Form->create('Post', [
        'url' => ['controller' => 'Threads', 'action' => 'comment'],
        'onsubmit' => 'return confirmPost();' // フォーム送信時にJavaScript関数を実行
    ]); ?>
    
    <?= $this->Form->hidden('thread_id', ['value' => $thread['Thread']['id']]); ?>
    
	<?= $this->Form->textarea('content', [
	    'label' => 'コメント内容',
	    'rows' => 8,
	    'style' => 'width: 100%; resize: vertical;',
	    'placeholder' => 'コメント番号を指定する場合は @番号 を入力（例: @3 ありがとう！）'
	]); ?>
    
    <?= $this->Form->button('投稿する', ['class' => 'btn-submit']); ?>
    <?= $this->Form->end(); ?>
<?php else: ?>
    <h2>🔒コメントを投稿する</h2>
    <p>コメントを投稿するにはログインが必要です。</p>
<?php endif; ?>

</section>

</main>
    <p></p>
	<?= $this->Html->link('スレッド一覧', ['controller' => 'Threads', 'action' => 'allList']); ?>
</body>
<script>
    function confirmPost() {
        // 確認ダイアログを表示
        return confirm('コメントを投稿しますか？');
    }
</script>
</html>
