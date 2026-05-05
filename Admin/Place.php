<?php
include("../Assets/Connection/Connection.php");
include("Head.php");

// --- Handle Delete ---
if (isset($_GET["did"])) {
    $delid = intval($_GET["did"]);
    $delqry = "DELETE FROM tbl_place WHERE place_id = $delid";
    if ($con->query($delqry)) {
        echo "<script>alert('Deleted successfully'); window.location='Place.php';</script>";
        exit;
    } else {
        echo "<script>alert('Deletion failed'); window.location='Place.php';</script>";
        exit;
    }
}

// --- Handle Edit Load ---
$editing = false;
$edit_place_id = 0;
$edit_district_id = "";
$edit_place_name = "";

if (isset($_GET["eid"])) {
    $editing = true;
    $edit_place_id = intval($_GET["eid"]);
    $sel = "SELECT * FROM tbl_place WHERE place_id = $edit_place_id";
    $res = $con->query($sel);
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $edit_place_name = $row["place_name"];
        $edit_district_id = $row["district_id"];
    } else {
        // invalid edit id
        $editing = false;
    }
}

// --- Handle Add or Update Submit ---
if (isset($_POST["btn_submit"])) {
    $district = intval($_POST["sel_district"]);
    $place = $con->real_escape_string($_POST["txt_place"]);

    if (isset($_POST["hdn_placeid"]) && intval($_POST["hdn_placeid"]) > 0) {
        // Update
        $pid = intval($_POST["hdn_placeid"]);
        $upqry = "UPDATE tbl_place 
                  SET place_name = '$place', district_id = $district
                  WHERE place_id = $pid";
        if ($con->query($upqry)) {
            echo "<script>alert('Updated Successfully'); window.location='Place.php';</script>";
            exit;
        } else {
            echo "<script>alert('Update Failed'); window.location='Place.php';</script>";
            exit;
        }
    } else {
        // Insert
        $insqry = "INSERT INTO tbl_place(place_name, district_id) 
                   VALUES('$place', $district)";
        if ($con->query($insqry)) {
            echo "<script>alert('Inserted Successfully'); window.location='Place.php';</script>";
            exit;
        } else {
            echo "<script>alert('Insertion Failed'); window.location='Place.php';</script>";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Manage Place</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f2f7ff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
     
    }
    .main-card {
      background-color: #fff;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0, 91, 170, 0.1);
      margin-bottom: 40px;
    }
    .section-header {
      background-color: #005baa;
      color: white;
      padding: 15px;
      border-radius: 15px 15px 0 0;
      font-size: 20px;
      text-align: center;
      margin-bottom: 25px;
    }
    label {
      font-weight: 600;
    }
    select, input[type="text"] {
      border-radius: 8px;
    }
    select.form-select {
      width: 100%;
      box-sizing: border-box;
    }
    .btn-submit {
      background-color: #007bff;
      color: white;
      padding: 10px 25px;
      border-radius: 25px;
      border: none;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    .btn-submit:hover {
      background-color: #0056b3;
    }
    table.table {
      border-radius: 15px;
      overflow: hidden;
    }
    table th {
      background-color: #007bff;
      color: white;
      text-align: center;
    }
    table td {
      vertical-align: middle;
      text-align: center;
    }
    .action-links a {
      margin: 0 8px;
      text-decoration: none;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 1.1rem;
    }
    .action-links a.text-danger:hover {
      color: #b30000;
    }
    .action-links a.text-primary:hover {
      color: #003d99;
    }
    @media screen and (max-width: 768px) {
      .table th, .table td {
        font-size: 13px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="main-card">
    <div class="section-header">
      <?php echo $editing ? "Edit Place" : "Add New Place"; ?>
    </div>
    <form method="post" action="">
      <input type="hidden" name="hdn_placeid" value="<?php echo $editing ? $edit_place_id : 0; ?>" />
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="sel_district" class="form-label">District</label>
          <select name="sel_district" id="sel_district" class="form-select" required>
            <option value="">Select</option>
            <?php
            $selqry2 = "SELECT * FROM tbl_district";
            $resopt2 = $con->query($selqry2);
            while ($dataopt2 = $resopt2->fetch_assoc()) {
                $did = $dataopt2["district_id"];
                $dname = $dataopt2["district_name"];
                $sel = ($editing && $did == $edit_district_id) ? "selected" : "";
                echo "<option value=\"$did\" $sel>$dname</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-6">
          <label for="txt_place" class="form-label">Place Name</label>
          <input required type="text" name="txt_place" id="txt_place" class="form-control"
                 value="<?php echo htmlspecialchars($editing ? $edit_place_name : "", ENT_QUOTES); ?>" />
        </div>
      </div>
      <div class="text-center mt-3">
        <input type="submit" name="btn_submit" id="btn_submit"
               value="<?php echo $editing ? "Update" : "Submit"; ?>" class="btn-submit" />
        <?php if ($editing): ?>
          <a href="Place.php" class="btn btn-secondary">Cancel</a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <div class="main-card">
    <div class="section-header">Place List</div>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Sl. No</th>
            <th>District Name</th>
            <th>Place Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $selqry3 = "SELECT p.place_id, p.place_name, d.district_name
                      FROM tbl_place p
                      JOIN tbl_district d ON p.district_id = d.district_id
                      ORDER BY d.district_name, p.place_name";
          $res3 = $con->query($selqry3);
          $i = 0;
          while ($row3 = $res3->fetch_assoc()) {
            $i++;
            $pid = $row3["place_id"];
            $dname = $row3["district_name"];
            $pname = $row3["place_name"];
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo htmlspecialchars($dname, ENT_QUOTES); ?></td>
              <td><?php echo htmlspecialchars($pname, ENT_QUOTES); ?></td>
              <td class="action-links">
                <a href="Place.php?did=<?php echo $pid; ?>" class="text-danger"
                   onclick="return confirm('Are you sure you want to delete this place?');" title="Delete">
                  <i class="bi bi-trash-fill"></i> Delete
                </a>
                <a href="Place.php?eid=<?php echo $pid; ?>" class="text-primary" title="Edit">
                  <i class="bi bi-pencil-fill"></i> Edit
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php
include("Foot.php");
?>
</body>
</html>
