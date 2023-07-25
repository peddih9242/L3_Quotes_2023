<?php

$find_sql = "SELECT

q.*,
a.*,
s1.Subject AS Subject1,
s2.Subject AS Subject2,
s3.Subject AS Subject3

FROM
quotes q

JOIN author a ON a.Author_ID = q.Author_ID
JOIN all_subjects s1 ON q.Subject1_ID = s1.SubjectID
JOIN all_subjects s2 ON q.Subject2_ID = s2.SubjectID
JOIN all_subjects s3 ON q.Subject3_ID = s3.SubjectID

";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);
$find_count = mysqli_num_rows($find_query);

?>

<h2>All Results (<?php echo $find_count ?>)</h2>

<?php 

while($find_rs = mysqli_fetch_assoc($find_query)) {

    $quote = $find_rs['Quote'];
    
    $author_first = $find_rs['First'];
    $author_middle = $find_rs['Middle'];
    $author_last = $find_rs['Last'];

    // put space before middle initial so if it's blank we don't have
    // spacing issues
    $author_middle = " ".$author_middle;

    // set up subjects
    $subject_1 = $find_rs['Subject1'];
    $subject_2 = $find_rs['Subject2'];
    $subject_3 = $find_rs['Subject3'];

    // put subjects in list so that we can iterate through it
    $all_subjects = array($subject_1, $subject_2, $subject_3);

    ?>

    <div class="results">
        <?php echo $quote ?>

        <p><i><?php echo $author_first.$author_middle." ".$author_last ?></i></p>

        <?php 
        
        // iterate through all_subjects list and output subject if it is not blank
        foreach($all_subjects as $subject) {
            // check if subject is n/a
            if($subject != "n/a") {
                echo "<span class='tag'>$subject</span>&nbsp;&nbsp;";
            }

        }

        ?>
    </div>
    <br/>

    <?php
}

?>