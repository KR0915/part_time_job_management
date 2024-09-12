<h1>編集</h1>
<?php
echo $this->Form->create('Company');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->input('name');
echo $this->Form->input('email');
echo $this->Form->end('Save');
?>