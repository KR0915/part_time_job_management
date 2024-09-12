<h1>管理者一覧</h1>

<?php echo $this->Form->create('Admin', array('type' => 'get')); ?>
<?php echo $this->Form->input('name', array('label' => 'Search by Admin Name', 'value' => $this->request->query('name'))); ?>
<?php echo $this->Form->end('Search'); ?>

<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>password</th>
    </tr>
    <?php foreach ($admins as $admin): ?>
    <tr>
        <td><?php echo h($admin['Admin']['username']); ?></td>
        <td><?php echo h($admin['Admin']['email']); ?></td>
        <td><?php echo h($admin['Admin']['password']); ?></td>
        <td>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $admin['Admin']['id'])); ?>
            <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $admin['Admin']['id']), null, __('Are you sure?')); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<p><?php echo $this->Html->link('管理者追加', array('action' => 'add')); ?></p>