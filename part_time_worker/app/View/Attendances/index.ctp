<head>
    <title>Attendances</title>
    <?php echo $this->Html->css('attendance'); ?>
</head>
<body>
    <br />
    <div id="current-time"></div>
    <br />
    <div class="button-container">
        <?php echo $this->Form->create('Attendance', array('url' => array('action' => 'checkIn', $workerId))); ?>
        <?php echo $this->Form->button('Check In', array('type' => 'submit', 'class' => 'button')); ?>
        <?php echo $this->Form->end(); ?>

        <?php echo $this->Form->create('Attendance', array('url' => array('action' => 'checkOut', $workerId))); ?>
        <?php echo $this->Form->button('Check Out', array('type' => 'submit', 'class' => 'button')); ?>
        <?php echo $this->Form->end(); ?>

        <?php echo $this->Form->create('Attendance', array('url' => array('action' => 'break', $workerId))); ?>
        <?php echo $this->Form->button('Break', array('type' => 'submit', 'class' => 'button')); ?>
        <?php echo $this->Form->end(); ?>
    </div>

    <p>Logged in User ID: <?php echo h($workerId); ?></p>
    <?php debug($workerId); ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Part-Time Worker</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($attendances as $attendance): ?>
        <tr>
            <td><?php echo h($attendance['Attendance']['id']); ?></td>
            <td><?php echo h($attendance['PartTimeWorker']['name']); ?></td>
            <td><?php echo h($attendance['Attendance']['check_in']); ?></td>
            <td><?php echo h($attendance['Attendance']['check_out']); ?></td>
            <td>
                <?php echo $this->Html->link('Edit', array('action' => 'edit', $attendance['Attendance']['id']), array('class' => 'table-button')); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <script>
    function updateTime() {
        var now = new Date();
        var currentTime = now.toLocaleTimeString();
        document.getElementById('current-time').innerText = '現在時刻: ' + currentTime;
    }
    setInterval(updateTime, 1000);
    updateTime();
    </script>
</body>