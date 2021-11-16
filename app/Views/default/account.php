<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

use app\services\UserService;

include VIEWS."header.php";
include VIEWS."navbar.php";
?>

<div class="container">
    <h1>My Account</h1>
    <br>
    <p style="color: white"><strong>My Details</strong></p>

    <?php

    $userdata = UserService::getInfoWeb($_COOKIE["codecrunchers"]);
    echo '<p style="color: white">';
    echo "Username: ".$userdata[1]."</p>";
    echo '<p style="color: white">';
    echo "Name: ".$userdata[2]." ".$userdata[3]."</p>";
    echo '<p style="color: white">';
    echo "Email: ".$userdata[4]."</p>";
    echo '<p style="color: white">';
    echo "Registration Date: ".date("d F Y H:i:s", $userdata[6])."</p>";
    ?>
    <br>
    <button onclick="deleteAccount()" type="button" class="btn btn-primary" id="login-button" style="background-color: red">Delete Account</button>
</div>

<script>
    function deleteAccount(){

    }
</script>