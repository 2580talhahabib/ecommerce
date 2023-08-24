<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_conn.php");
include("./includes/navbar.php");

if (isset($_REQUEST['type']) && $_REQUEST['type'] === 'update') {
    // fetching data from database against id
    $product_id = $_REQUEST['id'];
    $sql = "SELECT * FROM products WHERE p_id = $product_id";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);
    // pr($row);
}
if (isset($_REQUEST['type']) && $_REQUEST['type'] === 'delete') {
    echo "delete";
    $product_id = $_REQUEST['id'];
    echo $product_id;
}


if (isset($_POST['update_product'])) {
    $updated_id = get_safe_value($conn, $_POST['updated_id']);
    $p_name = get_safe_value($conn, $_POST['p_name']);
    $p_category_id = get_safe_value($conn, $_POST['p_category_id']);
    $p_mrp = get_safe_value($conn, $_POST['p_mrp']);
    $p_price = get_safe_value($conn, $_POST['p_price']);
    $p_qty = get_safe_value($conn, $_POST['p_qty']);
    $p_short_desc = get_safe_value($conn, $_POST['p_short_desc']);
    $p_long_desc = get_safe_value($conn, $_POST['p_long_desc']);
    $p_meta_title = get_safe_value($conn, $_POST['p_meta_title']);
    $p_meta_keyword = get_safe_value($conn, $_POST['p_meta_keyword']);
    $p_meta_desc = get_safe_value($conn, $_POST['p_meta_desc']);
    $p_img = $_FILES['p_img'];

    //image uploading code
    $fileName = $p_img['name'];
    $tmp_name = $p_img['tmp_name'];
    $separate_file_name = explode('.', $fileName);
    $new_file_name = round(microtime(true)) . '.' . end($separate_file_name);

    $upload_image_folder = './assets/product_img/' . $new_file_name;
    $file_upload_result = move_uploaded_file($tmp_name, $upload_image_folder);

    if ($file_upload_result) {
        $insert_product_query = "UPDATE `products` SET `p_category_id`='$p_category_id',`p_name`='$p_name',`p_mrp`='$p_mrp',`p_price`='$p_price',
        `p_qty`='$p_qty',`p_img`='$new_file_name',`p_short_desc`='$p_short_desc',`p_long_desc`='$p_long_desc',`p_meta_title`='$p_meta_title',`p_meta_keyword`='$p_meta_keyword',`p_meta_desc`='$p_meta_desc' WHERE `p_id`=$updated_id";
        $result_insert = mysqli_query($conn, $insert_product_query);
        if ($result_insert) {
            alert_message("success", "Product Updated Successfully");
        } else {
            alert_message("danger", "Something went wrong, Please try again");
        }
    }
}



?>

<div class="container py-5">
    <div class="card">
        <div class="card-header text-white bg-primary">
            Update Product
        </div>
        <div class="card-body">
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="hidden" value="<?php echo $row['p_id']; ?>" name="updated_id">
                        <label class="form-label" for="">Product Name</label>
                        <input class="form-control" type="text" name='p_name' value="<?php echo $row['p_name'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="">Product Category</label>
                        <select class="form-select" required name="p_category_id" aria-label="Default select example">
                            <option>Select Category</option>
                            <?php
                            $cat_sql = "SELECT * FROM categories ORDER BY cat_name ASC";
                            $cat_result = mysqli_query($conn, $cat_sql);

                            if (mysqli_num_rows($cat_result) > 0) {
                                // output data of each row
                                // $selection = "";
                                while ($cat_row = mysqli_fetch_assoc($cat_result)) {
                                    // if($cat_row['cat_id'] == $row['p_category_id']){
                                    //     $selection = "selected";
                                    // }

                            ?>
                                    <option value="<?php echo $cat_row['cat_id']; ?>"><?php echo $cat_row['cat_name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="">Product MRP</label>
                        <input class="form-control" type="number" min="0" name='p_mrp' value="<?php echo $row['p_mrp'] ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="">Product Price</label>
                        <input class="form-control" type="number" min="0" name='p_price' value="<?php echo $row['p_price'] ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="">Product Quantity</label>
                        <input class="form-control" type="number" min="0" name='p_qty' value="<?php echo $row['p_qty'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="">Product Image</label>
                        <input class="form-control" type="file" name='p_img' value="<?php echo $row['p_img'] ?>" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="">Product Short Description</label>
                        <input class="form-control" type="text" name='p_short_desc' value="<?php echo $row['p_short_desc'] ?>" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="">Product Long Description</label>
                        <input class="form-control" type="text" name='p_long_desc' value="<?php echo $row['p_long_desc'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="">Product Meta Title</label>
                        <input class="form-control" type="text" name='p_meta_title' value="<?php echo $row['p_meta_title'] ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="">Product Meta Keyword</label>
                        <input class="form-control" type="text" name='p_meta_keyword' value="<?php echo $row['p_meta_keyword'] ?>">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="">Product Meta Description</label>
                        <input class="form-control" type="text" name='p_meta_desc' value="<?php echo $row['p_meta_desc'] ?>">
                    </div>
                    <div class="col-md-12 mb-3">
                        <button class="btn btn-primary w-100" type="submit" name="update_product">
                            Update Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>







<?php
include("./includes/footer.php");
?>