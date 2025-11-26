<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Loja da Chape</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
<?php
$BASE_URL = "/Trabalho2_Jackson-PHP/Trabalho_2-PHP-Orientado-a-Objetos-com-PDO-e-DB";
?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">

            <!-- Logo direciona para o index público -->
            <a class="navbar-brand" href="<?= $BASE_URL ?>/loja/index.php">
                Loja da Chape
            </a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <!-- Home do seu site HTML antigo -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL ?>/site-chape/index.html">Home</a>
                    </li>

                    <!-- Página inicial da loja (público) -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL ?>/loja/index.php">Loja</a>
                    </li>

                    <!-- Login Administrativo -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL ?>/loja/site/admin/login.php">
                            Área Administrativa
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
