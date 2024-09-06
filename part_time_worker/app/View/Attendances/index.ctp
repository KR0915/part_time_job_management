<!DOCTYPE html>
<html>
<head>
    <title>Attendances</title>
    <?php echo $this->Html->css('attendance'); ?>
</head>
<body>
    <h1>Attendances</h1>

    <div id="current-time"></div>
    <br />
    <div>
        <?php echo $this->Html->link('Check In', array('action' => 'checkIn', $workerId), array('class' => 'button')); ?>
        <?php echo $this->Html->link('Check Out', array('action' => 'checkOut', $workerId), array('class' => 'button')); ?>
        <?php echo $this->Html->link('Break', array('action' => 'break', $workerId), array('class' => 'button')); ?>
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
                <?php echo $this->Html->link('Edit', array('action' => 'edit', $attendance['Attendance']['id']), array('class' => 'button')); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <script>
    function updateTime() {
        var now = new Date();
        var currentTime = now.toLocaleTimeString();
        document.getElementById('current-time').innerText = 'Current Time: ' + currentTime;
    }
    setInterval(updateTime, 1000);
    updateTime();
    </script>
</body>
</html>