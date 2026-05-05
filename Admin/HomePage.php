<?php
include("../Assets/Connection/Connection.php");
session_start();
// Calculate total expenses
$exp_qry = "SELECT SUM(expense_price) as total_exp FROM tbl_expense";
$exp_res = $con->query($exp_qry);
$exp_data = $exp_res->fetch_assoc();
$total_expenses = $exp_data['total_exp'] ?? 0;

// Calculate total income
$inc_qry = "SELECT SUM(income_amount) as total_inc FROM tbl_income";
$inc_res = $con->query($inc_qry);
$inc_data = $inc_res->fetch_assoc();
$total_income = $inc_data['total_inc'] ?? 0;

// Calculate total users
$user_count_qry = "SELECT COUNT(*) as total_users FROM tbl_user";
$user_count_res = $con->query($user_count_qry);
$user_count_data = $user_count_res->fetch_assoc();
$total_users = $user_count_data['total_users'] ?? 0;

// For weekly expenses (last 7 days)
$weekly_exp_qry = "SELECT SUM(expense_price) as weekly_exp FROM tbl_expense WHERE expense_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
$weekly_exp_res = $con->query($weekly_exp_qry);
$weekly_exp_data = $weekly_exp_res->fetch_assoc();
$weekly_expenses = $weekly_exp_data['weekly_exp'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Finanza</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../Assets/Templates/Admin/assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../Assets/Templates/Admin/assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../Assets/Templates/Admin/assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../Assets/Templates/Admin/assets/vendors/font-awesome/css/font-awesome.min.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../Assets/Templates/Admin/assets/vendors/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet"
    href="../Assets/Templates/Admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="../Assets/Templates/Admin/assets/css/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="../Assets/Templates/Admin/assets/images/favicon.png" />
</head>

<body >
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo" href="index.html"><img src="../Assets/Templates/Admin/assets/images/f2logorbg.png"
            alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img
            src="../Assets/Templates/Admin/assets/images/minilogo.png" alt="logo" /></a>
        </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
              <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                  <?php
                  $data = $con->query("select * from tbl_admin where admin_id=".$_SESSION['aid'])->fetch_assoc();
                  echo "<span style='color:black;'>Welcome ".$data['admin_name']."</span>";
                  ?>
                </div>
              </div>
            </form>
          </div>
        <ul class="navbar-nav navbar-nav-right">




          <li class="nav-item nav-logout d-none d-lg-block">
            <a class="nav-link" href="../Guest/LogOut.php">
              <i class="mdi mdi-power"></i>
            </a>
          </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">

          <li class="nav-item">
            <a class="nav-link" href="HomePage.php">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-web menu-icon"></i>
            </a>
          </li>






          <li class="nav-item">
            <a class="nav-link" href="District.php">
              <span class="menu-title">District</span>
              <i class="mdi mdi-map-marker menu-icon"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="Place.php">
              <span class="menu-title">Place</span>
              <i class="mdi mdi-map menu-icon"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="IncomeType.php">
              <span class="menu-title">Income Type</span>
              <i class="mdi mdi-cash-plus menu-icon"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="ExpenseType.php">
              <span class="menu-title">Expense Type</span>
              <i class="mdi mdi-cash-minus menu-icon"></i>
            </a>
          </li>


          <li class="nav-item">
            <a class="nav-link" href="UserList.php">
              <span class="menu-title">User List</span>
              <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
          </li>


           <li class="nav-item">
            <a class="nav-link" href="ViewComplaint.php">
              <span class="menu-title">View Complaint</span>
              <i class="mdi mdi-alert-circle menu-icon"></i>
            </a>
          </li>


          <li class="nav-item">
            <a class="nav-link" href="Feedback.php">
              <span class="menu-title">Feedback</span>
              <i class="mdi mdi-message-text menu-icon"></i>
            </a>
          </li>

          

        </ul>
      </nav>

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
              </span> Dashboard
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
              </ul>
            </nav>
          </div>
          <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                  <img src="../Assets/Templates/Admin/assets/images/dashboard/circle.svg" class="card-img-absolute"
                    alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">Total Expenses <i class="mdi mdi-chart-line mdi-24px float-end"></i>
                  </h4>
                  <h2 class="mb-5">₹ <?php echo number_format($total_expenses); ?></h2>
                  <h6 class="card-text">Weekly: ₹ <?php echo number_format($weekly_expenses); ?></h6>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="../Assets/Templates/Admin/assets/images/dashboard/circle.svg" class="card-img-absolute"
                    alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">Total Income <i
                      class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
                  </h4>
                  <h2 class="mb-5">₹ <?php echo number_format($total_income); ?></h2>
                  <h6 class="card-text">Active transactions</h6>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                  <img src="../Assets/Templates/Admin/assets/images/dashboard/circle.svg" class="card-img-absolute"
                    alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">Total Users <i class="mdi mdi-diamond mdi-24px float-end"></i>
                  </h4>
                  <h2 class="mb-5"><?php echo $total_users; ?></h2>
                  <h6 class="card-text">Registered users</h6>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Recent Users</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th> User </th>
                          <th></th>
                          <th> Status </th>
                          <th> Date of Birth </th>
                          <th> User ID </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $userlist="select * from tbl_user ORDER BY user_id DESC LIMIT 5";
                        $res=$con->query($userlist);
                        while($data=$res->fetch_assoc())
                        {
                        ?>
                        <tr>
                          <td>
                            <img src="../Assets/Files/UserPhotos/<?php echo $data['user_photo'] ?>" class="me-2" alt="image">
                            <?php echo $data['user_name'];  ?>
                          </td>
                          <td></td>
                          <td>
                            <label class="badge badge-gradient-success">Active</label>
                          </td>
                          <td> <?php echo date('M d, Y', strtotime($data['user_dob'])); ?> </td>
                          <td> <?php echo $data['user_id']; ?> </td>
                        </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
       
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../Assets/Templates/Admin/assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../Assets/Templates/Admin/assets/vendors/chart.js/chart.umd.js"></script>
  <script src="../Assets/Templates/Admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../Assets/Templates/Admin/assets/js/off-canvas.js"></script>
  <script src="../Assets/Templates/Admin/assets/js/misc.js"></script>
  <script src="../Assets/Templates/Admin/assets/js/settings.js"></script>
  <script src="../Assets/Templates/Admin/assets/js/todolist.js"></script>
  <script src="../Assets/Templates/Admin/assets/js/jquery.cookie.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page -->
  <script src="../Assets/Templates/Admin/assets/js/dashboard.js"></script>
  <!-- End custom js for this page -->
</body>

</html>