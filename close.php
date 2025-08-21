<?php
/** 
 * Login em PHP
 * Aula do Professor: Murilo Gomes
 * Twitch: https://twitch.tv/profmu
 * YouTube: https://youtube.com/@mugomesoficial
 */
 
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('miaula', true);

include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/checklogin.php');

$vetor = filter_input(INPUT_COOKIE, 'admInfo', FILTER_DEFAULT, FILTER_FORCE_ARRAY);

if (!empty($vetor)) {
    try {
        $conecta = mysqli_connect($dbConfig['server'], $dbConfig['username'], $dbConfig['password'], $dbConfig['database']);
        if (mysqli_connect_errno()) {
            throw new Exception(mysqli_connect_error());
        }
        mysqli_set_charset($conecta, 'utf8mb4');
        mysqli_query($conecta, "UPDATE mi_login SET idtoken1='',idtoken2='' WHERE idtoken1='{$vetor['strToken1']}'");
        mysqli_close($conecta);

        setcookie('admInfo[strToken1]', '', 0, '/', getenv('SERVER_NAME'), false, true);
        setcookie('admInfo[strToken2]', '', 0, '/', getenv('SERVER_NAME'), false, true);
        
        printf('<script>window.location.assign(\'https://%s\');</script>', getenv('SERVER_NAME'));
    } catch (mysqli_sql_exception | Exception $ex) {
        echo $ex->__toString();
    }
}
