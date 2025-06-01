<section class="collection-tab-home">
    <div class="banner-layout">
        <!-- Slide bên trái -->
        <div class="banner-side swiper leftSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="img/banner-left1.png" alt=""></div>
                <div class="swiper-slide"><img src="img/banner-left6.png" alt="lỗi"></div>
            </div>
            <!-- Pagination & Navigation riêng (bỏ comment nếu cần) -->
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
                <div class="swiper-slide"><img src="img/banner-right3.png" alt=""></div>
                <div class="swiper-slide"><img src="img/banner-right1.png" alt="lỗi"></div>
            </div>
            <!-- Pagination & Navigation riêng (bỏ comment nếu cần) -->
            <!-- <div class="swiper-pagination right-pagination"></div>
            <div class="swiper-button-next right-next"></div>
            <div class="swiper-button-prev right-prev"></div> -->
        </div>
    </div>

    <div class="sub-tab-collection">
        <div class="item-tab active" data-handle="litedash-sale-20" data-section="is-section-1" data-total="1"></div>
    </div>
    <div class="sectionContent">
        <h2>BÁN CHẠY NHẤT</h2>
        <div class="row-edit">
            <div class="pro-loop">
                <div class="horizontal-scroll-container">
                    <?php
                    $sql_pro = "SELECT * FROM sanpham, danhmuc WHERE sanpham.id_danhmuc = danhmuc.id_danhmuc ORDER BY sanpham.id_sanpham DESC LIMIT 25";
                    $query_pro = mysqli_query($mysqli, $sql_pro);
                    while ($row = mysqli_fetch_array($query_pro)) {
                    ?>
                        <div class="product-card">
                            <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sanpham'] ?>">
                                <img src="admin/modules/quanlysp/uploads/<?php echo $row['hinhanh'] ?>" alt="hình lỗi">
                                <p class="title_product"><?php echo $row['tensanpham'] ?></p>
                                <p class="price_product"><?php echo number_format($row['giasp'], 0, ',', '.') . '₫' ?></p>
                                <p style="text-align: center; color: green"><?php echo $row['tendanhmuc'] ?></p>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="banner-above">
    <div class="banner-layout">
        <!-- Slide bên trái -->
        <div class="banner-side swiper leftSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="img/banner-left1.png" alt=""></div>
                <div class="swiper-slide"><img src="img/banner-left5.png" alt="lỗi"></div>
            </div>
            <!-- Pagination & Navigation riêng (bỏ comment nếu cần) -->
            <!-- <div class="swiper-pagination left-pagination"></div>
            <div class="swiper-button-next left-next"></div>
            <div class="swiper-button-prev left-prev"></div> -->
        </div>

        <!-- Banner trung tâm -->
        <div class="banner-side swiper centerSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="img/banner-left2.png" alt=""></div>
                <div class="swiper-slide"><img src="img/banner-right2.png" alt="lỗi"></div>
            </div>
            <!-- Pagination & Navigation riêng (bỏ comment nếu cần) -->
            <!-- <div class="swiper-pagination left-pagination"></div>
            <div class="swiper-button-next left-next"></div>
            <div class="swiper-button-prev left-prev"></div> -->
        </div>

        <!-- Slide bên phải -->
        <div class="banner-side swiper rightSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="img/banner-right3.png" alt=""></div>
                <div class="swiper-slide"><img src="img/banner-right1.png" alt="lỗi"></div>
            </div>
            <!-- Pagination & Navigation riêng (bỏ comment nếu cần) -->
            <!-- <div class="swiper-pagination right-pagination"></div>
            <div class="swiper-button-next right-next"></div>
            <div class="swiper-button-prev right-prev"></div> -->
        </div>
    </div>
</div>


<div class="pro-new">
    <h2>Sản phẩm mới</h2>
    <div class="row-edit">
        <div class="pro-loop">
            <div class="horizontal-scroll-container">
                <?php
                $sql_pro = "SELECT * FROM sanphammoi, danhmuc WHERE sanphammoi.id_danhmuc = danhmuc.id_danhmuc ORDER BY sanphammoi.id_spmoi DESC LIMIT 25";
                $query_pro = mysqli_query($mysqli, $sql_pro);
                while ($row = mysqli_fetch_array($query_pro)) {
                ?>
                    <div class="product-card">
                        <a href="index.php?quanly=sanphammoi&id=<?php echo $row['id_spmoi'] ?>">
                            <img src="admin/modules/quanlyspmoi/uploads/<?php echo $row['hinhanh'] ?>" alt="hình lỗi">
                            <p class="title_product"><?php echo $row['tenspmoi'] ?></p>
                            <p class="price_product"><?php echo number_format($row['giaspmoi'], 0, ',', '.') . '₫' ?></p>
                            <p style="text-align: center; color: green"><?php echo $row['tendanhmuc'] ?></p>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="container-grid">
  <div class="footer-section">
    <h3>CỬA HÀNG KIWI - ĐAM MÊ, SÁNG TẠO & DỊCH VỤ TỪ NĂM 2025</h3>
    <p>KIWI ra đời với sứ mệnh mang đến trải nghiệm mua sắm mới mẻ và đầy cảm hứng. Là một thương hiệu trẻ, thành lập vào năm 2025, chúng tôi tự hào bước đầu tiên trên hành trình phục vụ khách hàng với những sản phẩm chất lượng và phong cách độc đáo.</p>
    <p>Chúng tôi cam kết không ngừng học hỏi, đổi mới và hoàn thiện để đáp ứng tốt nhất mọi nhu cầu của bạn. Từ những ý tưởng khởi đầu khiêm tốn, KIWI đang nỗ lực mang đến sự kết hợp hoàn hảo giữa chất lượng và sự sáng tạo, giúp bạn tự tin thể hiện bản thân trong từng khoảnh khắc cuộc sống.</p>
    <p>Sản phẩm tại KIWI bao gồm các dòng thời trang, phụ kiện và hơn thế nữa, được thiết kế để truyền cảm hứng cho lối sống hiện đại. Với trái tim nhiệt huyết, chúng tôi không ngừng cải tiến để mang đến những giá trị vượt trội, phù hợp với xu hướng và mong muốn của bạn.</p>
    <p>Nhận thức rằng hành trình phát triển của KIWI còn rất mới mẻ, chúng tôi luôn trân trọng mọi ý kiến đóng góp từ khách hàng. Dù còn những thiếu sót ban đầu, chúng tôi hy vọng bạn sẽ đồng hành và ủng hộ, cùng KIWI hoàn thiện để trở thành người bạn đồng hành đáng tin cậy trên mọi cung đường cuộc sống.</p>
    <p>Hãy khám phá thế giới KIWI ngay hôm nay và cảm nhận sự khác biệt. Chúng tôi hứa hẹn mang đến những sản phẩm tinh tế, giúp bạn tỏa sáng, từ những ngày thường đến những khoảnh khắc đặc biệt.</p>
  </div>
</div>