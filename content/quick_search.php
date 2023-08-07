<?php

// retrieve search type...
$search_type = $_REQUEST['search_type'];
$search_term = $_REQUEST['quick_search'];

// set up searches...
$quote_search = "q.Quote LIKE '%$search_term%'";

$author_search ="CONCAT(a.First, ' ', a.Middle, ' ', a.Last) LIKE";

$subject_search = "s1.Subject LIKE '%$search_term%'
                    OR s2.Subject LIKE '%$search_term%'
                    OR s3.Subject LIKE '%$search_term%'";

if ($search_type == "quote") {
    $sql_conditions = "WHERE $quote_search";
}

elseif ($search_type == "author") {
    // author doesn't work at the moment
    $sql_conditions = "WHERE $author_search";
}

elseif ($search_type == "subject") {
    $sql_conditions = "WHERE $subject_search";
}

else {
    $sql_conditions = "WHERE $quote_search
                        OR $author_search
                        OR $subject_search";
}

$heading = "'$search_term' Quotes";

include("results.php");

?>