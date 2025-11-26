<?php
session_start();
include '../../database/db.class.php';
$db = new db('admin');

$db->checkLogin();
?>

<?php include '../../header.php'; ?>

<div class="container mt-4">
    <h2>Painel Administrativo</h2>
    <p>Bem-vindo, <?= $_SESSION['admin_login'] ?></p>

    <div class="list-group mt-4">
        <a href="./funcionario/FuncionarioList.php" class="list-group-item">Funcionários</a>
        <a href="./cliente/ClienteList.php" class="list-group-item">Clientes</a>
        <a href="./produto/ProdutoList.php" class="list-group-item">Produtos</a>
        <a href="./venda/VendaList.php" class="list-group-item">Vendas</a>
        <a href="./admin/AdminList.php" class="list-group-item">Administradores</a>
        <a href="logout.php" class="list-group-item list-group-item-danger">Sair</a>
    </div>

</div>

<?php include '../../footer.php'; ?>
