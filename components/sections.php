<?php
// PHP Samples Project Index
// 各セクションとファイルの定義（データ化）
$sections = [
    [
        'id' => '04_hello',
        'label' => 'Hello World (基本)',
        'public' => true,
        'files' => [
            [
                'name' => 'demo.php',
                'label' => 'Hello World',
                'explanation' => 'explain.php?n=04'
            ]
        ]
    ],
    [
        'id' => '05_variable',
        'label' => '変数とデータ型',
        'public' => true,
        'files' => [
            [
                'name' => 'player.php',
                'label' => '変数の基本',
                'explanation' => 'explain.php?n=05'
            ],
            [
                'name' => 'superglobals.php',
                'label' => 'スーパーグローバル変数',
                'explanation' => 'explain.php?n=05'
            ],
            [
                'name' => 'check.php',
                'label' => 'データ型チェック',
                'explanation' => 'explain.php?n=05'
            ]
        ]
    ],
    [
        'id' => '06_calculate',
        'label' => '演算',
        'public' => true,
        'files' => [
            [
                'name' => 'order.php',
                'label' => '演算の基本',
                'explanation' => 'explain.php?n=06'
            ],
        ]
    ],
    [
        'id' => '07_includes',
        'label' => '外部ファイルの読み込み',
        'public' => true,
        'files' => [
            [
                'name' => 'index.php',
                'label' => 'ファイル分離の基本',
                'explanation' => 'explain.php?n=07'
            ],
        ]
    ],
    [
        'id' => '08_condition',
        'label' => '条件分岐 (if/match)',
        'public' => true,
        'files' => [
            [
                'name' => 'menu.php',
                'label' => 'メニュー',
                'explanation' => 'explain.php?n=08'
            ],
            [
                'name' => 'garbage.php',
                'label' => 'ゴミ出しカレンダー',
                'explanation' => 'explain.php?n=08'
            ],
            [
                'name' => 'payment.php',
                'label' => 'お支払い判定',
                'explanation' => 'explain.php?n=08'
            ]
        ]
    ],
    [
        'id' => '09_loops',
        'label' => '繰り返し処理 (for/while)',
        'public' => true,
        'files' => [
            [
                'name' => 'bingo.php',
                'label' => 'ビンゴカード生成',
                'explanation' => 'explain.php?n=09'
            ],
            [
                'name' => 'calculate_loan.php',
                'label' => 'ローン計算シミュレーター',
                'explanation' => 'explain.php?n=09'
            ]
        ]
    ],
    [
        'id' => '10_array_object',
        'label' => '配列とオブジェクト',
        'public' => true,
        'files' => [
            [
                'name' => 'user/',
                'label' => 'ユーザープロフィール',
                'explanation' => 'explain.php?n=10'
            ]
        ]
    ],
    [
        'id' => '11_function',
        'label' => '関数とクロージャ',
        'public' => true,
        'files' => [
            [
                'name' => 'data_check.php',
                'label' => 'ビルトイン関数',
                'explanation' => 'explain.php?n=11'
            ],
            [
                'name' => 'order.php',
                'label' => 'ユーザ定義関数',
                'explanation' => 'explain.php?n=11'
            ],
        ]
    ],
    [
        'id' => '12_form_session',
        'label' => 'フォームとセッション',
        'public' => true,
        'files' => [
            [
                'name' => 'get_request.php',
                'label' => 'GETリクエスト',
                'explanation' => 'explain.php?n=12'
            ],
            [
                'name' => 'post_request.php',
                'label' => 'POSTリクエスト',
                'explanation' => 'explain.php?n=12'
            ],
        ]
    ],
    [
        'id' => '13_datetime',
        'label' => '日付',
        'public' => true,
        'files' => [
            [
                'name' => 'date.php',
                'label' => 'date()関数',
                'explanation' => 'explain.php?n=13'
            ],
            [
                'name' => 'datetime.php',
                'label' => 'DateTimeクラスの使い方',
                'explanation' => 'explain.php?n=13'
            ],
            [
                'name' => 'calendar.php',
                'label' => 'カレンダー表示',
                'explanation' => 'explain.php?n=13'
            ],
        ]
    ],
    [
        'id' => '14_class',
        'label' => 'オブジェクト指向とクラス',
        'public' => true,
        'files' => [
            [
                'name' => 'instance.php',
                'label' => 'OOPとクラス',
                'explanation' => 'explain.php?n=14'
            ],
            [
                'name' => 'card_list.php',
                'label' => 'カードリスト',
                'explanation' => 'explain.php?n=14'
            ],
        ]
    ],
    [
        'id' => '15_card_game',
        'label' => 'クラスの応用',
        'public' => true,
        'files' => [
            [
                'name' => 'card_list.php',
                'label' => 'ポリモーフィズム',
                'explanation' => 'explain.php?n=15'
            ],
        ]
    ],
    [
        'id' => '16_mysql',
        'label' => 'MySQL & PDO',
        'public' => true,
        'files' => [
            [
                'name' => 'fin/create_database.php',
                'label' => 'DB作成',
                'explanation' => 'explain.php?n=16'
            ],
            [
                'name' => 'fin/connect_test.php',
                'label' => 'DB接続テスト',
                'explanation' => 'explain.php?n=16'
            ],
            [
                'name' => 'fin/connect_test_for_module.php',
                'label' => 'DB接続テスト（モジュール化）',
                'explanation' => 'explain.php?n=16'
            ],
        ]
    ],
    [
        'id' => '17_mysql_crud',
        'label' => 'CRUD操作',
        'public' => true,
        'files' => [
            [
                'name' => 'fin/',
                'label' => 'CRUD操作',
                'explanation' => 'explain.php?n=17'
            ],
        ]
    ],
    [
        'id' => '18_register',
        'label' => 'ユーザー登録',
        'public' => true,
        'files' => [
            ['name' => 'fin/regist/', 'label' => '登録画面'],
        ]
    ],
    [
        'id' => '19_signin',
        'label' => 'ユーザー認証',
        'public' => true,
        'files' => [
            ['name' => '/', 'label' => 'サインイン画面'],
        ]
    ],
    [
        'id' => '20_php_sns',
        'label' => 'PHP SNS',
        'public' => true,
        'files' => [
            [
                'name' => 'home/',
                'label' => 'SNSアプリ',
                'explanation' => 'explain.php?n=20_0'
            ],
        ]
    ],
];
