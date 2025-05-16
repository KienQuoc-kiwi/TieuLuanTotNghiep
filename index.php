<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin/css/pro.css">
    <link rel="stylesheet" href="admin/css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Chèn vào trong <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <title>KIWI Shop</title>
</head>

<body>
    <div class="index">
        <?php
        session_start();
        include('config/config.php');
        include('header.php');
        // include('main.php');
        include('include.php');
        include('footer.php');
        ?>
    </div>
</body>

</html>