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
	<body>
		<div class="signup-container">
			<h1 class="signup-title">お問い合わせ</h1>
					<?= $this->Form->create('Contact', [
		    'url' => ['controller' => 'Board', 'action' => 'contact'],
		    'class' => 'signup-form'
		]) ?>
		    <div class="form-group">
		        <?= $this->Form->input('email', [
		            'label' => 'メールアドレス：（任意）',
		            'class' => 'form-control'
		        ]) ?>
		    </div>
		    <div class="form-group">
		        <?= $this->Form->input('content', [
		            'label' => 'お問い合わせ内容：',
		            'class' => 'form-control',
		            'type' => 'text'
		        ]) ?>
		    </div>
		<?= $this->Form->button(__('送信'), ['class' => 'btn-submit']) ?>
		<?= $this->Form->end() ?>
		</div>	
	</body>
</html>