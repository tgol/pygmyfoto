<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

	<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link href='http://fonts.googleapis.com/css?family=Averia+Gruesa+Libre' rel='stylesheet' type='text/css'>
	<link href="http://fonts.googleapis.com/css?family=Droid+Serif:regular,italic,bold,bolditalic&v1" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Crete+Round' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="favicon.ico" />

	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/lightbox.js"></script>
	<link href="css/lightbox.css" rel="stylesheet" />

	<title>Pygmyfoto</title>
	</head>
	
	<body>

	<div id="menu">
		 <a class="menu" href="index.php">Home</a><br>
		 <a class="menu" href="archive.php">Archive</a><br>
		 <a class="menu" href="https://github.com/dmpop/pygmyfoto">Pygmyfoto</a><br>
		 <hr>
		 <form method="post" action="search.php">
		 	<input type="text" name="tag" size="12"> <input type="submit" value="&#10148;">
		 </form>
	</div>
	
	<div id="content">
	<h1>Pygmyfoto</h1>
	<hr>

	<script type="text/javascript">
	$(function() {
		$('a[@rel*=lightbox]').lightBox();
	});
	</script>

	<script type="text/javascript">
	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
	</script>

<?php

$id = $_GET['id'];

$db = new PDO('sqlite:pygmyfoto.sqlite');
print "<table border=0>";
$result = $db->query("SELECT id, description, tags, exif FROM photos WHERE id='$id'");
foreach($result as $row)
{
print "<tr><td>".$row['description']."</td></tr>";
print "<tr><td valign='top'><p class='box'>Tags:<em> ".$row['tags']."</p></em><div class='g-plusone'></div></td></tr>";
print "<tr><td><p class='box'>".$row['exif']."</p></td></tr>";
}
print "</table>";

$db = NULL;

?>
	<div class="footer">Powered by Pygmyfoto</div>
	</div>
	</body>
</html>