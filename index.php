<?php
session_start(); // On démarre la session AVANT toute chose
require 'inc_ouvre_base.php';
require 'fonctions_inc.php';
$MsgRetour = 0;
if (isset($_POST['envoi']) AND $_POST['envoi']=='Envoyer')
{
	$_SESSION['identifiant'] = $_POST['identifiant'];
	$_SESSION['motdepasse'] = $_POST['motdepasse'];
	
	$login_retour=login_recupcompte($_POST['identifiant'], $_POST['motdepasse']);  // récupération des infos en base
	
	if ($login_retour['coderetour'] != 0)
	{
		$MsgRetour = 1;  // Identifiant ou mot de passe erroné	
	}
	else
	{
		$_SESSION['NumClFourn'] = $login_retour['NumClFourn'];
		$_SESSION['CivilitéClFourn'] = $login_retour['CivilitéClFourn'];
		$_SESSION['NomClFourn'] = $login_retour['NomClFourn'];
		$_SESSION['PrenomClFourn'] = $login_retour['PrenomClFourn'];
		$_SESSION['TelClFourn'] = $login_retour['TelClFourn'];
		$_SESSION['Fournisseur'] = $login_retour['Fournisseur'];
		$_SESSION['SuperAdministrateur'] = $login_retour['SuperAdministrateur'];
	}	
}
elseif (isset($_POST['lescommandes']) AND $_POST['lescommandes']=='Commandes')
{	if (!isset($_SESSION['SuperAdministrateur']))
	{	$MsgRetour = 2;  // msg : Vous devez d'abord vous identifier
	}                                                               
	else
	{
		header('location: ListeCommandesFourn.php' );  // Envoi sur la page de traitement de la liste des commandes
		exit;
	}
}
elseif ((isset($_POST['loffregid']) AND $_POST['loffregid']=='OffreGraineID') OR (isset($_POST['loffretiers']) AND $_POST['loffretiers']=='OffreTiers') OR (isset($_POST['gestioncpteclient']) AND $_POST['gestioncpteclient']=='gestioncpteclient'))
{
	if (!isset($_SESSION['NumClFourn']))
	{	
		$MsgRetour = 2;  // msg : Vous devez d'abord vous identifier
	}                                                               
	elseif ($_SESSION['SuperAdministrateur'] < 1)
	{
		$MsgRetour = 3;  // msg : Vous n'avez pas le niveau de privilège suffisant pour cette opération	
	}
	else
	{	
		if (isset($_POST['loffregid']))
		{
			header('location: f1_choix_prod.php' );  // Envoi sur la page de constitution de l'offre de GID pour la semaine
		}
		elseif (isset($_POST['loffretiers']))
		{
			header('location: f4_choix_tiers.php' );  // Envoi sur la page de constitution des offres tiers
		}
		else
		{
			header('location: f3_gestion_cpte_client.php' );  // Envoi sur la page de gestion des comptes client
		}
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
<form method="post" action="index.php">
    <div class="container">
        <div class="col-md-12">
		<p align="center"><img src="assets/img/GIDventesAdmin.png" width="920"></p>
		<p></p>
        </div>
        <div class="row">
            <div class="col-md-12 col-md-push-2">
                <div class="btn-toolbar">
                    <div class="btn-group" role="group">
                        <button class="btn btn-default" type="submit" name="lescommandes" value="Commandes">Commandes enregistrées</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-default" type="submit" name="loffregid" value="OffreGraineID">L'offre de Graine d'ID</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-default" type="submit" name="loffretiers" value="OffreTiers">L'offre tiers</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-default" type="submit" name="gestioncpteclient" value="gestioncpteclient">Gestion des comptes client</button>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-md-offset-3">
				<font color=#000><p>
<?php
if ($MsgRetour==0 AND isset($_SESSION['NomClFourn']))
{
	echo '<p /><span style="color:blue;"><strong><em>Bonjour '.$_SESSION['CivilitéClFourn'].' '.$_SESSION['NomClFourn'].' '.$_SESSION['PrenomClFourn'].'</strong></em></span><p />';
}
elseif ($MsgRetour==1)
{
	echo  '<span style="color:red;"><strong>Identifiant ou mot de passe erroné</strong></span>';
}
elseif ($MsgRetour==2)
{
	echo '<span style="color:red;"><strong>Vous devez d\'abord vous identifier</strong></span>';
	print_r("Accueil ");
	print_r($_SESSION);
}
elseif ($MsgRetour==3)
{
	echo '<span style="color:red;"><strong>Vous n\'avez pas le niveau de privilège suffisant pour cette opération</strong></span>';
}
?>				</p></font>

                    <label>Votre identifiant (votre email)</label>
                    <input class="form-control" type="email" name="identifiant" value="<?php echo isset($_SESSION['identifiant'])?$_SESSION['identifiant']:''; ?>" onkeypress="refuserToucheEntree(event);">
                    <label>Mot de passe</label>
                    <input class="form-control" type="password" name="motdepasse" value="<?php echo isset($_SESSION['motdepasse'])?$_SESSION['motdepasse']:''; ?>" onkeypress="refuserToucheEntree(event);">
                    <font color=#ccd9a6><p>.</p><p>.</p></font>

            </div>
        </div>
    </div>
    <div class="col-md-12 col-md-push-6">
        <button class="btn btn-primary" type="submit" name="envoi" value="Envoyer">Envoi </button>
    </div>
</form>
	<script src="fonctions_js.js" type="text/javascript"></script>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>