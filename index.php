<?php 
  echo '<header>';
  echo '<link rel="stylesheet" href="style.css"/>';
  echo '<title>read me.</title></header>';
  echo '<body>';
  echo '<div class="top">';
  echo '<h2>Presently</h2>';
  print date('l, F d, Y') . '<br /></div>';
  $articles = array();
  function artic_create($title, $author, $body) { 
    $one = new stdClass();
    $one->title = $title;
    $one->author = $author;
    $one->body = $body;
    return $one;
  }
  $articles[] = artic_create('Cats', 'Fish', 'Very good. If I added a lot of lines here, what would happen? Does it go on forever? I really do not like fish it is so much work to eat.');
  $articles[] = artic_create('Title', 'Author', 'Content here.');
  $articles[] = artic_create('Cake', 'Baker', 'Frosting. So much frosting.');
  
  $mysqli = new mysqli("127.0.0.1", "root", "", "test");
  if ($mysqli->connect_errno) {
    echo "Failed";
  }
  
  function insert_db($title, $author, $body, $mysqli) {
    $query = "INSERT INTO articles VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare("INSERT INTO articles VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $title, $author, $body);
    $stmt->execute();
    $stmt->close();
  }
  //foreach ($articles as $o) {
  //  insert_db((string)$o->title,(string)$o->author,(string)$o->body, $mysqli);
  //}
  
  function get_db($mysqli) {
    $query = "SELECT * FROM articles"; 
    if ($stmt = $mysqli->prepare($query)) {
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($a, $b, $c);
      while ($stmt->fetch()) {
        echo '<table style="width:300px"><tr><td id="t">' . $a . '</td></tr><tr><td id="a">' . $b . '</td></tr><tr><td id="b">' . $c . '</td></tr></table><br />'; 
      }
      $stmt->free_result();
      $stmt->close();
   }
  }
  echo '<div class="articles">';
    get_db($mysqli);
  echo '</div>';
  echo '</body>';
?>
