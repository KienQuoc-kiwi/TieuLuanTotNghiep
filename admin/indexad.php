<!-- <?php
    // session_start();
    // if(!isset($_SESSION['dangnhap'])){
    //     header("Location:login.php");
    // }
    ?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý</title>
    <link rel="stylesheet" href="css/stylead.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/quanlysp.css">
    <link rel="stylesheet" href="css/danhmucsp.css">
    <link rel="stylesheet" href="css/donhang.css">
    <link rel="stylesheet" href="css/nhanvien.css">
</head>
<body>
    <h2>Welcome to Admincp</h2>
    <div class="wrapper">
        <?php
        session_start();
            include("../config/config.php");
            include("modules/header.php");
            include("modules/menu.php");
            include("modules/main.php");
            include("modules/footer.php");
        ?>
        
    </div>
</body>
</html>