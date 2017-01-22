<?php
session_start(); // On démarre la session AVANT toute chose
require 'inc_ouvre_base.php';
require 'fonctions_inc.php';
$MsgRetour = 0;
if (!isset($_SESSION['SuperAdministrateur']))
{
	$MsgRetour = 2;   // msg : Vous devez d'abord vous identifier
}
elseif ($_SESSION['SuperAdministrateur'] < 1)
{
	$MsgRetour = 3;  // msg : Vous n'avez pas le niveau de privilège suffisant pour cette opération	
}
else
{	
	if (isset($_POST['Creationcpteclient']) AND $_POST['Creationcpteclient']=='Creationcpteclient')
	{
//		unset($POST['boutonchoisi']);
		header('location: F3_1_creationcpte.php' );  // Envoi sur la page de traitement de création de compte
		exit;
	}
	elseif (isset($_POST['Modifcpteclient']) AND $_POST['Modifcpteclient']=='Modifcpteclient')
	{
		header('location: F3_2_1_modifcpte.php' );  // Envoi sur la page de traitement de modification de compte
		exit;
	}
	elseif (isset($_POST['Supprcpteclient']) AND $_POST['Supprcpteclient']=='Supprcpteclient')
	{
		header('location: F3_3_1_supprcpte.php' );  // Envoi sur la page de traitement de suppression de compte
		exit;
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
</head>

<body>
<form method="post" action="f3_gestion_cpte_client.php">
    <div class="container">
        <div class="col-md-12">
		<p align="center"><img src="assets/img/GIDventesAdmin.png" width="920"></p>
		<p></p>
        </div>
		<p align="right"><a href="index.php" ><img src="assets/img/MaisonPeVert.png" ></a></p>
		<div class="col-md-8 col-md-offset-4">
			<h2>Gestion des comptes clients</h2>
		</div>
		<div class="col-md-7 col-md-offset-3">
		<font color=#000><p>
<?php
if ($MsgRetour==2)
{
	echo '<span style="color:red;"><strong>Vous devez d\'abord vous identifier</strong></span>';
	print_r ("Gestion cptes ");
	print_r ($_SESSION);
}
elseif ($MsgRetour==3)
{
	echo '<span style="color:red;"><strong>Vous n\'avez pas le niveau de privilège suffisant pour cette opération</strong></span>';
}
?>		</p></font>
		</div>
		<div class="col-md-3 col-md-offset-2">
			<button class="btn btn-default" type="submit" name="Creationcpteclient" value="Creationcpteclient">Création d'un compte client</button>
		</div>
		<div class="col-md-3">
			<button class="btn btn-default" type="submit" name="Modifcpteclient" value="Modifcpteclient">Modification d'un compte client</button>
		</div>
		<div class="col-md-3">
			<button class="btn btn-default" type="submit" name="Supprcpteclient" value="Supprcpteclient">Suppression d'un compte client</button>
		</div>
	</div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>