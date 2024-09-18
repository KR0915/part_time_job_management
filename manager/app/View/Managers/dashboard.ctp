<div class="link-container">
    <?php
    echo $this->Html->link('アルバイト管理画面', array('controller' => 'partTimeWorkers', 'action' => 'index', $manager_id), array('class' => 'styled-link'));
    ?>
    <?php
    echo $this->Html->link('勤怠管理画面', array('controller' => 'confirmedTimesheets', 'action' => 'index', $manager_id), array('class' => 'styled-link'));
    ?>
    <?php
    echo $this->Html->link('給与管理画面', array('controller' => 'Attendances', 'action' => 'index', $manager_id), array('class' => 'styled-link'));
    ?>
</div>

<!-- CSSを適用 -->
<style>
    .link-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 40px; /* 隣とのスペースを広げる */
        margin: 100px 0 40px 0; /* 上にスペースを追加 */
    }
    .styled-link {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 250px; /* 幅を大きくする */
        height: 250px; /* 高さを大きくする */
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        text-align: center;
        border-radius: 10px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .styled-link:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
</style>