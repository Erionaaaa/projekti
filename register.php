<!DOCTYPE html>
<html>
  <head>
    <title>Bag Boutique - Regjistrohuni</title>
    <script>
      function validate() {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm-password").value;
        if (email == "" || password == "" || confirm_password == "") {
        alert("Duhet te plotesoni te gjitha fushat!");
        }
      }
    </script>
  </head>
  <body>
    <?php include 'header.php'; ?>
    <?php
    global $mysqli;
    $message = '';
    $error = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm-password"];
        if (empty($email) || empty($password) || empty($confirm_password)) {
            $error = "Duhet te plotesoni te gjitha fushat!";
        } elseif (strlen($password) < 8) {
            $error = "Fjalekalimi duhet te kete te pakten 8 karaktere!";
        } elseif ($password !== $confirm_password) {
            $error = "Fjalekalimet nuk perputhen!";
        } else {
            $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $error = "Ekziston nje perdorues me kete email!";
            } else {
                $stmt = $mysqli->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, 'user')");
                $stmt->bind_param("ss", $email, $password);
                if ($stmt->execute()) {
                    $message = "Perdoruesi u regjistrua me sukses!";
                } else {
                    $error = "Gabim gjate regjistrimit te perdoruesit.";
                }
            }
            $stmt->close();
        }
        $mysqli->close();
    }
    ?>

    <div class="permbajtja">
        <?php
        include 'klasat/Page.php';

        $home = new Page();
        $home->loadPageContent('regjistrohu');
        $home->displayPageContent();
        ?>

      <form method="post">
      Email:<br />
      <input type="email" id="email" name="email" /><br />
      Fjalekalimi:<br />
      <input type="password" id="password" name="password" /><br />
      Konfirmo Fjalekalimin:<br />
    <input type="password" id="confirm-password" name="confirm-password" /><br />
      <button type="submit" class="buton">Regjistrohuni</button>
      </form>
    <?php if (!empty($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
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