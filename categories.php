<?php
include("./includes/header.php");
include("./includes/navbar.php");
include("./includes/db_conn.php");
include("./includes/functions.php");

if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] != '') {
} else {
    header("Location: login.php");
}

if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($conn, $_GET['type']);
    $id = get_safe_value($conn, $_GET['id']);


    if ($type == 'status') {
        $operation = get_safe_value($conn, $_GET['operation']);

        if ($operation == 'active') {
            $status = '1';
        } else {
            $status = '0';
        }
        $update_status = "UPDATE categories set cat_status='$status' WHERE cat_id='$id'";
        mysqli_query($conn, $update_status);
    }
    if ($type == 'delete') {
        $cat_status = get_safe_value($conn, $_GET['cat_status']);
        if ($cat_status !== '1') {
            $delete_status = "DELETE FROM categories WHERE cat_id=$id";
            mysqli_query($conn, $delete_status);
            alert_message("success", "Category deleted successfully");
        } else {
            alert_message("warning", "Please deactivate the category first");
        }
    }
}
?>

<div class="container">
    <table class="table text-center table-bordered border-dark table-striped table-hover">
        <thead>
            <tr class="table-dark">
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Status</th>
                <th scope="col">Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            $fetch_data = "SELECT * FROM categories ORDER BY cat_name ASC";
            $result = mysqli_query($conn, $fetch_data);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <tr>
                        <th scope="row"><?php echo $counter ?></th>
                        <td><?php echo $row['cat_id'] ?></td>
                        <td><?php echo $row['cat_name'] ?></td>
                        <td>
                            <?php

                            if ($row['cat_status'] === "1") {
                                echo "<a class='btn btn-success px-4' href='?type=status&operation=deactive&id=" . $row['cat_id'] . "'>Active</a>";
                            } else {
                                echo "<a class='btn px-3 btn-warning' href='?type=status&operation=active&id=" . $row['cat_id'] . "'>Deactive</a>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo "<a class='mx-3 btn btn-danger' href='?type=delete&cat_status=" . $row['cat_status'] . "&id=" . $row['cat_id'] . "'>Delete</a>"; ?>
                            <?php echo "<a class='mx-3 btn btn-info' href='add_category.php?type=update&id=" . $row['cat_id'] . "'>Edit</a>"; ?>
                        </td>

                    </tr>
                <?php
                    $counter++;
                }
            } else { ?>
                <tr>
                    <td colspan="4">
                        <h3 class="text-center text-danger">No Record Found</h3>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>





<?php include("./includes/footer.php"); ?>