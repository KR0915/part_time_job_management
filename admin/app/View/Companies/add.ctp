<h1>Add Company</h1>

<?php
echo $this->Form->create('Company');
echo $this->Form->input('name', array('label' => 'Company Name'));
echo $this->Form->input('email', array('label' => 'Email'));
echo $this->Form->end('Submit');
?>