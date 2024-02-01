<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    echo "Nuk keni te drejta per te aksesuar kete faqe";
    exit;
}

include '../klasat/SliderForm.php';

$sliderForm = new SliderForm();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $imageUrl = $_POST['imageUrl'];
        $sliderForm->addImage($imageUrl);
    } elseif (isset($_POST['remove'])) {
        $imageId = $_POST['imageId'];
        $sliderForm->removeImage($imageId);
    }
}

$images = $sliderForm->getImages();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Slider Management</title>



    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        nav a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .admin-header, .admin-nav {
            background-color: #555;
            color: white;
            padding: 10px 0;
            margin-bottom: 20px;
        }
        .admin-nav a {
            color: white;
            padding: 0 15px;
            text-decoration: none;
            font-size: 16px;
        }
        form.add-image-form {
            margin: 20px auto;
            width: 80%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        form.add-image-form input[type="text"] {
            width: 70%;
            padding: 8px;
        }
        form.add-image-form button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        ul.image-list {
            list-style-type: none;
            margin: 0 auto;
            padding: 0;
            width: 80%;
        }
        ul.image-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        ul.image-list img {
            width: auto;
            height: 100px;
        }
        ul.image-list form {
            margin: 0;
        }
        ul.image-list button {
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div>
    <?php include 'admin-header.php'; ?>
    <form action="slider.php" method="post" class="add-image-form">
        <input type="text" name="imageUrl" placeholder="Enter image URL" />
        <button type="submit" name="add">Add Image</button>
    </form>
    <ul class="image-list">
        <?php foreach ($images as $image) { ?>
            <li>
                <img src="<?php echo $image['image_url']; ?>" alt="Slider Image" style="width: 100px; height: auto;">
                <form action="slider.php" method="post">
                    <input type="hidden" name="imageId" value="<?php echo $image['id']; ?>">
                    <button type="submit" name="remove">Remove</button>
                </form>
            </li>
        <?php } ?>
    </ul>
</div>
</body>
</html>
