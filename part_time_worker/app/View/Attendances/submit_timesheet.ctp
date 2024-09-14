<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>出勤簿提出</title>
    <?php echo $this->Html->css('submit_timesheet'); ?>
    <?php echo $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js'); ?>
</head>
<body id="submit-timesheet-body"> <!-- bodyタグにIDを追加 -->
    <h1>出勤簿提出</h1>
    <?php echo $this->element('calendar', array('workerId' => $workerId, 'submittedDates' => $submittedDates)); ?>
    <br />
    <br />
</body>
</html>