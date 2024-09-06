<!-- app/View/PartTimeWorkers/login.ctp -->
<h1>Login</h1>
<?php echo $this->Form->create('PartTimeWorker'); ?>
    <fieldset>
        <legend><?php echo __('Please enter your username and password'); ?></legend>
        <?php
            echo $this->Form->input('email', array('required' => true));
            echo $this->Form->input('password', array('required' => true));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Login')); ?>