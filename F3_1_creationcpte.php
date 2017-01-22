<?php
 session_start(); // On démarre la session AVANT toute chose
require 'inc_ouvre_base.php';
require 'fonctions_inc.php';
if (isset($_POST['envoi']) AND $_POST['envoi']=='insérer le compte')
{
	if ($_POST['NomClFourn'] == "" OR $_POST['emailClFourn'] == "" OR $_POST['MdPClFourn'] == "" OR $_POST['TelClFourn'] == "" OR $_POST['Fournisseur'] == "")
	{
		echo  '<span style="color:red;"><strong>Toutes les zones (sauf éventuellement le prénom) doivent être remplies</strong></span>';
	}
	elseif ( !preg_match (retourregex("email") , $_POST['emailClFourn'] ) )
		{
		echo  '<span style="color:red;"><strong>L\'adresse mail est invalide</strong></span>';
		}
	elseif (strlen($_POST['TelClFourn']) != 10 OR !is_numeric($_POST['TelClFourn']))
		{
			echo  '<span style="color:red;"><strong>Le numéro de téléphone est mal structuré</strong></span>';
		}
	elseif (!is_numeric($_POST['Fournisseur']) OR strlen($_POST['Fournisseur']) > 2)
		{
			echo  '<span style="color:red;"><strong>Le code fournisseur doit être numérique et inférieur à 100</strong></span>';
	}
	else
	{
		$login_retour=login_recupcompte($_POST['emailClFourn'], $_POST['MdPClFourn']);  // Vérif absence email en base
		if ($login_retour['coderetour'] != 99)
		{
			echo  '<span style="color:red;"><strong>Cette adresse mail existe déjà en base. Création impossible</strong></span>';
		}
		else
		{
			$retour=insreplcompte(0);   // on créé le nouveau compte client/fournisseur (on fournit une clé à 0)
			if ($retour != "OK")
			{
				echo '<script type="text/javascript">alert("ATTENTION l\'insertion n\'a pas fonctionné !");</script>';
			}
			else
			{
				echo '<script type="text/javascript">alert("Insertion OK");</script>';
				unset($_POST['CivilitéClFourn'],$_POST['NomClFourn'],$_POST['PrenomClFourn'],$_POST['emailClFourn'],$_POST['MdPClFourn'],$_POST['TelClFourn'],$_POST['Fournisseur']);
			}
		}	
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GID ADMINISTRATION</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=News+Cycle:400,700">
	<link rel="stylesheet" href="assets/css/user.css">
	<link rel="stylesheet" href="test_css.css">
</head>

<body>
<form name="insertion" action="F3_1_creationcpte.php" method="POST">
	<div class="container">
		<div class="col-md-12">
		<p align="center"><img src="assets/img/GIDventesAdmin.png" width="920"></p>
		<p></p>
		</div>
		<p align="right"><a href="f3_gestion_cpte_client.php" ><img src="assets/img/MaisonPeVert.png" ></a></p>
		<table  align="center" style="border-collapse: separate; border-spacing: 10px; width:60%">
		<tr align="left">
		<td>civilité</td>
		<td><select type="text" value="Civilité" name="CivilitéClFourn" onkeypress="refuserToucheEntree(event);">
			<option value="Mr">Mr</option>
			<option value="Mme">Mme</option>
			<option value="Mle">Mle</option>
			<option value="">aucune</option>
			</select>
		</td>
		</tr>
		  <td>nom</td>
		  <td><input type="text" size="50" maxlength="100" name="NomClFourn"  value="<?php echo isset($_POST['NomClFourn'])?trim($_POST['NomClFourn']):''; ?>" onkeypress="refuserToucheEntree(event);"></td>
		</tr>
		<tr>
		  <td>prenom</td>
		  <td><input type="text" size="50" maxlength="100" name="PrenomClFourn"  value="<?php echo isset($_POST['PrenomClFourn'])?trim($_POST['PrenomClFourn']):''; ?>" onkeypress="refuserToucheEntree(event);"></td>
		</tr>
		<tr> 
		  <td>adresse mail</td>
		  <td><input type="text" size="50" maxlength="100" name="emailClFourn" value="<?php echo isset($_POST['emailClFourn'])?trim($_POST['emailClFourn']):''; ?>" onkeypress="refuserToucheEntree(event);"></td>
		</tr>
		<tr>
		  <td>mot de passe</td>
		  <td><input type="text" size="50" maxlength="100" name="MdPClFourn" value="<?php echo isset($_POST['MdPClFourn'])?trim($_POST['MdPClFourn']):''; ?>" onkeypress="refuserToucheEntree(event);"></td>
		</tr>
		<tr> 
		  <td>numéro de téléphone</td>
		  <td><input type="text" size="50" maxlength="10" name="TelClFourn" value="<?php echo isset($_POST['TelClFourn'])?trim($_POST['TelClFourn']):''; ?>" onkeypress="refuserToucheEntree(event);"></td>
		</tr>
		  <td>Fournisseur(un chiffre) sinon 0</td>
		  <td><input type="text" size="2" maxlength="2" name="Fournisseur" value="<?php echo isset($_POST['Fournisseur'])?$_POST['Fournisseur']:'0'; ?>" onkeypress="refuserToucheEntree(event);"></td>
		</tr>
		 <tr align="center">
		  <td colspan="2"><input type="submit" name="envoi" value="insérer le compte"></td>
		</table>
	</div>
</form>
 <script src="fonctions_js.js" type="text/javascript"></script>
</body>
</html>