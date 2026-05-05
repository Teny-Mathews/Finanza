<!-- <?php
session_start();

?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<h2>Welcome! <?php echo $_SESSION['username']?></h2>
<table width="200" border="1">
  <tr>
    <td><a href="MyProfile.php"?>My Profile</a></td>
  </tr>
  <tr>
    <td><a href="EditProfile.php"?>Edit Profile</a></td>
  </tr>
  <tr>
    <td><a href="ChangePassword.php"?>Change Password</a></td>
  </tr>
  <tr>
    <td><a href="Expense.php"?>My Expenses</a></td>
  </tr>
  <tr>
    <td><a href="Income.php"?>My Income</a></td>
  </tr>
  <tr>
    <td><a href="Loan.php"?>Loan</a></td>
  </tr>
  <tr>
    <td><a href="Feedback.php"?>Reviews</a></td>
  </tr>
  <tr>
    <td><a href="Complaint.php"?>Register a Complaint</a></td>
  </tr>
</table>
</body>
</html>
<script src="../Assets/JQ/jQuery.js"></script>
<script>
  $(document).ready(function () {
    $.ajax({
      url: "../Assets/AjaxPages/MailRemainder.php",
      success: function (result) {
        console.log(result); // Debugging (optional)
      }
    });
  });
</script> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Finanza</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../Assets/Templates/Main/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../Assets/Templates/Main/lib/animate/animate.min.css" rel="stylesheet">
    <link href="../Assets/Templates/Main/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../Assets/Templates/Main/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../Assets/Templates/Main/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt text-primary me-2"></i>2nd Floor MCC Building,Karukadom,Kothamangalam,686691</small>
                <small class="ms-4"><i class="fa fa-clock text-primary me-2"></i>9.00 am - 3.45 pm</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small><i class="fa fa-envelope text-primary me-2"></i>infofinanza123@gmail.com</small>
                <small class="ms-4"><i class="fa fa-phone-alt text-primary me-2"></i>+918590376984</small>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="../Assets/Templates/Main/index.html" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="display-5 text-primary m-0">Finanza</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="HomePage.php" class="nav-item nav-link active">Home</a>
                    <a href="Income.php" class="nav-item nav-link">Income</a>
                    <a href="Expense.php" class="nav-item nav-link">Expense</a>
                    <a href="BudgetAnalysis.php" class="nav-item nav-link">BudgetAnalysis</a>
                    <a href="MonthlyReport.php" class="nav-item nav-link">MonthlyReport</a>
                    <a href="Loan.php" class="nav-item nav-link">Loan</a>
                    <a href="Rating.php" class="nav-item nav-link">Review</a>
                    <a href="Complaint.php" class="nav-item nav-link">Complaint</a>
                    
                    

                </div>
                <div class="d-none d-lg-flex ms-2">
                    <a class="btn btn-light btn-sm-square rounded-circle ms-6" href="MyProfile.php">
                        <i class="fa-regular fa-user" style="color:blue;size:100px;"></i>
                    </a>
                    <a class="btn btn-light btn-sm-square rounded-circle ms-3" href="../Guest/LogOut.php">
                        <i class="fa-solid fa-right-from-bracket" style="color:blue;size:100px;"></i>
                    </a>
                   
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="../Assets/Templates/Main/w-100" src="../Assets/Templates/Main/img/carousel-1.jpg" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-8">
                                    <p
                                        class="d-inline-block border border-white rounded text-primary fw-semi-bold py-1 px-3 animated slideInDown">
                                        Welcome to Finanza</p>
                                    <h1 class="display-1 mb-4 animated slideInDown">Your Financial Status Is Our Goal
                                    </h1>
                                    <a href="" class="btn btn-primary py-3 px-5 animated slideInDown">Explore More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="../Assets/Templates/Main/w-100" src="../Assets/Templates/Main/img/carousel-2.jpg" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-7">
                                    <p
                                        class="d-inline-block border border-white rounded text-primary fw-semi-bold py-1 px-3 animated slideInDown">
                                        Welcome to Finanza</p>
                                    <h1 class="display-1 mb-4 animated slideInDown">True Financial Support For You</h1>
                                    <a href="" class="btn btn-primary py-3 px-5 animated slideInDown">Explore More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->
      
