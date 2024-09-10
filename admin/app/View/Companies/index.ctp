<h1>Companies</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($companies as $company): ?>
    <tr>
        <td><?php echo h($company['Company']['id']); ?></td>
        <td><?php echo h($company['Company']['name']); ?></td>
        <td><?php echo h($company['Company']['email']); ?></td>
        <td><?php echo h($company['Company']['status']); ?></td>
        <td>
            <?php echo $this->Html->link('Deactivate', array('action' => 'deactivate', $company['Company']['id'])); ?>
            <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $company['Company']['id']), null, __('Are you sure?')); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<p><?php echo $this->Html->link('Add Company', array('action' => 'add')); ?></p>