<?php

function getHybridauthConfig(): array {
    return [
        'callback' => 'https://luissanchez.cat/index.php', // URL donde Hybridauth redirige después del login
        'providers' => [
            'Google' => [
                'enabled' => true,
                'keys' => [
                    'id' => 'Ov23liJDh5AJQjacuTfs',
                    'secret' => '737a0c072a32a00061c594e882ec9369d15566aa',
                ],
            ],
            'Facebook' => [
                'enabled' => true,
                'keys' => [
                    'id' => 'TU_APP_ID_DE_FACEBOOK',
                    'secret' => 'TU_APP_SECRET_DE_FACEBOOK',
                ],
            ],
        ],
    ];
}
