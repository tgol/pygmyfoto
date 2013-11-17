<?php

$title = 'Pygmyfoto';

$navigation="<a href='index.php'>Home</a> &#10034; <a href='randomphoto.php'>Random photo</a> &#10034; <a href='archive.php'>Archive</a> &#10034; <a href='stats.php'>Stats</a> &#10034; <a href='https://github.com/dmpop/pygmyfoto'>Pygmyfoto</a>";

$footer='Powered by Pygmyfoto. <a href="rss.php">RSS feed</a>';

$baseurl="http://dmpop.dyndns.org/pygmyfoto/"; // Remember the trailing slash

$password="m0nk3y" // For use with the publish.php and unpublish.php scripts

/* Number of rows in the stats page (0 for unlimited / no pagination) */
$stats_rows=10;

/* Number of columns in the archive table (0 for unlimited)*/
$archive_columns=10;
/*
 * If the number of different years exceeds the number of archive_columns, do
 * we paginate or display more tables
*/
$paginated_archive=true;

?>
