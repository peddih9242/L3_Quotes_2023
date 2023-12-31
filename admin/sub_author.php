<?php

// get all subjects from database
$all_tags_sql = "SELECT * FROM all_subjects ORDER BY Subject ASC";
$all_subjects = autocomplete_list($dbconnect, $all_tags_sql, 'Subject');

// initialise subject variables
$tag_1 = "";
$tag_2 = "";
$tag_3 = "";

// initialise tag IDs
$tag_1_ID = $tag_2_ID = $tag_3_ID = 0;

// get author full name from database
$author_full_sql = "SELECT *, CONCAT(First, ' ', Middle, ' ', Last) AS Full_Name FROM author";
$all_authors = autocomplete_list($dbconnect, $author_full_sql, 'Full_Name');

?>