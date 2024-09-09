<div id="calendar-container">
    <div id="calendar-header" class="calendar-header"></div>
    <div id="calendar" class="calendar"></div>
</div>

<!-- モーダルダイアログ -->
<div id="attendance-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>出勤情報を入力</h2>
        <?php
        echo $this->Form->create('SubmittedTimesheet', array('url' => array('controller' => 'attendances', 'action' => 'submitTimesheet', $workerId)));
        ?>
        <div class="form-group">
            <?php
            echo $this->Form->label('check_in', '出勤時間');
            echo $this->Form->input('SubmittedTimesheet.check_in', array('type' => 'text', 'label' => false, 'div' => false, 'required' => true, 'default' => null, 'placeholder' => 'YYYY-MM-DD HH:MM:SS'));
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $this->Form->label('check_out', '退勤時間');
            echo $this->Form->input('SubmittedTimesheet.check_out', array('type' => 'text', 'label' => false, 'div' => false, 'required' => true, 'default' => null, 'placeholder' => 'YYYY-MM-DD HH:MM:SS'));
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $this->Form->label('break_start', '休憩開始時間');
            echo $this->Form->input('SubmittedTimesheet.break_start', array('type' => 'text', 'label' => false, 'div' => false, 'default' => null, 'placeholder' => 'YYYY-MM-DD HH:MM:SS'));
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $this->Form->label('break_end', '休憩終了時間');
            echo $this->Form->input('SubmittedTimesheet.break_end', array('type' => 'text', 'label' => false, 'div' => false, 'default' => null, 'placeholder' => 'YYYY-MM-DD HH:MM:SS'));
            ?>
        </div>
        <?php
        echo $this->Form->input('SubmittedTimesheet.date', array('type' => 'hidden', 'id' => 'selected-date', 'default' => null));
        echo $this->Form->end('保存');
        ?>
    </div>
</div>

<style>
    body {
        background-color: #ffffff; /* ページ全体の背景色を白に設定 */
    }
    .calendar-header {
        text-align: center;
        font-size: 1.5em;
        margin-bottom: 10px;
    }
    .calendar {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
        margin: 20px auto;
        max-width: 500px; /* カレンダーの幅を指定 */
    }
    .calendar div {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
        min-height: 40px; /* 高さを確保 */
    }
    .calendar .header {
        font-weight: bold;
    }
    .calendar .day {
        cursor: pointer;
    }
    .calendar .selected {
        background-color: #f0f0f0;
    }
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script>
    $(document).ready(function() {
        function generateCalendar(year, month) {
            var daysInMonth = new Date(year, month + 1, 0).getDate();
            var firstDay = new Date(year, month, 1).getDay();
            var calendar = $('#calendar');
            var calendarHeader = $('#calendar-header');
            calendar.empty();
            calendarHeader.empty();

            var monthNames = ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'];
            calendarHeader.text(year + '年 ' + monthNames[month]);

            var headers = ['日', '月', '火', '水', '木', '金', '土'];
            headers.forEach(function(day) {
                calendar.append('<div class="header">' + day + '</div>');
            });

            for (var i = 0; i < firstDay; i++) {
                calendar.append('<div></div>');
            }

            for (var day = 1; day <= daysInMonth; day++) {
                calendar.append('<div class="day" data-date="' + year + '-' + (month + 1) + '-' + day + '">' + day + '</div>');
            }

            $('.day').click(function() {
                var selectedDate = $(this).data('date');
                $('#selected-date').val(selectedDate);
                $('#attendance-modal').show();
            });
        }

        var today = new Date();
        var nextMonth = new Date(today.getFullYear(), today.getMonth() + 1, 1);
        generateCalendar(nextMonth.getFullYear(), nextMonth.getMonth());

        // モーダルの閉じるボタン
        $('.close').click(function() {
            $('#attendance-modal').hide();
        });

        // モーダル外をクリックしたときに閉じる
        $(window).click(function(event) {
            if (event.target.id === 'attendance-modal') {
                $('#attendance-modal').hide();
            }
        });

        // フォームの送信処理
        $('#attendance-form').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            console.log(formData); // デバッグ用に送信データを確認
            $.ajax({
                type: 'POST',
                url: '/attendances/submittedTimesheet', // 新しいアクションのURL
                data: formData,
                success: function(response) {
                    alert('出勤情報が保存されました');
                    $('#attendance-modal').hide();
                },
                error: function() {
                    alert('出勤情報の保存に失敗しました');
                }
            });
        });
    });
</script>

<!-- <?php
echo $this->Form->create('SubmittedTimesheet', array('url' => array('controller' => 'attendances', 'action' => 'submitTimesheet', $workerId)));
echo $this->Form->input('SubmittedTimesheet.check_in', array('type' => 'text', 'label' => false, 'div' => false, 'required' => true, 'default' => null, 'placeholder' => 'YYYY-MM-DD HH:MM:SS'));
echo $this->Form->input('SubmittedTimesheet.check_out', array('type' => 'text', 'label' => false, 'div' => false, 'required' => true, 'default' => null, 'placeholder' => 'YYYY-MM-DD HH:MM:SS'));
echo $this->Form->input('SubmittedTimesheet.break_start', array('type' => 'text', 'label' => false, 'div' => false, 'default' => null, 'placeholder' => 'YYYY-MM-DD HH:MM:SS'));
echo $this->Form->input('SubmittedTimesheet.break_end', array('type' => 'text', 'label' => false, 'div' => false, 'default' => null, 'placeholder' => 'YYYY-MM-DD HH:MM:SS'));
echo $this->Form->input('SubmittedTimesheet.date', array('type' => 'hidden', 'id' => 'selected-date', 'default' => null));
echo $this->Form->end('保存');?> -->