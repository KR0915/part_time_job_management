<!-- app/View/Attendances/workHistory.ctp -->

<h1>勤怠履歴</h1>

<h2>従業員ID: <?php echo h($workerId); ?></h2>

<table>
    <thead>
        <tr>
            <th>日付</th>
            <th>出勤時間</th>
            <th>退勤時間</th>
            <th>備考</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($attendances as $attendance): ?>
            <tr>
                <td><?php echo h($attendance['Attendance']['date']); ?></td>
                <td><?php echo h($attendance['Attendance']['start_time']); ?></td>
                <td><?php echo h($attendance['Attendance']['end_time']); ?></td>
                <td><?php echo h($attendance['Attendance']['note']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>