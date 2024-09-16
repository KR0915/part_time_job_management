<?php
echo $this->Html->link('アルバイト管理画面', array('controller' => 'partTimeWorkers', 'action' => 'index', $manager_id));
echo '<br>';
echo 'Generated URL: ' . $this->Html->url(array('controller' => 'partTimeWorkers', 'action' => 'index', $manager_id));
?>