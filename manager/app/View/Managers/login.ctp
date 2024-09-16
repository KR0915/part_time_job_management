<h2>ログイン</h2>
<?php echo $this->Form->create('Manager', array('url' => array('controller' => 'managers', 'action' => 'login'))); ?>
    <fieldset>
        <legend><?php echo __('Please enter your email and password'); ?></legend>
        <?php
            echo $this->Form->input('email', array('required' => true));
            echo $this->Form->input('password', array('required' => true));
        ?>
    </fieldset>
<?php echo $this->Form->end(__('ログイン')); ?>