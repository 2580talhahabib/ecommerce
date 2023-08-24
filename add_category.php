<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_conn.php");
include("./includes/navbar.php");
$add_data_type = '';
$update_value = '';
$switch_cat_name = '';
$cat_name = '';
$cat_id = '';

// add category

if (isset($_POST['submit_cat']) && isset($_POST['cat_name'])) {
    $add_data_type = 'add_category';
    $cat_name = get_safe_value($conn, $_POST['cat_name']);
    $check_cat_query = "SELECT COUNT(*) AS count FROM categories WHERE cat_name='$cat_name'";
    $check_cat_result = mysqli_query($conn, $check_cat_query);
    $row = mysqli_fetch_assoc($check_cat_result);
    if ($row['count'] == 0) {
        $sql_query = "INSERT INTO categories (cat_name) VALUES ('$cat_name')";
        $query_add = mysqli_query($conn, $sql_query);
        if ($query_add) {
            alert_message("success", "Category added successfully");
        } else {
            alert_message("danger", "Something went wrong! Please try again");
        }
    } else {
        alert_message("warning", "Category Already Exist");
    }
}

// update category code

if (isset($_POST['submit_cat']) && isset($_POST['update_cat_name'])) {
    $cat_id = $_POST['update_cat_id'];
    $cat_name = get_safe_value($conn, $_POST['update_cat_name']);
    $check_cat_query = "SELECT COUNT(*) AS count FROM categories WHERE cat_name='$cat_name'";
    $check_cat_result = mysqli_query($conn, $check_cat_query);
    $row = mysqli_fetch_assoc($check_cat_result);
    if ($row['count'] == 0) {
        $update_sql_query = "UPDATE `categories` SET `cat_name`='$cat_name' WHERE cat_id='$cat_id'";
        $query_update = mysqli_query($conn, $update_sql_query);
        if ($query_update) {
            alert_message("success", "Category Updated successfully");
?>
            <script>
                setTimeout(() => {
                    window.location = "categories.php";
                }, 1000);
            </script>
<?php
        } else {
            alert_message("danger", "Something went wrong! Please try again");
        }
    } else {
        alert_message("warning", "Category Already Exist");
    }
}
if (isset($_GET['type'])) {

    $_GET['type'] == 'update';
    $add_data_type = 'update_category';
    $cat_id = $_GET['id'];
    $fetch_data = "SELECT cat_name FROM categories WHERE cat_id='$cat_id'";
    $result = mysqli_query($conn, $fetch_data);
    $row = mysqli_fetch_assoc($result);
    $update_value = $row['cat_name'];
    // $update_value = get_safe_value($conn, $_GET['cat_name']);
}
mysqli_close($conn);
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header text-white bg-primary">
                    Categories Form
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label" for="">Category Name</label>
                            <input type="hidden" name="update_cat_id" value="<?php echo $cat_id; ?>">
                            <input class="form-control" type="text" name='<?php echo $add_data_type === 'update_category' ? "update_cat_name" : "cat_name"; ?>' value="<?php echo $update_value; ?>" required>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary w-100" type="submit" name="submit_cat">
                                <?php echo $add_data_type === 'update_category' ? "Update Category" : "Add Category"; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>







<?php
include("./includes/footer.php");
?>