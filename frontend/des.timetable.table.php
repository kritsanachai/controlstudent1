<?php  
    include("../include/connect.inc.php");
    $date = $_POST['date'];
    $data = $_POST['data'];
    $dataP = json_decode($data);

    echo $dataP[0]->id;
?>

<