<?php
function paginate($reload, $page, $tpages, $adjacents,$onclic) {
	$prevlabel = "&lsaquo; Anterior";
	$nextlabel = "Siguiente &rsaquo;";
	$out = '<nav aria-label="Page navigation example"><ul class="pagination">';
	
	// previous label

	if($page==1) {
		$out.= "<li class='page-item disabled'><a class='page-link' aria-label='Previous'>$prevlabel</a></li>";
	} else if($page==2) {
		$out.= "<li class='page-item'><a href='javascript:void(0);' onclick='".$onclic."(1)' class='page-link' aria-label='Previous'>$prevlabel</a></li>";
	}else {
		$out.= "<li class='page-item'><a href='javascript:void(0);' onclick='".$onclic."(".($page-1).")' class='page-link' aria-label='Previous'>$prevlabel</a></li>";

	}
	
	// first label
	if($page>($adjacents+1)) {
		$out.= "<li class='page-item'><a href='javascript:void(0);' onclick='".$onclic."(1)' class='page-link'>1</a></li>";
	}
	// interval
	if($page>($adjacents+2)) {
		$out.= "<li class='page-item'><a class='page-link'>...</a></li>";
	}

	// pages

	$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
	$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
	for($i=$pmin; $i<=$pmax; $i++) {
		if($i==$page) {
			$out.= "<li class='page-item active'><a class='page-link'>$i</a></li>";
		}else if($i==1) {
			$out.= "<li class='page-item'><a href='javascript:void(0);' onclick='".$onclic."(1)' class='page-link'>$i</a></li>";
		}else {
			$out.= "<li class='page-item'><a href='javascript:void(0);' onclick='".$onclic."(".$i.")' class='page-link'>$i</a></li>";
		}
	}

	// interval

	if($page<($tpages-$adjacents-1)) {
		$out.= "<li class='page-item'><a class='page-link'>...</a></li>";
	}

	// last

	if($page<($tpages-$adjacents)) {
		$out.= "<li class='page-item'><a href='javascript:void(0);' onclick='".$onclic."($tpages)' class='page-link'>$tpages</a></li>";
	}

	// next

	if($page<$tpages) {
		$out.= "<li class='page-item'><a href='javascript:void(0);' onclick='".$onclic."(".($page+1).")' class='page-link' aria-label='Next'>$nextlabel</a></li>";
	}else {
		$out.= "<li class='page-item disabled'><a class='page-link' aria-label='Next'>$nextlabel</a></li>";
	}
	
	$out.= "</ul></nav>";
	return $out;
}
?>