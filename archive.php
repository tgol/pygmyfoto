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
	
	include 'config.php';
	
	echo "<div id='content'><h1>$title</h1>";
	
	$db = new PDO('sqlite:pygmyfoto.sqlite');
	
	echo "<div class='center'>$navigation</div>";
	echo "<br>";

	echo "<table class='arch'>";
	$result = $db->query("SELECT id, title, description, tags, exif, dt, osm, original FROM photos WHERE published = '0' ORDER BY dt DESC");
	$new_month="00";
	$new_year="0000";
	$ncol=0;
	foreach($result as $row) {

		$month=substr($row['dt'], 5, 2);
		$year=substr($row['dt'], 0, 4);
		$is_ny=0;

		if ($year != $new_year) {
			$ncol++;
			$arr[0][$ncol]=$year;
			$is_ny=1;
		}
		else
			$is_ny=0;

		if ($month != $new_month or $is_ny == 1) {
			$nrow=(13-$month);
			$arr[$nrow][$ncol]="X";
		}
		$new_month=$month;
		$new_year=$year;
	}

	if ($ncol < 1)
		goto notable;

	for ($i=0; $i<13; $i++) { /* year + 12 months */
		echo "<tr>";
		for ($j=0; $j<=$ncol; $j++) {
			if ($i == 0)
				echo "<th class='arch'><a class='title'>".$arr[0][$j]."</a></th>";
			else {
				$ii=(13-$i);
				if ($j==0) {
					switch ($ii) {
						case 1:
							$arr[$i][$j]="January";
							break;
						case 2:
							$arr[$i][$j]="February";
							break;
						case 3:
							$arr[$i][$j]="March";
							break;
						case 4:
							$arr[$i][$j]="April";
							break;
						case 5:
							$arr[$i][$j]="May";
							break;
						case 6:
							$arr[$i][$j]="June";
							break;
						case 7:
							$arr[$i][$j]="July";
							break;
						case 8:
							$arr[$i][$j]="August";
							break;
						case 9:
							$arr[$i][$j]="September";
							break;
						case 10:
							$arr[$i][$j]="October";
							break;
						case 11:
							$arr[$i][$j]="November";
							break;
						case 12:
							$arr[$i][$j]="December";
							break;
					}
					echo "<td class='arch'><a class='title'>".$arr[$i][$j]."</a></td>";
				}
				else {
					if ($ii<10)
						$ii="0".$ii;

					if ($arr[$i][$j]=="X")
						echo "<td class='archx' style='cursor: pointer;' bgcolor='#f3f3f3' onclick="."location.href='archive_month.php?month=".$arr[0][$j]."-".$ii."'"."></td>";
					else
						echo "<td class='arch'></td>";
				}
			}
		}
		echo "</tr>";
	}
	
	echo "</table>";
	
	echo "<br>";

notable:

	$db = NULL;

	echo "<p><center><form method='post' action='search.php'><input type='text' name='tag' size='11'> <input type='submit' value='&#10148;'></form></center></p>";

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
