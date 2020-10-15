<?php
return
[
    /* データベース接続先設定 */
    'database' =>[
        'host' => "localhost",
        'username' => "sunlight",
        'password' => "sunlight",
        'database_name' => "sunlight_db",
        'port' => "3306",
        'initial_statements'=> [
            'set names utf8',
        ],
    ],
    /* SQLファイル設定 */
    'sql_file' =>[
        'path' => dirname(__FILE__) . "/sql",
    ],
];
