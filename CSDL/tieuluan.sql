-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2025 at 04:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tieuluan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `ten_admin` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `diachi_admin` varchar(200) NOT NULL,
  `dienthoai_admin` int(11) NOT NULL,
  `id_vaitro` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `ten_admin`, `username`, `password`, `diachi_admin`, `dienthoai_admin`, `id_vaitro`) VALUES
(2, 'admin1', 'admin1', '202cb962ac59075b964b07152d234b70', 'Kiên Giang', 123654987, 1);

-- --------------------------------------------------------

--
-- Table structure for table `anhphu`
--

CREATE TABLE `anhphu` (
  `id_anhphu` int(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `duong_dan` varchar(250) NOT NULL,
  `thutu_hien_thi` int(11) DEFAULT 0,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anhphu`
--

INSERT INTO `anhphu` (`id_anhphu`, `id_sanpham`, `duong_dan`, `thutu_hien_thi`, `ngay_tao`) VALUES
(1, 40, 'anhphuuploads/1750252070_6852ba266cf98_Giay_Padel_Courtquick_trang_kw7232_01_phu.png', 1, '2025-06-18 20:07:50'),
(2, 40, 'anhphuuploads/1750252070_6852ba266d326_Giay_Padel_Courtquick_trang_kw7232_02_phu.png', 1, '2025-06-18 20:07:50'),
(3, 40, 'anhphuuploads/1750252070_6852ba266d463_Giay_Padel_Courtquick_trang_kw7232_03_phu.png', 1, '2025-06-18 20:07:50'),
(4, 40, 'anhphuuploads/1750252070_6852ba266d6e3_Giay_Padel_Courtquick_trang_kw7232_04_phu.png', 1, '2025-06-18 20:07:50'),
(5, 43, 'anhphuuploads/1750343196_68541e1c3bc74_Giay_Samba_OG_trang_B75806_03_phu.png', 2, '2025-06-19 21:26:36'),
(6, 43, 'anhphuuploads/1750343196_68541e1c3be69_Giay_Samba_OG_trang_kw75806_01_phu.png', 2, '2025-06-19 21:26:36'),
(7, 43, 'anhphuuploads/1750343196_68541e1c3bf8e_Giay_Samba_OG_trang_kw75806_02_phu.png', 2, '2025-06-19 21:26:36'),
(8, 43, 'anhphuuploads/1750343196_68541e1c3c045_Giay_Samba_OG_trang_kw75806_04_phu.png', 2, '2025-06-19 21:26:36'),
(9, 44, 'anhphuuploads/1750344581_68542385ba6ba_Giay_Y-3_Superstar_Xam_kw4216_01.png', 3, '2025-06-19 21:49:41'),
(10, 44, 'anhphuuploads/1750344581_68542385ba870_Giay_Y-3_Superstar_Xam_kw4216_02.png', 3, '2025-06-19 21:49:41'),
(11, 44, 'anhphuuploads/1750344581_68542385ba989_Giay_Y-3_Superstar_Xam_kw4216_03.png', 3, '2025-06-19 21:49:41'),
(12, 44, 'anhphuuploads/1750344581_68542385baa88_Giay_Y-3_Superstar_Xam_kw4216_04.png', 3, '2025-06-19 21:49:41');

-- --------------------------------------------------------

--
-- Table structure for table `bienthesanpham`
--

CREATE TABLE `bienthesanpham` (
  `id_bienthe` int(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `kichco` varchar(20) NOT NULL,
  `mausac` varchar(30) NOT NULL,
  `soluongtonkho` int(11) NOT NULL,
  `madinhdanh` varchar(50) NOT NULL,
  `hinhanh` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bienthesanpham`
--

INSERT INTO `bienthesanpham` (`id_bienthe`, `id_sanpham`, `kichco`, `mausac`, `soluongtonkho`, `madinhdanh`, `hinhanh`) VALUES
(154, 40, '42', 'xanh trắng', 11, 'PCQ-xanhtrang', '1750251318_Giay_Padel_Courtquick_trang_kw7232_04.png'),
(155, 40, '43', 'đỏ trắng', 15, 'PCQ-dotrang', '1750251318_Giay_Padel_Courtquick_trangdo_kw3925_02.png'),
(156, 43, '43', 'trắng ', 12, 'SOG-trang', '1750343167_Giay_Samba_OG_trang_kw75806_trangsocden.png'),
(157, 43, '44', 'đen', 15, 'SOG-den', '1750343167_Giay_Samba_OG_DJen_kw75807_densoctrang.png'),
(158, 44, '45', 'xám', 30, 'Y3SP-xam', '1750344563_Giay_Y-3_Superstar_Xam_kw4216_xam.png');

-- --------------------------------------------------------

--
-- Table structure for table `binhluan`
--

CREATE TABLE `binhluan` (
  `id_binhluan` int(11) NOT NULL,
  `id_khach` int(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `noidung` varchar(10000) NOT NULL,
  `ngaybinhluan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `binhluan`
--

INSERT INTO `binhluan` (`id_binhluan`, `id_khach`, `id_sanpham`, `noidung`, `ngaybinhluan`) VALUES
(7, 4, 44, 'sản phẩm đẹp', '21:21:19 21-06-2025');

-- --------------------------------------------------------

--
-- Table structure for table `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `id_chitietdonhang` int(11) NOT NULL,
  `ma_giohang` varchar(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `id_bienthe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`id_chitietdonhang`, `ma_giohang`, `id_sanpham`, `soluong`, `id_bienthe`) VALUES
(21, 'DH175039131', 40, 1, 154),
(22, 'DH175039142', 43, 2, 156),
(23, 'DH175049668', 40, 3, 154),
(24, 'DH175049668', 43, 1, 156);

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id_danhmuc` int(11) NOT NULL,
  `tendanhmuc` varchar(100) NOT NULL,
  `thutu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `danhmuc`
--

INSERT INTO `danhmuc` (`id_danhmuc`, `tendanhmuc`, `thutu`) VALUES
(1, 'Giày', 1),
(2, 'Nam', 2),
(3, 'Nữ', 3),
(4, 'Trẻ em', 4),
(5, 'Thế thao', 5),
(6, 'Các nhãn hiệu', 6),
(7, 'Khuyến mãi', 7);

-- --------------------------------------------------------

--
-- Table structure for table `danhmuccon`
--

CREATE TABLE `danhmuccon` (
  `id_danhmuccon` int(11) NOT NULL,
  `id_danhmuc` int(11) DEFAULT NULL,
  `ten_danhmuccon` varchar(100) NOT NULL,
  `mota` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `danhmuccon`
--

INSERT INTO `danhmuccon` (`id_danhmuccon`, `id_danhmuc`, `ten_danhmuccon`, `mota`) VALUES
(1, 1, 'Hàng mới về', 'Các mẫu giày mới nhất vừa cập bến'),
(2, 1, 'Trending giày', 'Những mẫu giày đang hot và được ưa chuộng'),
(3, 1, 'Giày Thể Thao', 'Giày đa năng cho các hoạt động thể thao'),
(4, 1, 'Giày Chạy Bộ & Đi Bộ', 'Hỗ trợ chạy bộ và đi bộ với công nghệ tiên tiến'),
(5, 1, 'Giày Bóng Đá', 'Thiết kế chuyên dụng cho sân cỏ và nhân tạo'),
(6, 1, 'Giày Tây', 'Giày lịch lãm, phù hợp với trang phục công sở'),
(7, 2, 'Hàng Mới Về', 'Các mẫu giày mới nhất dành cho nam'),
(8, 2, 'Originals', 'Dòng giày thời trang phong cách cổ điển cho nam'),
(9, 2, 'Giày Thể Thao', 'Giày thể thao đa năng dành cho nam'),
(10, 2, 'Giày Chạy Bộ & Đi Bộ', 'Giày hỗ trợ chạy bộ và đi bộ cho nam'),
(11, 2, 'Giày Bóng Đá', 'Giày bóng đá chuyên dụng cho nam'),
(12, 2, 'Giày Tây', 'Giày lịch lãm dành cho nam, phù hợp công sở'),
(13, 3, 'Hàng Mới Về', 'Các mẫu giày mới nhất dành cho nữ'),
(14, 3, 'Originals', 'Dòng giày thời trang phong cách cổ điển cho nữ'),
(15, 3, 'Giày Thể Thao', 'Giày thể thao đa năng dành cho nữ'),
(16, 3, 'Giày Chạy Bộ & Đi Bộ', 'Giày hỗ trợ chạy bộ và đi bộ cho nữ'),
(17, 3, 'Quần Vợt', 'Giày chuyên dụng cho quần vợt, hỗ trợ di chuyển linh hoạt'),
(18, 3, 'Giày Tập Yoga', 'Giày nhẹ, linh hoạt, phù hợp cho yoga và các bài tập nhẹ'),
(19, 4, 'Tập Luyện', 'Giày hỗ trợ tập luyện đa năng cho trẻ em'),
(20, 4, 'Bóng Đá', 'Giày bóng đá chuyên dụng dành cho trẻ em'),
(21, 4, 'Chạy', 'Giày chạy bộ nhẹ nhàng, phù hợp cho trẻ em'),
(22, 4, 'Đánh Gôn', 'Giày đánh gôn thiết kế đặc biệt cho trẻ em'),
(23, 5, 'Bóng Đá', 'Giày và phụ kiện chuyên dụng cho bóng đá'),
(24, 5, 'Chạy', 'Giày chạy bộ với công nghệ hỗ trợ hiệu suất cao'),
(25, 5, 'Bóng Rổ', 'Giày bóng rổ với độ bám và hỗ trợ cổ chân tốt'),
(26, 5, 'Tập Luyện', 'Giày đa năng cho các bài tập gym và thể dục'),
(27, 5, 'Motosport', 'Giày và trang phục thiết kế cho môn đua xe thể thao'),
(28, 5, 'Ngoài Trời', 'Giày và phụ kiện cho các hoạt động ngoài trời như leo núi'),
(29, 6, 'Originals', 'Dòng giày và phụ kiện thời trang phong cách cổ điển');

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE `donhang` (
  `id_giohang` int(11) NOT NULL,
  `id_khach` int(11) NOT NULL,
  `ma_giohang` varchar(11) NOT NULL,
  `trangthai` int(11) NOT NULL,
  `ngaytao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`id_giohang`, `id_khach`, `ma_giohang`, `trangthai`, `ngaytao`) VALUES
(18, 4, 'DH174917709', 1, '2025-06-06 09:31:31'),
(19, 5, 'DH174917735', 1, '2025-06-06 09:35:55'),
(20, 4, 'DH174927594', 0, '2025-06-07 12:59:06'),
(21, 4, 'DH175039131', 1, '2025-06-20 10:48:30'),
(22, 4, 'DH175039142', 1, '2025-06-20 10:50:24'),
(23, 4, 'DH175049668', 1, '2025-06-21 16:04:41');

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `id_khach` int(11) NOT NULL,
  `ten_khach` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `diachi` varchar(200) NOT NULL,
  `dienthoai` int(11) NOT NULL,
  `id_vaitro` int(11) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`id_khach`, `ten_khach`, `username`, `password`, `diachi`, `dienthoai`, `id_vaitro`) VALUES
(4, 'kiwi', 'kiwi', '202cb962ac59075b964b07152d234b70', 'Kiên Giang', 332165489, 3),
(5, 'mtruong', 'truong', '202cb962ac59075b964b07152d234b70', 'Kiên Giang', 123654789, 3);

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `id_nv` int(11) NOT NULL,
  `hoten_nhanvien` varchar(100) NOT NULL,
  `diachi` varchar(200) NOT NULL,
  `sodienthoai` int(11) NOT NULL,
  `id_vaitro` int(11) NOT NULL DEFAULT 2,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`id_nv`, `hoten_nhanvien`, `diachi`, `sodienthoai`, `id_vaitro`, `username`, `password`) VALUES
(2, 'Nguyễn Văn A', 'Kiên Giang', 123654987, 2, 'nva', '80c9ef0fb86369cd25f90af27ef53a9e'),
(4, 'Nguyễn Văn B', 'Kiên Giang', 123654898, 2, 'nvb', '1692fcfff3e01e7ba8cffc2baadef5f5'),
(6, 'Nguyễn Văn C', 'Kiên Giang', 1236456123, 2, 'nvc', '94f3b3a16d8ce064c808b16bee5003c5'),
(7, 'Nguyễn Văn D', 'Kiên Giang', 789456123, 2, 'nvd', '7097c422d46bb61fc4c169dbbae1c1e6');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `id_sanpham` int(11) NOT NULL,
  `tensanpham` varchar(250) NOT NULL,
  `masp` varchar(100) NOT NULL,
  `giasp` int(50) NOT NULL,
  `soluong` int(11) NOT NULL,
  `hinhanh` varchar(250) NOT NULL,
  `tomtat` tinytext NOT NULL,
  `noidung` text NOT NULL,
  `tinhtrang` int(11) NOT NULL,
  `id_danhmuc` int(11) NOT NULL,
  `id_danhmuccon` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id_sanpham`, `tensanpham`, `masp`, `giasp`, `soluong`, `hinhanh`, `tomtat`, `noidung`, `tinhtrang`, `id_danhmuc`, `id_danhmuccon`) VALUES
(40, 'Giày Padel Courtquick', 'kw7232', 2400000, 26, '1750170984_Giay_Padel_Courtquick_trang_kw7232.png', 'giày ', '', 1, 2, 9),
(43, 'Giày Samba OG', 'kw75806', 2700000, 27, '1750343055_Giay_Samba_OG_trang_kw75806.png', 'Dáng regular fit\r\nCó dây giày\r\nThân giày bằng da cật với các chi tiết da lộn bụi bặm và nhũ vàng ánh kim\r\nLớp lót bằng da tổng hợp; Đế gum bằng cao su', 'Ra đời trên sân bóng, giày Samba là biểu tượng kinh điển của phong cách đường phố. Phiên bản này trung thành với di sản, thể hiện qua thân giày bằng da mềm, dáng thấp, nhã nhặn, các chi tiết phủ ngoài bằng da lộn và đế gum, biến đôi giày trở thành item không thể thiếu trong tủ đồ của tất cả mọi người - cả trong và ngoài sân cỏ.', 1, 2, 8),
(44, 'Giày Y-3 Superstar', 'kw4216', 9990000, 30, '1750344510_Giay_Y-3_Superstar_Xam_kw4216_chinh.png', 'Kiểu dáng tiêu chuẩn\r\nCó dây giày\r\nThân giày bằng da', 'Giày adidas Superstar được coi là một trong những mẫu giày kinh điển và được yêu thích nhất mọi thời đại. Giờ đây, Y-3 mang đến làn gió mới cho dòng giày huyền thoại với Y-3 Superstar – nổi bật với chất liệu da mềm ở thân giày và lớp lót da đồng điệu. Trung thành với thiết kế sang chảnh, mũi giày vỏ sò đặc trưng cũng khoác lên mình chất liệu da — để tôn lên chi tiết mang tính biểu tượng nhất của đôi giày này.', 1, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `vaitro`
--

CREATE TABLE `vaitro` (
  `id` int(11) NOT NULL,
  `ten_vaitro` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaitro`
--

INSERT INTO `vaitro` (`id`, `ten_vaitro`) VALUES
(1, 'Admin'),
(2, 'Nhân viên'),
(3, 'Khách hàng');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `anhphu`
--
ALTER TABLE `anhphu`
  ADD PRIMARY KEY (`id_anhphu`),
  ADD KEY `id_sanpham` (`id_sanpham`);

--
-- Indexes for table `bienthesanpham`
--
ALTER TABLE `bienthesanpham`
  ADD PRIMARY KEY (`id_bienthe`),
  ADD KEY `lksp` (`id_sanpham`);

--
-- Indexes for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`id_binhluan`),
  ADD KEY `lk khach` (`id_khach`);

--
-- Indexes for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`id_chitietdonhang`),
  ADD KEY `lk sanpham` (`id_sanpham`),
  ADD KEY `fk_bienthe` (`id_bienthe`);

