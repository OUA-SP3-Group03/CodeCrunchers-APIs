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
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
    </div>
    <p>Dont already have an account? <a href="/register">register for free today.</a></p>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>