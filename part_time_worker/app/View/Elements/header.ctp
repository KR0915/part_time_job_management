<!-- app/View/Elements/header.ctp -->
<?php echo $this->Html->css('header'); ?>
<div id="header">
    <h1>
        <?php
        $userId = $this->Session->read('Auth.User.id');
        echo $this->Html->link('勤怠管理アプリ', array('controller' => 'attendances', 'action' => 'index', $userId), array('escape' => false,'class'=>'header-title'));
        ?>
    </h1>
    <?php if ($this->Session->check('Auth.User.id')): ?>
        <div class="button-group">
            <?php echo $this->Html->link('出勤簿', array('controller' => 'part_time_workers', 'action' => 'history'), array('class' => 'attendance record')); ?>
            <?php echo $this->Html->link('履歴', array('controller' => 'part_time_workers', 'action' => 'workHistory',$userId), array('class' => 'button history')); ?>
            <?php echo $this->Html->link('ログアウト', array('controller' => 'part_time_workers', 'action' => 'logout'), array('class' => 'button logout')); ?>
        </div>
    <?php endif; ?>
</div>