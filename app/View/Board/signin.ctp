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
	<div class="signup-container">
		<h1 class="signup-title">ログイン</h1>
		
		<?= $this->Form->create('User', [
		    'url' => ['controller' => 'SignIn', 'action' => 'SignIn'],
		    'class' => 'login-form'
		]) ?>
		    <div class="form-group">
		        <?= $this->Form->input('email', [
		            'label' => 'メールアドレス：',
		            'class' => 'form-control'
		        ]) ?>
		    </div>
		    <div class="form-group">
		        <?= $this->Form->input('password', [
		            'label' => 'パスワード：',
		            'type' => 'password',
		            'class' => 'form-control'
		        ]) ?>
		    </div>
		    <p></p>
		    <?= $this->Form->button(__('ログイン'), ['class' => 'btn-submit']) ?>
		<?= $this->Form->end() ?>
		
		<div class="signup-link">
			<?php
			    echo $this->Html->link('新規登録', ['controller' => 'SignUp', 'action' => 'about'], ['class' => 'btn-link']);
			?>
		</div>
		<?= $this->Html->link('ゲストでログイン', ['controller' => 'Board', 'action' => 'top']); ?>
	</div>
</body>
</html>