--
-- Indexes for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id_danhmuc`);

--
-- Indexes for table `danhmuccon`
--
ALTER TABLE `danhmuccon`
  ADD PRIMARY KEY (`id_danhmuccon`),
  ADD KEY `id_danhmuc` (`id_danhmuc`);

--
-- Indexes for table `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`id_giohang`),
  ADD KEY `lkkh` (`id_khach`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`id_khach`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`id_nv`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id_sanpham`),
  ADD KEY `fk_sanpham_danhmuccon` (`id_danhmuccon`);

--
-- Indexes for table `vaitro`
--
ALTER TABLE `vaitro`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `anhphu`
--
ALTER TABLE `anhphu`
  MODIFY `id_anhphu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bienthesanpham`
--
ALTER TABLE `bienthesanpham`
  MODIFY `id_bienthe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `id_binhluan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  MODIFY `id_chitietdonhang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `id_danhmuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `danhmuccon`
--
ALTER TABLE `danhmuccon`
  MODIFY `id_danhmuccon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `donhang`
--
ALTER TABLE `donhang`
  MODIFY `id_giohang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `id_khach` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `id_nv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id_sanpham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `vaitro`
--
ALTER TABLE `vaitro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anhphu`
--
ALTER TABLE `anhphu`
  ADD CONSTRAINT `anhphu_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id_sanpham`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bienthesanpham`
--
ALTER TABLE `bienthesanpham`
  ADD CONSTRAINT `lksp` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id_sanpham`);

--
-- Constraints for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `lk khach` FOREIGN KEY (`id_khach`) REFERENCES `khachhang` (`id_khach`);

--
-- Constraints for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `fk_bienthe` FOREIGN KEY (`id_bienthe`) REFERENCES `bienthesanpham` (`id_bienthe`),
  ADD CONSTRAINT `lk sanpham` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id_sanpham`);

--
-- Constraints for table `danhmuccon`
--
ALTER TABLE `danhmuccon`
  ADD CONSTRAINT `danhmuccon_ibfk_1` FOREIGN KEY (`id_danhmuc`) REFERENCES `danhmuc` (`id_danhmuc`);

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `lkkh` FOREIGN KEY (`id_khach`) REFERENCES `khachhang` (`id_khach`);

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_sanpham_danhmuccon` FOREIGN KEY (`id_danhmuccon`) REFERENCES `danhmuccon` (`id_danhmuccon`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
