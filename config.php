<?php
    Kirby::plugin('jenstornell/time-cache', [
        'options' => [
            'pages' => false,
            'expires' => 84400, // seconds
            'cache' => true
        ]
    ]);
