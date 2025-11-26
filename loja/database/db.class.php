<?php
class db
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $port = "3306";
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
            die("Erro de conexão ao banco: " . $e->getMessage());
        }
    }

    public function store($dados)
    {
        $conn = $this->conn();
        $flag = 0;
        $arrayDados = [];

        $sql = "INSERT INTO {$this->table_name} (";
        foreach ($dados as $campo => $valor) {
            if ($flag == 0) {
                $sql .= "$campo";
            } else {
                $sql .= ", $campo";
            }
            $flag = 1;
        }

        $sql .= ") VALUES (";

        $flag = 0;
        foreach ($dados as $campo => $valor) {
            if ($flag == 0) {
                $sql .= " ?";
            } else {
                $sql .= ", ?";
            }
            $flag = 1;
            $arrayDados[] = $valor;
        }

        $sql .= ")";

        $st = $conn->prepare($sql);
        return $st->execute($arrayDados);
    }

    public function update($dados)
    {
        if (empty($dados['id'])) {
            throw new Exception("É necessário informar o campo id para atualizar.");
        }

        $id = $dados['id'];
        unset($dados['id']);

        $conn = $this->conn();
        $array = [];

        $sql = "UPDATE {$this->table_name} SET ";
        $flag = 0;

        foreach ($dados as $campo => $valor) {
            if ($flag == 0) {
                $sql .= "$campo = ?";
            } else {
                $sql .= ", $campo = ?";
            }
            $array[] = $valor;
            $flag = 1;
        }

        $sql .= " WHERE id = ?";
        $array[] = $id;

        $st = $conn->prepare($sql);
        return $st->execute($array);
    }

    public function all()
    {
        $conn = $this->conn();
        $sql = "SELECT * FROM {$this->table_name}";

        $st = $conn->prepare($sql);
        $st->execute();

        return $st->fetchAll(PDO::FETCH_CLASS);
    }

    public function find($id)
    {
        $conn = $this->conn();
        $sql = "SELECT * FROM {$this->table_name} WHERE id = ?";

        $st = $conn->prepare($sql);
        $st->execute([$id]);

        return $st->fetchObject();
    }

    public function destroy($id)
    {
        $conn = $this->conn();
        $sql = "DELETE FROM {$this->table_name} WHERE id = ?";

        $st = $conn->prepare($sql);
        return $st->execute([$id]);
    }

    public function search($dados)
    {
        $campo = $dados['tipo'] ?? null;
        $valor = $dados['valor'] ?? null;

        if (empty($campo) || $valor === null) {
            return $this->all();
        }

        $conn = $this->conn();
        $sql = "SELECT * FROM {$this->table_name} WHERE {$campo} LIKE ?";

        $st = $conn->prepare($sql);
        $st->execute(["%{$valor}%"]);

        return $st->fetchAll(PDO::FETCH_CLASS);
    }

    public function login($dados)
    {
        $conn = $this->conn();

        $sql = "SELECT * FROM usuario WHERE login = ?";
        $st = $conn->prepare($sql);
        $st->execute([$dados['login']]);

        $result = $st->fetchObject();

        if (!$result) {
            return 'error';
        }

        if (password_verify($dados['senha'], $result->senha)) {
            return $result;
        } else {
            return 'error';
        }
    }

    public function checkLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['admin_id'])) {
            session_destroy();
            header("Location: login.php?error=Sessão Expirada!");
            exit;
        }
    }
}
