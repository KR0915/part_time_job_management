<!-- app/View/PartTimeWorkers/workHistory.ctp -->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>勤怠履歴</title>
    <link rel="stylesheet" href="<?php echo $this->Html->url('/css/work_history.css'); ?>">
</head>
<body>

<h1>勤怠履歴</h1>

<table>
    <thead>
        <tr>
            <th>日付</th>
            <th>出勤時間</th>
            <th>退勤時間</th>
            <th>休憩開始時間</th>
            <th>休憩終了時間</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($attendances as $attendance): ?>
            <tr>
                <td><?php echo h(date('m-d', strtotime($attendance['Attendance']['check_in']))); ?></td>
                <td><?php echo h(date('H:i', strtotime($attendance['Attendance']['check_in']))); ?></td>
                <td><?php echo h(date('H:i', strtotime($attendance['Attendance']['check_out']))); ?></td>
                <td><?php echo h($attendance['Attendance']['break_start'] ? date('H:i', strtotime($attendance['Attendance']['break_start'])) : '00:00'); ?></td>
                <td><?php echo h($attendance['Attendance']['break_end'] ? date('H:i', strtotime($attendance['Attendance']['break_end'])) : '00:00'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>