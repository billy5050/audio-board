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
            <h1 class="site-title">オーディオ掲示板</h1>
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
        <?php
            $cnt = 1;
            // ユーザーリストを ID をキーにした連想配列に変換（検索を高速化）
            $userInvalidMap = [];
            foreach ($userLists as $user) {
                $userInvalidMap[$user['User']['id']] = !empty($user['User']['invalid_flag']);
            }
        ?>

        <?php foreach ($thread['Post'] as $post): ?>
            <?php 
                // 投稿が削除されている場合
                if (!empty($post['invalid_flag'])): ?>
                    <li class="comment-item" id="comment-<?= h($cnt); ?>">
                        <div class="comment-header">
                            <span class="comment-number"><?= h($cnt); ?>.</span>
                            <strong>ユーザー名:</strong> <?= h('*****'); ?>
                            <strong> 投稿日時:</strong> <?= h($post['created_at']); ?>
                        </div>
                        <div class="comment-body">
                            <strong>
                                <?= h('このコメントは管理者によって削除されました。'); ?>
                            </strong>
                        </div>
                    </li>
                    <?php $cnt++; ?>
                    <?php continue; ?>
            <?php endif; ?>

            <?php
                // 投稿者が無効の場合はコメントを表示しない
                if (!empty($userInvalidMap[$post['created_by']])) {
                    continue;
                }
            ?>

            <li class="comment-item" id="comment-<?= h($cnt); ?>">
                <div class="comment-header">
                    <span class="comment-number"><?= h($cnt); ?>.</span>
                    <strong>ユーザー名:</strong> <?= h($post['User']['user_name']); ?>
                    <strong> 投稿日時:</strong> <?= h($post['created_at']); ?>
                </div>
                <div class="comment-body">
                    <?php if (!empty($post['image_path'])): ?>
                        <img src="<?= $this->Html->url('/' . h($post['image_path']), true); ?>" alt="投稿画像" style="max-width: 300px; height: auto;">
                    <?php endif; ?>
                    <p>
                        <?php
                            // コメント内の @番号 を #comment-番号 へのリンクに変換
                            $commentContent = preg_replace_callback('/@(\d+)/', function ($matches) {
                                return '<a href="#comment-' . h($matches[1]) . '">@' . h($matches[1]) . '</a>';
                            }, h($post['content']));
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
	        'type' => 'file',
	        'onsubmit' => 'return confirmPost();' // フォーム送信時にJavaScript関数を実行
	    ]); ?>
	    
	    <?= $this->Form->hidden('thread_id', ['value' => $thread['Thread']['id']]); ?>
	    
		<?= $this->Form->textarea('content', [
		    'label' => 'コメント内容',
		    'rows' => 8,
		    'style' => 'width: 100%; resize: vertical;',
		    'placeholder' => 'コメント番号を指定する場合は @番号 を入力（例: @3 ありがとう！）'
	]); 
?>
    <?= $this->Form->input('image', ['type' => 'file', 'label' => '画像を添付する']); ?>
    
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
