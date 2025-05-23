<section class="collection-tab-home">

<div class="banner-layout">
    <!-- Slide bên trái -->
    <div class="banner-side swiper leftSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="img/banner-left1.png" alt=""></div>
            <div class="swiper-slide"><img src="img/banner-left2.png" alt="lỗi"></div>
        </div>
        <!-- Pagination & Navigation riêng -->

        <!-- <div class="swiper-pagination left-pagination"></div>
        <div class="swiper-button-next left-next"></div>
        <div class="swiper-button-prev left-prev"></div> -->
    </div>

    <!-- Banner trung tâm cố định -->
    <div class="banner-center">
        <img src="img/banner-center.png" alt="Banner trung tâm">
    </div>

    <!-- Slide bên phải -->
    <div class="banner-side swiper rightSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="img/banner-right1.png" alt=""></div>
            <div class="swiper-slide"><img src="img/banner-right2.png" alt="lỗi"></div>
        </div>
        <!-- Pagination & Navigation riêng -->

        <!-- <div class="swiper-pagination right-pagination"></div>
        <div class="swiper-button-next right-next"></div>
        <div class="swiper-button-prev right-prev"></div> -->

    </div>
</div>



    <div class="sub-tab-collection">
        <div class="item-tab active" data-handle="litedash-sale-20" data-section="is-section-1" data-total="1"></div>
    </div>
    <div class="sectionContent">
        <div class="row-edit">
            <div class="pro-loop">
                <?php
                $sql_pro = "SELECT * FROM  sanpham, danhmuc where sanpham.id_danhmuc =
     danhmuc.id_danhmuc ORDER BY sanpham.id_sanpham DESC limit 25";
                $query_pro = mysqli_query($mysqli, $sql_pro);
                ?>

                <ul class="product_list">
                    <?php
                    while ($row = mysqli_fetch_array($query_pro)) {
                    ?>
                        <li>
                            <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sanpham'] ?>">
                                <img src="admin/modules/quanlysp/uploads/<?php echo $row['hinhanh'] ?>" alt="hình lỗi">
                                <p class="title_product">Tên sản phẩm: <?php echo $row['tensanpham'] ?></p>
                                <p class="price_product">Giá: <?php echo number_format($row['giasp'], 0, ',', '.') . 'vnđ' ?></p>
                                <p style="text-align: center; color: green"><?php echo $row['tendanhmuc'] ?></p>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>

    </div>
</section>