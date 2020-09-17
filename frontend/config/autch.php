<?php
return [
    'class' => 'yii\authclient\Collection',
    'clients' => [
        /*
        'google' => [
            'class' => 'yii\authclient\clients\Google',
            'clientId' => 'example',
            'clientSecret' => 'example',
        ],
        'twitter' => [
            'class' => 'yii\authclient\clients\Twitter',
            'consumerKey' => 'example',
            'consumerSecret' => 'example',
        ],
        */
        'vkontakte' => [
            'class' => 'yii\authclient\clients\VKontakte',
            'clientId' => '6478614',
            'clientSecret' => 'dYn70YbmQUxOgfP4OxGS',
        ],
        'facebook' => [
            'class' => 'yii\authclient\clients\Facebook',
            'clientId' => '2154031987970354',
            'clientSecret' => '8864605bb694e035fc4fae133bb07231',
        ],
    ],
];