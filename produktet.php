<?php
session_start();

include 'klasat/Page.php';
include 'klasat/Produkti.php';

$isLoggedIn = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$autori = $isLoggedIn ? $_SESSION["email"] : null;
$errors = [];
$success = '';

$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "projekti";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $isLoggedIn) {
    $titulli = $_POST['titulli'];
    $imazhi = $_POST['imazhi'];
    $pershkrimi = $_POST['pershkrimi'];

    if (empty($titulli) || empty($imazhi) || empty($pershkrimi)) {
        $errors[] = "Te gjitha fushat jane te detyrueshme.";
    } else {
        $stmt = $conn->prepare("INSERT INTO produkti (titulli, imazhi, pershkrimi, autori) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $titulli, $imazhi, $pershkrimi, $autori);

        if ($stmt->execute()) {
            $success = "Produkti u shtua me sukses!";
        } else {
            $errors[] = "Gabim ne shtimin e produktit: " . $stmt->error;
        }
        $stmt->close();
    }
}

$produktet = [];

$result = $conn->query("SELECT titulli, imazhi, pershkrimi, autori, date FROM produkti ORDER BY date DESC");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $produktet[] = new Produkti($row['titulli'], $row['imazhi'], $row['pershkrimi'], $row['autori'], $row['date']);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Bag Boutique - Produktet</title>
  </head>
  <body>
    <?php include 'header.php'; ?>
    <div class="permbajtja">
        <?php
        $home = new Page();
        $home->loadPageContent('produktet');
        $home->displayPageContent();
        ?>

        <?php if ($isLoggedIn): ?>
        <button onclick="toggleForm()" style="display: block;">Shto nje produkt te ri</button>
        <div id="productForm" style="display: none;">
            <form id="productForm" method="post" onsubmit="return validateProductForm()">
                <input type="text" name="titulli" name="titulli" placeholder="Titulli" /><br />
                <input type="text" name="imazhi" name="imazhi" placeholder="Image URL" /><br />
                <textarea name="pershkrimi" name="pershkrimi" placeholder="Pershkrimi"></textarea><br />
                <button class="buton" type="submit">Shto Produktin</button>
            </form>
        </div>

        <script>
            function toggleForm() {
                var form = document.getElementById('productForm');
                if (form.style.display === "none") {
                    form.style.display = "block";
                } else {
                    form.style.display = "none";
                }
            }

            function validateProductForm() {
                var titulli = document.forms["productForm"]["titulli"].value;
                var imazhi = document.forms["productForm"]["imazhi"].value;
                var pershkrimi = document.forms["productForm"]["pershkrimi"].value;

                if (titulli === "" || imazhi === "" || pershkrimi === "") {
                    alert("Te gjitha fushat jane te detyrueshme!");
                    return false;
                }
                if (!imazhi.match(/\.(jpeg|jpg|gif|png)$/)) {
                    alert("Imazhi duhet te jete valid!");
                    return false;
                }
                return true;
            }
        </script>
        <?php endif; ?>

        <div class="produktet">
        <?php
            foreach ($produktet as $produkt) {
                echo $produkt->htmlRepresentation();
            }
        ?>
        </div>
      </div>
    </div>
  </body>
</html>
<style>
  body {
    font-family: sans-serif;
    margin: 0;
   
  }
  header {
    background-color: rgb(233, 168, 190);
    color: #fff;
    padding-top: 10px;
    padding-bottom: 10px;
    text-align: center;
  }
  nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-left: 10px;
    padding-right: 10px;
  }

  ul {
    display: flex;
    padding: 0;
    list-style: none;
  }
  li {
    margin-left: 10px;
    margin-right: 10px;
  }
  a {
    color: #fff;
  }
  .permbajtja {
    padding: 20px;
  }
  .foto {
    display: inline-block;
  }
  img {
    margin-right: 50px;
    width: 210px;
    height: 200px;
  }
  form {
      background-color: #fff;
      margin-top: 50px;
  }
  input {
      width: 500px;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #000;
  }
  textarea {
      width: 500px;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #000;
  }
  .buton {
      background-color: #5cb85c;
      color: #fff;
      width: 250px;
      height: 40px;
  }

  .produktet {
        display: flex;
        flex-wrap: wrap;
  }
  .produkt {
      width: calc(25% - 1px);
      margin-bottom: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
  }
  .produkt img {
      width: 200px;
      height: 200px;
      object-fit: cover;
      align-self: center;
  }
  .produkt p {
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 10;
      -webkit-box-orient: vertical;
      text-align: center;
  }

</style>