<!-- Features Start -->
    <div class="container-xxl feature py-5">
   <div class="container text-center">
    <br>
    <!-- Heading -->
    <h1 class="display-5 mb-5">Our Services</h1>
    <br>

    <!-- First Row (3 cards) -->
    <div class="row justify-content-center g-4 mb-4">
      <!-- Expense -->
      <div class="col-md-4">
        <a href="Expense.php" class="text-decoration-none">
          <div class="feature-box border rounded p-4 h-100">
            <i class="fa fa-wallet fa-3x text-primary mb-3"></i>
            <h4 class="mb-3">Expense</h4>
            <p class="mb-0">Track and record your daily expenses</p>
          </div>
        </a>
      </div>
      <!-- Income -->
      <div class="col-md-4">
        <a href="Income.php" class="text-decoration-none">
          <div class="feature-box border rounded p-4 h-100">
            <i class="fa fa-money-bill-wave fa-3x text-success mb-3"></i>
            <h4 class="mb-3">Income</h4>
            <p class="mb-0">Track and record your daily incomes</p>
          </div>
        </a>
      </div>
      <!-- Budget -->
      <div class="col-md-4">
        <a href="BudgetAnalysis.php" class="text-decoration-none">
          <div class="feature-box border rounded p-4 h-100">
            <i class="fa fa-chart-pie fa-3x text-warning mb-3"></i>
            <h4 class="mb-3">Budget Analysis</h4>
            <p class="mb-0">See your budget analysis</p>
          </div>
        </a>
      </div>
    </div>

    <!-- Second Row (2 cards) -->
    <div class="row justify-content-center g-4">
      <!-- Reports -->
      <div class="col-md-4">
        <a href="MonthlyReport.php" class="text-decoration-none">
          <div class="feature-box border rounded p-4 h-100">
            <i class="fa fa-file-alt fa-3x text-danger mb-3"></i>
            <h4 class="mb-3">Monthly Reports</h4>
            <p class="mb-0">See your monthly reports</p>
          </div>
        </a>
      </div>
      <!-- Loan -->
      <div class="col-md-4">
        <a href="Loan.php" class="text-decoration-none">
          <div class="feature-box border rounded p-4 h-100">
            <i class="fa fa-hand-holding-usd fa-3x text-info mb-3"></i>
            <h4 class="mb-3">Loan</h4>
            <p class="mb-0">Track and manage your loans</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

    <!-- Features End -->
 
   


    <!-- Facts Start -->
    <div class="container-fluid facts my-5 py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-sm-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                    <i class="fa fa-users fa-3x text-white mb-3"></i>
                    <h1 class="display-4 text-white" data-toggle="counter-up">10</h1>
                    <span class="fs-5 text-white">Happy Clients</span>
                    <hr class="bg-white w-25 mx-auto mb-0">
                </div>
                <div class="col-sm-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                    <i class="fa fa-check fa-3x text-white mb-3"></i>
                    <h1 class="display-4 text-white" data-toggle="counter-up">10</h1>
                    <span class="fs-5 text-white">Analysed Finances</span>
                    <hr class="bg-white w-25 mx-auto mb-0">
                </div>
                <div class="col-sm-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                    <i class="fa fa-users-cog fa-3x text-white mb-3"></i>
                    <h1 class="display-4 text-white" data-toggle="counter-up">2</h1>
                    <span class="fs-5 text-white">Dedicated Staff</span>
                    <hr class="bg-white w-25 mx-auto mb-0">
                </div>
                <div class="col-sm-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">
                    <i class="fa fa-award fa-3x text-white mb-3"></i>
                    <h1 class="display-4 text-white" data-toggle="counter-up">3</h1>
                    <span class="fs-5 text-white">Awards Achieved</span>
                    <hr class="bg-white w-25 mx-auto mb-0">
                </div>
            </div>
        </div>
    </div>
    <!-- Facts End -->


   <!-- Features Start -->
    <div class="container-xxl feature py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <p class="d-inline-block border rounded text-primary fw-semi-bold py-1 px-3">Why Choosing Us!</p>
                    <h1 class="display-5 mb-4">Few Reasons Why People Choosing Us!</h1>
                    <p class="mb-4">Finanza is a secure, all-in-one platform that helps users easily track expenses,
                        create budgets, and gain clear financial insights through professional-grade reports.
                        Its clean, formal design and smart features make it ideal for individuals and professionals
                        who want to manage their money with confidence and clarity. </p>

                    <a class="btn btn-primary py-3 px-5" href="../about.html">Explore More</a>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-6">
                            <div class="row g-4">
                                <div class="col-12 wow fadeIn" data-wow-delay="0.3s">
                                    <div class="feature-box border rounded p-4">
                                        <i class="fa fa-check fa-3x text-primary mb-3"></i>
                                        <h4 class="mb-3">Fast Executions</h4>
                                        <p class="mb-3">Finanza delivers fast, seamless performance,
                                            enabling users to manage budgets and track expenses in real-time without
                                            delays.</p>
                                        <a class="fw-semi-bold" href="../about.html">Read More <i
                                                class="fa fa-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                                <div class="col-12 wow fadeIn" data-wow-delay="0.5s">
                                    <div class="feature-box border rounded p-4">
                                        <i class="fa fa-check fa-3x text-primary mb-3"></i>
                                        <h4 class="mb-3">Guide & Support</h4>
                                        <p class="mb-3">Finanza offers reliable guidance and
                                            responsive support, ensuring users have expert help
                                            every step of their financial journey.</p>
                                        <a class="fw-semi-bold" href="../about.html">Read More <i
                                                class="fa fa-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 wow fadeIn" data-wow-delay="0.7s">
                            <div class="feature-box border rounded p-4">
                                <i class="fa fa-check fa-3x text-primary mb-3"></i>
                                <h4 class="mb-3">Financial Clarity</h4>
                                <p class="mb-3">Finanza gives you clear, actionable insights into your
                                    spending habits, helping you manage expenses wisely, stay aware of
                                    financial pitfalls, and make smarter money decisions with confidence.</p>
                                <a class="fw-semi-bold" href="../about.html">Read More <i class="fa fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->

    





    <!-- Testimonial Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <p class="d-inline-block border rounded text-primary fw-semi-bold py-1 px-3">Testimonial</p>
            <h1 class="display-5 mb-5">What Our Clients Say About Finanza!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.3s">

            <!-- Treesa - Doctor -->
            <div class="testimonial-item">
                <div class="testimonial-text border rounded p-4 pt-5 mb-5">
                    <div class="btn-square bg-white border rounded-circle">
                        <i class="fa fa-quote-right fa-2x text-primary"></i>
                    </div>
                    Finanza helps me manage both my clinic and personal finances effortlessly. The budgeting tools are perfect for a busy doctor like me.
                </div>
                <img class="../Assets/Templates/Main/rounded-circle mb-3" src="../Assets/Templates/Main/img/testimonial-1.jpg" alt="">
                <h4>Treesa</h4>
                <span>Doctor</span>
            </div>

            <!-- Jacob - Engineer -->
            <div class="testimonial-item">
                <div class="testimonial-text border rounded p-4 pt-5 mb-5">
                    <div class="btn-square bg-white border rounded-circle">
                        <i class="fa fa-quote-right fa-2x text-primary"></i>
                    </div>
                    As an engineer, managing project budgets and daily expenses is now seamless with Finanza. It's user-friendly and accurate.
                </div>
                <img class="../Assets/Templates/Main/rounded-circle mb-3" src="../Assets/Templates/Main/img/testimonial-2.jpg" alt="">
                <h4>Jacob</h4>
                <span>Engineer</span>
            </div>

            <!-- Meera - Public Speaker -->
            <div class="testimonial-item">
                <div class="testimonial-text border rounded p-4 pt-5 mb-5">
                    <div class="btn-square bg-white border rounded-circle">
                        <i class="fa fa-quote-right fa-2x text-primary"></i>
                    </div>
                    Finanza has been a game-changer in keeping track of my travel and event-related expenses. I can finally stay organized on the go!
                </div>
                <img class="../Assets/Templates/Main/rounded-circle mb-3" src="../Assets/Templates/Main/img/testimonial-3.jpg" alt="">
                <h4>Meera</h4>
                <span>Public Speaker</span>
            </div>

            <!-- Mark - Political Leader -->
            <div class="testimonial-item">
                <div class="testimonial-text border rounded p-4 pt-5 mb-5">
                    <div class="btn-square bg-white border rounded-circle">
                        <i class="fa fa-quote-right fa-2x text-primary"></i>
                    </div>
                    Transparency in financial management is crucial in my field. Finanza provides the features I need to stay accountable and efficient.
                </div>
                <img class="../Assets/Templates/Main/rounded-circle mb-3" src="../Assets/Templates/Main/img/testimonial-4.jpg" alt="">
                <h4>Mark</h4>
                <span>Political Leader</span>
            </div>

          

        </div>
    </div>
