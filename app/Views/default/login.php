<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

include VIEWS."header.php";
include VIEWS."navbar.php";

?>
<div class="container">
<h1>Login</h1>
<form style="max-width: 400px; justify-content: center">
    <?php if(isset($_GET['registration_success'])){
            echo '<div class="alert alert-success" role="alert">
        <strongAccount Created!</strong> Please login with your new account!
    </div>';
    }?>
    <div class="alert alert-danger" role="alert" style="display: none" id="alert-login-failed">
        <strong>Login failed!</strong> please check your email and password and try again
    </div>
    <div class="mb-3">
        <div class="alert alert-warning" role="alert" style="display: none" id="input-email-alert">
           please enter your email address
        </div>
        <label for="input-email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="input-email" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <div class="alert alert-warning" role="alert" style="display: none" id="input-password-alert">
           please enter your password
        </div>
        <label for="input-password" class="form-label">Password</label>
        <input type="password" class="form-control" id="input-password">
    </div>
    <p>Dont already have an account? <a href="/register">register for free today.</a></p>
    <button onclick="login()" type="button" class="btn btn-primary" id="login-button">Submit</button>
</form>
</div>

<script>

    const emailInput = document.getElementById("input-email");
    const emailInputAlert = document.getElementById("input-email-alert");
    const passwordInput = document.getElementById("input-password");
    const passwordInputAlert = document.getElementById("input-password-alert");
    const loginFailedAlert = document.getElementById("alert-login-failed");
s
    //**** LOGIN BUTTON FUNCTION ****\\
    function login(){

      //STEP 1: check we have input from the user and display an alert if not

        //check to see if the email value is empty
        if(emailInput.valueOf().value === ""){
            //if so then show the error message
            emailInputAlert.style.display="block";
        }else{
            //else keep the error message hidden
            emailInputAlert.style.display="none";
        }

        //check to see if the email value is empty
        if(passwordInput.valueOf().value === ""){
            //if so then show the error message
            passwordInputAlert.style.display="block";
        }else{
            //else keep the error message hidden
            passwordInputAlert.style.display="none";
        }

        if(passwordInput.valueOf().value !== "" && emailInput.valueOf().value !== ""){
            var jqxhr = $.post( "/api/auth/login",{ type: "web", email: emailInput.valueOf().value, password: passwordInput.valueOf().value } )
            .done(function (data){

                    //redirect on true, representing success
                    if (typeof data === "object" && data.success) {
                        //make sure the error is hidden
                        loginFailedAlert.style.display = "none";
                        //redirect to successful login location
                        window.location.href=data.redirect;

                    } else {
                        loginFailedAlert.style.display = "block";
                    }

            });

        }

    }

</script>