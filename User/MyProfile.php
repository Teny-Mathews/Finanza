
<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

$selqry="select * from tbl_user where user_id='".$_SESSION['uid']."'";
$row=$con->query($selqry);
$data=$row->fetch_assoc();

?> 






















<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
    }

    .profile-container {
      width: 500px;
      min-height: 700px; /* Changed from height to min-height */
      margin: auto;
      background-color: white;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
      display: flex;
      flex-direction: column;
      position: relative;
    }

    .profile-header {
      background: linear-gradient(135deg, #005baa 0%, #003366 100%);
      color: white;
      padding: 20px 30px 15px;
      text-align: center;
      position: relative;
      overflow: hidden;
      flex-shrink: 0;
    }

    .profile-header::before {
      content: "";
      position: absolute;
      width: 180px;
      height: 180px;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 50%;
      top: -70px;
      right: -70px;
    }

    .profile-header::after {
      content: "";
      position: absolute;
      width: 140px;
      height: 140px;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 50%;
      bottom: -60px;
      left: -60px;
    }

    .profile-img-container {
      display: flex;
      justify-content: center;
      margin-bottom: 12px;
      position: relative;
      z-index: 2;
    }

    .profile-img-frame {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      border: 5px solid rgba(255, 255, 255, 0.3);
      position: relative;
    }

    .profile-img {
      width: 94%;
      height: 94%;
      object-fit: cover;
      border-radius: 50%;
    }

    .profile-name {
      font-size: 1.4rem;
      font-weight: 700;
      margin-bottom: 4px;
      position: relative;
      z-index: 2;
    }

    .profile-title {
      font-size: 0.85rem;
      opacity: 0.9;
      font-weight: 300;
      position: relative;
      z-index: 2;
    }

    .profile-body {
      padding: 15px 25px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      position: relative;
    }

    /* Blue bubbly background designs */
    .bubbles {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: 0;
    }

    .bubble {
      position: absolute;
      border-radius: 50%;
      background: rgba(0, 91, 170, 0.05);
      animation: float 15s infinite ease-in-out;
    }

    .bubble:nth-child(1) {
      width: 80px;
      height: 80px;
      top: 10%;
      left: 10%;
      animation-delay: 0s;
    }

    .bubble:nth-child(2) {
      width: 120px;
      height: 120px;
      top: 20%;
      right: 10%;
      animation-delay: 2s;
    }

    .bubble:nth-child(3) {
      width: 60px;
      height: 60px;
      bottom: 20%;
      left: 15%;
      animation-delay: 4s;
    }

    .bubble:nth-child(4) {
      width: 100px;
      height: 100px;
      bottom: 10%;
      right: 15%;
      animation-delay: 6s;
    }

    .bubble:nth-child(5) {
      width: 70px;
      height: 70px;
      top: 50%;
      left: 5%;
      animation-delay: 8s;
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0) scale(1);
      }
      50% {
        transform: translateY(-20px) scale(1.05);
      }
    }

    .info-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 8px;
      margin-bottom: 12px;
      flex-grow: 1;
      position: relative;
      z-index: 1;
    }

    .info-item {
      display: flex;
      padding: 10px 0;
      border-bottom: 1px solid #f0f6ff;
      align-items: center;
      min-height: 40px;
      background: rgba(255, 255, 255, 0.7);
      border-radius: 8px;
      padding: 10px 15px;
      backdrop-filter: blur(5px);
    }

    .info-label {
      font-weight: 600;
      color: #005baa;
      font-size: 0.78rem;
      width: 110px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .info-value {
      color: #333;
      font-size: 0.82rem;
      font-weight: 500;
      flex-grow: 1;
      line-height: 1.3;
    }

    .profile-actions {
      display: flex;
      gap: 8px;
      margin: 8px 0;
      flex-shrink: 0;
      position: relative;
      z-index: 1;
    }

    .btn-vintage-blue {
      background-color: #005baa;
      color: white;
      border-radius: 18px;
      padding: 7px 14px;
      text-decoration: none;
      transition: 0.3s ease;
      font-weight: 500;
      border: none;
      font-size: 0.8rem;
      box-shadow: 0 2px 5px rgba(0, 91, 170, 0.2);
      flex: 1;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 4px;
    }

    .btn-vintage-blue:hover {
      background-color: #004080;
      color: #fff;
      text-decoration: none;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 91, 170, 0.3);
    }

    /* Enhanced Logout Button */
    .logout-container {
      margin-top: auto;
      padding-top: 12px;
      border-top: 1px solid #f0f6ff;
      flex-shrink: 0;
      position: relative;
      z-index: 2; /* Increased z-index */
    }

    .btn-logout {
      background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
      color: white;
      border-radius: 18px;
      padding: 10px 16px;
      text-decoration: none;
      transition: all 0.3s ease;
      font-weight: 600;
      border: none;
      font-size: 0.85rem;
      box-shadow: 0 3px 8px rgba(255, 107, 107, 0.3);
      width: 100%;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      position: relative;
      overflow: hidden;
    }

    .btn-logout::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .btn-logout:hover {
      background: linear-gradient(135deg, #ff5252 0%, #d32f2f 100%);
      color: #fff;
      text-decoration: none;
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(255, 107, 107, 0.4);
    }

    .btn-logout:hover::before {
      left: 100%;
    }

    .btn-logout:active {
      transform: translateY(-1px);
    }

    /* Logout icon animation */
    .btn-logout i {
      transition: transform 0.3s ease;
    }

    .btn-logout:hover i {
      transform: translateX(3px);
    }

    @media (max-width: 550px) {
      .profile-container {
        width: 95%;
        min-height: auto; /* Adjusted for smaller screens */
      }
      
      .profile-img-frame {
        width: 180px;
        height: 180px;
      }
      
      .profile-actions {
        flex-direction: column;
        gap: 6px;
      }
    }

    @media (max-width: 400px) {
      .profile-img-frame {
        width: 160px;
        height: 160px;
      }
      
      body {
        padding: 10px;
      }
      
      .profile-body {
        padding: 12px 18px;
      }
      
      .profile-header {
        padding: 15px 20px 10px;
      }
    }
  </style>
</head>

<body>
  <div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header">
      <div class="profile-img-container">
        <div class="profile-img-frame">
          <img src="../Assets/Files/UserPhotos/<?php echo $data['user_photo']?>"
               alt="User Photo" class="profile-img" />
        </div>
      </div>
      
      <h1 class="profile-name"><?php echo $data['user_name'] ?></h1>
      
    </div>

    <!-- Profile Body -->
    <div class="profile-body">
      <!-- Blue bubbly background designs -->
      <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
      </div>
      
      <div class="info-grid">
        <div class="info-item">
          <span class="info-label">
            <i class="fas fa-user"></i> Full Name
          </span>
          <span class="info-value"><?php echo $data['user_name'] ?></span>
        </div>
        
        <div class="info-item">
          <span class="info-label">
            <i class="fas fa-venus-mars"></i> Gender
          </span>
          <span class="info-value"><?php echo $data['user_gender'] ?></span>
        </div>
        
        <div class="info-item">
          <span class="info-label">
            <i class="fas fa-envelope"></i> Email
          </span>
          <span class="info-value"><?php echo $data['user_email'] ?></span>
        </div>
        
        <div class="info-item">
          <span class="info-label">
            <i class="fas fa-phone"></i> Contact
          </span>
          <span class="info-value"><?php echo $data['user_contact'] ?></span>
        </div>
        
        <div class="info-item">
          <span class="info-label">
            <i class="fas fa-home"></i> Address
          </span>
          <span class="info-value"><?php echo $data['user_address'] ?></span>
        </div>
        
        <div class="info-item">
          <span class="info-label">
            <i class="fas fa-chart-line"></i> Expense Limit
          </span>
          <span class="info-value"><?php echo $data['user_expenselimit'] ?></span>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="profile-actions">
        <a href="EditProfile.php?<?php echo $data['user_id'] ?>" class="btn-vintage-blue">
          <i class="fas fa-user-edit"></i> Edit Profile
        </a>
        <a href="ChangePassword.php?<?php echo $data['user_id'] ?>" class="btn-vintage-blue">
          <i class="fas fa-key"></i> Change Password
        </a>
      </div>

      <!-- Enhanced Logout Button at Bottom -->
      <div class="logout-container">
        <a href="../Guest/LogOut.php" class="btn-logout">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
  include("Foot.php");
  ?>