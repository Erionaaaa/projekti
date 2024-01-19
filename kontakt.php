<!DOCTYPE html>
<html>
  <head>
    <title>Bag Boutique - Na Kontaktoni</title>
  <script>
      function validate() {
          var emri = document.forms["contactForm"]["emri"].value;
          var email = document.forms["contactForm"]["email"].value;
          var mesazhi = document.forms["contactForm"]["mesazhi"].value;
          var errors = [];

          if (emri === "") {
              errors.push("Emri duhet te plotesohet.");
          }
          if (email === "") {
              errors.push("Email duhet te plotesohet.");
          }
          if (mesazhi === "") {
              errors.push("Mesazhi duhet te plotesohet.");
          }

          if (errors.length > 0) {
              alert(errors.join("\n"));
              return false;
          }
          return true;
      }
  </script>
  </head>
  <body>
      <?php include 'header.php'; ?>
    <div class="permbajtja">
        <?php
        include 'klasat/Page.php';

        $home = new Page();
        $home->loadPageContent('kontakti');
        $home->displayPageContent();
        ?>

    <form name="contactForm" method="post" onsubmit="return validate()">
      Emri:<br />
      <input type="text" name="emri" /><br />
      Email:<br />
      <input type="email" name="email" /><br />
      Mesazhi:<br />
      <textarea name="mesazhi"></textarea><br />
      <button type="submit" class="buton">Na Kontakto</button>
      </form>
    <?php
    include 'klasat/KontaktForm.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $contactForm = new KontaktForm();
        $emri = $_POST['emri'];
        $email = $_POST['email'];
        $mesazhi = $_POST['mesazhi'];

        $errors = $contactForm->valido($emri, $email, $mesazhi);

        if (count($errors) == 0) {
            if ($contactForm->ruaj($emri, $email, $mesazhi)) {
                echo "<p style='color: green;'>Mesazhi u dergua me sukses.</p>";
            } else {
                echo "<p style='color: red;'>Ka ndodhur nje gabim gjate dergimit te mesazhit.</p>";
            }
        } else {
            foreach ($errors as $error) {
                echo "<p style='color: red;'>$error</p>";
            }
        }
    } ?>


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