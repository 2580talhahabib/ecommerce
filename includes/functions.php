<?php


function pr($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
function prx($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    die();
}

function get_safe_value($conn, $user_input)
{
    if ($user_input != '') {
        return mysqli_real_escape_string($conn, $user_input);
    }
}
?>
<?php
function alert_message($color, $message)
{
?>
    <div id="myAlert" class="alert z-3 alert-<?php echo $color ?> alert-dismissible fade show" role="alert">
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>