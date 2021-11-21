<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

include VIEWS . "header.php";
include VIEWS . "navbar.php";
?>

<div class="container"  id="body-content">

    <form style=" justify-content: center; max-width: 1200px" id="login-form" >
        <h1>Registration</h1>
        <div class="alert alert-danger" role="alert" style="display: none" id="alert-registration-failed">
            <strong>Registration Failed!</strong> please check all the required information is entered correctly and try again
        </div>
        <div class="flex-row d-flex">
            <div class="mb-3 p-2"  style="width: 300px">
                <div class="alert alert-warning" role="alert" style="display: none" id="input-firstname-alert">
                    please enter your first name
                </div>
                <label for="first_name" class="form-label">First name</label>
                <input type="text" class="form-control" id="first_name">
            </div>
            <div class="mb-3 p-2" style="width: 300px">
                <div class="alert alert-warning" role="alert" style="display: none" id="input-lastname-alert">
                    please enter your last name
                </div>
                <label for="last_name" class="form-label" >Last name</label>
                <input type="text" class="form-control" id="last_name">
            </div>
        </div>
        <div class="flex-row d-flex">
            <div class="mb-3 p-2" style="width: 300px">
                <div class="alert alert-warning" role="alert" style="display: none" id="input-username-alert">
                    please enter a valid username, usernames cannot match and must be unique!
                </div>
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username"  style="max-width: 300px">
            </div>
            <div class="mb-3 p-2" style="width: 300px">
                <div class="alert alert-warning" role="alert" style="display: none" id="input-email-alert">
                    please enter a valid email address, emails cannot match and must be unique!
                </div>
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email"  style="max-width: 300px">
            </div>
        </div>
        <div class="alert alert-warning" role="alert" style="display: none" id="input-password1-alert">
            please check your password is not blank and that both password fields match!
        </div>
        <div class="flex-row d-flex">
            <div class="mb-3 p-2" style="width: 300px">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="password1"  style="max-width: 300px">
            </div>
            <div class="mb-3 p-2" style="width: 300px">
                <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password2"  style="max-width: 300px">
            </div>
        </div>
        <div class="alert alert-warning" role="alert" style="display: none" id="input-tos-alert">
            Please read and accept our terms of service before creating an account
        </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="accept-tos">
                <label class="form-check-label" for="exampleCheck1">I Agree to the Code Crunchers <a href="/terms-of-service">Terms of Service</a></label>
            </div>
    <p>Already have an account? <a href="/login">login now!</a></p>
    <button onclick="register()" type="button" class="btn btn-primary" id="registerButton">Submit</button>
    </form>
</div>

<script>

    //registration inputs
    const firstnameInput = document.getElementById("first_name");
    const lastnameInput = document.getElementById("last_name");
    const usernameInput = document.getElementById("username");
    const emailInput = document.getElementById("email");
    const password1Input = document.getElementById("password1");
    const password2Input = document.getElementById("password2");

    const acceptTos = document.getElementById("accept-tos");

    //failure alerts
    const firstnameAlert = document.getElementById("input-firstname-alert");
    const lastnameAlert = document.getElementById("input-lastname-alert");
    const usernameAlert = document.getElementById("input-username-alert");
    const emailAlert = document.getElementById("input-email-alert");
    const password1Alert = document.getElementById("input-password1-alert");
    const registrationFailed = document.getElementById("alert-registration-failed");
    const tosAlert = document.getElementById("input-tos-alert");

    function register(){
        //perform blank checks
        let outcome = true;

        //check the firstname
        if(firstnameInput.valueOf().value === ""){
            firstnameAlert.style.display="block";
            outcome = false;
        }else{
            firstnameAlert.style.display="none";
        }

        //check the last name
        if(lastnameInput.valueOf().value === ""){
            outcome = false;
            lastnameAlert.style.display="block";
        }else{
            lastnameAlert.style.display="none";
        }

        //check the username
        if(usernameInput.valueOf().value === ""){
            outcome = false;
            usernameAlert.style.display="block";
        }else{
            usernameAlert.style.display="none";
        }

        //check the email
        if(emailInput.valueOf().value === ""){
            outcome = false;
            emailAlert.style.display="block";
        }else{
            emailAlert.style.display="none";
        }

        //check to make sure both passwords match
        if(password1Input.valueOf().value === password2Input.valueOf().value && password2Input.valueOf().value !== "" && password1Input.valueOf().value !== ""){
            password1Alert.style.display="none";
        }else{
            outcome = false;
            password1Alert.innerText = "Please ensure both passwords match and are not blank!"
            password1Alert.style.display="block";
        }

        if(!acceptTos.checked){
            tosAlert.style.display = "block"
        }else{
            tosAlert.style.display = "none"
        }



        if(outcome) {
            var jqxhr = $.post("/api/auth/add", {
                email: emailInput.valueOf().value,
                username: usernameInput.valueOf().value,
                first_name: firstnameInput.valueOf().value,
                last_name: lastnameInput.valueOf().value,
                password: password1Input.valueOf().value
            })
                .done(function (data) {

                    //redirect on true, representing success
                    if (typeof data === "object" && data.success) {
                        //make sure the error is hidden
                        registrationFailed.style.display = "none";
                        //redirect to successful login location
                        window.location.href = "/login/?registration_success=true";

                    } else {
                        registrationFailed.style.display = "block";

                        if (data.errors.email != null) {
                            emailAlert.innerText = data.errors.email;
                            emailAlert.style.display = "block";
                        }

                        if (data.errors.username != null) {
                            usernameAlert.innerText = data.errors.username;
                            usernameAlert.style.display = "block";
                        }

                    }

                });
        }

    }
</script>
