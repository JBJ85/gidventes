<?php

Function login_recupcompte ($ident, $mdp)
{
	global $bdd;
	$login_retour=array();
	$requeteDico = 'SELECT t0_comptesclientsfournisseurs.NumClFourn, t0_comptesclientsfournisseurs.CivilitéClFourn, t0_comptesclientsfournisseurs.NomClFourn, t0_comptesclientsfournisseurs.PrenomClFourn, t0_comptesclientsfournisseurs.TelClFourn, t0_comptesclientsfournisseurs.MdPClFourn, t0_comptesclientsfournisseurs.Fournisseur, t0_comptesclientsfournisseurs.SuperAdministrateur FROM t0_comptesclientsfournisseurs WHERE (((t0_comptesclientsfournisseurs.emailClFourn)="'.$ident.'"));';
	$reponse = $bdd->query($requeteDico);
	$donnees = $reponse->fetch();
	if (!$donnees)
	{
		$login_retour['coderetour'] = 99;  // enregistrement non trouvé
		$login_retour['msgretour'] = 'Identifiant inconnu';
	}
	elseif (!password_verify($mdp, $donnees['MdPClFourn']))
	{
		$login_retour['coderetour'] = 98;  // mot de passe faux
		$login_retour['msgretour'] = 'Mot de passe erroné';
		$login_retour['NumClFourn'] = $donnees['NumClFourn'];
	}
	else	
	{
		$login_retour['coderetour'] = 0;  // enregistrement trouvé et mdp bon
		$login_retour['msgretour'] = 'OK';
		$login_retour['NumClFourn'] = $donnees['NumClFourn'];
		$login_retour['CivilitéClFourn'] = $donnees['CivilitéClFourn'];
		$login_retour['NomClFourn'] = $donnees['NomClFourn'];
		$login_retour['PrenomClFourn'] = $donnees['PrenomClFourn'];
		$login_retour['TelClFourn'] = $donnees['TelClFourn'];
		$login_retour['Fournisseur'] = $donnees['Fournisseur'];
		$login_retour['SuperAdministrateur'] = $donnees['SuperAdministrateur'];
	}
	$reponse->closeCursor();
	return ($login_retour);
}
Function insreplcompte ($IdentClient)
{
	global $bdd;
	$code_retour="OK";
	$cryptage = password_hash($_POST['MdPClFourn'], PASSWORD_DEFAULT);
	$req = $bdd->prepare('REPLACE INTO t0_comptesclientsfournisseurs (NumClFourn, CivilitéClFourn, NomClFourn, PrenomClFourn, emailClFourn, MdPClFourn, TelClFourn, Fournisseur) VALUES(:Clef, :a, :b, :c, :d, :e,:f, :g)');
/*	print_r ("insrepl ");
	print_r (ucfirst(mb_strtolower($_POST['PrenomClFourn'])));
	print_r (strtoupper($_POST['NomClFourn']));
	print_r ($_POST);*/
	$reponse=$req->execute(array(
		'Clef' => $IdentClient,
		'a' => $_POST['CivilitéClFourn'],
		'b' => strtoupper($_POST['NomClFourn']),
		'c' => ucfirst(mb_strtolower($_POST['PrenomClFourn'])),
		'd' => $_POST['emailClFourn'],
		'e' => $cryptage,
		'f' => $_POST['TelClFourn'],
		'g' => $_POST['Fournisseur'],
    ));
/*	print_r("Erreur : ");
	print_r ($reponse);*/
  if(!$reponse)
  {
	$code_retour="Non OK";
  }
return ($code_retour);
}
Function retourregex ($besoin)
{
	if ($besoin == "email")
	{
		$RegRetour = " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";
	}
	elseif ($besoin == "date")
	{
		$RegRetour =  " \^([0-3][0-9]})(/)([0-9]{2,2})(/)([0-3]{2,2})$\ ";
	}
	elseif ($besoin == "codepostal")
	{
		$RegRetour =  " \^[0-9]{5,5}$\ ";
	}
	
	elseif ($besoin == "numtelephone")
	{
		$RegRetour =  " \^(\d\d\s){4}(\d\d)$\ ";
	}

return ($RegRetour);
}
?>