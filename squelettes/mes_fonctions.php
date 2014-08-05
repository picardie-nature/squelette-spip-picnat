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

function glossaire_motcles($texte) {
	$q = sql_select('id_groupe', 'spip_groupes_mots','titre=\'Glossaire\'');
	$rgrp = sql_fetch($q);

	// échoue silentieusement
	if (!$rgrp)
		return "(Erreur glossaire) $texte";
	$q = sql_select(array('titre','descriptif'), 'spip_mots', "id_groupe={$rgrp['id_groupe']}");
	while ($r = sql_fetch($q)) {
		$mots[$r['titre']] = $r['descriptif'];
	}

	foreach ($mots as $abbr => $desc) {
		$texte = preg_replace("/([ ,.\(])$abbr([ ,.\)])/", "$1<abbr title=\"$desc\">$abbr</abbr>$2",$texte);
	}
	return $texte;
}
?>
