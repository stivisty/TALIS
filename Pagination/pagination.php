<?php
function pagination($current_page, $nb_pages, $link='?page=%d', $around=10, $firstlast=1)
{
	$pagination = '';
	$link = preg_replace('`%([^d])`', '%%$1', $link);
	if ( !preg_match('`(?<!%)%d`', $link) ) $link .= '%d';
	if ( $nb_pages > 1 ) {

		// Lien précédent
		if ( $current_page > 1 )
			$pagination .= '<a class="prevnext" href="'.sprintf($link, $current_page-1).'" title="Previous page">&laquo; Previous</a>';
		else
			$pagination .= '<span class="prevnext disabled">&laquo; Previous </span>';

		// Lien(s) début
		for ( $i=1 ; $i<=$firstlast ; $i++ ) {
			$pagination .= ' ';
			$pagination .= ($current_page==$i) ? '<span class="current">'.$i.'</span>' : '<a href="'.sprintf($link, $i).'">'.$i.'</a>';
		}

		// ... après pages début ?
		if ( ($current_page-$around) > $firstlast+1 )
			$pagination .= ' &hellip;';

		// On boucle autour de la page courante
		$start = ($current_page-$around)>$firstlast ? $current_page-$around : $firstlast+1;
		$end = ($current_page+$around)<=($nb_pages-$firstlast) ? $current_page+$around : $nb_pages-$firstlast;
		for ( $i=$start ; $i<=$end ; $i++ ) {
			$pagination .= ' ';
			if ( $i==$current_page )
				$pagination .= '<span class="current">'.$i.'</span>';
			else
				$pagination .= '<a href="'.sprintf($link, $i).'">'.$i.'</a>';
		}

		// ... avant page nb_pages ?
		if ( ($current_page+$around) < $nb_pages-$firstlast )
			$pagination .= ' &hellip;';

		// Lien(s) fin
		$start = $nb_pages-$firstlast+1;
		if( $start <= $firstlast ) $start = $firstlast+1;
		for ( $i=$start ; $i<=$nb_pages ; $i++ ) {
			$pagination .= ' ';
			$pagination .= ($current_page==$i) ? '<span class="current">'.$i.'</span>' : '<a href="'.sprintf($link, $i).'">'.$i.'</a>';
		}

		// Lien suivant
		if ( $current_page < $nb_pages )
			$pagination .= ' <a class="prevnext" href="'.sprintf($link, ($current_page+1)).'" title="Next page">Next &raquo;</a>';
		else
			$pagination .= ' <span class="prevnext disabled">Next &raquo;</span>';
	}
	return $pagination;
}		


function pagination_fr($current_page, $nb_pages, $link='?page=%d', $around=10, $firstlast=1)
{
	$pagination = '';
	$link = preg_replace('`%([^d])`', '%%$1', $link);
	if ( !preg_match('`(?<!%)%d`', $link) ) $link .= '%d';
	if ( $nb_pages > 1 ) {

		// Lien précédent
		if ( $current_page > 1 )
$pagination .= '<a class="prevnext" href="'.sprintf($link, $current_page-1).'" title="Page pr&eacute;c&eacute;dente">				&laquo; Pr&eacute;c&eacute;dent</a>';
		else
			$pagination .= '<span class="prevnext disabled">&laquo; Pr&eacute;c&eacute;dente </span>';

		// Lien(s) début
		for ( $i=1 ; $i<=$firstlast ; $i++ ) {
			$pagination .= ' ';
			$pagination .= ($current_page==$i) ? '<span class="current">'.$i.'</span>' : '<a href="'.sprintf($link, $i).'">'.$i.'</a>';
		}

		// ... après pages début ?
		if ( ($current_page-$around) > $firstlast+1 )
			$pagination .= ' &hellip;';

		// On boucle autour de la page courante
		$start = ($current_page-$around)>$firstlast ? $current_page-$around : $firstlast+1;
		$end = ($current_page+$around)<=($nb_pages-$firstlast) ? $current_page+$around : $nb_pages-$firstlast;
		for ( $i=$start ; $i<=$end ; $i++ ) {
			$pagination .= ' ';
			if ( $i==$current_page )
				$pagination .= '<span class="current">'.$i.'</span>';
			else
				$pagination .= '<a href="'.sprintf($link, $i).'">'.$i.'</a>';
		}

		// ... avant page nb_pages ?
		if ( ($current_page+$around) < $nb_pages-$firstlast )
			$pagination .= ' &hellip;';

		// Lien(s) fin
		$start = $nb_pages-$firstlast+1;
		if( $start <= $firstlast ) $start = $firstlast+1;
		for ( $i=$start ; $i<=$nb_pages ; $i++ ) {
			$pagination .= ' ';
			$pagination .= ($current_page==$i) ? '<span class="current">'.$i.'</span>' : '<a href="'.sprintf($link, $i).'">'.$i.'</a>';
		}

		// Lien suivant
		if ( $current_page < $nb_pages )
			$pagination .= ' <a class="prevnext" href="'.sprintf($link, ($current_page+1)).'" title="Page suivante">Suivant &raquo;</a>';
		else
			$pagination .= ' <span class="prevnext disabled">Suivant &raquo;</span>';
	}
	return $pagination;
}		

		
?>