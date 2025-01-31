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
	<div class="signup-container">
		<h1 class="signup-title">新規登録</h1>
		
		<?= $this->Form->create('User', [
		    'url' => ['controller' => 'SignUp', 'action' => 'signup'],
		    'class' => 'signup-form'
		]) ?>
		    <div class="form-group">
		        <?= $this->Form->input('email', [
		            'label' => 'メールアドレス：',
		            'class' => 'form-control'
		        ]) ?>
		    </div>
		    <div class="form-group">
		        <?= $this->Form->input('user_name', [
		            'label' => 'ユーザーネーム：',
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
		    <div class="form-group">
		        <?= $this->Form->input('confirm_password', [
		            'label' => '確認用パスワード：',
		            'type' => 'password',
		            'class' => 'form-control'
		        ]) ?>
		    </div>
		<?= $this->Form->button(__('登録'), ['class' => 'btn-submit']) ?>
		<?= $this->Form->end() ?>
		
		<div class="login-link">
			<?php
				echo $this->Html->link('ログイン', ['controller' => 'SignIn', 'action' => 'index'], ['class' => 'btn-link']);
			?>
		</div>
	</div>
</body>
</html>
