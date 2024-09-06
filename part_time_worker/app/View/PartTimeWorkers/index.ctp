<h1>Part-Time Workers</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($partTimeWorkers as $worker): ?>
    <tr>
        <td><?php echo h($worker['PartTimeWorker']['id']); ?></td>
        <td><?php echo h($worker['PartTimeWorker']['name']); ?></td>
        <td><?php echo h($worker['PartTimeWorker']['email']); ?></td>
        <td>
            <?php echo $this->Html->link('View', array('action' => 'view', $worker['PartTimeWorker']['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>