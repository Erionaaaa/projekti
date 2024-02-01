<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    echo "Nuk keni te drejta per te aksesuar kete faqe";
    return;
}
include '../klasat/KontaktForm.php';
$kontaktForm = new KontaktForm();
$kontakte = $kontaktForm->merrKontaktet();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Kontakte</title>
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
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
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
    </style>
</head>
<body>
    <?php include 'admin-header.php'; ?>
    <table>
        <tr>
            <th>Emri</th>
            <th>Email</th>
            <th>Mesazhi</th>
            <th>Data</th>
        </tr>
        <?php foreach ($kontakte as $kontakt) { ?>
            <tr>
                <td><?php echo $kontakt['emri']; ?></td>
                <td><?php echo $kontakt['email']; ?></td>
                <td><?php echo $kontakt['mesazhi']; ?></td>
                <td><?php echo $kontakt['data']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
