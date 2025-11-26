<?php
include '../../../header.php';
include '../../../database/db.class.php';


$db = new db('clientes');
$db->checkLogin();


// EXCLUSÃO
if (!empty($_GET['id'])) {
    $db->destroy($_GET['id']);
    header("Location: ClienteList.php");
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

<h3>Clientes</h3>

<form method="post">
    <div class="row mb-3">
        <div class="col-2">
            <select name="tipo" class="form-control">
                <option value="Nome">Nome</option>
                <option value="CPF">CPF</option>
                <option value="Telefone">Telefone</option>
            </select>
        </div>

        <div class="col-6">
            <input type="text" name="valor" placeholder="Pesquisar" class="form-control">
        </div>

        <div class="col-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="./ClienteForm.php" class="btn btn-success">Novo Cliente</a>
        </div>
    </div>
</form>

<table class="table table-striped">
<thead>
<tr>
    <th>Nome</th>
    <th>Telefone</th>
    <th>Nascimento</th>
    <th>CPF</th>
    <th>Ações</th>
</tr>
</thead>

<tbody>
<?php foreach ($dados as $item): ?>
<tr>
    <td><?= $item->Nome ?></td>
    <td><?= $item->Telefone ?></td>
    <td><?= $item->Nascimento ?></td>
    <td><?= $item->CPF ?></td>

    <td>
        <a href="ClienteForm.php?id=<?= $item->id ?>" class="btn btn-primary btn-sm">Editar</a>

        <a href="ClienteList.php?id=<?= $item->id ?>"
           onclick="return confirm('Deseja realmente excluir?')"
           class="btn btn-danger btn-sm">Excluir</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php include '../../../footer.php'; ?>
