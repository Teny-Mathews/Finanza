<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

$editData = null;

/* ✅ DELETE */
if (isset($_GET["did"])) {
  $did = $_GET["did"];
  $delQry = "DELETE FROM tbl_complaint WHERE complaint_id='$did' AND user_id='" . $_SESSION['uid'] . "'";
  if ($con->query($delQry)) {
    echo "<script>alert('Complaint deleted'); window.location='Complaint.php';</script>";
    exit;
  }
}

/* ✅ FETCH DATA FOR EDIT */
if (isset($_GET["eid"])) {
  $eid = $_GET["eid"];
  $editQry = "SELECT * FROM tbl_complaint WHERE complaint_id='$eid' AND user_id='" . $_SESSION['uid'] . "'";
  $res = $con->query($editQry);
  $editData = $res->fetch_assoc();
}

/* ✅ INSERT / UPDATE */
if (isset($_POST["btn_submit"])) {

  $title = $_POST["txt_comptitle"];
  $content = $_POST["txtarea_compcontent"];

  // ✅ Update
  if (isset($_POST["hid_id"]) && $_POST["hid_id"] != "") {
    $cid = $_POST["hid_id"];
    $upQry = "UPDATE tbl_complaint 
                  SET complaint_title='$title', complaint_content='$content' 
                  WHERE complaint_id='$cid' AND user_id='" . $_SESSION['uid'] . "'";
    if ($con->query($upQry)) {
      echo "<script>alert('Complaint updated'); window.location='Complaint.php';</script>";
      exit;
    }
  }
  // ✅ Insert
  else {
    $insQry = "INSERT INTO tbl_complaint 
                  (complaint_title, complaint_content, user_id) 
                  VALUES ('$title', '$content', '" . $_SESSION['uid'] . "')";
    if ($con->query($insQry)) {
      echo "<script>alert('Complaint submitted'); window.location='Complaint.php';</script>";
      exit;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Complaint Form</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f4f8ff;
      font-family: 'Segoe UI', Tahoma;
      padding: 30px;
    }

    .con {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0, 51, 102, 0.1);
    }

    h2 {
      color: #003366;
      margin-bottom: 25px;
    }

    .table thead {
      background: #005baa;
      color: white;
    }

    .table tbody tr:nth-child(even) {
      background-color: #f0f8ff;
    }

    .btn-icon {
      padding: 4px 8px;
      font-size: 14px;
    }

    .btn-edit {
      color: #0d6efd;
    }

    .btn-edit:hover {
      color: #084298;
    }

    .btn-delete {
      color: #dc3545;
    }

    .btn-delete:hover {
      color: #a71d2a;
    }

    textarea {
      resize: vertical;
    }

    .cancel {
      background: gray;
      color: white;
    }
  </style>
</head>

<body>

  <div class="con">
    <h2 class="text-center"><?php echo $editData ? "Edit Complaint" : "Complaint Submission"; ?></h2>

    <form method="post" action="">

      <!-- ✅ Hidden ID for Edit -->
      <input type="hidden" name="hid_id" value="<?php echo $editData['complaint_id'] ?? ""; ?>">

      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Complaint Title</label>
        <div class="col-sm-9">
          <input required type="text" class="form-control" name="txt_comptitle"
            value="<?php echo $editData['complaint_title'] ?? ""; ?>">
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Complaint Content</label>
        <div class="col-sm-9">
          <textarea required class="form-control" name="txtarea_compcontent" rows="4"><?php
          echo $editData['complaint_content'] ?? "";
          ?></textarea>
        </div>
      </div>

      <div class="text-center">
        <button type="submit" name="btn_submit" class="btn btn-primary">
          <?php echo $editData ? "Update" : "Submit"; ?>
        </button>

        <button type="button" class="btn cancel" onclick="window.location='Complaint.php'">Clear</button>
      </div>

      <hr class="my-5" />

      <h2 class="text-center">My Complaints</h2>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>Slno</th>
              <th>Title</th>
              <th>Content</th>
              <th>Reply</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

            <?php
            $sel = "SELECT * FROM tbl_complaint WHERE user_id='" . $_SESSION['uid'] . "'";
            $res = $con->query($sel);
            $i = 0;
            while ($row = $res->fetch_assoc()) {
              $i++; ?>

              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo htmlspecialchars($row["complaint_title"]); ?></td>
                <td><?php echo htmlspecialchars($row["complaint_content"]); ?></td>
                <td><?php echo htmlspecialchars($row["complaint_reply"] ?: "No reply yet"); ?></td>

                <td>
                  <a href="Complaint.php?eid=<?php echo $row['complaint_id']; ?>" class="btn-icon btn-edit">
                    <i class="fas fa-edit"></i>
                  </a>

                  <a href="Complaint.php?did=<?php echo $row['complaint_id']; ?>"
                    onclick="return confirm('Delete this complaint?');" class="btn-icon btn-delete">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>

            <?php } ?>

          </tbody>
        </table>
      </div>

    </form>
  </div>

</body>

</html>

<?php include("Foot.php"); ?>