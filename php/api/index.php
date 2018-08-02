<?php
header("Content-Type: application/json; charset=utf-8");

if($_REQUEST["month"]){
    $month = htmlspecialchars($_REQUEST["month"]);
}else{
    $month = 1;
}

$mysqli=new mysqli ("mysql","matatsuna","matatsuna");
$mysqli -> select_db("weather_db");

$results=$mysqli->query("select area_table.prefecture_name,sum(rainfall_level) from weather_table,area_table where weather_table.prefecture_id=area_table.prefecture_id and month=".$month." and year=2008 group by area_table.prefecture_id,area_table.prefecture_name");

$json = array();
$jsonchild = array();

array_push($jsonchild,"都道府県");
array_push($jsonchild,"月別総雨量");
array_push($json,$jsonchild);

while ($line = $results-> fetch_array(MYSQLI_BOTH)) {

    $jsonchild = array();

    array_push($jsonchild,$line["prefecture_name"]);
    array_push($jsonchild,intval($line["sum(rainfall_level)"]));
    array_push($json,$jsonchild);
}
$mysqli->close();

echo json_encode($json);
?>