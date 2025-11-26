<?php
include '../../database/db.class.php';
session_start();

if (!empty($_SESSION['admin_id'])) {
    header("Location: indexAdmin.php");
    exit;
}

$db = new db('admin');
$error = "";

if (!empty($_POST)) {

    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($login) || empty($senha)) {
        $error = "Preencha login e senha.";
    } else {
        $conn = $db->conn();
        $sql = "SELECT * FROM admin WHERE login = ?";
        $st = $conn->prepare($sql);
        $st->execute([$login]);
        $admin = $st->fetchObject();

        if ($admin && password_verify($senha, $admin->senha)) {
            $_SESSION['admin_id'] = $admin->id;
            $_SESSION['admin_login'] = $admin->login;

            header("Location: indexAdmin.php");
            exit;
        } else {
            $error = "Login ou senha inválidos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="col-4 offset-4">

        <div class="card">
            <div class="card-header bg-success text-white">
                <h4>Login Administrativo</h4>
            </div>

            <div class="card-body">

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form method="post">

                    <div class="mb-3">
                        <label class="form-label">Login</label>
                        <input type="text" class="form-control" name="login">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" class="form-control" name="senha">
                    </div>

                    <button type="submit" class="btn btn-success w-100">Entrar</button>

                </form>

                <a href="../../index.php" class="btn btn-secondary w-100 mt-3">Voltar</a>

            </div>
        </div>

    </div>
</div>

</body>
</html>
