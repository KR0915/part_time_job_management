<h1>店長一覧</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Company</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($managers as $manager): ?>
        <tr>
            <td><?php echo h($manager['Manager']['id']); ?></td>
            <td><?php echo h($manager['Manager']['name']); ?></td>
            <td><?php echo h($manager['Manager']['email']); ?></td>
            <td><?php echo h($manager['Manager']['company_name']); ?></td>
            <td>
                <?php echo $this->Html->link('Edit', array('action' => 'edit', $manager['Manager']['id'])); ?>
                <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $manager['Manager']['id']), array('confirm' => 'Are you sure?')); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p><?php echo $this->Html->link('店長追加', array('action' => 'add', 'admin' => true)); ?></p>