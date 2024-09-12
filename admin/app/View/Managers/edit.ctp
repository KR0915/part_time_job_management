<h1>編集</h1>
<?php
echo $this->Form->create('Manager');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->input('name', array('label' => 'Name'));
echo $this->Form->input('email', array('label' => 'Email'));
echo $this->Form->input('password', array('label' => 'Password', 'type' => 'password'));
echo $this->Form->input('company_id', array('label' => 'Company', 'options' => $companies));
echo $this->Form->end('完了');
?>