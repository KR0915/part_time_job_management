<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>出勤情報を編集</title>
    <?php echo $this->Html->css('edit_submit_timesheet'); ?>
    <?php echo $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js'); ?>
</head>
<body>
    <div class="edit-submit-timesheet-container">
        <h1 class="edit-title">出勤情報を編集</h1>
        <?php
        echo $this->Form->create('SubmittedTimesheet', array('id' => 'attendance-form'));
        ?>
        <div class="edit-form-group">
            <?php
            echo $this->Form->label('check_in', '出勤時間');
            echo $this->Form->input('SubmittedTimesheet.check_in', array('type' => 'text', 'label' => false, 'div' => false, 'required' => true, 'default' => null, 'placeholder' => 'HH:MM'));
            ?>
        </div>
        <div class="edit-form-group">
            <?php
            echo $this->Form->label('check_out', '退勤時間');
            echo $this->Form->input('SubmittedTimesheet.check_out', array('type' => 'text', 'label' => false, 'div' => false, 'required' => true, 'default' => null, 'placeholder' => 'HH:MM'));
            ?>
        </div>
        <div class="edit-form-group">
            <?php
            echo $this->Form->label('break_start', '休憩開始時間');
            echo $this->Form->input('SubmittedTimesheet.break_start', array('type' => 'text', 'label' => false, 'div' => false, 'default' => null, 'placeholder' => 'HH:MM'));
            ?>
        </div>
        <div class="edit-form-group">
            <?php
            echo $this->Form->label('break_end', '休憩終了時間');
            echo $this->Form->input('SubmittedTimesheet.break_end', array('type' => 'text', 'label' => false, 'div' => false, 'default' => null, 'placeholder' => 'HH:MM'));
            ?>
        </div>
        <?php
        echo $this->Form->input('SubmittedTimesheet.date', array('type' => 'hidden', 'id' => 'selected-date', 'default' => null));
        ?>
        <div class="edit-button-container">
            <?php
            echo $this->Form->end(array('label' => '保存', 'class' => 'edit-button'));
            ?>
            <?php
                echo $this->Form->postLink(
                    '削除',
                    array('controller' => 'Attendances', 'action' => 'deleteSubmittedTimesheet', $workerId, $date),
                    array('confirm' => '本当にこの出勤簿を削除しますか？', 'class' => 'edit-button edit-button-delete')
                );
            ?>
        </div>
    </div>
    <br />
    <br />
</body>
</html>