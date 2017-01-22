<?php
	session_start();
	require 'inc_ouvre_base.php';
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
	<div class="container">
		<div class="col-md-12">
		<p align="center"><img src="assets/img/GIDventesAdmin.png" width="920"></p>
		<p></p>
		</div>
		<p align="right"><a href="f3_gestion_cpte_client.php" ><img src="assets/img/MaisonPeVert.png" ></a></p>
		<table  align="center" style="width:30%">
<?php
    //requête SQL pour lister tous les clients/fournisseurs
    $sql = "SELECT * FROM t0_comptesclientsfournisseurs ORDER BY NomClFourn" ;
    $requete = $bdd->query($sql) ;
	while ($donnees = $requete->fetch())
    {
       echo(
           "<tr class=\"tdthbord\" align=\"left\"><td class=\"tdthbord\">"
           .htmlspecialchars($donnees['NomClFourn']) ." ".htmlspecialchars($donnees['PrenomClFourn'])
           ."</td><td class=\"tdthbord\"> <a href=\"F3_3_2_supprcpte.php?idPersonne=".$donnees['NumClFourn']."\">supprimer</a></td></tr>"
       ) ;
    }
?>
		</table>
	</div>
</body>
</html>
