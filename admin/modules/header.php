<?php
    if(isset($_GET['dangxuat'])&&$_GET['dangxuat']==1){
        unset($_SESSION['dangnhap']);
        header("Location:login.php");
    }
?>
<style>
    p a{
        color: red;
        float: right;
    }
    
</style>
 <p><a href="indexad.php?dangxuat=1">Đăng xuất: <?php if(isset($_SESSION['dangky'])){
    echo $_SESSION['dangky'];
    }?></a></li></p>