<title>Acceuil > Gestion établissements > Suppression établissements</title>
<?php

include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

// CONNEXION AU SERVEUR MYSQL PUIS SÉLECTION DE LA BASE DE DONNÉES festival

$connexion=connect();
$ut8=utf8($connexion);
// SUPPRIMER UN ÉTABLISSEMENT 

$id=$_REQUEST['idEtablissement'];  

$lgEtab=obtenirDetailEtablissement($connexion, $id);
$nom=$lgEtab['nom'];

echo '<center> <a href="index.php">Acceuil</a> > <a href="listeEtablissements.php">Gestion établissements</a> > <a href="suppressionEtablissement.php?action=demanderSupprEtab&idEtablissement='.$id.'">Suppression établissements</a> </center> <br>';

// Cas 1ère étape (on vient de listeEtablissements.php)

if ($_REQUEST['action']=='demanderSupprEtab')    
{
   echo "
   <br><center><h5>Souhaitez-vous vraiment supprimer l'établissement $nom ? 
   <br><br>
   <a href='suppressionEtablissement.php?action=validerSupprEtab&amp;idEtablissement=$id'>
   Oui</a>&nbsp; &nbsp; &nbsp; &nbsp;
   <a href='listeEtablissements.php?'>Non</a></h5></center>";
}

// Cas 2ème étape (on vient de suppressionEtablissement.php)

else
{
   supprimerEtablissement($connexion, $id);
   echo '<meta http-equiv="refresh" content="0 ; URL=listeEtablissements.php">';
}

?>
