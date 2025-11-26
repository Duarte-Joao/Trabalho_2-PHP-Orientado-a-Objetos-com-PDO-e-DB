<?php
include '../../../header.php';
include '../../../database/db.class.php';


$dbAdmin = new db('admin');
$dbFuncionario = new db('funcionario');

$dbAdmin->checkLogin();

// Se deletar
if (!empty($_GET['id'])) {
    $dbAdmin->destroy($_GET['id']);
    header("Location: AdminList.php");
    exit;
}

// Se buscar
if (!empty($_POST['valor'])) {
    $dados = $dbAdmin->search([
        'tipo' => $_POST['tipo'],
        'valor' => $_POST['valor']
    ]);
} else {
    $dados = $dbAdmin->all();
}
?>

<h3>Administradores</h3>

<form method="post">
    <div class="row mb-3">
        <div class="col-2">
            <select name="tipo" class="form-control">
                <option value="login">Login</option>
            </select>
        </div>

        <div class="col-6">
            <input type="text" name="valor" placeholder="Pesquisar" class="form-control">
        </div>

        <div class="col-4">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="AdminForm.php" class="btn btn-success">Novo Admin</a>
        </div>
    </div>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Funcionário</th>
            <th>Login</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($dados)): ?>
            <?php foreach ($dados as $item): 

                $func = $dbFuncionario->find($item->funcionario_id);
            ?>
                <tr>
                    <td><?= $item->id ?></td>
                    <td><?= $func->Nome ?? "Funcionário removido" ?></td>
                    <td><?= $item->login ?></td>

                    <td>
                        <a href="AdminForm.php?id=<?= $item->id ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="AdminList.php?id=<?= $item->id ?>"
                           onclick="return confirm('Deseja excluir?')"
                           class="btn btn-danger btn-sm">Excluir</a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Nenhum administrador encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../../../footer.php'; ?>
