<!-- app/View/Admins/login.ctp -->
<br />
<h1>ログイン</h1>
<?php echo $this->Form->create('Admin', array('class' => 'login-form')); ?>
    <fieldset>
        <?php
            echo $this->Form->input('email', array('required' => true, 'class' => 'form-control', 'placeholder' => 'メールアドレス'));
            echo $this->Form->input('password', array('required' => true, 'class' => 'form-control', 'placeholder' => 'パスワード'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(array('label' => __('Login'), 'class' => 'btn btn-primary')); ?>

<!-- CSSを追加 -->
<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }
    .login-form {
        max-width: 400px;
        margin: 50px auto;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }
    .login-form fieldset {
        border: none;
        padding: 0;
    }
    .login-form legend {
        font-size: 20px;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }
    .login-form .form-control {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }
    .login-form .btn {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 16px;
    }
    .login-form .btn:hover {
        background-color: #0056b3;
    }
    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        color: #333;
    }
</style>