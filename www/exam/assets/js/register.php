<?php
include('phpfiles/dbconn.php');
include_once("phpfiles/authentication2.php");

    if(isset($_POST["submit"])){
        $fullname = clean($_POST["fullname"]);
        $email = clean($_POST["email"]);
        $phoneno = clean($_POST["phoneno"]);
        $password = base64_encode(clean($_POST["password"]));
        $address = clean($_POST["address"]);
        $repassword = base64_encode(clean($_POST["repassword"]));

        if($password == $repassword){
            $query = "insert into user_entity (fullname, email, phoneno, password, address) value ('$fullname', '$email', '$phoneno', '$password', '$address')";
            if( $mysqli->query($query) === true ){
                sendNewRegMail($fullname, $email, $phoneno, $address);
                $msg = sprintf($msgTemplate, "Registration Successful...<u><a href='index.php'>Click Here </a></u>to Log-in");
            }

            else
                $msg = sprintf($errTemplate, "Email / Phone Number already exists!");
        }
        else
            $msg = sprintf($errTemplate, "Password mis-match!");
    }



?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
   <?php include_once 'head_style2.php'?>
    <style>
        body{
            color:#000;
        }
    </style>
</head>
<div class="modal fade" id="myDemoModal">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
<body class="bg-gradient-primary">
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-5">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade <?php if(!isset($_POST["submit"])) echo 'show active'?>" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    <div class="mb-4">
                        <h2>Let's get started</h2>
                        <span>What is your Contact detail?</span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate = "Phone Number is required">
                        <input id="phoneNumber" class="input100" type="tel" placeholder="Enter phone number">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-phone" aria-hidden="true"></i>
						</span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate = "Email is required">
                        <input id="txtEmail" class="input100" type="text" placeholder="Enter email" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100"><i class="fa fa-envelope" aria-hidden="true"></i>	</span>
                    </div>

                    <div class="container-login100-form-btn">
                        <input id="sign-in-button" onclick="verifyPhoneNumber()" type="button" class="login100-form-btn btn-primary" value="Next"/>
                    </div>

                    <div class="text-center pt-2">
						<span class="txt1">
							Already Registered?
						</span>
                        <a class="txt2" href="index.php">
                            Login now
                        </a>
                    </div>
                </div>
                <div class="tab-pane fade " id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                    <div class="mb-4">
                        <h2>Phone Verification</h2>
                        <span>Enter the OTP Code sent to your phone?</span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate = "Phone Number is required">
                        <input id="code" class="input100" type="password" name="code" placeholder="OTP Code">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-code" aria-hidden="true"></i>
						</span>
                    </div>

                    <div class="container-login100-form-btn">
                        <input id="sign-in-button" onclick="verifyOTPCode()" type="button" class="login100-form-btn btn-primary" value="Next"/>
                    </div>

                    <div class="text-center pt-2">
						<span class="txt1">
							Didn't receive an OTP?
						</span>
                        <a class="txt2" href="" onclick="resendOTPCode()">
                            Resend
                        </a>
                    </div>
                </div>
                <div class="tab-pane fade <?php if(isset($_POST["submit"])) echo 'show active'?>" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                    <form class="login100-form validate-form" method="post">
                        <div class="mb-4">
                            <h2>Bio Data</h2>
                            <span>Please complete your bio-data form</span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate = "Full name is required">
                            <input id="fullname" class="input100" type="text" name="fullname" placeholder="Enter full name" required>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100"><i class="fa fa-user" aria-hidden="true"></i>	</span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate = "Address is required">
                            <input id="address" class="input100" type="text" name="address" placeholder="Enter Address" required>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100"><i class="fa fa-map-marker-alt" aria-hidden="true"></i></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate = "Password is required">
                            <input id="password" class="input100" type="password" name="password" placeholder="Enter Password" required>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100"><i class="fa fa-key" aria-hidden="true"></i>	</span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate = "Address is required">
                            <input id="repassword" class="input100" type="password" name="repassword" placeholder="Re-enter password" required>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100"><i class="fa fa-key" aria-hidden="true"></i>	</span>
                        </div>
                        <input type="hidden" id="phoneno" name="phoneno" value="<?php if(isset($_POST["phoneno"])) echo $_POST["phoneno"]?>">
                        <input type="hidden" id="email" name="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"]?>">
                        <div class="container-login100-form-btn">
                            <input name="submit" type="submit" class="login100-form-btn btn-primary" value="Submit"/>
                        </div>

                        <?php if(isset($msg)) echo $msg;?>

                        <div class="text-center pt-2">
						<span class="txt1">
							Already have an account?
						</span>
                            <a class="txt2" href="index.php">
                                Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Adon Scripts -->
<!-- Core -->
<script src="assets/plugins/jquery/dist/jquery.min.js"></script>
<script src="assets/js/popper.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>

<script type="text/javascript">
    var phoneNumber = "";
    var email = "";
    function sendVerificationCode() {
        var jsonRequest = JSON.stringify({ phoneNumber: phoneNumber, email : email });
        $.ajax({
            url: "api.php",
            cache : false,
            data: {generateOTP : jsonRequest},
            type: "POST",
            beforeSend: function () {

            },
            success: function (returnData) {
                $("#tabs-icons-text-1").removeClass("show active");
                $("#tabs-icons-text-2").addClass("show active");
                $("#phoneno").val(phoneNumber);
                $("#email").val(email);
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("Error occurs...Please check if it's a valid phone number");
                $.unblockUI();
            },
            complete: function () {
            }
        });

    }
    function verifyPhoneNumber() {
        phoneNumber = $("#phoneNumber").val();
        email = $("#txtEmail").val();
        phoneNumber = formatPhoneNumber(phoneNumber);
        $.ajax({
            url: "api.php",
            cache : false,
            data: {verifyPhoneNumberEmail : phoneNumber, email : email},
            type: "POST",
            beforeSend: function () {
                $.blockUI({ message: '<h4>Processing request...Please wait</h4>' });
            },
            success: function (returnData) {
                var response = JSON.parse(returnData);
                if(response.responseCode == "00"){
                    $.unblockUI();
                    alert("Phone Number / Email already exits");
                }
                else
                    sendVerificationCode();

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("Error occurs...Please check if it's a valid phone number");
                $.unblockUI();
            },
            complete: function () {
            }
        });
    }
    function verifyOTPCode() {

        var code = $("#code").val();
        var jsonRequest = JSON.stringify({ phoneNumber: phoneNumber, code : code });
        $.ajax({
            url: "api.php",
            cache : false,
            data: {validateOTP : jsonRequest},
            type: "POST",
            beforeSend: function () {
                $.blockUI({ message: '<h4>Processing request...Please wait</h4>' });
            },
            success: function (returnData) {
               if(returnData == "00"){
                   $("#tabs-icons-text-2").removeClass("show active");
                   $("#tabs-icons-text-3").addClass("show active");
               }
               else
                   alert("Invalid verification code");
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("Error occurs...Please try again!");
                $.unblockUI();
            },
            complete: function () {

            }
        });
    }
    function resendOTPCode() {
        sendVerificationCode();
    }
    function formatPhoneNumber(phone) {
        phone = phone.indexOf("+234") != -1 ?  '0' + phone.substr(4) : phone;
        phone = phone.indexOf("234") != -1 ?  '0' + phone.substr(3) : phone;
        phone = phone.substr(0,1) != 0 ? '0' + phone : phone;
        return phone;
    }
</script>


</body>

</html>