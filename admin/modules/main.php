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
    elseif ($tam == 'quanlysanpham' && $query == 'sua') {
        include("modules/quanlysp/sua.php");
    } elseif ($tam == 'quanlysanpham' && $query == 'lietke') {
        include("modules/quanlysp/them.php");
        include("modules/quanlysp/lietke.php");
    }
    // //quản lý sản phẩm mới
    // elseif ($tam == 'quanlyspmoi' && $query == 'them') {
    //     include("modules/quanlyspmoi/them.php");
    //     include("modules/quanlyspmoi/lietke.php");
    // } elseif ($tam == 'quanlyspmoi' && $query == 'sua') {
    //     include("modules/quanlyspmoi/sua.php");
    // }
    //quản lý biến thể sản phẩm
    elseif ($tam == 'quanlybienthe' && $query == 'lietke') {
        include("modules/quanlybienthe/thembienthe.php");
        include("modules/quanlybienthe/lietkebienthe.php");
    } elseif ($tam == 'quanlybienthe' && $query == 'sua') {
        include("modules/quanlybienthe/suabienthe.php");
        //quản lý ảnh phụ
    } elseif ($tam == 'quanlyanhphu' && $query == 'lietkeanh') {
        include("modules/quanlysp/themanhphu.php");
        include("modules/quanlysp/lietkeanhphu.php");
    } elseif ($tam == 'quanlyanhphu' && $query == 'suaanhphu') {
        include("modules/quanlysp/suaanhphu.php");
    }
    //quản lý đơn hàng
    elseif ($tam == 'quanlydonhang' && $query == 'lietke') {
        include("modules/quanlydonhang/lietke.php");
    } elseif ($tam == 'quanlydonhang' && $query == 'sua') {
        include("modules/quanlydonhang/sua.php");
    } elseif ($tam == 'quanlydonhang' && $query == 'xemdonhang') {
        include("modules/quanlydonhang/xemdonhang.php");
        //quản lý nhân viên    
    } elseif ($tam == 'quanlynhanvien' && $query == 'lietke') {
        include("modules/quanlynhanvien/lietke.php");
        include("modules/quanlynhanvien/themnv.php");
    } elseif ($tam == 'quanlynhanvien' && $query == 'sua') {
        include("modules/quanlynhanvien/sua.php");
    }
    //quản lý khách hàng
    elseif ($tam == 'quanlykhach' && $query == 'lietke') {
        include("modules/quanlykhach/lietke.php");
    } elseif ($tam == 'quanlykhach' && $query == 'sua') {
        include("modules/quanlykhach/sua.php");
    }

    //quản lý tồn kho
    elseif ($tam == 'quanlytonkho' && $query == 'lietke') {
        include("modules/quanlytonkho/lietke.php");
    } elseif ($tam == 'quanlytonkho' && $query == 'sua') {
        include("modules/quanlytonkho/sua.php");
    } elseif ($tam == 'quanlytonkho' && $query == 'chitiet') {
        include("modules/quanlytonkho/chitiettonkho.php");
    }
    //quản lý doanh thu
    elseif ($tam == 'quanlydoanhthu' && $query == 'lietke') {
        include("modules/quanlydoanhthu/doanhthu.php");
    }elseif ($tam == 'quanlydoanhthu' && $query == 'lietkengay') {
        include("modules/quanlydoanhthu/doanhthungay.php");
    }elseif ($tam == 'quanlydoanhthu' && $query == 'lietkethang') {
        include("modules/quanlydoanhthu/doanhthuthang.php");
    }elseif ($tam == 'quanlydoanhthu' && $query == 'lietkenam') {
        include("modules/quanlydoanhthu/doanhthunam.php");

        //quản lý bình luận
    } elseif ($tam == 'quanlybinhluan' && $query == 'lietke') {
        include("../../page/main/comment/lietkecontent.php");
        include("../../page/main/comment/xulycontent.php");
    } else {
        include("dashboard.php");
    }
    ?>
</div>