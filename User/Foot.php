<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finanza - Financial Services</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    
    <style>
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
    
    <!-- Testimonial End -->
    </div>
    </div>

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
                    <!--/*** This template is free as long as you keep the footer author's credit link/attribution link/backlink. If you'd like to use the template without the footer author's credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed And <a class="border-bottom" href="https://htmlcodex.com"></a> Distributed By <a
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
    
    <script>
        // Back to top button functionality
        $(document).ready(function(){
            $(window).scroll(function(){
                if ($(this).scrollTop() > 100) {
                    $('.back-to-top').fadeIn();
                } else {
                    $('.back-to-top').fadeOut();
                }
            });
            
            $('.back-to-top').click(function(){
                $("html, body").animate({ scrollTop: 0 }, 600);
                return false;
            });
        });
    </script>
</body>
</html>