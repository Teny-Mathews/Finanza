<?php
include("../Assets/Connection/Connection.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Finanza Admin</title>
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

<body>
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
            <span class="d-flex align-items-center h-100" action="#">
              <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                  <?php
                  $data = $con->query("select * from tbl_admin where admin_id=".$_SESSION['aid'])->fetch_assoc();
                  echo "<span style='color:black;'>Welcome ".$data['admin_name']."</span>";
                  ?>
                </div>
              </div>
            </span>
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