<?php

$find_sql = "
SELECT

q.*,
a.*,
s1.Subject AS Subject1,
s2.Subject AS Subject2,
s3.Subject AS Subject3

FROM Quotes q

JOIN author a ON a.Author_ID = q.Author_ID

";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);
$find_count = mysqli_num_rows($find_query);

?>

<h2>All Results (<?php echo $find_count ?>)</h2>

<?php 

while($find_rs = mysqli_fetch_assoc($find_query)) {

    $quote = $find_rs['Quote'];

    ?>

    <div class="results">
        <?php echo $quote ?>
    </div>
    <br/>

    <?php
}

?>