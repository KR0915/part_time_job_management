<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者編集</title>
    <!-- Bootstrap CSSの読み込み -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">管理者編集</h1>
        <?php
        echo $this->Form->create('Admin', array('class' => 'form-horizontal'));
        echo $this->Form->input('id', array('type' => 'hidden'));
        ?>
        <div class="form-group">
            <?php
            echo $this->Form->label('username', '名前', array('class' => 'control-label'));
            echo $this->Form->input('username', array('label' => false, 'class' => 'form-control'));
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $this->Form->label('email', 'Email', array('class' => 'control-label'));
            echo $this->Form->input('email', array('label' => false, 'class' => 'form-control'));
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $this->Form->label('password', 'Password', array('class' => 'control-label'));
            echo $this->Form->input('password', array('type' => 'password', 'label' => false, 'class' => 'form-control'));
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $this->Form->button('Save', array('class' => 'btn btn-primary'));
            ?>
        </div>
        <?php
        echo $this->Form->end();
        ?>
        <div class="form-group">
            <?php
            echo $this->Html->link('戻る', array('action' => 'index'), array('class' => 'btn btn-secondary'));
            ?>
        </div>
    </div>
    <!-- Bootstrap JSと依存するPopper.jsの読み込み -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>