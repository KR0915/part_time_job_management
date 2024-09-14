<div id="calendar-container">
    <div id="calendar-header" class="calendar-header"></div>
    <div id="calendar" class="calendar"></div>
</div>

<style>
    body {
        background-color: #ffffff; /* ページ全体の背景色を白に設定 */
        overflow-x: hidden; /* 横スクロールを無効にする */
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
        max-width: 100%; /* カレンダーの幅を画面幅に収める */
        box-sizing: border-box; /* パディングを含めて幅を計算 */
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
    .calendar .submitted {
        background-color: #f0f0f0; /* 色を変更 */
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
        var submittedDates = <?php echo json_encode($submittedDates); ?>;
        var workerId = <?php echo json_encode($workerId); ?>;

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
                var date = year + '-' + (month + 1).toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');
                var isSubmitted = submittedDates.includes(date);
                var className = isSubmitted ? 'day submitted' : 'day';
                calendar.append('<div class="' + className + '" data-date="' + date + '">' + day + '</div>');
            }

            $('.day').click(function() {
                var selectedDate = $(this).data('date');
                $('#selected-date').val(selectedDate);

                // フォームのアクションURLを動的に設定
                var actionUrl = '/attendances/submitTimesheet/' + workerId + '/' + selectedDate;
                console.log('Action URL:', actionUrl); // URLをコンソールに出力
                $('#attendance-form').attr('action', actionUrl);

                // ページをリダイレクト
                window.location.href = '/part_time_worker/attendances/editSubmittedTimesheet/' + workerId + '/' + selectedDate;
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
                url: $('#attendance-form').attr('action'),
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