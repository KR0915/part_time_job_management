<!-- app/View/Elements/header.ctp -->
<?php echo $this->Html->css('header'); ?>
<div id="header">
    <h1 class="admin-link"><?php echo $this->Html->link('Admin', array('controller' => 'admins', 'action' => 'index', 'admin' => true)); ?></h1>
</div>