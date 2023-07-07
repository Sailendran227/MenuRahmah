<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Rahmah</title>
</head>
<body>
    <?php
        include 'header.php';

        var_dump($_POST);

        if (isset($_POST['halalCheck'])) {           
            $sql = "SELECT shop_name, shop_id, shop_capacity, shop_lat, shop_long FROM shops WHERE shop_halal IS TRUE;";
            echo "<script>document.getElementById('halalCheck').checked = true;";
        } else {
            $sql = "SELECT shop_name, shop_id, shop_capacity, shop_lat, shop_long FROM shops;";
        };

        if (!($conn->query($sql))) {
            echo $conn->error;
            //*exit();
        };

        echo "
                <input type='hidden' name='lat' value=0>
                <input type='hidden' name='long' value=0>
                <input type='submit' value = 'Search!'>
            </form>";
    ?>

</body>
</html>