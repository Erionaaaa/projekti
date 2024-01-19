<?php
session_start();

include 'klasat/Page.php';
include 'klasat/Lajmi.php';

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
    $pershkrimi = $_POST['pershkrimi'];

    if (empty($titulli) || empty($pershkrimi)) {
        $errors[] = "Te gjitha fushat jane te detyrueshme.";
    } else {
        $stmt = $conn->prepare("INSERT INTO lajmi (titulli, pershkrimi, autori) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $titulli, $pershkrimi, $autori);

        if ($stmt->execute()) {
            $success = "Lajmi u shtua me sukses!";
        } else {
            $errors[] = "Gabim ne shtimin e lajmit: " . $stmt->error;
        }
        $stmt->close();
    }
}

$lajmet = [];

$result = $conn->query("SELECT titulli, pershkrimi, autori, date FROM lajmi ORDER BY date DESC");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $lajmet[] = new Lajmi($row['titulli'], $row['pershkrimi'], $row['autori'], $row['date']);
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
        $home->loadPageContent('lajmet');
        $home->displayPageContent();
        ?>

        <?php if ($isLoggedIn): ?>
        <button onclick="toggleForm()" style="display: block;">Shto nje lajm te ri</button>
        <div id="lajmiForm" style="display: none;">
            <form id="lajmiForm" method="post" onsubmit="return validateLajmiForm()">
                <input type="text" name="titulli" name="titulli" placeholder="Titulli" /><br />
                <textarea name="pershkrimi" name="pershkrimi" placeholder="Pershkrimi"></textarea><br />
                <button class="buton" type="submit">Shto Lajmin</button>
            </form>
        </div>

        <script>
            function toggleForm() {
                var form = document.getElementById('lajmiForm');
                if (form.style.display === "none") {
                    form.style.display = "block";
                } else {
                    form.style.display = "none";
                }
            }

            function validateLajmiForm() {
                var titulli = document.forms["lajmiForm"]["titulli"].value;
                var pershkrimi = document.forms["lajmiForm"]["pershkrimi"].value;

                if (titulli === "" || pershkrimi === "") {
                    alert("Te gjitha fushat jane te detyrueshme!");
                    return false;
                }
                return true;
            }
        </script>
        <?php endif; ?>

        <div class="lajmet">
        <?php
            foreach ($lajmet as $lajmi) {
                echo $lajmi->htmlRepresentation();
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

  .lajmi {
      width: 100%;
      margin-bottom: 20px;
  }

</style>