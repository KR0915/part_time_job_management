<?php
// app/Model/PartTimeWorker.php
class PartTimeWorker extends AppModel {
    public $validate = array(
        'email' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'このメールアドレスは既に使用されています。'
            ),
            'email' => array(
                'rule' => 'email',
                'message' => '有効なメールアドレスを入力してください。'
            ),
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'メールアドレスは必須です。'
            )
        ),
        // 他のバリデーションルール
    );
}