<?php
    $sql_pro = "SELECT * FROM  sanpham, danhmuc where sanpham.id_danhmuc =
     danhmuc.id_danhmuc ORDER BY sanpham.id_sanpham DESC limit 25";
    $query_pro = mysqli_query($mysqli,$sql_pro);
    
?>
<h3>Sản phẩm mới nhất</h3>
    <ul class="product_list">
        <?php
            while($row = mysqli_fetch_array($query_pro)){
        ?>
            <li>
                <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sanpham'] ?>">
                <img src="../admincp/modules/quanlysp/uploads/<?php echo $row['hinhanh']?>" alt="hình lỗi">
                <p class="title_product">Tên sản phẩm: <?php echo $row['tensanpham']?></p>
                <p class="price_product">Giá: <?php echo number_format($row['giasp'],0,',','.').'vnđ' ?></p>
                <p style="text-align: center; color: green"><?php echo $row['tendanhmuc']?></p>
                </a>
            </li>
        <?php
        }
        ?>
    </ul>
    <div style="clear: both;"></div>
    <ul class="list_trang">
        <style type="text/css">
            ul.list_trang {
                padding: 0;
                margin: 0;
                list-style: none;
            }
            ul.list_trang li {
                float: left;
                padding: 5px 17px;
                margin: 5px;
                background: yellow;
            }
        </style>
        <!-- Trang:
        <li><a href="">1</a></li>
        <li><a href="">2</a></li>
        <li><a href="">3</a></li> -->
    </ul>