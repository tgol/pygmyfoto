<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

  <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
  <link href='http://fonts.googleapis.com/css?family=Asap:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link rel="shortcut icon" href="favicon.ico" />

  <script src="js/jquery-1.7.2.min.js"></script>
  <script src="js/lightbox.js"></script>
  <link href="css/lightbox.css" rel="stylesheet" />

  <?php
  
  include 'config.php';
  echo "<title>$title</title>";
  
  ?>
  
  </head>
  <body>

	<script type="text/javascript">
	$(function() {
		$('a[@rel*=lightbox]').lightBox();
	});
	</script>
	
	<?php
	echo "<div id='content'><h1>$title</h1>";
	
	$id = $_GET['id'];
	
	$db = new PDO('sqlite:pygmyfoto.sqlite');
	
	echo "<div class='center'>$navigation</div>";
	
	echo "<table border=0>";

	$result = $db->prepare("SELECT id, title, description, tags, exif, osm, original, count FROM photos WHERE id=:id");
	$result->bindParam(':id', $id, PDO::PARAM_INT);
	$result->execute();

	foreach($result as $row)
{
	echo "<tr><td><h2>".$row['title']."</h2></td></tr>";
	echo "<tr><td><p>".$row['description']."</p></td></tr>";
	echo "<tr><td valign='top'><p class='box'><img src='images/tag.png' alt='Tags' title='Tags'><em> ".$row['tags']."</em> <a href='photo.php?id=".$row['id']."'><img src='images/photography.png' alt='Permalink'title='Permalink'></a> <a href='".$row['original']."'><img src='images/graphic-design.png' alt='Original' title='Original'></a> <a href='".$row['osm']."'><img src='images/world.png' alt='OpenStreetMap' title='Show on OpenStreetMap'></a> <strong>Views:</strong><em> ".$row['count']."</p></td></tr>";
	echo "<tr><td><p class='box'>".$row['exif']."</p></td></tr>";
	}
	
	echo "</table>";

	$result = $db->prepare("UPDATE photos SET count = count + 1 WHERE id=:id");
	$result->bindParam(':id', $id, PDO::PARAM_INT);
	$result->execute();
	$result->closeCursor();
	$db = NULL;

	echo "<p><center><form method='post' action='search.php'><input type='text' name='tag' size='11'> <input type='submit' value='&#10148;'></form></center></p>";

	echo "<div class='footer'>$footer</div>";
	
	$ip=$_SERVER['REMOTE_ADDR'];
	$date = $date = date('Y-m-d H:i:s');
	$page = basename($_SERVER['PHP_SELF'])."/?id=".$row['id'];
	$file = fopen("ip.log", "a+");
	fputs($file, " $ip	$page $date \n");
	fclose($file);
	
	?>
	
	</div>
	</body>
</html>
