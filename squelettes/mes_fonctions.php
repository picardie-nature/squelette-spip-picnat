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
		$texte = preg_replace("/([^A-Za-z0-9_])$abbr([^A-Za-z0-9_])/", "$1<abbr title=\"$desc\">$abbr</abbr>$2",$texte);
	}
	return $texte;
}

function mini_url_sortie($date,$id_sortie,$date) {
	$id_sortie = (int)$id_sortie;
	$url = "http://www.picardie-nature.org/?page=sortie_detail&id_sortie=$id_sortie&date=$date";
	$datajs = file_get_contents("http://sorties.picardie-nature.org/?t=json_sortie&id_sortie=$id_sortie");
	$data = json_decode($datajs, true);
	return mini_url($url,$data['nom']);
}

function mini_url($url,$titre) {
	if (!preg_match('/^http\:\/\//',$url))
		$url = "http://www.picardie-nature.org/$url";

	$datajs = file_get_contents("http://10.10.0.3/~nicolas/minilink/api.php?cmd=reduce&url=".urlencode($url));
	$data = json_decode($datajs, true);

	$minurl = "http://l.picnat.fr/{$data['id']}";

	
	$r = "Partager : ";
	// twitter
	$targs = array(
		"lang" => "fr",
		"via" => "PicardieNature",
		"url" => $minurl,
		"text" => $titre
	);
	$r .= "<a href=\"https://twitter.com/share?";
	foreach ($targs as $k => $v) {
		$r.=urlencode($k)."=".urlencode($v)."&";
	}
	$r .= "\" title=\"Partager sur Tweeter\"><i class=\"fa fa-twitter\"></i> </a>";

	// facebook
	$targs = array(
		"u" => $minurl,
		"t" => $titre
	);

	$r .= "<a target='_blank' href=\"https://www.facebook.com/sharer/sharer.php?";
	foreach ($targs as $k => $v) {
		$r.=urlencode($k)."=".urlencode($v)."&";
	}
	$r .= "\" title='Partager sur Facebook'><i class=\"fa fa-facebook-square\"></i></a> ";

	// google+
	$targs = array(
		"url" => $minurl
	);

	$r .= "<a target='_blank' href=\"https://plus.google.com/share?";
	foreach ($targs as $k => $v) {
		$r.=urlencode($k)."=".urlencode($v)."&";
	}
	$r .= "\" title='Partager sur Google+'><i class=\"fa fa-google-plus\"></i></a> ";

	// minilien 
	$r .= "<a href=\"$minurl\"";
	if ($data['reused'] == 1) {
		$rdata_js = file_get_contents("http://10.10.0.3/~nicolas/minilink/api.php?cmd=status&id=".$data['id']);
		$rdata =json_decode($rdata_js, true);
		$r .= " title='URL courte utilisée {$rdata['visites']} fois'";
	}
	$r .= ">$minurl</a> ";

	return $r;
}
?>
