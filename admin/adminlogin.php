<?php

if(isset($_REQUEST['login'])) {

    // get username from form
    $username = $_REQUEST['username'];
    $options = ['cost' => 9,];

    // Get username and hashed password from database
    $login_sql = "SELECT * FROM `users` WHERE `username` = '$username'";
    $login_query = mysqli_query($dbconnect, $login_sql);
    $login_rs = mysqli_fetch_assoc($login_query);

if ($login_rs == NULL) {
    echo 'invalid username';
    unset($_SESSION);
    $login_error = "Incorrect username";
    header("Location: index.php?page=../admin/login&error=$login_error");
}

else {

// Hash password and compare with password in database
if (password_verify($_REQUEST['password'], $login_rs['Password'])) {

// password matches
echo 'password is valid';
echo $username;
$_SESSION['admin'] = $login_rs['Username'];
header("Location: index.php?page=../admin/add_quote");

} // end valid password if

else {

echo 'invalid password';
unset($_SESSION);
$login_error = "Incorrect password";
header("Location: index.php?page=../admin/login&error=$login_error");

} // end invalid password else

} // end valid username else

} // end if login button has been pushed


?>