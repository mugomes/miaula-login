<?php
/**
 * Login em PHP
 * Aula do Professor: Murilo Gomes
 * Twitch: https://twitch.tv/profmu
 * YouTube: https://youtube.com/@mugomesoficial
 */
 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_name('3ugdiubd23id2udb23d3223');
session_start();

define('miaula', true);

function gerarSenha(int $tamanho = 5, bool $maiusculo = true, bool $numeros = true, bool $simbolos = false): string {
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';

    $retorno = '';
    $caracteres = $lmin;
    $caracteres .= ($maiusculo) ? $lmai : '';
    $caracteres .= ($numeros) ? $num : '';
    $caracteres .= ($simbolos) ? $simb : '';

    $len = strlen($caracteres);

    for ($i=1; $i <= $tamanho ; $i++) { 
        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand - 1];
    }

    return $retorno;
}

function gerarToken() {
    global $dbConfig;
    $sToken = gerarSenha(10, true, true, true);

    try {
        $conecta = mysqli_connect($dbConfig['server'], $dbConfig['username'], $dbConfig['password'], $dbConfig['database']);
        if (mysqli_connect_errno()) {
            throw new Exception(mysqli_connect_error());
        }
        mysqli_set_charset($conecta, 'utf8mb4');
        $result = mysqli_query($conecta, "SELECT idtoken1 FROM mi_login WHERE idtoken1='{$sToken}'");
        $row = mysqli_fetch_array($result);
        if (!empty($row)) {
            $exists = true;
        }
        mysqli_free_result($result);
        mysqli_close($conecta);

        if (isset($exists)) {
            gerarToken();
        }

        return $sToken;
    } catch (mysqli_sql_exception|Exception $ex) {
        echo $ex->__toString();
    }
}

if (getenv('REQUEST_METHOD') == 'POST') {
    if (empty($_POST['txtMiMel'])) {
        if ($_SESSION['token'] == $_POST['txtToken']) {
            include_once(dirname(__FILE__) . '/config.php');

            $txtEmail = filter_input(INPUT_POST, 'txtEmail', FILTER_SANITIZE_EMAIL);
            $txtSenha = filter_input(INPUT_POST, 'txtSenha');

            if (!empty($txtEmail) && !empty($txtSenha)) {
                try {
                    $conecta = mysqli_connect($dbConfig['server'], $dbConfig['username'], $dbConfig['password'], $dbConfig['database']);
                    if (mysqli_connect_errno()) {
                        throw new Exception(mysqli_connect_error());
                    }
                    mysqli_set_charset($conecta, 'utf8mb4');
                    if ($result = mysqli_prepare($conecta, 'SELECT id,senha FROM mi_login WHERE email=?')) {
                        mysqli_stmt_bind_param($result, 's', $txtEmail);
                        mysqli_stmt_execute($result);
                        $query = mysqli_stmt_get_result($result);
                        $row = mysqli_fetch_array($query);

                        if (!empty($row)) {
                            if (password_verify($txtSenha, $row['senha'])) {
                                $txtToken1 = gerarToken();
                                $txtToken2 = gerarSenha(20, true, true, true);
                                
                                $txtID = $row['id'];
                                $errorLogin = false;
                            } else {
                                $errorLogin = true;
                            }
                        } else {
                            $errorLogin = true;
                        }

                        mysqli_stmt_free_result($result);
                        $query = null;
                    } else {
                        $errorLogin = true;
                    }
                    mysqli_close($conecta);

                    if ($errorLogin) {
                        // Redirecionamento
                        printf('<script>window.location.assign(\'https://%s?error=1\');</script>', getenv('SERVER_NAME'));
                    } else {
                        $conecta2 = mysqli_connect($dbConfig['server'], $dbConfig['username'], $dbConfig['password'], $dbConfig['database']);
                        if (mysqli_connect_errno()) {
                            throw new Exception(mysqli_connect_error());
                        }
                        mysqli_set_charset($conecta2, 'utf8mb4');
                        mysqli_query($conecta2, "UPDATE mi_login SET idtoken1='{$txtToken1}',idtoken2='" . password_hash($txtToken2, PASSWORD_DEFAULT) . "' WHERE id={$txtID}");
                        mysqli_close($conecta2);

                        setcookie('admInfo[strToken1]', $txtToken1, 0, '/', getenv('SERVER_NAME'), false, true);
                        setcookie('admInfo[strToken2]', $txtToken2, 0, '/', getenv('SERVER_NAME'), false, true);

                        printf('<script>window.location.assign(\'https://%s/dashboard.php\');</script>', getenv('SERVER_NAME'));
                    }
                } catch (mysqli_sql_exception | Exception $ex) {
                    echo $ex->__toString();
                }
            }
        }
    }
}

$_SESSION['token'] = rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de Login | Aula do Prof Mu</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            font-family: Arial, sans-serif;
        }

        /* Container do formulário (card) */
        .login-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 350px;
        }

        /* Estilo do Título (Login) */
        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .login-container label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .login-container input {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        .login-container button {
            width: 100%;
            padding: 0.8rem;
            background-color: #2575fc;
            border: none;
            border-radius: 8px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }

        .login-container button:hover {
            background: #1a5ed7;
        }

        .login-container p {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .login-container a {
            color: #2575fc;
            text-decoration: none;
        }

        .login-container a:hover {
            text-decoration: underline;
        }

        @media (max-width: 400px) {
            .login-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <?php if (!empty($_GET['error'])) : ?>
        <p>Erro de Login</p>
        <?php endif; ?>
        <h2>Login</h2>
        <form method="post" action="/">
            <label for="txtEmail">E-mail</label>
            <input type="email" id="txtEmail" name="txtEmail" placeholder="Digite seu e-mail" required>

            <label for="txtSenha">Senha</label>
            <input type="password" id="txtSenha" name="txtSenha" placeholder="Digite sua senha" required>

            <input type="hidden" id="txtToken" name="txtToken" value="<?php echo $_SESSION['token']; ?>">
            <input type="hidden" id="txtMiMel" name="txtMiMel">

            <button type="submit">Entrar</button>
        </form>

        <p>Não tem conta? <a href="#">Cadastre-se</a></p>
    </div>
</body>

</html>
