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
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Administrativa | Aula do Prof Mu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            background: #f4f6f9;
        }

        .sidebar {
            width: 220px;
            background: #2c3e50;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 2rem;
        }

        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            padding: 0.75rem 1rem;
            display: block;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #34485e;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        .main-content h1 {
            margin-bottom: 1rem;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                flex-direction: row;
                overflow-x: auto;
            }

            .sidebar a {
                flex: 1;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Meu Painel</h2>
        <a href="#">Dashboard</a>
        <a href="#">Relatório</a>
        <a href="#">Configurações</a>
        <a href="#">Perfil</a>
        <a href="/close.php">Sair</a>
    </div>
    <div class="main-content">
        <h1>Bem-Vindo ao Dashboard</h1>
        <p>Aqui você pode ver informações importantes de forma rápida.</p>
        <div class="cards">
            <div class="card">
                <h3>Vendas</h3>
                <p>R$ 12.450,00</p>
            </div>
            <div class="card">
                <h3>Usuários</h3>
                <p>1.245 ativos</p>
            </div>
            <div class="card">
                <h3>Feedbacks</h3>
                <p>89 recebidos</p>
            </div>
        </div>
    </div>
</body>

</html>
