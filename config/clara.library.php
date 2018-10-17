<?php

/**
 * Default config values
 */
return [
    
    'route' => [
        'web' => [
            'prefix'    => 'admin',
            'middleware' => ['web', 'access']
        ],
        'api' => [
            'prefix'    => 'admin',
            'middleware' => ['api', 'access']
        ]
    ],
    
    'folder' => 'library',
    
];
