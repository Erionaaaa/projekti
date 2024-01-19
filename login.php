<?php
session_start();

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysqli = new mysqli("127.0.0.1", "root", "root", "projekti");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $email = $mysqli->real_escape_string($_POST["email"]);
    $password = $mysqli->real_escape_string($_POST["password"]);

    $stmt = $mysqli->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row["password"]) {
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $email;
            $_SESSION["role"] = $row['role'];
            $success = "Miresevini prape, $email!";
        } else {
            $error = "Fjalekalimi eshte i gabuar.";
        }
    } else {
        $error = "Nuk u gjet nje perdorues me kete emer.";
    }
    $stmt->close();
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Bag Boutique - Kyçuni</title>
    <script>
      function validimi() {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        if (email == "" || password == "") {
        alert("Duhet te plotesoni emrin e perdoruesit dhe fjalekalimin!");
        }
      }
    </script>
  </head>
  <body>
    <?php include 'header.php'; ?>
    <div class="permbajtja">
        <?php
        include 'klasat/Page.php';

        $home = new Page();
        $home->loadPageContent('kycuni');
        $home->displayPageContent();
        ?>

      <form onsubmit="return validimi()" method="post">
      Email:<br />
      <input type="text" id="email" name="email" /><br />
      Password:<br />
      <input type="password" id="password" name="password" /><br />
      <button type="submit" class="buton">Kyçuni</button>
      </form>
    <?php
    if (!empty($error)) {
        echo '<p style="color: red;">' . $error . '</p>';
    }
    if (!empty($success)) {
        echo '<p style="color: green;">' . $success . '</p>';
    }
    ?>
  </body>
    </div>
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
</style>