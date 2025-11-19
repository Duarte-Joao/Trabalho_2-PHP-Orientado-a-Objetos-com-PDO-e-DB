<?php
include '../../../header.php';
include '../../../db.class.php';

$db = new db('funcionario');
$data = null;
$errors = [];

// SE FOR EDIÇÃO — CARREGA OS DADOS
if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

// SE ENVIAR O FORMULÁRIO
if (!empty($_POST)) {

    try {

        if (empty($_POST['Nome']))  $errors[] = 'O nome é obrigatório';
        if (empty($_POST['CPF']))   $errors[] = 'O CPF é obrigatório';

        if (empty($errors)) {

            // SE TEM ID → UPDATe
            if (!empty($_POST['id'])) {

                $db->update([
                    'id'      => $_POST['id'],
                    'Nome'    => $_POST['Nome'],
                    'Cargo'   => $_POST['Cargo'],
                    'CPF'     => $_POST['CPF'],
                    'Contato' => $_POST['Contato']
                ]);

                echo "<script>alert('Funcionário atualizado com sucesso!');</script>";

            } else {
                // SE NÃO TEM ID → INSERT
                $db->store([
                    'Nome'    => $_POST['Nome'],
                    'Cargo'   => $_POST['Cargo'],
                    'CPF'     => $_POST['CPF'],
                    'Contato' => $_POST['Contato']
                ]);

                echo "<script>alert('Funcionário cadastrado com sucesso!');</script>";
            }

            echo "<script>window.location.href='FuncionarioList.php';</script>";
            exit;
        }

    } catch (Exception $e) {
        echo "<pre>";
        var_dump($e->getMessage());
        echo "</pre>";
        exit;
    }
}
?>

<h3>Cadastro de Funcionário</h3>

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
            <input class="form-control" type="text" name="Nome" value="<?= $data->Nome ?? '' ?>">
        </div>

        <div class="col-6">
            <label class="form-label">Cargo</label>
            <input class="form-control" type="text" name="Cargo" value="<?= $data->Cargo ?? '' ?>">
        </div>
    </div>

    <div class="row">
        <div class="col">
            <label class="form-label">CPF</label>
            <input class="form-control" type="text" name="CPF" value="<?= $data->CPF ?? '' ?>">
        </div>

        <div class="col">
            <label class="form-label">Contato</label>
            <input class="form-control" type="text" name="Contato" value="<?= $data->Contato ?? '' ?>">
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
