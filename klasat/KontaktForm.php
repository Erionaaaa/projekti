<?php
class KontaktForm {
    private $servername = "127.0.0.1";
    private $username = "root";
    private $password = "root";
    private $dbname = "projekti";
    private $conn;

    public $emri;
    public $email;
    public $mesazhi;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct() {
        $this->conn->close();
    }

    public function valido($emri, $email, $mesazhi) {
        $errors = [];
        if (empty($emri)) {
            $errors[] = "Emri duhet te plotesohet.";
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email jovalid.";
        }
        if (empty($mesazhi)) {
            $errors[] = "Mesazhi duhet te plotesohet.";
        }
        return $errors;
    }

    public function ruaj($emri, $email, $mesazhi) {
        $stmt = $this->conn->prepare("INSERT INTO kontakt (emri, email, mesazhi) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $emri, $email, $mesazhi);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function merrKontaktet() {
        $kontakte = [];
        $sql = "SELECT emri, email, mesazhi, data FROM kontakt ORDER BY data DESC";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $kontakte[] = $row;
            }
        }
        return $kontakte;
    }
}
