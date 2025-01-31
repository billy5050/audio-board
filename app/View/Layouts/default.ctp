<!DOCTYPE html>
<?php
echo $this->Session->flash();
echo $this->Session->flash('auth');
?>
<html lang="ja">
<head>
    <?= $this->Html->charset(); ?>
    <title><?= h($title_for_layout); ?> - 掲示板サイト</title>
    <?= $this->Html->meta('viewport', 'width=device-width, initial-scale=1'); ?>
    <?= $this->Html->css(['reset', 'style']); ?>
    <?= $this->fetch('meta'); ?>
    <?= $this->fetch('css'); ?>
    <?= $this->fetch('script'); ?>
    <?= $this->Html->script('jquery'); // Include jQuery library?>
</head>
<body>
    <main>
        <div class="container">
            <?= $this->Session->flash(); ?>
            <?= $this->fetch('content'); ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?= date('Y'); ?> 掲示板サイト. All rights reserved.</p>
        </div>
    </footer>
    <?= $this->Js->writeBuffer(); // Write cached scripts?>
    <?= $this->fetch('script'); ?>
</body>
</html>
