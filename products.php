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

<div class="container-fluid">
    <table class="table text-center table-bordered border-dark table-striped table-hover">
        <thead>
            <tr class="table-dark">
                <th scope="col">Sr</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">MRP</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Image</th>
                <th scope="col">S.Desc</th>
                <th scope="col">L.Desc</th>
                <th scope="col">M Title</th>
                <th scope="col">M Keyword</th>
                <th scope="col">M Desc</th>
                <th scope="col">Status</th>
                <th scope="col">Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            $fetch_data = "SELECT products.*, categories.cat_id, categories.cat_name
            FROM products
            INNER JOIN categories ON categories.cat_id = products.p_category_id";
            // $fetch_data = "SELECT * FROM products INNER JOIN categories ON products.p_category_id = categories.cat_id";
            $result = mysqli_query($conn, $fetch_data);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <tr>
                        <th scope="row"><?php echo $counter ?></th>
                        <td><?php echo $row['p_name'] ?></td>
                        <td><?php echo $row['cat_name'] ?></td>
                        <td><?php echo $row['p_mrp'] ?></td>
                        <td><?php echo $row['p_price'] ?></td>
                        <td><?php echo $row['p_qty'] ?></td>
                        <td>
                            <img width="70" src="./assets/product_img/<?php echo $row['p_img'] ?>" alt="">
                        </td>
                        <td><?php echo $row['p_short_desc'] ?></td>
                        <td><?php echo $row['p_long_desc'] ?></td>
                        <td><?php echo $row['p_meta_title'] ?></td>
                        <td><?php echo $row['p_meta_keyword'] ?></td>
                        <td><?php echo $row['p_meta_desc'] ?></td>
                        <td><?php echo $row['p_status'] ?></td>
                        <td>
                            <?php echo "<a class='mx-3 btn btn-danger' href='update_product.php?type=delete" . "&id=" . $row['p_id'] . "'>Delete</a>"; ?>
                            <?php echo "<a class='mx-3 btn btn-info' href='update_product.php?type=update&id=" . $row['p_id'] . "'>Edit</a>";?>
                        </td>

                    </tr>
                <?php
                    $counter++;
                }
            } else { ?>
                <tr>
                    <td colspan="14">
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