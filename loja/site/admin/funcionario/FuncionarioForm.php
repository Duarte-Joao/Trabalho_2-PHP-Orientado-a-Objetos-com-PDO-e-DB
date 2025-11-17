<?php
include '../../../header.php';
include '../../../db.class.php';

$db = new db('funcionario');
$data = null;

if (!empty($_POST)) {
    try {
        $errors = [];
        
        if (empty($_POST['nome'])) {
            $errors[] =  'O nome é obrigatório';
        }

        if (empty($_POST['telefone'])) {
            $errors[] =  'O telefone é obrigatório';
        }

        if (empty($_POST['cpf'])) {
            $errors[] =  'O cpf é obrigatório';
        }


       /* echo "<script>
        setTimeout(
            ()=> window.location.href = 'usuarioList.php', 2000
        );
    </script>";*/
    } catch (Exception $e) {
        var_dump($errors, $e->getMessage());
        exit;
    }
}

if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
    //var_dump($data);
    //exit;
}

?>

<h3>Formulário do Usuário</h3>
<form action="" method="post">
    <input type="hidden" name="id" value="<?= $data->id ?? '' ?>">

    <div class="row">
        <div class="col-6">
            <label for="" class="form-label">Nome</label>
            <input class="form-control" type="text" name="nome" value="<?= $data->nome ?? '' ?>"> <!-- <.?= é iguala a o echo-->
        </div>
        <div class="col-6">
            <label for="" class="form-label">Email</label>
            <input class="form-control" type="text" name="email" value="<?= $data->email ?? '' ?>">
        </div>
    </div>

    <div class="row">
        <div class="col">
            <label for="" class="form-label">CPF</label>
            <input class="form-control" type="text" name="cpf" value="<?= $data->cpf ?? '' ?>">
        </div>
        <div class="col">
            <label for="" class="form-label">Telefone</label>
            <input class="form-control" type="text" name="telefone" value="<?= $data->telefone ?? '' ?>">
        </div>
    </div>

    <div class="row">
        <div class="col mt-4">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="./FuncionarioList.php" class="btn btn-primary">Voltar</a>
        </div>
    </div>
    </div>
</form>

<?php
include '../../../footer.php';
?>