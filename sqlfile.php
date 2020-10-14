<?php
/**
 * Configuration
 */
require 'utilities.php';

// データベース接続先
define("HOST",          "localhost");   // ホスト名
define("USER_NAME",     "sunlight");    // ユーザ名
define("PASSWORD",      "sunlight");    // パスワード
define("DATABASE_NAME", "sunlight_db"); // データベース名
define("PORT",          3306);          // ポート

// SQLファイルの保存先
define("SQL_PATH", dirname(__FILE__) . "/sql");

/**
 * Main
 */
// SQスクリプト取得
if (isset($_REQUEST['f']))
{
    $sql_file = SQL_PATH . "/{$_REQUEST['f']}";
    if (!file_exists($sql_file)) die('File does not exists');

    $sql_array = file_get_sql($sql_file);
}
elseif (isset($_REQUEST['t']))
{
    $sql_array = array_get_sql($_REQUEST['t']);
}
else
{
    die('Illegal request');
}

// データベースへの接続
$mysqli = @new mysqli( HOST, USER_NAME, PASSWORD, DATABASE_NAME, PORT );
if( $mysqli->connect_errno )
{
    die($mysqli->connect_errno . ' : ' . $mysqli->connect_error);
}

// 文字セットの指定
if (isset($_REQUEST['s']))
{
    $mysqli->query('SET NAMES utf8');
}

// レスポンス処理
HTML_Begin();
DoSqlScript( $mysqli, $sql_array );
HTML_End();

// データベースの切断
$mysqli->close();

/**
 * SQLスクリプトの実行
 * @param mysqli $mysqli　MySQLiオブジェクト
 * @param string[] $sql_text SQL文の配列
 */
function DoSqlScript( mysqli $mysqli, array $sql_text )
{
    if (empty($sql_text)) return;

    $sqltime = 0;
    foreach( $sql_text as $sql )
    {
        // SQL文表示
        print HTML_Escape(strlen($sql)<80 ? $sql : substr($sql,0,80)." ...");
        print "<br />\n";
        ob_flush(); flush();

        if ( !$sql ) continue; # 空行

        // 特別なEVAL文の実行
        if ( preg_match( "/^eval\s+(.+)/i", $sql, $reg ) )
        {
            eval("{$reg[1]};");
            continue;
        }

        // SELECT文と非SELECT文で処理を分ける
        $time1 =  microtime_as_float();
        if (preg_match("/^(select|show)\s/i", $sql))
        {
            if (!DoSelect($mysqli, $sql)) break;
        }
        else
        {
            $res = $mysqli->query($sql);
            if($res===false)
            {
                SqlError("DoSqlScript", $mysqli->error);
                break;
            }
        }
        $time2 =  microtime_as_float();
        $sqltime += ($time2-$time1);

        ob_flush(); flush();
    }
    print "exec time: ".sprintf('%01.03f', $sqltime)." [sec]<br />\n";
}

/**
 * SELECT文の実行
 * @param mysqli $mysqli　MySQLiオブジェクト
 * @param string $sql SQL文
 * @return boolean 成功でTrueを返す
 */
function DoSelect( mysqli $mysqli, string $sql )
{
    // 検索実行
    $res = $mysqli->query($sql);
    if($res===false)
    {
        SqlError("DoSelect", $mysqli->error);
        return false;
    }

    // カラム名の表示
    if ($rows = $res->fetch_all(MYSQLI_ASSOC))
    {
        print "<table>\n";
        print "<tr>\n";
        foreach( $rows[0] as $key => $value )
        {
            print "<th>$key</th>\n";
        }
        print "</tr>\n";
    }
    else
    {
        print "No results found.<br />\n";
        return true;
    }

    // 行の表示
    foreach( $rows as $row )
    {
        print "<tr>\n";
        foreach( $row as $value )
        {
            $value = HTML_Escape($value);
            print "<td>$value</td>\n";
        }
        print "</tr>\n";
    }

    print "</table><br />\n";
    return true;
}

/**
 *　マイクロ秒取得
 * @return float
 */
function microtime_as_float()
{
    list($usec, $sec) = explode(' ', microtime());
    return ((float)$sec + (float)$usec);
}

/**
 * HTML エスケープ
 * @param string $str
 * @return string
 */
function HTML_Escape( string $str )
{
    return htmlentities( $str, ENT_QUOTES, "utf-8" );
}

/**
 * HTML エスケープ(FORM用)
 * @param string $str
 * @return string
 */
function FORM_Escape( string $str )
{
    return htmlspecialchars( $str, ENT_QUOTES, "utf-8" );
}

/**
 * HTMLの開始処理
 */
function HTML_Begin()
{
    header('Content-type: text/html; charset=utf8');
    print <<<EOF
<html>
<head>
<style type="text/css">
body  {font:10pt monospace;}
table {font:10pt monospace;border-collapse:collapse;}
th,td {border:solid 1px #000000;}
th    {background-color:#eeeeee;}
</style>
</head>
<body>\n
EOF;
}

/**
 * HTMLの終了処理
 */
function HTML_End(){
    print "</body></html>\n";
}

/**
 * エラーメッセージ表示
 * @param string $title タイトル
 * @param string $msg メッセージ
 */
function SqlError($title, $msg)
{
    print "<span style='color:red'>[Error]$title: $msg</span><br />\n";
}
