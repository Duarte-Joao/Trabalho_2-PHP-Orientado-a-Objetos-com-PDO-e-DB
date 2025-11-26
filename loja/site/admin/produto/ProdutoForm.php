<?php
include '../../../header.php';
include '../../../database/db.class.php';
+

$db = new db('produtos');
$data = null;
$errors = [];
$db->checkLogin();


// CARREGAR PARA EDIÇÃO
if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {

    if (empty($_POST['Nome']))
        $errors[] = "O nome é obrigatório";

    if (empty($errors)) {

        $dados = [
            'Nome'      => $_POST['Nome'],
            'Descricao' => $_POST['Descricao']
        ];

        if (!empty($_POST['id'])) {
            $dados['id'] = $_POST['id'];
            $db->update($dados);

            echo "<script>alert('Produto atualizado com sucesso!');</script>";
        } else {
            $db->store($dados);

            echo "<script>alert('Produto cadastrado com sucesso!');</script>";
        }

        echo "<script>window.location.href='ProdutoList.php';</script>";
        exit;
    }
}
?>

<h3>Cadastro de Produto</h3>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <?= implode("<br>", $errors) ?>
</div>
<?php endif; ?>

<form action="" method="post">

    <input type="hidden" name="id" value="<?= $data->id ?? '' ?>">

    <label class="form-label mt-2">Nome</label>
    <input class="form-control" name="Nome" value="<?= $data->Nome ?? '' ?>">

    <label class="form-label mt-2">Descrição</label>
    <input class="form-control" name="Descricao" value="<?= $data->Descricao ?? '' ?>">

    <div class="row mt-4">
        <div class="col">
            <button class="btn btn-success">Salvar</button>
            <a href="./ProdutoList.php" class="btn btn-primary">Voltar</a>
        </div>
    </div>

</form>

<?php include '../../../footer.php'; ?>
