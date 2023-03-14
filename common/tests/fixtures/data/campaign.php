<?php

return [
    [
        'id' => '1',
        'name' => 'General campaign',
        'start_date' => '20/10/2000',
        'closure_date' => '20/10/2200',
        'end_date' => '5/11/2200',
        'status' => '1',
        'created_at' => new \yii\db\Expression('NOW()'),
        'created_by' => 'admin',
        'updated_at' => new \yii\db\Expression('NOW()'),
        'updated_by' => 'admin',
    ],
];