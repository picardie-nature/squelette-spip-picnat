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
function sortie_pole($id_secteur)
{
	$pole = array(1 => 2, 14 => 3, 24 => 4, 4 => 1);
	return $pole[$id_secteur];
}

function zero2d($d)
{
	if (!empty($d))
		return sprintf("%02d", $d);
	return "";
}
?>
