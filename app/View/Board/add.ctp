<!DOCTYPE html>
<html lang="ja">
<head>
    <?= $this->Html->charset(); ?>
    <?= $this->Html->meta('viewport', 'width=device-width, initial-scale=1'); ?>
    <?= $this->Html->css(['reset', 'style']); ?>
    <?= $this->fetch('meta'); ?>
    <?= $this->fetch('css'); ?>
    <?= $this->fetch('script'); ?>    
    <?= $this->Html->script('jquery'); // Include jQuery library?>
    <title>新しいスレッドの作成</title>
</head>
<body>
    <div class="thread-container">
        <h1 class="thread-title">新しいスレッドの作成</h1>
        <p class="thread-description">以下のフォームに必要事項を入力してください。</p>

        <div class="thread-form-container">
		<?= $this->Form->create('Thread', [
		    'url' => ['controller' => 'Threads', 'action' => 'add'],
		    'class' => 'thread-form',
		    'onsubmit' => 'return confirmPost();'
		]);?>

            <div class="form-group">
                <?= $this->Form->input('title', [
                    'label' => 'スレッド名 <span class="required">※必須</span>',
                    'class' => 'form-control'
                ]) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->input('Tags._ids', [
                    'type' => 'select',
                    'label' => 'ジャンル・価格帯（最低1つは選択してください）',
                    'options' => $options, // コントローラーから渡されたオプション
                    'multiple' => 'checkbox',
                    'class' => 'form-checkbox-group'
                ]) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->button(__('スレッドを作成する'), ['class' => 'btn btn-submit']) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>

        <div class="back-button-container">
            <button type="button" class="btn btn-back" onclick="history.back()">戻る</button>
        </div>
    </div>
<script>
    function confirmPost() {
        return confirm('このスレッドを作成しますか？');
    }
</script>
    
</body>
</html>
