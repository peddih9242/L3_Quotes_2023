<?php

// retrieve search type...
$search_type = $_REQUEST['search'];

if ($search_type == "all") {
    $heading = "All Quotes";
    $sql_conditions = "";
}
elseif ($search_type == "recent") {
    $heading = "Recent Quotes";
    $sql_conditions = "ORDER BY q.ID DESC LIMIT 10";
}
elseif ($search_type == "random") {
    $heading = "Random Quotes";
    $sql_conditions = "ORDER BY RAND() LIMIT 10";
}

elseif ($search_type == "author") {
    // retrieve author ID
    $author_ID = $_REQUEST['Author_ID'];

    $heading = "";
    $heading_type = "author";

    $sql_conditions = "WHERE q.Author_ID = $author_ID";
}

elseif ($search_type == "subject") {
    // retrieve subject ID
    $subject_name = $_REQUEST['subject_name'];

    $heading = "";
    $heading_type = "subject";

    ?>
        <p><?php echo $subject_name ?></p>
    <?php

    $sql_conditions = "WHERE s1.Subject LIKE $subject_name";
}

else {
    $heading = "No Results";
    $sql_conditions = "WHERE q.ID = 1000";
}

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

    $heading = "<h2>$subject_name Quotes ($find_count $result_s)</h2>";
}

echo $heading;
?>

<?php 

while($find_rs = mysqli_fetch_assoc($find_query)) {

    $quote = $find_rs['Quote'];
    
    $author_first = $find_rs['First'];
    $author_middle = $find_rs['Middle'];
    $author_last = $find_rs['Last'];

    
    // create full name of author
    $author_full = $author_first." ".$author_middle." ".$author_last;

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
                <span class="tag">
                    <a href="index.php?page=all_results&search=subject&subject_name=<?php echo $subject ?>">
                        <?php echo $subject ?>
                    </a>
                </span>
                &nbsp;&nbsp;
                <?php
            }

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