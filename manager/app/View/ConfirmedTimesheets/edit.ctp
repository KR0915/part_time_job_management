<!-- app/View/ConfirmedTimesheets/edit.ctp -->
<h2><?php echo h($date); ?>の勤怠データ</h2>

<?php
// 月を数値形式に変換
$dateNumericMonth = date('Y-n-d', strtotime($date));
echo $this->Form->create('ConfirmedTimesheet', array('url' => array('action' => 'save', $dateNumericMonth)));
?>
<?php if ($timesheet): ?>
    <?php foreach ($timesheet as $entry): ?>
        <p>名前: <?php echo h($entry['PartTimeWorker']['name']); ?></p>
        <p>時給: <?php echo h($entry['PartTimeWorker']['hourly_wage']); ?></p>
        <p>出勤時間: <?php echo h(date('H:i', strtotime($entry['SubmittedTimesheet']['check_in']))); ?></p>
        <p>退勤時間: <?php echo h(date('H:i', strtotime($entry['SubmittedTimesheet']['check_out']))); ?></p>
        <p>休憩開始: <?php echo h(date('H:i', strtotime($entry['SubmittedTimesheet']['break_start']))); ?></p>
        <p>休憩終了: <?php echo h(date('H:i', strtotime($entry['SubmittedTimesheet']['break_end']))); ?></p>
        <?php
        // ConfirmedTimesheetにデータがあるかどうかを確認
        $confirmed = !empty($entry['ConfirmedTimesheet']['id']);
        ?>
        <p>出勤: <?php echo $this->Form->checkbox('ConfirmedTimesheet[' . $entry['SubmittedTimesheet']['id'] . '][confirmed]', array('checked' => $confirmed)); ?></p>
        <?php echo $this->Form->hidden('ConfirmedTimesheet[' . $entry['SubmittedTimesheet']['id'] . '][date]', array('value' => $dateNumericMonth)); ?>
        <?php echo $this->Form->hidden('ConfirmedTimesheet[' . $entry['SubmittedTimesheet']['id'] . '][part_time_worker_id]', array('value' => $entry['PartTimeWorker']['id'])); ?>
        <?php echo $this->Form->hidden('ConfirmedTimesheet[' . $entry['SubmittedTimesheet']['id'] . '][check_in]', array('value' => $entry['SubmittedTimesheet']['check_in'])); ?>
        <?php echo $this->Form->hidden('ConfirmedTimesheet[' . $entry['SubmittedTimesheet']['id'] . '][check_out]', array('value' => $entry['SubmittedTimesheet']['check_out'])); ?>
        <?php echo $this->Form->hidden('ConfirmedTimesheet[' . $entry['SubmittedTimesheet']['id'] . '][break_start]', array('value' => $entry['SubmittedTimesheet']['break_start'])); ?>
        <?php echo $this->Form->hidden('ConfirmedTimesheet[' . $entry['SubmittedTimesheet']['id'] . '][break_end]', array('value' => $entry['SubmittedTimesheet']['break_end'])); ?>
        <?php echo $this->Form->hidden('ConfirmedTimesheet[' . $entry['SubmittedTimesheet']['id'] . '][submitted_timesheet_id]', array('value' => $entry['SubmittedTimesheet']['id'])); ?>
        <hr>
    <?php endforeach; ?>
    <?php echo $this->Form->end('保存'); ?>
<?php else: ?>
    <p>この日の勤怠データはありません。</p>
<?php endif; ?>