<?php
include '../../../header.php';
include '../../../db.class.php';

$db = new db('produtos');

// EXCLUSÃO
if (!empty($_GET['id'])) {
    $db->destroy($_GET['id']);
    header("Location: ProdutoList.php");
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

<h3>Produtos</h3>

<form method="post">
    <div class="row mb-3">
        <div class="col-2">
            <select name="tipo" class="form-control">
                <option value="Nome">Nome</option>
                <option value="Descricao">Descrição</option>
            </select>
        </div>

        <div class="col-6">
            <input type="text" name="valor" placeholder="Pesquisar" class="form-control">
        </div>

        <div class="col-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="./ProdutoForm.php" class="btn btn-success">Novo Produto</a>
        </div>
    </div>
</form>

<table class="table table-striped">
<thead>
<tr>
    <th>Nome</th>
    <th>Descrição</th>
    <th>Ações</th>
</tr>
</thead>

<tbody>
<?php foreach ($dados as $item): ?>
<tr>
    <td><?= $item->Nome ?></td>
    <td><?= $item->Descricao ?></td>

    <td>
        <a href="ProdutoForm.php?id=<?= $item->id ?>" class="btn btn-primary btn-sm">Editar</a>

        <a href="ProdutoList.php?id=<?= $item->id ?>"
           onclick="return confirm('Deseja realmente excluir?')"
           class="btn btn-danger btn-sm">Excluir</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php include '../../../footer.php'; ?>
