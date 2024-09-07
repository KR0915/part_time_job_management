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

            <?php echo $this->Form->create('Attendance', array('url' => array('action' => 'breakStart', $workerId))); ?>
            <?php echo $this->Form->button('休憩開始', array('type' => 'submit', 'class' => 'button')); ?>
            <?php echo $this->Form->end(); ?>

            <?php echo $this->Form->create('Attendance', array('url' => array('action' => 'breakEnd', $workerId))); ?>
            <?php echo $this->Form->button('休憩終了', array('type' => 'submit', 'class' => 'button')); ?>
            <?php echo $this->Form->end(); ?>
        </div>

        <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>出勤時間</th>
                    <th>退勤時間</th>
                    <th>休憩開始時間</th>
                    <th>休憩終了時間</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendances as $attendance): ?>
                    <tr>
                        <td><?php echo h(date('H:i', strtotime($attendance['Attendance']['check_in']))); ?></td>
                        <td><?php echo h($attendance['Attendance']['check_out'] ? date('H:i', strtotime($attendance['Attendance']['check_out'])) : '00:00'); ?></td>
                        <td><?php echo h($attendance['Attendance']['break_start'] ? date('H:i', strtotime($attendance['Attendance']['break_start'])) : '00:00'); ?></td>
                        <td><?php echo h($attendance['Attendance']['break_end'] ? date('H:i', strtotime($attendance['Attendance']['break_end'])) : '00:00'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
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