<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

return [
    'creativecow' => [
        'satis' => [
            'output_dir'  => realpath('public'),
            'config_json' => realpath('data') . '/satis.json',
        ],
    ],
];
