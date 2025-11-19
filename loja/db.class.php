<?php
class db
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $port = "3306";
    // coloque o nome exato do seu banco aqui (o que existe no HeidiSQL/phpMyAdmin)
    private $dbname = "lojachape";
    private $table_name;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
    }

    public function conn()
    {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $conn = new PDO($dsn, $this->user, $this->password, $options);
            return $conn;
        } catch (PDOException $e) {
            // Mensagem amigável em desenvolvimento — evite mostrar em produção
            die("Erro de conexão ao banco: " . $e->getMessage());
        }
    }

    public function store($dados)
    {

        $conn = $this->conn();
        $flag = 0;
        $arrayDados = [];


        $sql = "INSERT INTO $this->table_name ("; //ISSO AQUI É PARA CONCATENAR OS CAMPOS O SQL E E TORNAR A INSERÇÃO GENERICA
        
        foreach($dados as $campo => $valor){
            if($flag == 0){
                $sql .= "$campo";                     // .= é para concatenar
            }else{
                $sql .=", $campo";
            }
            $flag = 1;
        }

        $sql .= ") VALUES (";

        $flag = 0;
        foreach($dados as $campo => $valor){    //ISSO AQUI É PARA CONCATENAR OS VALORERS DA TABELA
            if($flag == 0){
                $sql .= " ? ";                     // .= é para concatenar
            }else{
                $sql .= ", ? ";
            }
            $flag =1;
            $arrayDados[] = $valor;
        }

        $sql .= "); ";                                  //ATÉ AQUI!!!!!!

        $st = $conn->prepare($sql);
        $st->execute($arrayDados);
    }

    public function update($dados)
    {
    // pega o ID e remove do array
    $id = $dados['id'];
    unset($dados['id']);

    $conn = $this->conn();
    $array = [];

    // Monta SQL dinâmico
    $sql = "UPDATE {$this->table_name} SET ";
    $flag = 0;

    foreach ($dados as $campo => $valor) {

        // pula campos vazios ou inexistentes
        if ($campo == 'id') continue;

        if ($flag == 0) {
            $sql .= "$campo = ?";
        } else {
            $sql .= ", $campo = ?";
        }

        $array[] = $valor;
        $flag = 1;
    }

    // adiciona o ID ao final (para o WHERE)
    $sql .= " WHERE id = ? ";
    $array[] = $id;

    // prepara e executa
    $st = $conn->prepare($sql);
    return $st->execute($array);
    }   


    public function all(){

        $conn = $this->conn();
        $sql = "SELECT * FROM $this->table_name";

        $st = $conn->prepare($sql);
        $st->execute();

        return $st->fetchAll(PDO::FETCH_CLASS);
    }

    public function find($id){

        //slect 8 from usuario where id =5 --> exemplo

        $conn = $this->conn();
        $sql = "SELECT * FROM $this->table_name WHERE id = ?";

        $st = $conn->prepare($sql);
        $st->execute([$id]);

        return $st->fetchObject();
    }

    public function destroy($id){

        $conn = $this->conn();
        $sql = "DELETE FROM $this->table_name WHERE id = ?";

        $st = $conn->prepare($sql);
        $st->execute([$id]);
        
    }

    public function search($dados){

        $campo = $dados['tipo'];
        $valor = $dados['valor'];

        $conn = $this->conn();
        $sql = "SELECT * FROM $this->table_name WHERE $campo LIKE ?";

        $st = $conn->prepare($sql);
        $st->execute(["%$valor%"]);

        return $st->fetchAll(PDO::FETCH_CLASS);
    }}

    /*public function login($dados)
{
    $conn - $this->conn();

    $sql = 'SELCT * FROM $this->table_name WHERE login = ?';
    
    $st = $conn->prepare($sql);
    $st->execute([$dados['login']]);

    $result = $st->fetchObject();

    if(password_verify($dados['senha'], $result->senha)){
        return $result;
    } else{
        return 'error';
    }

}

public function checkLogin()
{
    session_start();

    if(empty($_SESSION['login'])){
        session_destroy();
        header('Location: ../login.php?error=Sessão Expirada!'); //direcionando o usuario para a pagina de login de volta

    }
}
}*/

    // ... mantenha aqui seus métodos store/update/all/find/destroy/search, etc.

