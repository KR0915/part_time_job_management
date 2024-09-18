<?php
echo $this->Html->link('アルバイト管理画面', array('controller' => 'partTimeWorkers', 'action' => 'index', $manager_id));
echo '<br>';
echo 'Generated URL: ' . $this->Html->url(array('controller' => 'partTimeWorkers', 'action' => 'index', $manager_id));
?>
<br />
<?php
echo $this->Html->link('勤怠管理画面', array('controller' => 'confirmedTimesheets', 'action' => 'index', $manager_id));
echo '<br>';
echo 'Generated URL: ' . $this->Html->url(array('controller' => 'confirmedTimesheets', 'action' => 'index', $manager_id));
?>