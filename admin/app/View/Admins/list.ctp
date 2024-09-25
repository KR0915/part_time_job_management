<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者一覧</title>
    <!-- Bootstrap CSSの読み込み -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">管理者一覧</h1>

        <?php echo $this->Form->create('Admin', array('type' => 'get', 'class' => 'form-inline mb-3')); ?>
        <div class="form-group mx-sm-3 mb-2">
            <?php echo $this->Form->input('name', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Search by Admin Name', 'value' => $this->request->query('name'))); ?>
        </div>
        <?php echo $this->Form->button('Search', array('class' => 'btn btn-primary mb-2')); ?>
        <?php echo $this->Form->end(); ?>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?php echo h($admin['Admin']['username']); ?></td>
                    <td><?php echo h($admin['Admin']['email']); ?></td>
                    <td><?php echo h($admin['Admin']['password']); ?></td>
                    <td>
                        <?php echo $this->Html->link('Edit', array('action' => 'edit', $admin['Admin']['id']), array('class' => 'btn btn-warning btn-sm')); ?>
                        <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $admin['Admin']['id']), array('class' => 'btn btn-danger btn-sm'), __('Are you sure?')); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><?php echo $this->Html->link('管理者追加', array('action' => 'add'), array('class' => 'btn btn-primary mb-2')); ?></p>
    </div>
    <!-- Bootstrap JSと依存するPopper.jsの読み込み -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>