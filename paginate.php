<?php

/**
* https://forrst.com/posts/PHP_Simple_pagination_function-vHK
*
* Pagination function
*
* @param int $current The current page
* @param int $pages How many pages there are in total
* @param int $link Link format (sprintf with one %d parameter)
* @return array An array of links
*/
function pagination($current, $pages, $link='?page=%d') {
	$min = ($current-3<$pages && $current-3>0) ? $current-3 : 1;
	$max = ($current+3>$pages) ? $pages : $current+3;
	$output = array();
	for ($i=$min; $i<=$max; $i++):
		if ($current == $i):
			if ($i==1):
				$output[] = "<span>< {$i}</span>";
			else:
				$output[] = "<span>{$i}</span>";
			endif;
		else:
			$output[] = '<a href="'.sprintf($link,$i).'">'.$i.'</a>';
		endif;
	endfor;
	if ($current+1 < $pages):
		$output[] = '<a href="'.sprintf($link,$current+1).'">></a>';
	else:
		$output[] = '<a>></a>';
	endif;
	if ($current-1 > 0):
		array_unshift($output, '<a href="'.sprintf($link,$current-1).'"><</a>');
	endif;
	return $output;
}
?>
