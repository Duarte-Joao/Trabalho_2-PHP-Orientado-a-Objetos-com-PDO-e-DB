<?php
include '../../../header.php';
include '../../../database/db.class.php';



$db = new db('clientes');
$data = null;
$errors = [];

$db->checkLogin();

// Se estiver editando (carrega os dados do cliente)
if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {

    if (empty($_POST['Nome'])) {
        $errors[] = 'O nome é obrigatório';
    }

    if (empty($_POST['CPF'])) {
        $errors[] = 'O CPF é obrigatório';
    }

    if (empty($_POST['Telefone'])) {
        $errors[] = 'O telefone é obrigatório';
    }

    // Se não houver erros, salvar
    if (empty($errors)) {

        $dados = [
            'Nome'       => $_POST['Nome'],
            'Telefone'   => $_POST['Telefone'],
            'Nascimento' => $_POST['Nascimento'],
            'CPF'        => $_POST['CPF']
        ];

        // UPDATE
        if (!empty($_POST['id'])) {
            $dados['id'] = $_POST['id'];
            $db->update($dados);

            echo "<script>alert('Cliente atualizado com sucesso!');</script>";

        } else {
            // INSERT
            $db->store($dados);
            echo "<script>alert('Cliente cadastrado com sucesso!');</script>";
        }

        echo "<script>window.location.href='ClienteList.php';</script>";
        exit;
    }
}

?>

<h3>Cadastro de Cliente</h3>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?= implode("<br>", $errors) ?>
    </div>
<?php endif; ?>

<form action="" method="post">

    <input type="hidden" name="id" value="<?= $data->id ?? '' ?>">

    <div class="row">
        <div class="col-6">
            <label class="form-label">Nome</label>
            <input class="form-control" name="Nome"
                   value="<?= $data->Nome ?? '' ?>">
        </div>

        <div class="col-6">
            <label class="form-label">Telefone</label>
            <input class="form-control" name="Telefone"
                   value="<?= $data->Telefone ?? '' ?>">
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-4">
            <label class="form-label">Nascimento</label>
            <input type="date" class="form-control" name="Nascimento"
                   value="<?= $data->Nascimento ?? '' ?>">
        </div>

        <div class="col-8">
            <label class="form-label">CPF</label>
            <input class="form-control" name="CPF"
                   value="<?= $data->CPF ?? '' ?>">
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <button class="btn btn-success">Salvar</button>
            <a href="./ClienteList.php" class="btn btn-primary">Voltar</a>
        </div>
    </div>

</form>

<?php include '../../../footer.php'; ?>
