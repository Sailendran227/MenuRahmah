<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Rahmah</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <?php
        include 'header.php';

        echo "
                <input type='hidden' name='lat' value=0>
                <input type='hidden' name='long' value=0>
                <input type='submit' value = 'Search!'>
            </form>";

        $sql = "";

        //If Halal box is checked, only display halal (Set SQL to select Halal)
        if (isset($_POST["halalCheck"]) && $_POST['halalCheck'] == "halal") {
            $sql = "SELECT shop_name, shop_sells, shop_time_start, shop_time_stop, shop_remark, shop_lat, shop_long FROM shops WHERE shop_halal = 1;";
            echo "<script>document.getElementById('halalCheck').checked = true;</script>";
        } else {
            $sql = "SELECT shop_name, shop_sells, shop_time_start, shop_time_stop, shop_remark, shop_lat, shop_long FROM shops;";
        };

        echo "
        <table id = 'mainTable'>
            <tr>
                <th>Outlet Name</th>
                <th>Menu Rahmah</th>
                <th>Time</th>
                <th>Distance</th>
                <th>Long</th>
                <th>Remarks</th>
            </tr>";

        $result = $conn->query($sql);

        $returns = false;
        
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc() ) {
                echo "
                    <tr>
                        <td>".$row['shop_name']."</td>
                        <td>".$row['shop_sells']."</td>
                        <td>".$row['shop_time_start']." - ".$row['shop_time_stop']."</td>
                        <td>".$row['shop_lat']."</td>
                        <td>".$row['shop_long']."</td>
                        <td>".$row['shop_remark']."</td>
                    </tr>
                ";
            }
            
            $returns = true;
        };
    ?>

<script>
var userCoords = [0, 0];

function getGPS() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(GPScallback);
    } else { 
        console.log("Geolocation is not supported by this browser.");
    };

};

function GPScallback(position) {
    userCoords = [position.coords.latitude, position.coords.longitude];
    callbackResume();
}

getGPS();

console.log("User coords: " + userCoords);

function coordsToDist() {

    const table =document.getElementById('mainTable');

    var lat, long, dLAT, dLONG, dCOORD, dist;

    for (i=1; i<table.rows.length; i++) {

         lat = document.getElementById('mainTable').rows[i].cells[3].innerHTML;
         long = document.getElementById('mainTable').rows[i].cells[4].innerHTML;

        //doing pythag to get distance in coordinate units
         dLAT = Math.abs((userCoords[0]) - lat);
         dLONG = Math.abs(userCoords[1] - long);
         dCOORD = Math.sqrt((dLAT*dLAT) + (dLONG*dLONG));

        //converting coords to km
         dist = dCOORD * 111;

        table.rows[i].cells[3].innerHTML = dist;

    }

};

function sortTable() {

  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("mainTable");
  switching = true;

  while (switching) {

    switching = false;
    rows = table.rows;

    for (i = 1; i < (rows.length - 1); i++) {

      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[3];
      y = rows[i + 1].getElementsByTagName("TD")[3];

      if (Number(x.innerHTML) > Number(y.innerHTML)) {
        shouldSwitch = true;
        break;
      }

    }

    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    };

  };

};

function trimTable() {

    console.log('function logged');
    //trim distance then delete long row
    for (i=1; i<document.getElementById('mainTable').rows.length;i++) {

        let val = document.getElementById('mainTable').rows[i].cells[3].innerHTML;
        let rounded = Math.round(val * 10) / 10;
        document.getElementById('mainTable').rows[i].cells[3].innerHTML = rounded;

        document.getElementById('mainTable').rows[i].deleteCell(4);

    }

    document.getElementById('mainTable').rows[0].deleteCell(4);

    //deleting long column

};

function callbackResume() {

    coordsToDist();
    console.log('1');
    sortTable();
    console.log('2');
    trimTable();
    console.log('3');

};

</script>

</body>
</html>