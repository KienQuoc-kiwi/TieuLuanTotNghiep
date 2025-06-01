<?php
    include('../../../config/config.php');

    $tensanpham = $_POST['tenspmoi'];
    $masp = $_POST['maspmoi'];
    $giasp = $_POST['giaspmoi'];
    $soluong = $_POST['soluong'];
    //xuly hinh anh
    $hinhanh = $_FILES['hinhanh']['name'];
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
    $hinhanh = time().'_'.$hinhanh;
    $tomtat = $_POST['tomtat'];
    $noidung = $_POST['noidung'];
    $tinhtrang = $_POST['tinhtrang'];
    $danhmuc = $_POST['danhmuc'];


    if(isset($_POST['themsanpham'])){
        //them
        $sql_them = "INSERT INTO sanphammoi(tenspmoi,maspmoi,giaspmoi,soluong,hinhanh,tomtat,noidung,tinhtrang,id_danhmuc) VALUE('".$tensanpham."',
        '".$masp."','".$giasp."','".$soluong."','".$hinhanh."','".$tomtat."','".$noidung."','".$tinhtrang."','".$danhmuc."')";
        mysqli_query($mysqli,$sql_them);
        move_uploaded_file($hinhanh_tmp,'uploads/'.$hinhanh);
        header('Location:../../indexad.php?action=quanlyspmoi&query=them');
    }elseif(isset($_POST['suasanpham'])){
        //sua
        if($hinhanh !=''){
            move_uploaded_file($hinhanh_tmp,'uploads/'.$hinhanh);
            
            $sql_update = "UPDATE sanphammoi SET tenspmoi='".$tensanpham."',maspmoi='".$masp."',giaspmoi='".$giasp."'
            ,soluong='".$soluong."',hinhanh='".$hinhanh."',tomtat='".$tomtat."',noidung='".$noidung."',tinhtrang='".$tinhtrang."'
            ,id_danhmuc='".$danhmuc."' WHERE id_spmoi ='$_GET[id_spmoi]'";
            //xóa hình ảnh cũ
            $sql = "SELECT * FROM sanphammoi WHERE id_spmoi = '$_GET[id_spmoi]' limit 1";
            $query = mysqli_query($mysqli,$sql);
            while($row = mysqli_fetch_array($query)){
                unlink('uploads/'.$row['hinhanh']);
        }
        }else{
            $sql_update = "UPDATE sanphammoi SET tenspmoi='".$tensanpham."',maspmoi='".$masp."',giaspmoi='".$giasp."'
            ,soluong='".$soluong."',tomtat='".$tomtat."',noidung='".$noidung."',tinhtrang='".$tinhtrang."'
            ,id_danhmuc='".$danhmuc."' WHERE id_spmoi ='$_GET[id_spmoi]'";
        }
        
        mysqli_query($mysqli,$sql_update);
        header('Location: ../../indexad.php?action=quanlyspmoi&query=them');
    }else{
        $id=$_GET['id_spmoi'];
        $sql = "SELECT * FROM sanphammoi WHERE id_spmoi = '.$id.' limit 1";
        $query = mysqli_query($mysqli,$sql);
        while($row = mysqli_fetch_array($query)){
            unlink('uploads/'.$row['hinhanh']);
        }
        $sql_xoa="DELETE FROM sanphammoi WHERE id_spmoi='".$id."'";
        mysqli_query($mysqli,$sql_xoa);
        header('Location: ../../indexad.php?action=quanlyspmoi&query=them');
    }
?>