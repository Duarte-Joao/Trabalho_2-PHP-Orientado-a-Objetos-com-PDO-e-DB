<?php
include '../../../header.php';
include '../../../database/db.class.php';

$db = new db('vendas');
$dbProdutos = new db('produtos');
$db->checkLogin();


// EXCLUSÃO
if (!empty($_GET['id'])) {
    $db->destroy($_GET['id']);
    header("Location: VendaList.php");
    exit;
}

// BUSCA
if (!empty($_POST['valor'])) {
    $dados = $db->search([
        'tipo'  => $_POST['tipo'],
        'valor' => $_POST['valor']
    ]);
} else {
    $dados = $db->all();
}

?>

<h3>Vendas</h3>

<form method="post">
    <div class="row mb-3">
        <div class="col-3">
            <select name="tipo" class="form-control">
                <option value="idProduto">Produto (ID)</option>
                <option value="data">Data</option>
            </select>
        </div>

        <div class="col-5">
            <input type="text" name="valor" placeholder="Pesquisar" class="form-control">
        </div>

        <div class="col-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="./VendaForm.php" class="btn btn-success">Nova Venda</a>
        </div>
    </div>
</form>

<table class="table table-striped">
<thead>
<tr>
    <th>Produto</th>
    <th>Quantidade</th>
    <th>Data</th>
    <th>Valor Total</th>
    <th>Ações</th>
</tr>
</thead>

<tbody>

<?php foreach ($dados as $item): ?>

    <?php 
        // Carrega o nome do produto
        $produto = $dbProdutos->find($item->idProduto);
    ?>

<tr>
    <td><?= $produto->Nome ?? "Produto não encontrado" ?></td>
    <td><?= $item->quantidade ?></td>
    <td><?= $item->data ?></td>
    <td>R$ <?= number_format($item->valor_total, 2, ',', '.') ?></td>

    <td>
        <a href="VendaForm.php?id=<?= $item->id ?>" class="btn btn-primary btn-sm">Editar</a>

        <a href="VendaList.php?id=<?= $item->id ?>"
           onclick="return confirm('Deseja realmente excluir?')"
           class="btn btn-danger btn-sm">Excluir</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php include '../../../footer.php'; ?>
