<div class="main">
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (isset($_GET['action']) && isset($_GET['query'])) {
        $tam = $_GET['action'];
        $query = $_GET['query'];
    } else {
        $tam = '';
        $query = '';
    }
    //quản lý danh mục sản phẩm
    if ($tam == 'quanlydanhmucsanpham' && $query == 'them') {
        include("modules/quanlydanhmucsp/them.php");
        include("modules/quanlydanhmucsp/lietke.php");
    } elseif ($tam == 'quanlydanhmucsanpham' && $query == 'sua') {
        include("modules/quanlydanhmucsp/sua.php");
    }
    //quản lý sản phẩm
    elseif ($tam == 'quanlysanpham' && $query == 'them') {
        include("modules/quanlysp/them.php");
    } elseif ($tam == 'quanlysanpham' && $query == 'sua') {
        include("modules/quanlysp/sua.php");
    } elseif ($tam == 'quanlysanpham' && $query == 'lietke') {
        include("modules/quanlysp/lietke.php");
    }
    //quản lý sản phẩm mới
    elseif ($tam == 'quanlyspmoi' && $query == 'them') {
        include("modules/quanlyspmoi/them.php");
        include("modules/quanlyspmoi/lietke.php");
    } elseif ($tam == 'quanlyspmoi' && $query == 'sua') {
        include("modules/quanlyspmoi/sua.php");
    }
    //quản lý biến thể sản phẩm
    elseif ($tam == 'quanlybienthe' && $query == 'them') {
        include("modules/quanlybienthe/them.php");
        include("modules/quanlybienthe/lietke.php");
    } elseif ($tam == 'quanlybienthe' && $query == 'sua') {
        include("modules/quanlybienthe/sua.php");
    }
    //quản lý đơn hàng
    elseif ($tam == 'quanlydonhang' && $query == 'lietke') {
        include("modules/quanlydonhang/lietke.php");
    } elseif ($tam == 'donhang' && $query == 'xemdonhang') {
        include("modules/quanlydonhang/xemdonhang.php");
        //quản lý nhân viên    
    } elseif ($tam == 'quanlynhanvien' && $query == 'lietke') {
        include("modules/quanlynhanvien/lietke.php");
        include("modules/quanlynhanvien/themnv.php");
    } elseif ($tam == 'quanlynhanvien' && $query == 'sua') {
        include("modules/quanlynhanvien/sua.php");

        //quản lý doanh thu
    } elseif ($tam == 'quanlydoanhthu' && $query == 'lietke') {
        include("modules/quanlydoanhthu/doanhthu.php");

        //quản lý bình luận
    } elseif ($tam == 'quanlybinhluan' && $query == 'lietke') {
        include("../../page/main/comment/lietkecontent.php");
        include("../../page/main/comment/xulycontent.php");
    } else {
        include("dashboard.php");
    }
    ?>
</div>