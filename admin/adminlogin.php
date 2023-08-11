<?php

if(isset($_REQUEST['login'])) {

    // get username from form
    $username = $_REQUEST['username'];
    $options = ['cost' => 9,];

    // Get username and hashed password from database
    $login_sql = "SELECT * FROM `users` WHERE `username` = '$username'";
    $login_query = mysqli_query($dbconnect, $login_sql);
    $login_rs = mysqli_fetch_assoc($login_query);

// Hash password and compare with password in database
if (password_verify($_REQUEST['password'], $login_rs['Password'])) {

// password matches
echo 'password is valid';

} // end valid password if

else {

} // end invalid password else

} // end if login button has been pushed

?>