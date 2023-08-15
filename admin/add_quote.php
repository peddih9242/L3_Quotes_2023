<?php
// check user is logged on
if (isset($_SESSION['admin'])) {

// get all subjects from database
$all_tags_sql = "SELECT * FROM all_subjects ORDER BY Subject ASC";
$all_subjects = autocomplete_list($dbconnect, $all_tags_sql, 'Subject');

// initialise subject variables
$tag_1 = "";
$tag_2 = "";
$tag_3 = "";

// initialise tag IDs
$tag_1_ID = $tag_2_ID = $tag_3_ID = 0;

?>

<h2>Add Quote</h2>

<div class="admin-form">
    <h1>Add a Quote</h1>

    <form>
        <p><textarea name="quote" placeholder="Quote (required)" required></textarea></p>
        <p><input name="author" placeholder="Author Name (First Middle Last)"/></p>
        
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

    </script>

</div>

<?php
} // end user is logged on if

else{
    $login_error = "Please login to access this page";
    header("Location: index.php?page=../admin/login&error=$login_error");
}
?>