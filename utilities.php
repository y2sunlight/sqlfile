<?php

/**
 * Gets an array of SQL statemnets from a file.
 *
 * @param string $filename
 * @return array
 */
function file_get_sql(string $filename):array
{
    if (!file_exists($filename)) return [];
    return array_get_sql(file_get_contents($filename));
}

/**
 * Gets an array of SQL statemnets from text.
 *
 * @param string $text
 * @return array
 */
function array_get_sql(string $text=''):array
{
    $text = str_replace(["\r\n","\r"], "\n", $text);

    // Remove comment
    $text = preg_replace("/\/\*.*?\*\//s", '', $text);
    $text = preg_replace("/--.*?$/m", '', $text);

    // Split SQL text
    $sql = preg_split("/\s*;\s*/", $text);
    array_walk($sql, function(&$item){
        $item = trim($item);
    });
    $sql = array_filter($sql, function($val){
        return !empty(trim($val));
    });
    return $sql;
}
