<?php
function deco($w='') 
{
	return "deco/".$w;
}
function class_secteur($id_secteur)
{
	$classes = array (1 => 'obs', 14 => 'prot', 24 => 'env', 4 => 'anim', 100 => 'asso');
	if (isset ($classes[$id_secteur])) {
		return $classes[$id_secteur];
	} else {
		return 'def';
	}
}
function zero2d($d)
{
	if (!empty($d))
		return sprintf("%02d", $d);
	return "";
}

function balise_HIER($params) {
	$params->code = "date('Y-m-d', time()-24*3600)";
	$params->type = 'php';  
	return $params;
}
?>
