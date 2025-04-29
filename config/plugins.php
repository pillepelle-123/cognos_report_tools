<?php

return [
    // 'DebugKit' => [
    //     'onlyDebug' => true,
    // ],
    'Bake' => [
        'onlyCli' => true,
        'optional' => true,
    ],
    // 'Migrations' => [        // wird geladen durch $this->addPlugin('Migrations'); in bootstrap.php
    //     'onlyCli' => true,
    // ],
    'QueryExpander' => [],
];
