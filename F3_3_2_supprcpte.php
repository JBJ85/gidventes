<?php
 session_start(); // On démarre la session AVANT toute chose
require 'inc_ouvre_base.php';
require 'fonctions_inc.php';
$_SESSION['Id']=isset($_GET["idPersonne"])?$_GET["idPersonne"]:$_SESSION['Id'];
if (isset($_POST['NomClFourn']))
{
	$id  = $_SESSION['Id'] ;
	$requeteDico = 'DELETE FROM t0_comptesclientsfournisseurs WHERE NumClFourn= "'.$id.'";';   // on supprime le compte client/fournisseur
	$reponse = $bdd->query($requeteDico);
	unset($_POST['CivilitéClFourn'],$_POST['NomClFourn'],$_POST['PrenomClFourn'],$_POST['emailClFourn'],$_POST['MdPClFourn'],$_POST['TelClFourn'],$_POST['Fournisseur']);
	unset($_SESSION['Id']);
	if (!$reponse)
	{
		echo '<script type="text/javascript">alert("ATTENTION l\'la suppresion n\'a pas fonctionné !");</script>';
	}
	else
	{
		echo '<script type="text/javascript">alert("Suppression OK");document.location.href="F3_3_1_supprcpte.php";</script>';
	}
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>suppression</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=News+Cycle:400,700">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="test_css.css">
	<script src="fonctions_js.js" type="text/javascript"></script>
	<SCRIPT type="text/javascript"> 
	 function confirmMessage() { 
		if (confirm("Voulez-vous vraiment supprimer ce client ?")) { // Clic sur OK 
		document.getElementById("suppression").submit(); 
      }
     } 
	</SCRIPT> 
</head>
<body>
<?php
	$id  = $_SESSION['Id'];
	$sql = "SELECT * FROM t0_comptesclientsfournisseurs WHERE NumClFourn = ".$id ;
	$requete = $bdd->query($sql) ;
	if( $donnees = $requete->fetch() )
	{
?>
	<form id="suppression" action="F3_3_2_supprcpte.php" method="POST">
	<div class="container">
		<div class="col-md-12">
		<p align="center"><img src="assets/img/GIDventesAdmin.png" width="920"></p>
		<p></p>
		</div>
		<p align="right"><a href="F3_3_1_supprcpte.php" ><img src="assets/img/MaisonPeVert.png" ></a></p>
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
		<tr> 
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
		<tr> 
			<td>Fournisseur</td>
			<td><input type="text" size="1" maxlength="1" name="Fournisseur" value="0"  onkeypress="refuserToucheEntree(event);"></td>
		</tr>
		<tr align="center">
			<td colspan="2"><INPUT class="beauboutonvert" type="button" name="envoi" value="Supprimer le compte" onClick="confirmMessage()";></td>
		</tr>
	  </table>
	</form>
	</div>
	<?php }?>
	<script src="fonctions_js.js" type="text/javascript"></script>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>