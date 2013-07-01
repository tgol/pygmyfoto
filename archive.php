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
	print "<title>$title</title>";
	
	?>
	
	</head>
	<body>
	
	<script type="text/javascript">
	$(function() {
		$('a[@rel*=lightbox]').lightBox();
	});
	</script>
	
	<?php
	
	include 'config.php';
	
	print "<div id='content'><h1>$title</h1>";
	
	$db = new PDO('sqlite:pygmyfoto.sqlite');
	
	print $navigation;
	
	print "<table border=0>";
	$result = $db->query("SELECT id, title, description, tags, exif, osm, original FROM photos WHERE published = '0' ORDER BY dt DESC");
	
	foreach($result as $row)
	{
	print "<tr><td><h2><a class='title' href='photo.php?id=".$row['id']."'>".$row['title']."</h2></a></td></tr>";
	print "<tr><td><p>".$row['description']."</p></td></tr>";
	print "<tr><td valign='top'><p class='box'><img src='images/tag.png' alt='Tags' title='Tags'><em> ".$row['tags']."</em> <a href='photo.php?id=".$row['id']."'><img src='images/photography.png' alt='Permalink'title='Permalink'></a> <a href='".$row['original']."'><img src='images/graphic-design.png' alt='Original' title='Original'></a> <a href='".$row['osm']."'><img src='images/world.png' alt='OpenStreetMap' title='Show on OpenStreetMap'></a></p></td></tr>";
	print "<tr><td><p class='box'>".$row['exif']."</p></td></tr>";
	}
	
	print "</table>";
	
	$db = NULL;
	
	print "<p><center><form method='post' action='search.php'><input type='text' name='tag' size='11' value='Search by tag'> <input type='submit' value='&#10148;'></form></center></p>";
	
	print "<div class='footer'>$footer</div>";
	
	$ip=$_SERVER['REMOTE_ADDR'];
	$date = $date = date('Y-m-d H:i:s');
	$page = basename($_SERVER['PHP_SELF']);
	$file = fopen("ip.log", "a+");
	fputs($file, " $ip	$page $date \n");
	fclose($file);
	
	?>
	
	</div>
	</body>
</html>
