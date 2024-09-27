<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>会社一覧</title>
    <!-- Bootstrap CSSの読み込み -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">会社一覧</h1>

        <p><?php echo $this->Html->link('会社追加', array('action' => 'add'), array('class' => 'btn btn-primary mb-2')); ?></p>

        <?php echo $this->Form->create('Company', array('type' => 'get', 'class' => 'form-inline mb-3')); ?>
        <div class="form-group mx-sm-3 mb-2">
            <?php echo $this->Form->input('name', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Search by Company Name', 'value' => $this->request->query('name'))); ?>
        </div>
        <?php echo $this->Form->button('Search', array('class' => 'btn btn-primary mb-2')); ?>
        <?php echo $this->Form->end(); ?>
        

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($companies as $company): ?>
                <tr>
                    <td><?php echo h($company['Company']['id']); ?></td>
                    <td><?php echo h($company['Company']['name']); ?></td>
                    <td><?php echo h($company['Company']['email']); ?></td>
                    <td><?php echo h($company['Company']['status']); ?></td>
                    <td>
                        <?php echo $this->Form->postLink(
                            ($company['Company']['status'] === 'active') ? 'Deactivate' : 'Activate',
                            array('action' => 'toggleStatus', $company['Company']['id']),
                            array('confirm' => 'Are you sure?', 'class' => 'btn btn-warning btn-sm')
                        ); ?>
                        <?php echo $this->Html->link('Edit', array('action' => 'edit', $company['Company']['id']), array('class' => 'btn btn-primary btn-sm')); ?>
                        <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $company['Company']['id']), array('class' => 'btn btn-danger btn-sm'), __('Are you sure?')); ?>
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