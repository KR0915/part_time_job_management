<!-- app/View/ConfirmedTimesheets/index.ctp -->
<div class="calendar-container">
    <!-- 先月、今月、来月を選択するボタン -->
    <div class="month-navigation">
        <?php
        $prevMonth = (new DateTime("$year-$month-01"))->modify('-1 month');
        $nextMonth = (new DateTime("$year-$month-01"))->modify('+1 month');
        ?>
        <?php echo $this->Html->link('先月', array('controller' => 'confirmedTimesheets', 'action' => 'index', '?' => array('year' => $prevMonth->format('Y'), 'month' => $prevMonth->format('m'))), array('class' => 'button')); ?>
        <?php echo $this->Html->link('今月', array('controller' => 'confirmedTimesheets', 'action' => 'index', '?' => array('year' => date('Y'), 'month' => date('m'))), array('class' => 'button')); ?>
        <?php echo $this->Html->link('来月', array('controller' => 'confirmedTimesheets', 'action' => 'index', '?' => array('year' => $nextMonth->format('Y'), 'month' => $nextMonth->format('m'))), array('class' => 'button')); ?>
    </div>

    <?php
    // カレンダーのヘッダーを表示
    echo '<h2>' . h($monthName) . '</h2>';
    echo '<table class="calendar">';
    echo '<tr>';
    echo '<th>日</th>';
    echo '<th>月</th>';
    echo '<th>火</th>';
    echo '<th>水</th>';
    echo '<th>木</th>';
    echo '<th>金</th>';
    echo '<th>土</th>';
    echo '</tr>';

    // カレンダーの最初の週を表示
    $firstDayOfWeek = (new DateTime($firstDayOfMonth))->format('w');
    echo '<tr>';
    for ($i = 0; $i < $firstDayOfWeek; $i++) {
        echo '<td></td>';
    }

    // カレンダーの日付を表示
    $currentDay = new DateTime($firstDayOfMonth);
    while ($currentDay->format('Y-m-d') <= $lastDayOfMonth) {
        if ($currentDay->format('w') == 0 && $currentDay->format('d') != '01') {
            echo '</tr><tr>';
        }

        // $confirmDataに日付が含まれているかをチェック
        $isConfirmed = false;
        $workHours = '';
        foreach ($confirmData as $data) {
            if ($data['ConfirmedTimesheet']['date'] == $currentDay->format('Y-m-d')) {
                $isConfirmed = true;
                $checkIn = isset($data['ConfirmedTimesheet']['check_in']) ? (new DateTime($data['ConfirmedTimesheet']['check_in']))->format('H:i') : '未設定';
                $checkOut = isset($data['ConfirmedTimesheet']['check_out']) ? (new DateTime($data['ConfirmedTimesheet']['check_out']))->format('H:i') : '未設定';
                $workHours = $checkIn . '～' . $checkOut;
                break;
            }
        }

        // 特定のCSSクラスを適用
        $class = $isConfirmed ? 'confirmed' : '';

        echo '<td class="' . $class . '">';
        echo '<a href="' . $this->Html->url(array('controller' => 'confirmedTimesheets', 'action' => 'edit', $currentDay->format('Y'), $currentDay->format('m'), $currentDay->format('d'))) . '">';
        echo '<div>' . $currentDay->format('j') . '</div>';
        if ($workHours) {
            echo '<div class="work-hours">' . h($workHours) . '</div>';
        }
        echo '</a>';
        echo '</td>';
        $currentDay->modify('+1 day');
    }

    // カレンダーの最後の週を表示
    $lastDayOfWeek = (new DateTime($lastDayOfMonth))->format('w');
    for ($i = $lastDayOfWeek; $i < 6; $i++) {
        echo '<td></td>';
    }
    echo '</tr>';
    echo '</table>';
    ?>
    <br />
    <br />
</div>

<!-- CSSを適用 -->
<style>
    .calendar-container {
        margin: 20px auto; /* カレンダーの周りにスペースを追加し、中央に配置 */
        max-width: 800px; /* 最大幅を設定 */
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    .calendar {
        width: 100%;
        border-collapse: collapse;
        margin: 0 auto; /* カレンダーを中央に配置 */
    }
    .calendar th, .calendar td {
        border: 1px solid #ddd;
        padding: 0; /* パディングをリセット */
        text-align: center;
        position: relative; /* 相対位置を設定 */
    }
    .calendar th {
        background-color: #f2f2f2;
        padding: 10px;
    }
    .calendar td {
        height: 100px; /* 高さを調整 */
    }
    .calendar td a {
        display: flex; /* リンクをフレックスボックスに */
        flex-direction: column; /* 縦方向に要素を並べる */
        align-items: center; /* 垂直方向に中央揃え */
        justify-content: center; /* 水平方向に中央揃え */
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: inherit; /* リンクの色を継承 */
        position: absolute; /* 絶対位置を設定 */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
    .calendar td:hover {
        background-color: #f5f5f5;
    }
    .calendar td.confirmed {
        background-color: #d3d3d3; /* 背景色を変更 */
    }
    .work-hours {
        font-size: 12px;
        color: #555;
        margin-top: 5px;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }
    .month-navigation {
        text-align: center;
        margin-bottom: 20px;
    }
    .month-navigation .button {
        margin: 0 10px;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .month-navigation .button:hover {
        background-color: #0056b3;
    }
</style>