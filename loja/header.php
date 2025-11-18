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
            <a class="navbar-brand" href="<?= $BASE_URL ?>/loja/index.php">Admin Loja</a>
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button> -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL?>/site-chape/index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL?>/loja/site/admin/produto/ProdutoList.php">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL?>/loja/site/admin/cliente/ClienteList.php">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL?>/loja/site/admin/funcionario/FuncionarioList.php">Funcionarios</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>