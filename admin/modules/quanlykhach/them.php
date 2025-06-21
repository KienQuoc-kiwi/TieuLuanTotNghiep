<div class="form-them-khachhang">
  <p class="tieude-chucnang">Thêm Khách Hàng</p>
  <form method="POST" action="modules/quanlykhach/xuly.php">
    <table class="form-khachhang__table">
      <tr>
        <th>Tên khách hàng</th>
        <td><input type="text" name="Tenkhach" /></td>
      </tr>
      <tr>
        <th>Username</th>
        <td><input type="text" name="Username" /></td>
      </tr>
      <tr>
        <th>Password</th>
        <td><input type="text" name="Password" /></td>
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
          <input class="btn-khachhang btn-them" type="submit" name="themkhachhang" value="Thêm khách hàng" />
        </td>
      </tr>
    </table>
  </form>
</div>