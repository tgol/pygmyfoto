<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

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
	
	include 'config.php';
	echo "<div id='content'><h1>$title</h1>";
	echo "<div class='center'>$navigation</div><br />";
	
	$files = glob($streamdir.'*.jpg', GLOB_BRACE);
	$fileCount = count(glob($streamdir.'*.jpg'));
	
	for ($i=($fileCount-1); $i>=0; $i--)  {  
	$exif = exif_read_data($files[$i], 0, true);
	echo "<h2>".substr($exif['FILE']['FileName'], 0, -4)."</h2>";
	echo "<p>".$exif['COMPUTED']['UserComment']."</p>";
    echo '<a href="'.$files[$i].'"><img class="dropshadow" src="'.$files[$i].'" alt="" width="500px"></a>';
    $Fnumber = explode("/", $exif['EXIF']['FNumber']);
    $Fnumber = $Fnumber[0] / $Fnumber[1];
    echo "<p class='box'>Aperture: f/</em>".$Fnumber." Shutter speed: " .$exif['EXIF']['ExposureTime']. " ISO: ".$exif['EXIF']['ISOSpeedRatings']. " Date: ".$exif['EXIF']['DateTimeOriginal']."</p>";
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
