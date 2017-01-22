<?php
session_start();
require 'inc_ouvre_base.php';
require 'fonctions_inc.php';
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
	<link rel="stylesheet" href="test_css.css">
</head>
<body>
	<div class="container">
		<div class="col-md-12">
		<p align="center"><img src="assets/img/GIDventesAdmin.png" width="920"></p>
		<p></p>
		</div>
		<p align="right"><a href="index.php" ><img src="assets/img/MaisonPeVert.png" ></a></p>
		<p align="center"><h3  align="center">Les Produits choisis pour la semaine</h3></p><p />
		<table  align="center" style="width:40%">
		<?php
			$requeteDico = "SELECT t1_dictionnaireproduction.NumProduction, t4_famillesproduits.LibelleFamille, t1_dictionnaireproduction.NomProduction, ".
			"t1_dictionnaireproduction.ImgProduit, t2_unitevente.LibelleUniteVente, t1_dictionnaireproduction.DernierPrixVente FROM t1_dictionnaireproduction ".
			"INNER JOIN t4_famillesproduits ON t1_dictionnaireproduction.FamilleDeProduit = t4_famillesproduits.NumFamilleprod ".
			"INNER JOIN t2_unitevente ON t1_dictionnaireproduction.UnitedeVente = t2_unitevente.NumUniteVente ".
			"WHERE t1_dictionnaireproduction.Selection ORDER BY t4_famillesproduits.LibelleFamille DESC, t1_dictionnaireproduction.NomProduction ASC";
			$reponse = $bdd->query($requeteDico);
			$nombre_de_lignes=0;
			$Num_ID_Prod=array(); //tableau des clés primaires des produits pour les mises à jour ultérieures
			echo '<tr class="tdthbord"><td class="tdthbord"><b><em>Produit</em></b></td><td class="tdthbord"><b><em>Image</em></b></td><td class="tdthbord"><b><em>Type</em></b></td><td class="tdthbord"><b><em>Conditionnement</em></b></td>'.
			'<td class="tdthbord"><b><em>Prix unitaire</em></b></td></tr>'; // la balise th ne fonctionne pas sous Firefox
			$repertoire = 'Images/';
			while ($donnees = $reponse->fetch())
			{	$Num_ID_Prod[$nombre_de_lignes]=$donnees['NumProduction'];
				echo '<tr class="tdthbord"><td class="tdthbord">'. $donnees['NomProduction'] . '</td>'.
				'<td class="tdthbord"><img src="'.$repertoire. $donnees['ImgProduit'].'" alt="" />' . '</td>'.
				'<td class="tdthbord">'. $donnees['LibelleFamille'] . '</td>'.
				'<td class="tdthbord">'. $donnees['LibelleUniteVente'] . '</td>'.
				'<td class="tdthbord">'. number_format($donnees['DernierPrixVente'], 2, ',', ' ') . ' € </td></tr>';
				$nombre_de_lignes++;
			}
			$reponse->closeCursor();
		?>
		</table>
	</div>
</body>
</html>