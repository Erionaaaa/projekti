<?php

class SliderForm
{
    private $servername = "127.0.0.1";
    private $username = "root";
    private $password = "root";
    private $dbname = "projekti";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function addImage($imageUrl)
    {
        $stmt = $this->conn->prepare("INSERT INTO slider_images (image_url) VALUES (?)");
        $stmt->bind_param("s", $imageUrl);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function removeImage($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM slider_images WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getImages()
    {
        $images = [];
        $result = $this->conn->query("SELECT id, image_url FROM slider_images ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
            $images[] = $row;
        }
        return $images;
    }
}
