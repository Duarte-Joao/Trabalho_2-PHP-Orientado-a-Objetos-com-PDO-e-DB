<?php
include '../../../header.php';
include '../../../database/db.class.php';

$db = new db('vendas');
$dbProdutos = new db('produtos');
$db->checkLogin();

$data = null;
$errors = [];

// EDITAR
if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

// PROCESSAR FORM
if (!empty($_POST)) {

    if (empty($_POST['idProduto']))
        $errors[] = "Selecione um produto";

    if (empty($_POST['quantidade']))
        $errors[] = "Quantidade obrigatória";

    if (empty($_POST['data']))
        $errors[] = "A data é obrigatória";

    if (empty($_POST['valor_total']))
        $errors[] = "O valor total é obrigatório";

    if (empty($errors)) {

        $dados = [
            'idProduto'  => $_POST['idProduto'],
            'quantidade' => $_POST['quantidade'],
            'data'       => $_POST['data'],
            'valor_total'=> $_POST['valor_total']
        ];

        if (!empty($_POST['id'])) {
            $dados['id'] = $_POST['id'];
            $db->update($dados);

            echo "<script>alert('Venda atualizada com sucesso!');</script>";
        } else {
            $db->store($dados);
            echo "<script>alert('Venda cadastrada com sucesso!');</script>";
        }

        echo "<script>window.location.href='VendaList.php';</script>";
        exit;
    }
}

// CARREGA PRODUTOS
$produtos = $dbProdutos->all();
?>

<h3>Cadastro de Venda</h3>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <?= implode("<br>", $errors) ?>
</div>
<?php endif; ?>

<form action="" method="post">

<input type="hidden" name="id" value="<?= $data->id ?? '' ?>">

<div class="mb-3">
    <label class="form-label">Produto</label>
    <select name="idProduto" class="form-control">
        <option value="">Selecione...</option>

        <?php foreach ($produtos as $p): ?>
            <option value="<?= $p->id ?>"
                <?= (!empty($data->idProduto) && $data->idProduto == $p->id) ? "selected" : "" ?>>
                <?= $p->Nome ?>
            </option>
        <?php endforeach; ?>

    </select>
</div>

<div class="mb-3">
    <label class="form-label">Quantidade</label>
    <input type="number" class="form-control" name="quantidade"
           value="<?= $data->quantidade ?? '' ?>">
</div>

<div class="mb-3">
    <label class="form-label">Data</label>
    <input type="date" class="form-control" name="data"
           value="<?= $data->data ?? '' ?>">
</div>

<div class="mb-3">
    <label class="form-label">Valor Total (R$)</label>
    <input type="number" step="0.01" class="form-control" name="valor_total"
           value="<?= $data->valor_total ?? '' ?>">
</div>

<button class="btn btn-success">Salvar</button>
<a href="./VendaList.php" class="btn btn-primary">Voltar</a>

</form>

<?php include '../../../footer.php'; ?>
