<?php
session_start();
require 'inc_ouvre_base.php';
$Erreur=false;
if (isset($_POST['A0']))
{	$TabledesID=array();
	$TabledesID = unserialize(urldecode($_POST['TabledesID']));
	$NbLignes = count($TabledesID)-1;
	// Traitement des erreurs
	for ($num_de_ligne = 0; $num_de_ligne <= $NbLignes; $num_de_ligne++)
	{	if ($_POST['B'.$num_de_ligne] != NULL)
		{	$NouveauPrix = trim( $_POST['B'.$num_de_ligne] );
			if( preg_match('#^[0-9]{1,2}[.,]?[0-9]{0,2}$#', $NouveauPrix ) AND ( $NouveauPrix <100) ) 
			{	$_POST['B'.$num_de_ligne] = preg_replace('#([0-9]{1,2})([.,]?)([0-9]{0,2})#','$1.$3',$NouveauPrix);
			}
			else 
			{
				echo '<span style="color:red;">Le montant entré suivant est incorrect (trop grand ou mal structuré) : '.$NouveauPrix.'</span><p />';
				$Erreur=true;
			}			
		}
	}
	// Enregistrement des résultats si pas d'erreur
	if (!$Erreur)
	{	for ($num_de_ligne = 0; $num_de_ligne <= $NbLignes; $num_de_ligne++)
		{	if ($_POST['A'.$num_de_ligne]!= NULL and $_POST['B'.$num_de_ligne] != NULL)
			{	$bdd->exec('UPDATE t1_dictionnaireproduction SET DernierPrixVente='.$_POST['B'.$num_de_ligne].',Selection=true WHERE NumProduction='.$TabledesID[$num_de_ligne]);
			}
			elseif ($_POST['A'.$num_de_ligne]!=NULL)
			{	$bdd->exec('UPDATE t1_dictionnaireproduction SET Selection=true WHERE NumProduction='.$TabledesID[$num_de_ligne]);
			}
		}
		header('location: f4_fin_choix_tiers.php' );  // Envoi sur la page de visualisation de la sélection (en format client)
		exit;
	}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>GID ADMINISTRATION</title>
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=News+Cycle:400,700">
		<link rel="stylesheet" href="assets/css/user.css">
        <link rel="stylesheet" href="test_css.css" />
</head>

    <body>
		<form method="post" action="f4_choix_tiers">
		<div class="container">
			<div class="col-md-12">
			<p align="center"><img src="assets/img/GIDventesAdmin.png" width="920"></p>
			<p></p>
			</div>
			<p align="right"><a href="index.php" ><img src="assets/img/MaisonPeVert.png" ></a></p>
			<p align="center"><button type="submit" name="ImagePanier"><img src="Images\Legumes.png"></button></p>
			<table  align="center" style="border-collapse: collapse; width:70%">
			<?php
			if (!$Erreur) $bdd->exec('UPDATE t1_dictionnaireproduction SET Selection=false where t1_dictionnaireproduction.producteur <> 1');
			$requeteDico = "SELECT t1_dictionnaireproduction.NumProduction, t1_dictionnaireproduction.NomProduction, t4_famillesproduits.LibelleFamille, t2_unitevente.LibelleUniteVente, t1_dictionnaireproduction.DernierPrixVente, t1_dictionnaireproduction.Permanent, t1_dictionnaireproduction.producteur FROM t1_dictionnaireproduction INNER JOIN t2_unitevente ON t1_dictionnaireproduction.UnitedeVente = t2_unitevente.NumUniteVente INNER JOIN t4_famillesproduits ON t1_dictionnaireproduction.FamilleDeProduit = t4_famillesproduits.NumFamilleprod WHERE (t1_dictionnaireproduction.producteur<>1) ORDER BY t1_dictionnaireproduction.producteur, t1_dictionnaireproduction.FamilleDeProduit, t1_dictionnaireproduction.OrdreDeParution, t1_dictionnaireproduction.NomProduction";
			if (!$reponse = $bdd->query($requeteDico)) echo 'ATTENTION - la requete de constitution de la liste des produits ne s\'exécute pas';
			$nombre_de_lignes=0;
			$Num_ID_Prod=array(); //tableau des clés primaires des produits pour les mises à jour ultérieures
			echo '<tr class="tdthbord"><td class="tdthbord"><b><em>Produit</em></b></td><td class="tdthbord"><b><em>Type</em></b></td><td class="tdthbord"><b><em>Conditionnement</em></b></td>'.
			'<td class="tdthbord"><b><em>Prix</em></b></td><td class="tdthbord"><b><em>Permanent</em></b></td><td class="tdthbord"><b><em>Sélection</em></b></td><td class="tdthbord"><b><em>Nouveau prix</em></b></td></tr>'; // la balise th ne fonctionne pas sous Firefox

			while ($donnees = $reponse->fetch())
			{	$VarSelect=isset($_POST['A'.$nombre_de_lignes])?$_POST['A'.$nombre_de_lignes]:'';   //pour l'affichage au retour du formulaire
				$VarNouvPrix=isset($_POST['B'.$nombre_de_lignes])?$_POST['B'.$nombre_de_lignes]:'';
				$Num_ID_Prod[$nombre_de_lignes]=$donnees['NumProduction'];
				echo '<tr class="tdthbord"><td class="tdthbord">'. $donnees['NomProduction'] . '</td>'.
				'<td class="tdthbord">'. $donnees['LibelleFamille'] . '</td>'.
				'<td class="tdthbord">'. $donnees['LibelleUniteVente'] . '</td>'.
				'<td class="tdthbord">'. number_format($donnees['DernierPrixVente'], 2, ',', ' ') . ' € </td>'.
				'<td class="tdthbord">'. $donnees['Permanent'] . '</td>'.
				'<td class="tdthbord"><input type="text" size=6 maxlength=1 name="A' . $nombre_de_lignes . '" id="A' . $nombre_de_lignes . '" value="'.$VarSelect.'" /></td>'.
				'<td class="tdthbord"><input type="text" size=11 name="B' . $nombre_de_lignes . '" id="B' . $nombre_de_lignes . '" value="'.$VarNouvPrix.'" /></td></tr>';
				$nombre_de_lignes++;
			}
			$reponse->closeCursor();
			echo '</table>';
			// on sérialise pour pouvoir passer le tableau des clés primaires des produits en paramètre
			$ClesProd = serialize($Num_ID_Prod);
			echo '<input type="hidden" name="TabledesID" id="TabledesID" value="'.urlencode($ClesProd).'"/>';
			echo '<p align="center"><button type="submit" name="ImagePanier"><img src="Images\Legumes.png"></button></p>';
			?>
		</div>
    </body>
</html>