<h1>管理者追加</h1>

<?php
echo $this->Form->create('Admin');
echo $this->Form->input('username', array('label' => 'Name'));
echo $this->Form->input('email', array('label' => 'Email'));
echo $this->Form->input('password', array('label' => 'password'));
echo $this->Form->end('Submit');
?>