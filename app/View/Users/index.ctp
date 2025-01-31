<h1>オーディオ掲示板</h1>
<?php
$userName = $this->Session->read('User.user_name'); // セッションからユーザー名を取得
if ($userName) {
    echo $userName . "さんようこそ！";
} else {
    echo "ゲストさんようこそ！";
}
?>
<h2>スレッド検索</h2>
<?= $this->Form->create('Thread', ['url' => ['controller' => 'Threads', 'action' => 'search']]) ?>
    <?= $this->Form->input('keyword', ['label' => 'キーワードを入力', 'placeholder' => '例: コスパ最強']) ?>
    <?= $this->Form->button(__('検索')) ?>
<?= $this->Form->end() ?>
<p></p>
<nav>
    <ul>
        <!-- ジャンル別のリンク -->
        <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['genre' => 'ワイヤレス']]) ?>">ワイヤレス</a></li>
        <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['genre' => '有線']]) ?>">有線</a></li>
        <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['genre' => 'イヤホン']]) ?>">イヤホン</a></li>
        <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['genre' => 'ヘッドホン']]) ?>">ヘッドホン</a></li>
        <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['genre' => 'イヤホン']]) ?>">スピーカー</a></li>
        <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['genre' => 'イヤホン']]) ?>">サウンドバー</a></li>
        <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['genre' => 'DAC・アンプ']]) ?>">DAC・アンプ</a></li>
	</ul>
	<ul>
	    <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['price_range' => '低価格帯']]) ?>">低価格帯（～5千円）</a></li>
	    <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['price_range' => '中価格帯']]) ?>">中価格帯（5千円～2万円）</a></li>
	    <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['price_range' => '高価格帯']]) ?>">高価格帯（2万円～5万円）</a></li>
    </ul>
	<ul>
	    <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['price_range' => 'ファン']]) ?>">オーディオファン（5万円～10万円前後）</a></li>
	    <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['price_range' => 'マニア']]) ?>">オーディオマニア（10万～100万）</a></li>
	    <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index', '?' => ['price_range' => '玄人']]) ?>">オーディオ玄人（100万～）</a></li>
    </ul>
    <!-- 投稿フォームへのリンク -->
    <li><a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'index']) ?>">投稿する</a></li>
    
</nav>
<!-- すべてのスレッド -->
<h3>最新のスレッド</h3>
<ul>
    <?php foreach ($threads as $thread): ?>
        <li>
            <a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'view', $thread->id]) ?>">
                <?= h($thread->title) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<h3>人気のスレッド</h3>
<ul>
    <?php foreach ($popularThreads as $thread): ?>
        <li>
            <a href="<?= $this->Html->url(['controller' => 'Threads', 'action' => 'view', $thread['Thread']['id']]) ?>">
                <?= h($thread['Thread']['title']) ?>
            </a>
            (<?= h($thread['Thread']['view_count']) ?> 閲覧)
        </li>
    <?php endforeach; ?>
</ul>

<?php
	echo $this->Html->link('ログアウト',['controller' => 'Users', 'action' => 'logout'],  ['class' => 'button']);
?>