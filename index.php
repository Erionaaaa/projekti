<!DOCTYPE html>
<html>
  <head>
    <title>Bag Boutique - Home</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
  </head>

  <body>
      <?php include 'header.php'; ?>
    <div class="permbajtja">
        <?php
        include 'klasat/Page.php';
        $home = new Page();
        $home->loadPageContent('home');
        $home->displayPageContent();

        include 'klasat/SliderForm.php';
        $sliderForm = new SliderForm();
        $images = $sliderForm->getImages();
        ?>

        <div class="slider">
            <?php foreach ($images as $image) { ?>
                <div><img src="<?php echo $image['image_url']; ?>" alt="Bag Image" /></div>
            <?php } ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.slider').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      arrows: true
    });
  });
</script>

  </body>
</html>
<style>
  body {
    font-family: sans-serif;
    margin: 0;
    /*background-image:url(images/bag0.webp);*/
    background-size: cover;
    background-repeat: no-repeat;
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
  }a {
    color: #fff;
  }
  .permbajtja {
    padding: 20px;
  }
  .slider {
    width: 50%;
    margin: auto;
  }
  .slider img {
    width: 210px;
    height: 200px;
}

    .slick-prev:before, .slick-next:before {
        color: black;
    }
    .slick-prev, .slick-next {
        font-size: 24px;
        line-height: 1;
        opacity: 0.75;
        color: black;
        background-color: white;
        border-radius: 50%;
        padding: 8px;
    }
    .slick-prev {
        left: -25px;
        z-index: 1;
    }
    .slick-next {
        right: -25px;
        z-index: 1;
    }

</style>