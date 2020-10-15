# sqlfile
サーバー上のSQLファイルを実行する簡単なPHPスクリプトです。

mysqliのサンプルとして作成したので、mysql(mariaDB)専用です。

## 設定

同封の `config.php` を編集して下さい。

~~~php
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
~~~

* database --- データベースの接続先を指定して下さい。
* sql_file --- SQLファイルを保存しているパスを指定して下さい。

## sqlfileの使い方

SQLファイルをURLのクエリ文字列で指定して実行します：

* http://localhost/sqlfile.php?f=sample.sql

SQLテキストを直接指定したい場合は、以下のようにします：

* http://localhost/sqlfile.php?t=SELECT%20*%20FROM%20syain

sqlfileはGET/POST両方のメソッドをサポートしているのでHTMLフォームからも使用できます。

## SQLファイルの仕様

- SQLスクリプトファイルにはSQL文、コメント、EVAL文を含みます。
- 文はセミコロン( ; )で区切って複数入力できます。
- 行コメント( -- Comment )とブロックコメント( /* Comment */ )の両方が使用できます。
- 連続する空白( TAB, Space, 改行文字 )は1つの空白と同じにみなされます。

EVAL文
- EVAL文はPHPのeval関数で実行します。例えば： `EVAL sleep(1);`
- 複文の実行はできません。
- クォート処理をしていないので、`EVAL echo 'Hellow;';` などは途中で文が区切られエラーになります。

## 実行例

~~~sql
# テーブル作成
DROP TABLE IF EXISTS syain;
CREATE TABLE syain (
  syain_no INT(10) NOT NULL,
  syain_name VARCHAR(50),
  bumon_no INT(10),
  PRIMARY KEY (syain_no)
);

# テーブルにデータを挿入
INSERT INTO syain VALUES(1,'Suzuki',3);
INSERT INTO syain VALUES(2,'Yamamoto',1);
INSERT INTO syain VALUES(3,'Tanaka',2);

# テーブルの検索
SELECT * FROM syain;
~~~

上のSQLファイルを次のURLで実行します：

* http://localhost/sqlfile.php?f=sample.sql

![実行結果](http://www.y2sunlight.com/ground/lib/exe/fetch.php?w=463&h=183&tok=c9cf60&media=mariadb:10.4:sqlfile01.png)

## クイックスタート

#### データベースの作成

データベースとユーザを作成します。

例：
- ホスト： localhost
- データベース： sunlight_db
- ユーザ： sunlight
- パスワード： sunlight"

#### ダウンロードと設定

[リリース版](https://github.com/y2sunlight/sqlfile/releases)をダウンロードし、適当な場所に解凍して下さい。

ダウンロードした `config.php` を上の「設定」の項を参考にして編集して下さい。


#### Webサーバの起動

ダウンロードした `sqlfile.php` の存在するディレクトリでPHPのビルトインサーバーを実行します。

* php -S localhost:8888

#### sqlfileの実行

ブラウザで以下のようにして `sqlfile.php` を実行します：

* http://localhost:8888/sqlfile.php?f=sample.sql


## リンク
sqlfileを使った他の実行例は以下のサイトをご覧下さい。

* [y2sunlight.com](http://www.y2sunlight.com/ground/doku.php?id=mariadb:10.4:mysqli)


## License
The sqlfile is licensed under the MIT license. See [License File](LICENSE) for more information.
