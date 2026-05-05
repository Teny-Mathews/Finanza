<?php
include("../Assets/Connection/Connection.php");
include("Head.php");

?>






<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Complaint List</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      background: linear-gradient(to right, #e6f2ff, #ffffff);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      overflow-x: hidden;
    }

    .card-custom {
      background-color: #fff;
      border-radius: 18px;
      box-shadow: 0 0 15px rgba(0, 91, 170, 0.1);
      padding-top: 30px;
      padding-left: 10px;
      padding-right: 10px;
      max-width: 100%;
      overflow-x: hidden;
    }

    .table thead {
      background-color: #005baa;
      color: white;
    }

    .table tbody tr:hover {
      background-color: #f1f9ff;
    }

    .table td:nth-child(3) {
      max-width: 300px;
      word-wrap: break-word;
      white-space: normal;
    }

    .btn-reply {
      background-color: #007bff;
      color: white;
      border-radius: 20px;
      padding: 6px 15px;
      font-size: 14px;
      transition: all 0.2s ease-in-out;
    }

    .btn-reply:hover {
      background-color: #0056b3;
      color: #fff;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="card card-custom">
      <h3 class="text-center mb-4 text-primary">Complaint Management</h3>

      <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
          <thead>
            <tr>
              <th>Sl No</th>
              <th>Title</th>
              <th>Content</th>
              <th>Reply</th>

            </tr>
          </thead>
          <tbody>
            <?php
            $selqry = "select * from tbl_complaint";
            $result = $con->query($selqry);
            $i = 0;
            while ($data = $result->fetch_assoc()) {
              $i++;
              ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $data["complaint_title"] ?></td>
                <td><?php echo $data["complaint_content"] ?></td>
                <td>
                  <?php if (!empty($data["complaint_reply"])) { ?>
                    <span class="text-success"><?php echo nl2br(htmlspecialchars($data["complaint_reply"])); ?></span>
                  <?php } else { ?>
                    <a href="Reply.php?did=<?php echo $data["complaint_id"] ?>" class="btn btn-sm btn-reply">
                      Reply
                    </a>
                  <?php } ?>
                </td>

              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>

</html>

<?php
include("Foot.php");
?>