</div>
<!-- Testimonial End -->

<<style>
        /* Custom styles to maintain original design */
        .bg-dark {
            background-color: #24346bff !important;
        }
        
        .copyright {
            background-color: #1a1a1bff !important;
        }
        
        .btn-link {
            color: #fff;
            text-decoration: none;
            padding: 5px 0;
            display: block;
            width: 100%;
        }
        
        .btn-link:hover {
            color: #4dabf7;
        }
        
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 99;
            display: none;
        }
        
        /* Center alignment for footer content */
        .footer-center-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        /* Ensure the footer structure remains exactly the same */
        .footer .row {
            display: flex;
            justify-content: center;
        }
        
        .footer .col-lg-3 {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>
<body>

    <!-- Your existing content would go here -->
    
    
 <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5 justify-content-center">
                <div class="col-lg-3 col-md-6 footer-center-content">
                    <h4 class="text-white mb-4">Our Office</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>2nd Floor MCC Building,Karukadom,
                    Kothamangalam,686691</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+91 8590376984</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>infofinanza123@gmail.com</p>
                </div>
                <div class="col-lg-3 col-md-6 footer-center-content">
                    <h4 class="text-white mb-4">Services</h4>
                    <a class="btn btn-link text-center" href="HomePage.php">Financial Planning</a>
                    <a class="btn btn-link text-center" href="BudgetAnalysis.php">Budget Analysis</a>
                    <a class="btn btn-link text-center" href="MonthlyReport.php">Monthly Report Generation</a>
                    <a class="btn btn-link text-center" href="Loan.php">Your Loan Alerts</a>
                </div>
                <div class="col-lg-3 col-md-6 footer-center-content">
                    <h4 class="text-white mb-4">Quick Links</h4>
                    <a class="btn btn-link text-center" href="../about.html">About Us</a>
                    <a class="btn btn-link text-center" href="../contact.html">Contact Us</a>
                    <a class="btn btn-link text-center" href="HomePage.php">Our Services</a>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Copyright Start -->
    <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">Finanza</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed And<a class="border-bottom" href="https://htmlcodex.com"></a> Distributed By <a
                    href="https://themewagon.com">Paul Baby John & Teny Mathews</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Assets/Templates/Main/lib/wow/wow.min.js"></script>
    <script src="../Assets/Templates/Main/lib/easing/easing.min.js"></script>
    <script src="../Assets/Templates/Main/lib/waypoints/waypoints.min.js"></script>
    <script src="../Assets/Templates/Main/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../Assets/Templates/Main/lib/counterup/counterup.min.js"></script>

    <!-- Template Javascript -->
    <script src="../Assets/Templates/Main/js/main.js"></script>
</body>

</html>  

<script src="../Assets/JQ/jQuery.js"></script>
<script>
  $(document).ready(function () {
    $.ajax({
      url: "../Assets/AjaxPages/MailRemainder.php",
      success: function (result) {
        console.log(result); 
      }
    });
  });

   $(document).ready(function () {
    $.ajax({
      url: "../Assets/AjaxPages/ExpenseLimitReminder.php",
      success: function (result) {
        console.log(result); 
      }
    });
  });
</script> 