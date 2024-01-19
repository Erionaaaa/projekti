<?php

class Page
{
    private $servername = "127.0.0.1";
    private $username = "root";
    private $password = "root";
    private $dbname = "projekti";
    private $conn;

    public $id;
    public $page;
    public $titulli;
    public $permbajtja;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $this->conn->set_charset("utf8");

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    public function loadPageContent($pageName)
    {
        $stmt = $this->conn->prepare("SELECT id, page, titulli, permbajtja FROM page WHERE page = ?");
        $stmt->bind_param("s", $pageName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $this->id = $row['id'];
            $this->page = $row['page'];
            $this->titulli = $row['titulli'];
            $this->permbajtja = $row['permbajtja'];
        } else {
            echo "No results for the page: " . $pageName;
        }

        $stmt->close();
    }

    public function displayPageContent()
    {
        echo "<h2>" . htmlspecialchars($this->titulli) . "</h2>";
        echo "<p>" . htmlspecialchars($this->permbajtja) . "</p>";
    }
}
