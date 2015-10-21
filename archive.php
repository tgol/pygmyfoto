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

	$ncolmax=intval($archive_columns);

	echo "<div id='content'><h1>$title</h1>";
	
	$db = new PDO('sqlite:pygmyfoto.sqlite');
	
	echo "<div class='center'>$navigation</div>";

	/* get archived pictures info from db */
	$result=$db->prepare("SELECT id, title, description, tags, exif, dt, osm, original FROM photos WHERE published = '0' ORDER BY dt DESC");
	$result->execute();

	/* build archive table */
	$year_init='';
	$ncol=0;
	while ($val=$result->fetch(PDO::FETCH_OBJ)) {
		$month=substr($val->dt, 5, 2);
		$year=substr($val->dt, 0, 4);

		if ($year != $new_year) {
			$ncol++;
			$arr[0][$ncol]=$year;
			$is_ny=1;
		}
		else
			$is_ny=0;

		if ($month != $new_month or $is_ny == 1) {
			$pic_count=1;
			$nrow=(13-$month);
			$arr[$nrow][$ncol]=$pic_count;
			$nrow_save=$nrow;
		}
		else {
			$pic_count++;
			$arr[$nrow_save][$ncol]=$pic_count;
		}
		$new_month=$month;
		$new_year=$year;
	}

	/* if no data get out */
	if ($ncol==0)
		goto notable;

	/* build left column containing months */
	$month_col[0]="December";
	$month_col[1]="November";
	$month_col[2]="October";
	$month_col[3]="September";
	$month_col[4]="August";
	$month_col[5]="July";
	$month_col[6]="June";
	$month_col[7]="May";
	$month_col[8]="April";
	$month_col[9]="March";
	$month_col[10]="February";
	$month_col[11]="January";


	/* number of tables */
	if ($ncolmax <= 0)
		$ncolmax=$ncol;

	$ntables=ceil($ncol/$ncolmax);

	/* get page number */
	$page=0;
	$ppage = $_GET['page'];
	if (isset($ppage))
		$page=intval($ppage);

	if ($page<1 || $page>$ntables)
		$page=1;

	echo "<br>";

	/* one loop if pagination activated */
	if ($paginated_archive) {
		$kmin=$page-1;
		$kmax=$page;
	}
	else {
		$kmin=0;
		$kmax=$ntables;
	}

	/* build html tables */
	for ($k=$kmin; $k<$kmax; $k++) {
		echo "<table class='arch'>";
		$jstart=($k*($ncolmax+1));
		$jstop=min(((($k+1)*$ncolmax)+$k),($ncol+$ntables-1));
		for ($i=0; $i<13; $i++) {
			echo "<tr>";
			for ($j=$jstart; $j<=$jstop; $j++) {

				if ($i==0 && $j==$jstart)
					echo "<td class='arch'>&nbsp;</td>";
				else if ($i==0)
					echo "<th class='arch'>".$arr[$i][$j-$k]."</th>";
				else if ($j==$jstart)
					echo "<td class='arch'>".$month_col[$i-1]."</td>";
				else {
					if ($arr[$i][$j-$k]>0) {
						$ii=13-$i;
						if ($ii<10)
							$ii="0".$ii;
						echo "<td class='archx' style='cursor: pointer;' bgcolor='#f3f3f3' onclick="."location.href='archive_month.php?month=".$arr[0][$j-$k]."-".$ii."'".">".$arr[$i][$j-$k]."</td>";
					}
					else
						echo "<td class='arch'></td>";
				}

			}
			echo "</tr>";
		}
		echo "</table>";
		echo "<br>";
	}

notable:
	/* close db query */
	$result->closeCursor();
	$db = NULL;

	/* pagination links */
	if ($paginated_archive) {
		if ($ntables>1) {
			include 'paginate.php';
			$pagination = pagination($page,$ntables,'/private/archive.php?page=%d');
			echo "<div class='center'>";
			foreach ($pagination as $link)
				echo $link."&nbsp;";
			echo "</div>";
		}
	}

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
