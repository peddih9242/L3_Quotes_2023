<?php
// check user is logged on
if (isset($_SESSION['admin'])) {

// retrieve subjects and authors to populate combo box
include("sub_author.php");

// retrieve current values for quote
$ID = $_REQUEST['ID'];

// get values from DB
$edit_query = get_data($dbconnect, "WHERE q.ID = $ID");

$edit_results_query = $edit_query[0];

?>

<div class="admin-form">
    <h1>Add a Quote</h1>

    <form action="index.php?page=../admin/insert_quote" method="post">
        <p><textarea name="quote" placeholder="Quote (required)" required></textarea></p>
        
        <div class="autocomplete">
            <input name="author_full" id="author_full" placeholder="Author Name (First Middle Last)"/></p>
        </div>
        
        <div class="autocomplete">
            <input name="subject1" id="subject1" placeholder="Subject 1 (required)" required /></p>
        </div>

        <div class="autocomplete">
            <input name="subject2" id="subject2" placeholder="Subject 2" />
        </div>

        <br /><br />

        <div class="autocomplete">
            <input name="subject3" id="subject3" placeholder="Subject 3" />
        </div>

        <br /><br />

        <input class="form-submit" type="submit" name="submit" value="Submit Quote" />
    </form>

    <script>
        <?php include ("autocomplete.php") ?>

        // Arrays containing lists
        var all_tags = <?php print("$all_subjects")?>;
        autocomplete(document.getElementById("subject1"), all_tags);
        autocomplete(document.getElementById("subject2"), all_tags);
        autocomplete(document.getElementById("subject3"), all_tags);
        
        var all_author = <?php print("$all_authors") ?>;
        autocomplete(document.getElementById("author_full"), all_author);

    </script>

</div>

<?php
} // end user is logged on if

else{
    $login_error = "Please login to access this page";
    header("Location: index.php?page=../admin/login&error=$login_error");
}
?>