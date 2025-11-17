<?php
include '../../../header.php';
include '../../../db.class.php';

$db = new db('usuario');
/*$db->checkLogin();

//var_dump($dados);
//exit;

if (!empty($_GET['id'])) {
    $db->destroy($_GET['id']);
}

if (!empty($_POST)) {
    $dados = $db->search($_POST);
} else {
    $dados = $db->all();
}*/


?>

<h3>Listagem de Usuários</h3>

<form action="./usuarioList.php" method="post">
    <div class="row">
        <div class="col">
            <select name="tipo">
                <option value="nome">Nome</option>
                <option value="cpf">CPF</option>
                <option value="telefone">Telefone</option>
            </select>
        </div>

        <div class="col">
            <input type="text" name="valor" placeholder="Pesquisar" class="form-control">
        </div>

        <div class="col">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="./FuncionarioForm.php" class="btn btn-success">Cadastrar</a>
        </div>
    </div>
</form>

<div class="row mt-4">
    <div class="col">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Email</th>
                    <th scope="col">Ação</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dados as $item) {
                    echo "<tr>
                            <th scope='row'>$item->id</th>
                            <td>$item->nome</td>
                            <td>$item->telefone</td>
                            <td>$item->cpf</td>
                            <td>$item->email</td>
                            <td><a href='./usuarioForm.php?id=$item->id'>Editar</a></td>
                            <td><a 
                                 href='./usuarioList.php?id=$item->id'
                                onclick='return confirm(\"Deseja Excluir?\")'
                                 >Deletar</a></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<a href="./FuncionarioForm.php" class="btn btn-success">Cadastrar</a>

<?php
include '../../../footer.php'
?>