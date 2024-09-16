<?php echo $this->Html->css('header'); ?>
<div id="header">
    <h1>
        <?php
        $userId = $this->Session->read('Auth.User.id');
        echo $this->Html->link('アルバイト管理アプリ', array('controller' => 'managers', 'action' => 'dashboard', $userId), array('escape' => false, 'class' => 'header-title'));
        ?>
    </h1>
    <?php if ($this->Session->check('Auth.User.id')): ?>
        <div class="button-group">
            <?php echo $this->Html->link('ログアウト', array('controller' => 'managers', 'action' => 'logout'), array('class' => 'button logout')); ?>
        </div>
    <?php endif; ?>
</div>