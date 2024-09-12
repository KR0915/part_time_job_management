<h1>編集</h1>
<?php
echo $this->Form->create('Admin');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->input('username');
echo $this->Form->input('email');
echo $this->Form->input('password');
echo $this->Form->end('Save');
?>