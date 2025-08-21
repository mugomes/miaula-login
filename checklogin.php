<?php
/** 
 * Login em PHP
 * Aula do Professor: Murilo Gomes
 * Twitch: https://twitch.tv/profmu
 * YouTube: https://youtube.com/@mugomesoficial
 */
 
if (!defined('miaula')) {
    exit;
}

function checkLogin():bool
{
    global $dbConfig;

    $cLogin = false;

    try {
        $vetor = filter_input(INPUT_COOKIE, 'admInfo', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        if (!empty($vetor)) {
            $vToken1 = $vetor['strToken1'];
            $vToken2 = $vetor['strToken2'];

            if (!empty($vToken1) && !empty($vToken2)) {
                $conecta = mysqli_connect($dbConfig['server'], $dbConfig['username'], $dbConfig['password'], $dbConfig['database']);
                if (mysqli_connect_errno()) {
                    throw new Exception(mysqli_connect_error());
                }
                mysqli_set_charset($conecta, 'utf8mb4');
                if ($result = mysqli_prepare($conecta, 'SELECT idtoken2 FROM mi_login WHERE idtoken1=?')) {
                    mysqli_stmt_bind_param($result, 's', $vToken1);
                    mysqli_stmt_execute($result);

                    $query = mysqli_stmt_get_result($result);
                    $row = mysqli_fetch_array($query);

                    if (!empty($row)) {
                        if (password_verify($vToken2, $row['idtoken2'])) {
                            $cLogin = true;
                        }
                    }

                    mysqli_stmt_free_result($result);
                }
                mysqli_close($conecta);
            }
        }
    } catch (mysqli_sql_exception | Exception $ex) {
        echo $ex->__toString();
    } finally {
        return $cLogin;
    }
}

if (!checkLogin()) {
    printf('<script>window.location.assign(\'https://%s\');</script>', getenv('SERVER_NAME'));
}
