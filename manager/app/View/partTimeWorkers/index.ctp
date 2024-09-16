<h1>アルバイト管理</h1>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>password</th>
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
                    <?php echo $this->Html->link('編集', array('controller' => 'partTimeWorkers', 'action' => 'edit', $worker['PartTimeWorker']['id'], $manager_id)); ?>
                    <?php echo $this->Form->postLink('削除', array('controller' => 'partTimeWorkers', 'action' => 'delete', $worker['PartTimeWorker']['id'], $manager_id), array('confirm' => '本当に削除しますか？')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php 
echo $this->Html->link('アルバイト追加', array('controller' => 'partTimeWorkers', 'action' => 'add', $manager_id));
?>