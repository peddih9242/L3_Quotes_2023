<?php

// check if user is logged on
if (isset($_SESSION['admin'])) {
    
    if(isset($_REQUEST['submit'])) {

    // retrieve data from form
    $quote = $_REQUEST['quote'];

    $author_full = $_REQUEST['author_full'];
    $subject1 = $_REQUEST['subject1'];
    $subject2 = $_REQUEST['subject2'];
    $subject3 = $_REQUEST['subject3'];

    $first = "";
    $middle = "";
    $last = "";

    // initialise IDs
    $subject_ID_1 = $subject_ID_2 = $subject_ID_3 = $author_ID = "";

    // handle blank fields
    if ($author_full == "") {
        $author_full = $first = "Anonymous";
    }

    if ($subject2 == "") {
        $subject2 = "n/a";
    }

    if ($subject3 == "") {
        $subject3 = "n/a";
    }

    // checks if subject / author is in DB, if not then adds to DB
    $subjects = array($subject1, $subject2, $subject3);
    $subject_IDs = array();
    
    // statement to insert subject/s
    $stmt = $dbconnect -> prepare("INSERT INTO `all_subjects` (`Subject`)
    VALUES ('?');");

    foreach ($subjects as $subject) {
        $subjectID = get_search_ID($dbconnect, $subject);

        if ($subjectID == "no results") {
            
            // insert the subject
            $stmt -> bind_param("s", $subject);
            $stmt -> execute();

            // retrieve subject ID
            $subjectID = $dbconnect -> insert_id;
        }

        $subject_IDs[] = $subjectID;
    }

    print_r($subject_IDs);

    } // submit if

} // end user is logged on if

else{
    $login_error = "Please login to access this page";
    header("Location: index.php?page=../admin/login&error=$login_error");
}
?>