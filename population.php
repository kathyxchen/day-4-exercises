<h1>Welcome to Population Data Online</h1>
<?php
  $mysqli = new mysqli("127.0.0.1", "root", "", "test");
  if ($mysqli->connect_errno) {
    echo "Failed";
  }
  
  function insert_db($city, $pop, $mysqli) {
    $stmt = $mysqli->prepare("INSERT INTO population (city_name, population) VALUES (?, ?)");
    $stmt->bind_param('si', $city, $pop);
    $stmt->execute();
    printf("%d Row inserted.\n", $stmt->affected_rows);
    $stmt->close();
  }
$cities = array(
  'Philadelphia' => 1548000,
  'New York' => 8337000,
  'Los Angeles' => 3858000,
  'Seattle' => 634535,
  'Boston' => 636479,
);
//foreach ($cities as $city => $pop) {
//  insert_db($city, $pop, $mysqli);
//}
  $params = array('city_name', 'population');
  function str_params($params) {
    $str = '';
    if (sizeof($params) != 0) {
      $str = $params[0];
      foreach ($params as $p) {
        if ($params[0] != $p) {
          $str = $str . ', ' . $p;
        }
      }
    }
    return $str;
 }


  function get_db($mysqli, $str_params, $which) {
    $query = "SELECT " . $str_params . " FROM population WHERE city_name='" . $which. "'";
    if ($stmt = $mysqli->prepare($query)) {
      $stmt->execute();
      $stmt->bind_result($a, $b);
      $stmt->fetch();
      printf("The population of %s is %d.\n", $a, $b);
      $stmt->close();
   }
  }
  $fields = str_params($params);

if (!empty($_GET)) {
  $city=$_GET['city'];
  if ($city && isset($cities[$city])) {
    get_db($mysqli, $fields, $city);
  }
}
?>
<h2>Our Cities</h2>
<ul>
<?php
  $query = "SELECT city_name FROM population";
  if ($stmt = $mysqli->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($cts);
    while ($stmt->fetch()) {
       print '<li><a href="/trial/test.php?city=' . $cts . '">' .  $cts .
      '</a></li>';
   }
  }
?>
</ul>
