<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アルバイトの勤怠データ編集</title>
    <!-- Bootstrap CSSの読み込み -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4"><?php echo h($date); ?>の勤怠データ</h2>

        <?php
        // 月を数値形式に変換
        $dateNumericMonth = date('Y-n-d', strtotime($date));
        echo $this->Form->create('ConfirmedTimesheet', array('url' => array('action' => 'save', $dateNumericMonth), 'class' => 'form-horizontal'));
        ?>
        <?php if ($timesheet): ?>
            <?php foreach ($timesheet as $entry): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">名前: <?php echo h($entry['PartTimeWorker']['name']); ?></h5>
                        <hr />
                        <p class="card-text">時給: <?php echo h($entry['PartTimeWorker']['hourly_wage']); ?>円</p>
                        <p class="card-text">出勤時間: <?php echo h(date('H:i', strtotime($entry['SubmittedTimesheet']['check_in']))); ?></p>
                        <p class="card-text">退勤時間: <?php echo h(date('H:i', strtotime($entry['SubmittedTimesheet']['check_out']))); ?></p>
                        <p class="card-text">休憩開始: <?php echo h(date('H:i', strtotime($entry['SubmittedTimesheet']['break_start']))); ?></p>
                        <p class="card-text">休憩終了: <?php echo h(date('H:i', strtotime($entry['SubmittedTimesheet']['break_end']))); ?></p>
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
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="form-group">
                <?php echo $this->Form->button('保存', array('class' => 'btn btn-primary')); ?>
            </div>
            <?php echo $this->Form->end(); ?>
        <?php else: ?>
            <p>この日の勤怠データはありません。</p>
        <?php endif; ?>
    </div>
    <!-- Bootstrap JSと依存するPopper.jsの読み込み -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>