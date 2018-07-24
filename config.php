<?php
    Kirby::plugin('jenstornell/time-cache', [
        'options' => [
            'pages' => false,
            'expires' => 84400,
            'filename.hash' => true,
            'cache' => true,
            'path' => function() {
                return kirby()->roots()->storage() . '/cache-time';
            },
        ]
    ]);
