
<!DOCTYPE html>
<html>
  <head>
    <title>Bag Boutique - Per Ne</title>
  </head>
  <body>
  <?php include 'header.php'; ?>
    <div class="permbajtja">
        <?php
            include 'klasat/Page.php';

            $home = new Page();
            $home->loadPageContent('per-ne');
            $home->displayPageContent();
        ?>
    </div>
  </body>
</html>






<style>
  body {
    font-family: sans-serif;
    margin: 0;
    background-image: url(yellow.jpg);
    background-size: contain;
    background-position: center bottom;
    height: 100vh;
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
  }li {
    margin-left: 10px;
    margin-right: 10px;
  }
  a {
    color: #fff;
  }

  .permbajtja {
    padding: 20px;
    margin-bottom: 100px;
  }
</style>