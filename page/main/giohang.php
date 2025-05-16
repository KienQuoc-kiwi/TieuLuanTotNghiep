
<p>Giỏ hàng</p>
    <?php

      if(isset($_SESSION['dangkyk'])){
        echo 'xin chào:'. '<span style="color:red;">'.$_SESSION['dangkyk'].'</span>';
        echo $_SESSION['id_khach'];
      }
    ?>
    <?php
        if(isset($_SESSION['cart'])){
        }
        ?>
        <table style="width:100%; text-align: center; border-collapse: collapse;" border="1">
      <tr>    
        <th>id</th>
        <th>Mã sản phẩm</th>
        <th>Tên sản phẩm</th>
        <th>Hình ảnh</th>
        <th>Số lượng</th>
        <th>Giá sản phẩm</th>
        <th>Thành tiền</th>
        <th>Quản lý</th>
      </tr>
      <?php
      if(isset($_SESSION['cart'])){
        $i=0;
        $tongtien=0;
        foreach($_SESSION['cart'] as $cart_item){
            $thanhtien=$cart_item['soluong']*$cart_item['giasp'];
            $tongtien+=$thanhtien;
            $i++;

      ?>
      <tr>
        <td><?php echo $i;?></td>
        <td><?php echo $cart_item['masp']?></td>
        <td><?php echo $cart_item['tensanpham']?></td>
        <td><img src="admin/modules/quanlysp/uploads/<?php echo $cart_item['hinhanh']?>" width="150px"></td>
        <td>
          <a href="page/main/themgiohang.php?tru=<?php echo $cart_item['id']?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
          <?php echo $cart_item['soluong']?>
          <a href="page/main/themgiohang.php?cong=<?php echo $cart_item['id']?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
        </td>
        <td><?php echo number_format( $cart_item['giasp'],0,',','.').'vnđ'?></td>
        <td><?php echo number_format( $thanhtien,0,',','.').'vnđ'?></td>
        <td><a href="page/main/themgiohang.php?xoa=<?php echo $cart_item['id']?>">xóa</a></td>
      </tr>
      <?php
      }
      ?>
        <tr>
            <td colspan="8">
              <p style="float:left;">Tổng tiền: <?php echo number_format( $tongtien,0,',','.').'vnđ'?><br></p>
              <p style="float:right;"><a href="main/themgiohang.php?xoatatca=1">Xóa tất cả sản phẩm </a></p>
              <div style="clear:both;"></div>
            <?php
              if(isset($_SESSION['dangkyk'])){
            ?>
            <p><a href="main/thanhtoan.php"><input  class="dathang" name = "dathang" type="submit" value="Đặt hàng"></p></a>
            <?php
              }else{
                ?>
                  <p><a href="main/dangkykhach.php?quanly=dangkyk"><input  class="dangkydathang" name = "dangkydathang" type="submit" value="Đăng ký Đặt hàng"></p></a>
                  <?php
                  }
                ?>
              
            </td>
        </tr>
      <?php
      }else{
        ?>
        <tr>
            <td colspan="8"><p>Hiện tại giỏ hàng đang trống</p></td>
        </tr>
        <?php
      }
      ?>
    </table>