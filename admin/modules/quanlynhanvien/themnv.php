<div class="form-them-nhanvien">
  <p class="tieude-chucnang">Thêm Nhân Viên</p>
  <form method="POST" action="modules/quanlynhanvien/xuly.php">
    <table class="form-nhanvien__table">
      <tr>
        <th>Họ tên</th>
        <td><input type="text" name="Hoten" /></td>
      </tr>
      <tr>
        <th>Giới tính</th>
        <td><input type="text" name="Gioitinh" /></td>
      </tr>
      <tr>
        <th>Địa chỉ</th>
        <td><input type="text" name="Diachi" /></td>
      </tr>
      <tr>
        <th>Số điện thoại</th>
        <td><input type="text" name="sdt" /></td>
      </tr>
      <tr>
        <td colspan="2">
          <input class="btn-nhanvien btn-them" type="submit" name="themnhanvien" value="Thêm nhân viên" />
        </td>
      </tr>
    </table>
  </form>
</div>
