<?php 

$all_results = get_data($dbconnect, $sql_conditions);

$find_query = $all_results[0];
$find_count = $all_results[1];

if($find_count == 1) {
    $result_s = "Result";
}
else{
    $result_s = "Results";
}

// check if we have results
if ($find_count > 0) {

if ($heading != "") {
$heading = "<h2>$heading ($find_count $result_s)</h2>";
}

elseif ($heading_type == "author") {
    // retrieve author name
    $author_rs = get_item_name($dbconnect, "author", "Author_ID", $author_ID);
    $author_name = $author_rs['First']." ".$author_rs['Middle']." ".$author_rs['Last'];

    $heading = "<h2>$author_name Quotes ($find_count $result_s)</h2>";

}

elseif ($heading_type == "subject") {

    $title_subject = ucwords($subject_name);
    $heading = "<h2>$title_subject Quotes ($find_count $result_s)</h2>";
}

elseif ($heading_type == "quote_success") {
    $heading = "<h2>Insert Quote Success</h2>
    <p>You have inserted the following quote...</p>";
}

elseif ($heading_type == "edit_success") {
    $heading = "<h2>Edit Quote Sucess</h2>
    <p>You have edited the quote. The entry is now...</p>";
}

elseif ($heading_type == "delete_quote") {
    $heading = "<h2>Delete Quote - Are you sure?</h2>
    <p>
    Do you really want to delete the quote in the box below?
    </p>";
}

echo $heading;

while($find_rs = mysqli_fetch_assoc($find_query)) {

    $quote = $find_rs['Quote'];
    $ID = $find_rs['ID'];

    $author_first = $find_rs['First'];
    $author_middle = $find_rs['Middle'];
    $author_last = $find_rs['Last'];

    // create full name of author
    $author_full = $find_rs['Full_Name'];

    $author_ID = $find_rs['Author_ID'];

    // set up subjects
    $subject_1 = $find_rs['Subject1'];
    $subject_2 = $find_rs['Subject2'];
    $subject_3 = $find_rs['Subject3'];

    // put subjects in list so that we can iterate through it
    $all_subjects = array($subject_1, $subject_2, $subject_3);

    ?>

    <div class="results">
        <?php echo $quote ?>

        <p><i>
            <a href="index.php?page=all_results&search=author&Author_ID=<?php echo $author_ID ?>">
            <?php echo $author_full ?>
            </a>
        </i></p>

        <?php 
        
        // iterate through all_subjects list and output subject if it is not blank
        foreach($all_subjects as $subject) {
            // check if subject is n/a
            if($subject != "n/a") {
                ?>
                <span class="tag subject-tag">
                    <a href="index.php?page=all_results&search=subject&subject_name=<?php echo $subject ?>">
                        <?php echo $subject ?>
                    </a>
                </span>
                &nbsp;&nbsp;
                <?php
            } // end subject exists if

        } // end listing subjects

        // if user is logged in, show edit / delete options

        if (isset($_SESSION['admin'])) {

            ?>

            <div class="tools">
                <a href="index.php?page=../admin/editquote&ID=<?php echo $ID ?>"><i class="fa fa-edit fa-2x"></i></a> &nbsp;&nbsp;
                <a href="index.php?page=../admin/deleteconfirm&ID=<?php echo $ID ?>"><i class="fa fa-trash fa-2x"></i></a>
            </div>

            <?php

        }

        ?>
    </div>
    <br/>

    <?php
}

}

// if there are no results, show error message
else {
    ?>

    <h2>Sorry!</h2>

    <div class="no-results">Unfortunately - there were no results for your search. Please try again.</div>

    <?php
} // end of no results else

?>