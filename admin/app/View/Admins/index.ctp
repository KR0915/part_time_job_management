<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ナビゲーションメニュー</title>
    <!-- Bootstrap CSSの読み込み -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">ナビゲーションメニュー</h2>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action" href="<?php echo $this->Html->url(array('controller' => 'companies', 'action' => 'index', 'admin' => true)); ?>">契約会社一覧</a>
                    <a class="list-group-item list-group-item-action" href="<?php echo $this->Html->url(array('controller' => 'managers', 'action' => 'index', 'admin' => true)); ?>">店長一覧</a>
                    <a class="list-group-item list-group-item-action" href="<?php echo $this->Html->url(array('controller' => 'admins', 'action' => 'list', 'admin' => true)); ?>">管理者一覧</a>
                    <a class="list-group-item list-group-item-action" href="<?php echo $this->Html->url(array('controller' => 'PartTimeWorkers', 'action' => 'index', 'admin' => true)); ?>">アルバイト一覧</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JSと依存するPopper.jsの読み込み -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>