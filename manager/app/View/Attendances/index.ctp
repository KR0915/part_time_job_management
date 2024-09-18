<!-- app/View/Attendances/index.ctp -->
<h1>給与</h1>

<!-- 月ごとのページ切り替えリンク -->
<div class="month-navigation">
    <?php
    $prevMonth = (new DateTime("$year-$month-01"))->modify('-1 month');
    $nextMonth = (new DateTime("$year-$month-01"))->modify('+1 month');
    ?>
    <?php echo $this->Html->link('先月', array('controller' => 'attendances', 'action' => 'index', '?' => array('year' => $prevMonth->format('Y'), 'month' => $prevMonth->format('m'), 'search_name' => h($searchName))), array('class' => 'button')); ?>
    <?php echo $this->Html->link('今月', array('controller' => 'attendances', 'action' => 'index', '?' => array('year' => date('Y'), 'month' => date('m'), 'search_name' => h($searchName))), array('class' => 'button')); ?>
    <?php echo $this->Html->link('来月', array('controller' => 'attendances', 'action' => 'index', '?' => array('year' => $nextMonth->format('Y'), 'month' => $nextMonth->format('m'), 'search_name' => h($searchName))), array('class' => 'button')); ?>
</div>
<div class="month-display">
    <?php echo h($year); ?>年<?php echo h($month); ?>月
</div>

<!-- 人ごとの勤怠データの表示 -->
<?php foreach ($workersData as $worker): ?>
    <h2 class="worker-name" onclick="toggleAttendance('<?php echo h($worker['name']); ?>')">
        <?php echo h($worker['name']); ?>
        <span class="triangle">&#9654;</span>
        <span class="summary">
            (合計出勤時間: <?php echo h($worker['totalWorkDurationInHours']); ?> 時間, 合計給与: <?php echo h($worker['totalSalary']); ?> 円)
        </span>
    </h2>
    <div id="attendance-<?php echo h($worker['name']); ?>" class="attendance-details" style="display: none;">
        <table>
            <thead>
                <tr>
                    <th>出勤時間</th>
                    <th>退勤時間</th>
                    <th>休憩開始</th>
                    <th>休憩終了</th>
                    <th>時給</th>
                    <th>給与</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($worker['attendances'] as $attendance): ?>
                    <tr>
                        <td><?php echo h($attendance['check_in']); ?></td>
                        <td><?php echo h($attendance['check_out']); ?></td>
                        <td><?php echo h($attendance['break_start']); ?></td>
                        <td><?php echo h($attendance['break_end']); ?></td>
                        <td><?php echo h($worker['hourly_wage']); ?>円</td>
                        <td><?php echo h($attendance['salary']); ?>円</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>

<!-- 改善されたCSS -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f7f7f7;
        color: #333;
        line-height: 1.6;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        color: #333;
    }

    .month-navigation {
        text-align: center;
        margin-bottom: 20px;
    }

    .month-navigation .button {
        margin: 0 10px;
        padding: 10px 30px;
        background-color: #28a745;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .month-navigation .button:hover {
        background-color: #218838;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .month-display {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
        color: #666;
    }

    .worker-name {
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between; /* 左右の要素をスペースで分ける */
        background-color: #f8f9fa;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 5px;
        transition: background-color 0.3s ease;
    }

    .worker-name:hover {
        background-color: #e9ecef;
    }

    .triangle {
        margin-left: 10px;
        transition: transform 0.3s ease;
        display: none;
        align-items: center;
        justify-content: center;
        flex-shrink: 0; /* サイズが縮まないように固定 */
    }

    .triangle.down {
        transform: rotate(90deg);
    }

    .summary {
        font-size: 14px;
        color: #555;
    }

    .attendance-details {
        margin-top: 10px;
        padding: 10px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: none;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0;
        background-color: #fff;
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f8f9fa;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    @media (max-width: 768px) {
        .worker-name {
            flex-direction: column;
            align-items: flex-start;
        }

        .month-navigation .button {
            display: block;
            margin: 10px auto;
        }

        table, th, td {
            font-size: 14px;
        }
    }
</style>

<!-- JavaScript -->
<script>
    function toggleAttendance(workerName) {
        var details = document.getElementById('attendance-' + workerName);
        var triangle = details.previousElementSibling.querySelector('.triangle');
        if (details.style.display === 'none') {
            details.style.display = 'block';
            triangle.classList.add('down');
        } else {
            details.style.display = 'none';
            triangle.classList.remove('down');
        }
    }
</script>
