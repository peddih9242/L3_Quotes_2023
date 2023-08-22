<?php

// check if user is logged on
if (isset($_SESSION['admin'])) {
    
    if(isset($_REQUEST['submit'])) {

    // retrieve quote and author ID from form
    // check they are integers (in case someone edits the URL)
    $quote_ID = filter_var($REQUEST['ID'], FILTER_SANITIZE_NUMBER_INT);
    $old_author = filter_var($_REQUEST['authorID'], FILTER_SANITIZE_NUMBER_INT);

    include("process_form.php");

    // delete author if there are no quotes associated with that author
    if ($old_author != $author_ID) {
        delete_ghost($dbconnect, $old_author)
    } // end check author changed

// close stmt once everything has been inserted
$stmt -> close();

$heading = "Edit Success";
$sql_conditions = "WHERE `ID` = $quote_ID";

include("content/results.php");

} // submit if

} // end user is logged on if

else{
    $login_error = "Please login to access this page";
    header("Location: index.php?page=../admin/login&error=$login_error");
}
?>