<head>
    <title>Attendances</title>
    <?php echo $this->Html->css('attendance'); ?>
</head>
<body>
    <div class="container">
        <br />
        <div id="current-time"></div>
        <br />
        <div class="button-container">
            <?php echo $this->Form->create('Attendance', array('url' => array('action' => 'checkIn', $workerId))); ?>
            <?php echo $this->Form->button('出勤', array('type' => 'submit', 'class' => 'button')); ?>
            <?php echo $this->Form->end(); ?>

            <?php echo $this->Form->create('Attendance', array('url' => array('action' => 'checkOut', $workerId))); ?>
            <?php echo $this->Form->button('退勤', array('type' => 'submit', 'class' => 'button')); ?>
            <?php echo $this->Form->end(); ?>

            <?php echo $this->Form->create('Attendance', array('url' => array('action' => 'break', $workerId))); ?>
            <?php echo $this->Form->button('休憩', array('type' => 'submit', 'class' => 'button')); ?>
            <?php echo $this->Form->end(); ?>
        </div>

        <p>Logged in User ID: <?php echo h($workerId); ?></p>
        <?php debug($workerId); ?>

        <div class="table-container">
            <table>
                <tr>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($attendances as $attendance): ?>
                <tr>
                    <td><?php echo h($attendance['Attendance']['check_in']); ?></td>
                    <td><?php echo h($attendance['Attendance']['check_out']); ?></td>
                    <td>
                        <?php echo $this->Html->link('Edit', array('action' => 'edit', $attendance['Attendance']['id']), array('class' => 'table-button')); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

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