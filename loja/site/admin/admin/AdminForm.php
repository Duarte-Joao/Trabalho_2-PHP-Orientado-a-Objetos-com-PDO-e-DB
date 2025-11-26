<?php
include '../../../header.php';
include '../../../database/db.class.php';



$dbAdmin = new db('admin');
$dbFuncionario = new db('funcionario');

$dbAdmin->checkLogin();

$data = null;
$errors = [];

// Se é edição
if (!empty($_GET['id'])) {
    $data = $dbAdmin->find($_GET['id']);
}

// Se salvar
if (!empty($_POST)) {

    if (empty($_POST['funcionario_id'])) {
        $errors[] = "Escolha um funcionário.";
    }

    if (empty($_POST['login'])) {
        $errors[] = "O login é obrigatório.";
    }

    if (empty($_POST['id'])) { 
        // Cadastro de novo admin
        if (empty($_POST['senha']) || empty($_POST['c_senha'])) {
            $errors[] = "Preencha a senha.";
        } elseif ($_POST['senha'] !== $_POST['c_senha']) {
            $errors[] = "As senhas não coincidem.";
        }

        if (empty($errors)) {
            $dados = [
                'funcionario_id' => $_POST['funcionario_id'],
                'login' => $_POST['login'],
                'senha' => password_hash($_POST['senha'], PASSWORD_BCRYPT)
            ];

            $dbAdmin->store($dados);

            echo "<script>alert('Administrador cadastrado.');</script>";
            echo "<script>location.href='AdminList.php';</script>";
            exit;
        }
    } 

    else {
        // Edição
        $dados = [
            'id' => $_POST['id'],
            'funcionario_id' => $_POST['funcionario_id'],
            'login' => $_POST['login'],
        ];

        if (!empty($_POST['senha'])) {
            if ($_POST['senha'] !== $_POST['c_senha']) {
                $errors[] = "Senhas não coincidem.";
            } else {
                $dados['senha'] = password_hash($_POST['senha'], PASSWORD_BCRYPT);
            }
        }

        if (empty($errors)) {
            $dbAdmin->update($dados);

            echo "<script>alert('Administrador atualizado.');</script>";
            echo "<script>location.href='AdminList.php';</script>";
            exit;
        }
    }
}

$funcionarios = $dbFuncionario->all();
?>

<h3>Cadastro de Administrador</h3>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?= implode("<br>", $errors) ?>
    </div>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="id" value="<?= $data->id ?? '' ?>">

    <div class="mb-3">
        <label class="form-label">Funcionário</label>
        <select name="funcionario_id" class="form-control">
            <option value="">Selecione um funcionário</option>

            <?php foreach ($funcionarios as $f): ?>
                <option value="<?= $f->id ?>"
                    <?= isset($data->funcionario_id) && $data->funcionario_id == $f->id ? "selected" : "" ?>>
                    <?= $f->Nome ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Login</label>
        <input type="text" name="login" class="form-control" 
               value="<?= $data->login ?? '' ?>">
    </div>

    <div class="row">
        <div class="col">
            <label class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control">
        </div>

        <div class="col">
            <label class="form-label">Confirmar Senha</label>
            <input type="password" name="c_senha" class="form-control">
        </div>
    </div>

    <button class="btn btn-success mt-3">Salvar</button>
    <a href="AdminList.php" class="btn btn-secondary mt-3">Voltar</a>
</form>

<?php include '../../../footer.php'; ?>
