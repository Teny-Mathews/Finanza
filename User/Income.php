<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

$income_title   = "";
$income_id      = "";
$income_details = "";
$income_amount  = "";
$incometypeid   = 0;
$income_date    = "";

if(isset($_POST["btn_submit"]))
{
    $title   = $_POST["txt_title"];
    $content = $_POST["txtarea_details"];
    $price   = $_POST["txt_amount"];
    $etype   = $_POST['sel_incometype'];
    $date    = $_POST["txt_date"];
    $hid     = $_POST["txt_hid"];

    if($hid=="")
    {
        // Insert query
        $insQry= "INSERT INTO tbl_income 
                  (income_title,income_details,income_amount,income_date,incometype_id,user_id) 
                  VALUES ('$title','$content','$price','$date','$etype','".$_SESSION['uid']."')";
        if($con->query($insQry))
        {	
            ?>
            <script>
            alert("Inserted Successfully");
            window.location="Income.php";
            </script>
            <?php
        }
    }
    else 
    { 
        // Update query
        $upqry="UPDATE tbl_income 
                SET income_title='$title',
                    income_details='$content',
                    income_amount='$price',
                    income_date='$date',
                    incometype_id='$etype' 
                WHERE income_id='$hid'";
        if($con->query($upqry))
        {
            ?>
            <script>
            alert("Updated successfully");
            window.location="Income.php";
            </script>
            <?php
        }
    }
}

// Delete
if(isset($_GET["did"]))
{
    $delqry="DELETE FROM tbl_income WHERE income_id=".$_GET["did"];
    if($con->query($delqry))
    {
        ?>
        <script>
        alert("Deleted Successfully");
        window.location="Income.php";
        </script>
        <?php
    }
}

// Edit (fetch data)
if(isset($_GET["eid"]))
{
    $selqryt="SELECT * FROM tbl_income WHERE income_id ='".$_GET['eid']."' ";
    $rowt=$con->query($selqryt);
    $datat=$rowt->fetch_assoc();
    $income_title   = $datat['income_title'];
    $income_id      = $datat['income_id'];
    $income_details = $datat['income_details'];
    $income_amount  = $datat['income_amount'];
    $incometypeid   = $datat['incometype_id'];
    $income_date    = $datat['income_date'];
}
?>	


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
  <title>Income Management</title>

  <!-- Font Awesome CDN for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #e0efff, #c6ddff);
      color: #222;
    }
    form {
      width: 100%;
      max-width: 1100px;
      background: rgba(255 255 255 / 0.95);
      border-radius: 18px;
      padding: 40px 50px;
      box-shadow: 0 12px 40px rgb(0 82 204 / 0.15);
      margin: auto;
    }
    .section {
      margin-bottom: 50px;
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgb(0 82 204 / 0.12);
      padding: 35px 40px;
      transition: box-shadow 0.3s ease;
    }
    .section:hover { box-shadow: 0 12px 30px rgb(0 82 204 / 0.25); }
    h1 {
      color: #0055cc;
      font-weight: 700;
      font-size: 28px;
      margin-bottom: 25px;
      text-align: center;
    }
    label {
      display: block;
      font-weight: 600;
      color: #004494;
      margin-bottom: 8px;
      font-size: 15px;
    }
    input[type="text"], input[type="date"], select, textarea {
      width: 100%;
      padding: 14px 18px;
      margin-bottom: 22px;
      border: 1.8px solid #a9c0ff;
      border-radius: 12px;
      font-size: 16px;
      background: #f6faff;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    input[type="text"]:focus, input[type="date"]:focus, select:focus, textarea:focus {
      border-color: #0055cc;
      outline: none;
      box-shadow: 0 0 8px #0055ccaa;
      background: #f0f6ff;
    }
    input[type="submit"] {
      background: linear-gradient(90deg, #0066ff 0%, #3399ff 100%);
      color: #fff;
      padding: 15px 0;
      font-size: 18px;
      font-weight: 700;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      width: 100%;
      margin-top: 20px;
    }
    input[type="submit"]:hover {
      background: linear-gradient(90deg, #004bb5 0%, #2674d9 100%);
      transform: scale(1.05);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      font-size: 15px;
    }
    th, td {
      padding: 14px 18px;
      border-bottom: 1.5px solid #d1e3ff;
    }
    th {
      background: #0073ff;
      color: white;
      font-weight: 700;
    }
    tbody tr:hover { background: #e8f0ff; }
    .action-links a {
      color: #0073ff;
      font-weight: 600;
      text-decoration: none;
      margin-right: 14px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 14px;
    }
    .action-links a:hover { color: #004bb5; transform: scale(1.15); }
  </style>
</head>

<body>
  <form id="form1" name="form1" method="post" action="">

    <!-- Income Form -->
    <div class="section">
      <h1><?php echo $income_id ? "Edit Income" : "Add Income"; ?></h1>

      <input type="hidden" name="txt_hid" id="txt_hid" value="<?php echo $income_id; ?>"/>

      <label for="txt_title">Title</label>
      <input required type="text" name="txt_title" id="txt_title" value="<?php echo $income_title ?>"/>

      <label for="txtarea_details">Details</label>
      <textarea required name="txtarea_details" id="txtarea_details" rows="4"><?php echo $income_details ?></textarea>

      <label for="txt_date">Date</label>
      <input type="date" required name="txt_date" id="txt_date" 
             value="<?php echo $income_date ?>" 
             max="<?php echo date('Y-m-d')?>">

      <label for="txt_amount">Amount</label>
      <input required type="text" name="txt_amount" id="txt_amount" value="<?php echo $income_amount ?>"/>

      <label for="sel_incometype">Income Type</label>
      <select name="sel_incometype" id="sel_incometype" required>
        <option value="">Select</option>
        <?php
        $selqry = "SELECT * FROM tbl_incometype";
        $resopt = $con->query($selqry);
        while ($dataopt = $resopt->fetch_assoc()) {
            $selected = ($dataopt["incometype_id"] == $incometypeid) ? "selected" : "";
            ?>
            <option value="<?php echo $dataopt["incometype_id"]; ?>" <?php echo $selected; ?>>
                <?php echo $dataopt["incometype_name"]; ?>
            </option>
            <?php
        }
        ?>
      </select>

      <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
    </div>

    <!-- Income List -->
    <div class="section">
      <h1>Your Income Records</h1>
      <table>
        <thead>
          <tr>
            <th>Sl. No</th>
            <th>Title</th>
            <th>Details</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Income Type</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $selqry = "SELECT * FROM tbl_income i 
                     INNER JOIN tbl_incometype t ON i.incometype_id = t.incometype_id 
                     WHERE user_id='".$_SESSION['uid']."' ORDER BY income_date DESC";
          $result = $con->query($selqry);
          $i = 0;
          while ($data = $result->fetch_assoc()) {
              $i++;
              ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $data["income_title"] ?></td>
                <td><?php echo $data["income_details"] ?></td>
                <td><?php echo $data["income_date"] ?></td>
                <td><?php echo $data["income_amount"] ?></td>
                <td><?php echo $data["incometype_name"] ?></td>
                <td class="action-links">
                  <a href="Income.php?eid=<?php echo $data["income_id"] ?>"><i class="fas fa-edit"></i>Edit</a>
                  <a href="Income.php?did=<?php echo $data["income_id"] ?>" onclick="return confirm('Are you sure you want to delete this income?');"><i class="fas fa-trash-alt"></i>Delete</a>
                </td>
              </tr>
              <?php
          }
          ?>
        </tbody>
      </table>
    </div>

  </form>
</body>
</html>

<?php
include("Foot.php");
?>
