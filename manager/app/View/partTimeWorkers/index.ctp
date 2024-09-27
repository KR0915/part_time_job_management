<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アルバイト管理</title>
    <!-- Bootstrap CSSの読み込み -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">アルバイト管理</h1>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>時給</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($partTimeWorkers as $worker): ?>
                    <tr>
                        <td><?php echo h($worker['PartTimeWorker']['name']); ?></td>
                        <td><?php echo h($worker['PartTimeWorker']['email']); ?></td>
                        <td><?php echo h($worker['PartTimeWorker']['password']); ?></td>
                        <td><?php echo h($worker['PartTimeWorker']['hourly_wage']); ?></td>
                        <td>
                            <?php echo $this->Html->link('編集', array('controller' => 'partTimeWorkers', 'action' => 'edit', $worker['PartTimeWorker']['id'], $manager_id), array('class' => 'btn btn-primary btn-sm')); ?>
                            <?php echo $this->Form->postLink('削除', array('controller' => 'partTimeWorkers', 'action' => 'delete', $worker['PartTimeWorker']['id'], $manager_id), array('confirm' => '本当に削除しますか？', 'class' => 'btn btn-danger btn-sm')); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mt-3">
            <?php echo $this->Html->link('アルバイト追加', array('controller' => 'partTimeWorkers', 'action' => 'add', $manager_id), array('class' => 'btn btn-success')); ?>
        </div>
    </div>
    <!-- Bootstrap JSと依存するPopper.jsの読み込み -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>