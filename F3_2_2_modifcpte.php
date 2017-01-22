<?php
 session_start(); // On démarre la session AVANT toute chose
require 'inc_ouvre_base.php';
require 'fonctions_inc.php';
$_SESSION['Id']=isset($_GET["idPersonne"])?$_GET["idPersonne"]:$_SESSION['Id'];
if (isset($_POST['envoi']) AND $_POST['envoi']=='Modifier le compte')
{
	if ($_POST['NomClFourn'] == "" OR $_POST['emailClFourn'] == "" OR $_POST['MdPClFourn'] == "" OR $_POST['TelClFourn'] == "" OR $_POST['Fournisseur'] == "")
	{
		echo  '<span style="color:red;"><strong><p>Toutes les zones (sauf le prénom) doivent être remplies</p></strong></span>';
	}
	elseif (strlen($_POST['TelClFourn']) != 10 OR !is_numeric($_POST['TelClFourn']))
	{
		echo  '<span style="color:red;"><strong>Le numéro de téléphone est mal structuré</strong></span>';
	}
	elseif ( !preg_match (retourregex("email") , $_POST['emailClFourn'] ) )
		{
		echo  '<span style="color:red;"><strong>L\'adresse mail est invalide</strong></span>';
		}
	elseif (!is_numeric($_POST['Fournisseur']) OR strlen($_POST['Fournisseur']) > 2)
		{
			echo  '<span style="color:red;"><strong>Le code fournisseur doit être numérique et inférieur à 100</strong></span>';
	}
	else
	{
		$login_retour=login_recupcompte($_POST['emailClFourn'], $_POST['MdPClFourn']);  // Vérif absence email en base (autre que l'article lui-même)
		if ($login_retour['coderetour'] != 99 AND $login_retour['NumClFourn'] != $_SESSION['Id'])
		{
			echo "<p>Cette adresse mail existe déjà en base. Création impossible</p>";
		}
		else
		{
			$id  = $_SESSION['Id'] ;
			$retour=insreplcompte($id);   // on modifie le compte client/fournisseur
			unset($_POST['CivilitéClFourn'],$_POST['NomClFourn'],$_POST['PrenomClFourn'],$_POST['emailClFourn'],$_POST['MdPClFourn'],$_POST['TelClFourn'],$_POST['Fournisseur']);
			unset($_SESSION['Id']);
			if ($retour != "OK")
			{
				echo '<script type="text/javascript">alert("ATTENTION l\'la modification n\'a pas fonctionné !");document.location.href="F3_2_1_modifcpte.php";</script>';
			}
			else
			{
				echo '<script type="text/javascript">alert("Modification OK");document.location.href="F3_2_1_modifcpte.php";</script>';
			}
		}	
	}
}
?>
<html>
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>modification</title>
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=News+Cycle:400,700">
	<link rel="stylesheet" href="assets/css/user.css">
	<link rel="stylesheet" href="test_css.css">
</head>
<body>

<?php
	$id  = $_SESSION['Id'];
	$sql = "SELECT * FROM t0_comptesclientsfournisseurs WHERE NumClFourn = ".$id ;
	$requete = $bdd->query($sql) ;
	if( $donnees = $requete->fetch() )
	{
?>
	<form name="modification" action="F3_2_2_modifcpte.php" method="POST">
		<div class="container">
			<div class="col-md-12">
				<p align="center"><img src="assets/img/GIDventesAdmin.png" width="920"></p>
				<p></p>
			</div>
			<p align="right"><a href="F3_2_1_modifcpte.php" ><img src="assets/img/MaisonPeVert.png" ></a></p>
			<input type="hidden" name="id" value="<?php echo($id) ;?>">
			<table  align="center" style="border-collapse: separate; border-spacing: 10px; width:60%">
			<tr align="left">
			  <td>civilité</td>
			  <td><select type="text" value="Civilité" name="CivilitéClFourn">
				<option value="Mr">Mr</option>
				<option value="Mme" <?php echo ($donnees['CivilitéClFourn']=='Mme')? ' selected="selected"':''; ?>>Mme</option>
				<option value="Mle" <?php echo ($donnees['CivilitéClFourn']=='Mle')? ' selected="selected"':''; ?>>Mle</option>
				<option value="" <?php echo ($donnees['CivilitéClFourn']=='')? ' selected="selected"':''; ?>>aucune</option>
				</select>
			</td>
			</tr>
			  <td>nom</td>
			  <td><input type="text" size="50" maxlength="100" name="NomClFourn"  value="<?php echo($donnees['NomClFourn']) ;?>" onkeypress="refuserToucheEntree(event);"> </td>
			</tr>
			<tr>
			  <td>prenom</td>
			  <td><input type="text" size="50" maxlength="100" name="PrenomClFourn"  value="<?php echo($donnees['PrenomClFourn']) ;?>" onkeypress="refuserToucheEntree(event);"></td>
			</tr>
			<tr> 
			  <td>adresse mail</td>
			  <td><input type="text" size="50" maxlength="100" name="emailClFourn" value="<?php echo($donnees['emailClFourn']) ;?>" onkeypress="refuserToucheEntree(event);"></td>
			</tr>
			<tr>
			  <td>mot de passe</td>
			  <td><input type="text" size="50" maxlength="100" name="MdPClFourn" value="" onkeypress="refuserToucheEntree(event);"></td>
			</tr>
			<tr> 
			  <td>numéro de téléphone</td>
			  <td><input type="text" size="50" maxlength="100" name="TelClFourn" value="<?php echo($donnees['TelClFourn']) ;?>" onkeypress="refuserToucheEntree(event);"></td>
			</tr>
			  <td>Fournisseur(un nombre) sinon 0</td>
			  <td><input type="text" size="2" maxlength="2" name="Fournisseur" value="<?php echo($donnees['Fournisseur']) ;?>"  onkeypress="refuserToucheEntree(event);"></td>
			</tr>
			 <tr align="center">
			<td colspan="2"><button class="btn btn-primary" type="submit" name="envoi" value="Modifier le compte">Modifier le compte </button></td>
			</tr>
			</table>
		</div>
	</form>
	<?php }?>
	<script src="fonctions_js.js" type="text/javascript"></script>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>