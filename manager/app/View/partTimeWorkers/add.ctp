<h1>アルバイトの追加</h1>

<?php
echo $this->Form->create('PartTimeWorker');
echo $this->Form->input('name', array('label' => '名前'));
echo $this->Form->input('email', array('label' => 'メールアドレス'));
echo $this->Form->input('password', array('label' => 'パスワード', 'type' => 'password'));
echo $this->Form->input('hourly_wage', array('label' => '時給'));
echo $this->Form->hidden('company_id', array('value' => $companyId));
echo $this->Form->end('保存');
?>