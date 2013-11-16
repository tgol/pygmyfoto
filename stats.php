<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

	<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link href='http://fonts.googleapis.com/css?family=Asap:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="favicon.ico" />

	<?php
	include 'config.php';
	echo "<title>$title</title>";
	?>

	</head>
	<body>
	
	<?php

	echo "<div id='content'><h1>$title</h1>";
	
	$db = new PDO('sqlite:pygmyfoto.sqlite');
	
	echo "<div class='center'>$navigation</div>";
	
	echo "<table border=0>";

	$page=0;
	$ppage = $_GET['page'];
	if (isset($ppage))
		$page=intval($ppage);

	$result = $db->prepare("SELECT id, title, count
	                        FROM photos
	                        ORDER BY count DESC");
	$result->execute();
	$rows=$result->fetchAll();
	$row_count = count($rows);
	$num_pages=ceil($row_count/$stats_rows);
	if ($page<1 || $page>$num_pages)
		$page=1;

	$imin=$stats_rows*($page-1);
	$imax=$imin+$stats_rows;

	for ($i=$imin; $i<$imax; $i++) {
		if (empty($rows[$i]))
			echo "<tr><td><p class='text'>&nbsp;</p></td><td><p class='text'>&nbsp;</p></td></tr>";
		else
			echo "<tr><td><p class='text'>".$rows[$i]['title']."</p></td><td><p class='text'>".$rows[$i]['count']."</p></td></tr>";
	}
	
	echo "</table>";

	$result->closeCursor();
	$db = NULL;

	if ($num_pages>1) {
		include 'paginate.php';
		$pagination = pagination($page,$num_pages,'/private/stats.php?page=%d');
		echo "<div class='center'>";
		foreach ($pagination as $link)
			echo $link."&nbsp;";

		echo "</div>";
	}

	echo "<div class='footer'>$footer</div>";
	
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
