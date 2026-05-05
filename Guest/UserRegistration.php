<?php
include("../Assets/Connection/Connection.php");
if(isset($_POST["btn_signup"]))
{
	
	$name = $_POST["txt_name"];
	$email = $_POST["txt_email"];
	$contact=$_POST["txt_contact"];
	$address=$_POST["txt_address"];
	$gender=$_POST["btn_gender"];
	$dob=$_POST["txt_dob"];
	$district=$_POST["sel_district"];
	$place=$_POST["sel_place"];
	$photo=$_FILES["file_photo"]["name"];
	$tempPhoto=$_FILES["file_photo"]["tmp_name"];
	move_uploaded_file($tempPhoto,"../Assets/Files/UserPhotos/".$photo);
	$password = $_POST["txt_password"];
	$repassword = $_POST["txt_repassword"];
    $expenselimit = $_POST["txt_expenselimit"];

    $SelQry="select * from tbl_user where user_email='".$email."'";
    $res=$con->query($SelQry);

    if($res->num_rows>0)
    {
        ?>
        <script>
            alert("Email Already Exist");
            
        </script>
        <?php

    }

    else
    {
                if($password==$repassword)
	{
	$insqry="INSERT INTO tbl_user(
    user_name,
    user_email,
    user_contact,
    user_address,
    user_gender,
    user_dob,
    user_photo,
    user_password,
    place_id,
    user_expenselimit
) VALUES (
    '".$name."',
    '".$email."',
    '".$contact."',
    '".$address."',
    '".$gender."',
    '".$dob."',
    '".$photo."',
    '".$password."',
    '".$place."',
    '".$expenselimit."'
)";

	if($con->query($insqry))
	{
		?>
        <script>
		alert("Inserted Successfully");
    Window.location="Login.php";
		</script>
        <?php 
	}
	}
	else
	{
?>
        <script>
		alert("Password Error Can't Insert");
		</script>
        <?php 
}
    }
	
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finanza - User Registration</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-container {
            max-width: 1200px;
            width: 100%;
            background: white;
            border-radius: 24px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 700px;
        }

        /* Left Side - Welcome & Actions */
        .welcome-side {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e40af 100%);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .welcome-side::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .brand-logo {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            letter-spacing: -2px;
            background: linear-gradient(45deg, #ffffff, #e0f2fe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-tagline {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.9;
            font-weight: 300;
            line-height: 1.6;
        }

        .welcome-content {
            z-index: 2;
            position: relative;
        }

        .feature-list {
            list-style: none;
            margin: 40px 0;
            text-align: left;
        }

        .feature-list li {
            margin: 15px 0;
            display: flex;
            align-items: center;
            opacity: 0.9;
        }

        .feature-list li::before {
            content: '✓';
            margin-right: 15px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
        }

        .action-buttons {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
            max-width: 280px;
        }

        .btn {
            padding: 16px 32px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(45deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(245, 158, 11, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
        }

        /* Right Side - Form */
        .form-side {
            background: #fafbff;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            overflow-y: auto;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .form-subtitle {
            color: #64748b;
            font-size: 1rem;
        }

        .form-container {
            flex: 1;
        }

        .input-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 24px;
        }

        .input-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }

        input, select {
            width: 100%;
            padding: 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            background: white;
            transition: all 0.3s ease;
            color: #1f2937;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        input::placeholder {
            color: #9ca3af;
        }

        .gender-options {
            display: flex;
            gap: 24px;
            margin-top: 8px;
        }

        .gender-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .gender-option input[type="radio"] {
            width: auto;
            margin: 0;
        }

        .gender-option label {
            margin: 0;
            font-weight: 500;
            color: #6b7280;
        }

        .file-input-wrapper {
            position: relative;
            cursor: pointer;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-label {
            display: block;
            padding: 16px;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            text-align: center;
            background: #f9fafb;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        .file-label:hover {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.05);
            color: #3b82f6;
        }

        .submit-section {
            margin-top: 40px;
            text-align: center;
        }

        .btn-submit {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 18px 48px;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
            margin-right: 15px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4);
        }

        .btn-cancel {
            background: #f1f5f9;
            color: #64748b;
            padding: 18px 32px;
            font-size: 1.1rem;
            font-weight: 600;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
            color: #475569;
        }

        .login-link {
            margin-top: 30px;
            text-align: center;
            color: #64748b;
        }

        .login-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Progress Steps */
        .progress-steps {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 8px;
        }

        .step {
            width: 40px;
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
        }

        .step.active {
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-container {
                grid-template-columns: 1fr;
                max-width: 480px;
            }
            
            .welcome-side {
                padding: 40px 30px;
                min-height: 300px;
            }
            
            .brand-logo {
                font-size: 2.5rem;
            }
            
            .form-side {
                padding: 30px 25px;
            }
            
            .input-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .form-title {
                font-size: 2rem;
            }

            .action-buttons {
                flex-direction: row;
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .welcome-side {
                padding: 30px 20px;
            }
            
            .form-side {
                padding: 25px 20px;
            }
        }

        /* Loading Animation */
        .loading {
            opacity: 0;
            animation: fadeIn 0.8s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container loading">
        <!-- Left Side - Welcome & Branding -->
        <div class="welcome-side">
            <div class="welcome-content">
                <div class="brand-logo">Finanza</div>
                <p class="brand-tagline">Your Gateway to Smart Financial Management</p>
                
                <ul class="feature-list">
                    <li>Secure & Encrypted Platform</li>
                    <li>Real-time Financial Tracking</li>
                    <li>Advanced Analytics Dashboard</li>
                    <li>24/7 Expert Support</li>
                </ul>
                
                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="scrollToForm()">Get Started</button>
                    <a href="Login.php" class="btn btn-secondary">Already Have Account?</a>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Registration Form -->
        <div class="form-side">
            <div class="form-header">
                <h2 class="form-title">Create Account</h2>
                <p class="form-subtitle">Join thousands of users managing their finances smarter</p>
            </div>
            
           
            
            <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" class="form-container">
                <div class="input-grid">
                    <div class="input-group">
                        <label for="txt_name">Full Name *</label>
                        <input required type="text" name="txt_name" id="txt_name" 
                               placeholder="Enter your full name"
                               title="Name Allows Only Alphabets,Spaces and First Letter Must Be Capital Letter" 
                               pattern="^[A-Z]+[a-zA-Z ]*$" />
                    </div>
                    
                    <div class="input-group">
                        <label for="txt_email">Email Address *</label>
                        <input required type="email" name="txt_email" id="txt_email" 
                               placeholder="your.email@example.com" />
                    </div>
                </div>
                
                <div class="input-grid">
                    <div class="input-group">
                        <label for="txt_contact">Phone Number *</label>
                        <input required type="text" name="txt_contact" id="txt_contact" 
                               placeholder="9876543210"
                               pattern="[5-9]{1}[0-9]{9}" 
                               title="Phone number with 5-9 and remaining 9 digits with 0-9" />
                    </div>
                    
                    <div class="input-group">
                        <label for="txt_dob">Date of Birth *</label>
                        <input type="date" required name="txt_dob" id="txt_dob" />
                    </div>
                </div>
                
                <div class="input-group full-width">
                    <label for="txt_address">Address *</label>
                    <input required type="text" name="txt_address" id="txt_address" 
                           placeholder="Enter your complete address" />
                </div>
                
                <div class="input-grid">
                    <div class="input-group">
                        <label for="sel_district">District *</label>
                        <select onChange="getPlace(this.value)" name="sel_district" id="sel_district" required>
                            <option value="">Select District</option>
                            <?php 
                            $selqry="select * from tbl_district";
                            $resopt=$con->query($selqry);
                            while($dataopt=$resopt->fetch_assoc())
                            {
                                ?>
                                <option value="<?php echo $dataopt["district_id"] ?>">
                                <?php echo $dataopt["district_name"] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="input-group">
                        <label for="sel_place">Place *</label>
                        <select name="sel_place" id="sel_place" required >
                            <option value="">Select Place</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-group full-width">
                    <label>Gender *</label>
                    <div class="gender-options">
                        <div class="gender-option">
                            <input type="radio" required name="btn_gender" id="Male" value="Male" />
                            <label for="Male">Male</label>
                        </div>
                        <div class="gender-option">
                            <input type="radio" name="btn_gender" id="Female" value="Female" />
                            <label for="Female">Female</label>
                        </div>
                    </div>
                </div>
                
                <div class="input-group full-width">
                    <label for="file_photo">Profile Photo *</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="file_photo" id="file_photo" class="file-input" 
                               accept="image/*" required />
                        <div class="file-label" id="file-label">
                            📸 Click to upload your photo
                        </div>
                    </div>
                </div>
                
                <div class="input-grid">
                    <div class="input-group">
                        <label for="txt_password">Password *</label>
                        <input required type="password" name="txt_password" id="txt_password" 
                               placeholder="Create a strong password"
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                               title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
                    </div>
                    
                    <div class="input-group">
                        <label for="txt_repassword">Confirm Password *</label>
                        <input required type="password" name="txt_repassword" id="txt_repassword" 
                               placeholder="Confirm your password" />
                    </div>
                </div>
                <div class="input-group full-width">
    <label for="txt_expenselimit">Monthly Expense Limit (in ₹) *</label>
    <input required type="number" name="txt_expenselimit" id="txt_expenselimit" 
           placeholder="Enter your monthly expense limit" 
           min="0" step="0.01" />
</div>

                <div class="submit-section">
                    <input type="submit" name="btn_signup" id="btn_signup" value="Create Account" class="btn-submit" />
                    <input type="button" name="btn_cancel" id="btn_cancel" value="Cancel" class="btn-cancel" />
                </div>
                
                <div class="login-link">
                    Already have an account? <a href="Login.php">Sign In Here</a>
                </div>
            </form>
        </div>
    </div>

    <script src="../Assets/JQ/jQuery.js"></script>
    <script>
        function getPlace(did) {
            $.ajax({
                url: "../Assets/AjaxPages/AjaxPlace.php?did=" + did,
                success: function (result) {
                    $("#sel_place").html(result);
                }
            });
        }

        function scrollToForm() {
            document.querySelector('.form-side').scrollIntoView({ 
                behavior: 'smooth' 
            });
        }

        // File input label update
        document.getElementById('file_photo').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || '📸 Click to upload your photo';
            const displayName = fileName.length > 30 ? fileName.substring(0, 30) + '...' : fileName;
            document.getElementById('file-label').textContent = '✓ ' + displayName;
            document.getElementById('file-label').style.color = '#059669';
            document.getElementById('file-label').style.borderColor = '#059669';
        });

        // Password strength indicator
        document.getElementById('txt_password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strength = checkPasswordStrength(password);
            // You can add visual feedback here
        });

        function checkPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            return strength;
        }

        // Form validation enhancement
        document.getElementById('form1').addEventListener('submit', function(e) {
            const password = document.getElementById('txt_password').value;
            const repassword = document.getElementById('txt_repassword').value;
            
            if (password !== repassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
        });

        // Loading animation
        window.addEventListener('load', function() {
            document.querySelector('.auth-container').classList.add('loading');
        });

        // Enhanced mobile experience
        if (window.innerWidth <= 768) {
            document.querySelector('.welcome-side').addEventListener('click', scrollToForm);
        }
    </script>
    <script>
document.getElementById("txt_dob").addEventListener("change", function() {
    let dob = new Date(this.value);
    let today = new Date();

    // calculate age
    let age = today.getFullYear() - dob.getFullYear();
    let monthDiff = today.getMonth() - dob.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--; // adjust if birthday not reached yet this year
    }

    if (age < 18) {
        alert("You must be at least 18 years old.");
        this.value = ""; // clear the field
    }
});
</script>
</body>
</html>