<?php
include '../../../header.php';
include '../../../db.class.php';

$db = new db('funcionario');

// Se tem busca
if (!empty($_POST['valor'])) {
    $dados = $db->search([
        'tipo'  => $_POST['tipo'],
        'valor' => $_POST['valor']
    ]);
} else {
    // Lista tudo
    $dados = $db->all();
}

// Se deletar
if (!empty($_GET['cpf'])) {
    $db->destroy($_GET['cpf']);
    header("Location: FuncionarioList.php");
    exit;
}

?>

<h3>Funcionários</h3>

<form method="post">
    <div class="row mb-3">
        <div class="col-2">
            <select name="tipo" class="form-control">
                <option value="Nome">Nome</option>
                <option value="CPF">CPF</option>
                <option value="Contato">Contato</option>
            </select>
        </div>

        <div class="col-6">
            <input type="text" name="valor" placeholder="Pesquisar" class="form-control">
        </div>

        <div class="col-4">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="./FuncionarioForm.php" class="btn btn-success">Novo Funcionário</a>
        </div>
    </div>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Cargo</th>
            <th>CPF</th>
            <th>Contato</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($dados)): ?>
            <?php foreach ($dados as $item): ?>
                <tr>
                    <td><?= $item->Nome ?></td>
                    <td><?= $item->Cargo ?></td>
                    <td><?= $item->CPF ?></td>
                    <td><?= $item->Contato ?></td>

                    <td>
                        <a href="FuncionarioForm.php?cpf=<?= $item->CPF ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="FuncionarioList.php?cpf=<?= $item->CPF ?>"
                           onclick="return confirm('Deseja realmente excluir?')"
                           class="btn btn-danger btn-sm">Excluir</a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Nenhum funcionário encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../../../footer.php'; ?>
