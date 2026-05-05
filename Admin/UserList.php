<?php
include("../Assets/Connection/Connection.php");
include("Head.php");



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>User List</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      background: #f0f8ff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 40px 20px;
    }

    .container-custom {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 91, 170, 0.1);
    }

    .heading-blue {
      background-color: #005baa;
      color: white;
      padding: 15px;
      border-radius: 12px 12px 0 0;
      text-align: center;
      margin-bottom: 25px;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .table th {
      background-color: #007bff;
      color: white;
      vertical-align: middle;
    }

    .table td {
      vertical-align: middle;
      font-size: 14px;
    }

    .table tbody tr:hover {
      background-color: #eef6ff;
    }

    .img-round {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #007bff;
    }

    @media screen and (max-width: 768px) {
      .table th,
      .table td {
        font-size: 12px;
      }

      .img-round {
        width: 50px;
        height: 50px;
      }
    }
  </style>
</head>

<body>

  <div class="container container-custom">
    <div class="heading-blue">
      <h3>User List</h3>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered text-center align-middle">
        <thead>
          <tr>
            <th>Sl. No</th>
            <th>User</th>
            <th>Address</th>
            <th>Gender</th>
            <th>District</th>
            <th>Place</th>
            <th>Contact</th>
            <th>Photo</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 0;
          $selQry = "select * from tbl_user s inner join tbl_place c inner join tbl_district r on s.place_id=c.place_id and c.district_id=r.district_id";
          $row = $con->query($selQry);
          while ($data = $row->fetch_assoc()) {
            $i++;
          ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $data['user_name']; ?></td>
              <td><?php echo $data['user_address']; ?></td>
              <td><?php echo $data['user_gender']; ?></td>
              <td><?php echo $data['district_name']; ?></td>
              <td><?php echo $data['place_name']; ?></td>
              <td><?php echo $data['user_contact']; ?></td>
              <td>
                <img src="../Assets/Files/UserPhotos/<?php echo $data['user_photo']; ?>" class="img-round" alt="User Photo" />
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>

<?php
  include("Foot.php");
  ?>