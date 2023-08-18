<?php 

// function to 'clean' data
function clean_input($dbconnect, $data) {
	$data = trim($data);	
	$data = htmlspecialchars($data); //  needed for correct special character rendering
	// remove dodgy characters to prevent SQL injections
	$data = mysqli_real_escape_string($dbconnect, $data);
	return $data;
}


function get_data($dbconnect, $more_condition=null) {

$find_sql = "SELECT

q.*,
a.*,

CONCAT(a.First, ' ', a.Middle, ' ', a.Last) AS Full_Name,

s1.Subject AS Subject1,
s2.Subject AS Subject2,
s3.Subject AS Subject3

FROM
quotes q

JOIN author a ON a.Author_ID = q.Author_ID
JOIN all_subjects s1 ON q.Subject1_ID = s1.Subject_ID
JOIN all_subjects s2 ON q.Subject2_ID = s2.Subject_ID
JOIN all_subjects s3 ON q.Subject3_ID = s3.Subject_ID

";
// if we have a WHERE condition, add it to the sql
if($more_condition != null) {
	// add extra string onto sql
	$find_sql .= $more_condition;
}

$find_query = mysqli_query($dbconnect, $find_sql);
$find_count = mysqli_num_rows($find_query);

return $find_query_count = array($find_query, $find_count);
}

function get_item_name($dbconnect, $table, $column, $ID) {
	$find_sql = "SELECT * FROM $table WHERE $column = $ID";
	$find_query = mysqli_query($dbconnect, $find_sql);
	$find_rs = mysqli_fetch_assoc($find_query);

	return $find_rs;
}

// entity is subject / full name of author
function autocomplete_list($dbconnect, $item_sql, $entity)    
{
// Get entity / topic list from database
$all_items_query = mysqli_query($dbconnect, $item_sql);
    
// Make item arrays for autocomplete functionality...
while($row=mysqli_fetch_array($all_items_query))
{
  $item=$row[$entity];
  $items[] = $item;
}

$all_items=json_encode($items);
return $all_items;
    
}

// get search ID
function get_search_ID($dbconnect, $search_term) {
	$find_sql = "SELECT * FROM all_subjects WHERE Subject LIKE '$search_term'";
	$find_query = mysqli_query($dbconnect, $find_sql);
	$find_rs = mysqli_fetch_assoc($find_query);

	// count results
	$find_count = mysqli_num_rows($find_query);

	if ($find_count == 1) {
		return $find_rs['Subject_ID'];
	}
	else {
		return "no results";
	}

}

?>