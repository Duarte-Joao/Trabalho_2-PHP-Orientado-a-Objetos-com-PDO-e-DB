<?php
class db
{

    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $port = "3306";
    private $dbname = "db_pweb1_2025_2";
    private $table_name;


    public function __construct($table_name)
    {
        $this->table_name = $table_name;
    }

    function conn()
    {

        try {
            $conn = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;port=$this->port",
                $this->user,
                $this->password,
                [
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => " SET NAMES utf8"
                ]
            );

            return $conn;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
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
                $sql .= " ? ";
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
        $id = $dados['id'];
        $conn = $this->conn();
        $flag = 0;
        $arrayDados = [];

        $sql = "UPDATE `$this->table_name` SET ";

        foreach($dados as $campo => $valor){
            if($flag ==0){
                $sql .= "$campo = ? ";
            }else{
                $sql .= ", $campo = ? ";
            }
            $flag = 1;
            $arrayDados = $valor;
        }

        $sql .= " WHERE id = $id ";


        $st = $conn->prepare($sql); //$st = statement
        $st->execute($arrayDados);
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