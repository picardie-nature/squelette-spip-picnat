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
		return '';
	}
}
?>
