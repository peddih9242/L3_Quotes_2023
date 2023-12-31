<?php

// check if user is logged on
if (isset($_SESSION['admin'])) {
    
    if(isset($_REQUEST['submit'])) {

    include("process_form.php");

// add quote to DB
$stmt = $dbconnect -> prepare("INSERT INTO `quotes` (`Author_ID`, `Quote`, `Subject1_ID`, `Subject2_ID`, `Subject3_ID`) VALUES (?, ?, ?, ?, ?);");
$stmt -> bind_param("isiii", $author_ID, $quote, $subject_ID_1, $subject_ID_2, $subject_ID_3);
$stmt -> execute();

$quote_ID = $dbconnect -> insert_id;

// close stmt once everything has been inserted
$stmt -> close();

$heading = "";
$heading_type = "quote_success";
$sql_conditions = "WHERE `ID` = $quote_ID";

include("content/results.php");

} // submit if

} // end user is logged on if

else{
    $login_error = "Please login to access this page";
    header("Location: index.php?page=../admin/login&error=$login_error");
}
?>