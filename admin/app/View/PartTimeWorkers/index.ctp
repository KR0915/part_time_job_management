<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パートタイムワーカー一覧</title>
    <!-- Bootstrap CSSの読み込み -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">パートタイムワーカー一覧</h1>
        <div class="mb-3">
            <?php echo $this->Html->link('新しいパートタイムワーカーを追加', array('action' => 'add'), array('class' => 'btn btn-primary')); ?>
        </div>
        <div class="mb-3">
            <?php echo $this->Form->create('PartTimeWorker', array('type' => 'get', 'class' => 'form-inline')); ?>
            <div class="form-group mx-sm-3 mb-2">
                <?php echo $this->Form->input('search', array('label' => false, 'class' => 'form-control', 'placeholder' => '名前またはメールで検索')); ?>
            </div>
            <?php echo $this->Form->button('検索', array('class' => 'btn btn-primary mb-2')); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>会社ID</th>
                    <th>メール</th>
                    <th>作成日</th>
                    <th>更新日</th>
                    <th>アクション</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($partTimeWorkers as $worker): ?>
                    <tr>
                        <td><?php echo $worker['PartTimeWorker']['id']; ?></td>
                        <td><?php echo $worker['PartTimeWorker']['name']; ?></td>
                        <td><?php echo $worker['PartTimeWorker']['company_id']; ?></td>
                        <td><?php echo $worker['PartTimeWorker']['email']; ?></td>
                        <td><?php echo $worker['PartTimeWorker']['created']; ?></td>
                        <td><?php echo $worker['PartTimeWorker']['modified']; ?></td>
                        <td>
                            <?php echo $this->Html->link('編集', array('action' => 'edit', $worker['PartTimeWorker']['id']), array('class' => 'btn btn-primary btn-sm')); ?>
                            <?php echo $this->Form->postLink('削除', array('action' => 'delete', $worker['PartTimeWorker']['id']), array('confirm' => '本当にこのパートタイムワーカーを削除しますか？', 'class' => 'btn btn-danger btn-sm')); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br />
    </div>
    <!-- Bootstrap JSと依存するPopper.jsの読み込み -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>