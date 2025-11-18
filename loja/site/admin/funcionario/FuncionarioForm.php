<?php
include '../../../header.php';
include '../../../db.class.php';

$db = new db('funcionario');
$data = null;

if (!empty($_POST)) {

    try {
        $errors = [];

        if (empty($_POST['nome'])) {
            $errors[] = 'O nome é obrigatório';
        }

        if (empty($_POST['cpf'])) {
            $errors[] = 'O CPF é obrigatório';
        }

        if (empty($errors)) {

            // Mapeamento para o nome das colunas corretas da tabela
            $dados = [
                'Nome'    => $_POST['nome'],
                'Cargo'   => $_POST['cargo'],
                'CPF'     => $_POST['cpf'],
                'Contato' => $_POST['contato']
            ];

            // Inserir no banco
            $db->store($dados);

            echo "<script>alert('Funcionário salvo com sucesso!');</script>";
            echo "<script>window.location.href='FuncionarioList.php';</script>";
            exit;
        }

    } catch (Exception $e) {
        var_dump($errors, $e->getMessage());
        exit;
    }
}

if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

?>

<h3>Cadastro de Funcionário</h3>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <?= implode("<br>", $errors) ?>
</div>
<?php endif; ?>

<form action="" method="post">
    <input type="hidden" name="id" value="<?= $data->CPF ?? '' ?>">

    <div class="row">
        <div class="col-6">
            <label class="form-label">Nome</label>
            <input class="form-control" type="text" name="nome" value="<?= $data->Nome ?? '' ?>">
        </div>

        <div class="col-6">
            <label class="form-label">Cargo</label>
            <input class="form-control" type="text" name="cargo" value="<?= $data->Cargo ?? '' ?>">
        </div>
    </div>

    <div class="row">
        <div class="col">
            <label class="form-label">CPF</label>
            <input class="form-control" type="text" name="cpf" value="<?= $data->CPF ?? '' ?>">
        </div>

        <div class="col">
            <label class="form-label">Contato</label>
            <input class="form-control" type="text" name="contato" value="<?= $data->Contato ?? '' ?>">
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="./FuncionarioList.php" class="btn btn-primary">Voltar</a>
        </div>
    </div>

</form>

<?php include '../../../footer.php'; ?>
