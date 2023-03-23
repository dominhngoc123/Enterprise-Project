<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@backend_alias' => stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://' . 'admin.ep.web',
        '@frontend_alias' => stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://' . 'client.ep.web',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
    'modules' => [
        'gridview' =>  [
             'class' => '\kartik\grid\Module'
             // enter optional module parameters below - only if you need to  
             // use your own export download action or custom translation 
             // message source
             // 'downloadAction' => 'gridview/export/download',
             // 'i18n' => []
         ]
     ]
];
