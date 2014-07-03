<?php
function deco($w='') 
{
	return "deco/".$w;
}
function class_secteur($id_secteur)
{
	$classes = array (1 => 'obs', 14 => 'prot', 24 => 'env', 4 => 'anim', 100 => 'asso', '137' => 'vieasso');
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

function archives_classeur($id_classeur) {
	$id = (int)$id_classeur;
	return file_get_contents("http://archives.picardie-nature.org/?action=classeur&id=$id&spip=1");
}

function balise_SORTIES($p) {
	$n = 1;
	$args = '';
	while ($_arg = interprete_argument_balise($n, $p)) {
		list($k,$v) = explode("=", trim($_arg,"'"));
		$args .= '&'.urlencode($k).'='.urlencode($v);
		$n++;
	}
	$p->code = "file_get_contents(\"http://localhost:8080/~nicolas/sorties/?t=www_liste$args\")";
	return $p;
}
?>
