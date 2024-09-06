<!-- app/View/Elements/header.ctp -->
<?php echo $this->Html->css('header'); ?>
<div id="header">
    <h1>勤怠管理アプリ</h1>
    <?php if ($this->Session->check('Auth.User.id')): ?>
        <div class="logout-button">
            <?php echo $this->Html->link('ログアウト', array('controller' => 'part_time_workers', 'action' => 'logout'), array('class' => 'logout')); ?>
        </div>
    <?php endif; ?>
</div>