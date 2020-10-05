<title>Acceuil > Attribution chambres > Nombres de chambres</title>
<?php

include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

// CONNEXION AU SERVEUR MYSQL PUIS SÉLECTION DE LA BASE DE DONNÉES festival

$connexion=connect();
$ut8=utf8($connexion);
// SÉLECTIONNER LE NOMBRE DE CHAMBRES SOUHAITÉES

$idEtab=$_REQUEST['idEtab'];
$idEquipe=$_REQUEST['idEquipe'];
$nbChambres=$_REQUEST['nbChambres'];

echo "
<form method='POST' action='modificationAttributions.php'>
	<input type='hidden' value='validerModifAttrib' name='action'>
   <input type='hidden' value='$idEtab' name='idEtab'>
   <input type='hidden' value='$idEquipe' name='idEquipe'>";
   $nomEquipe=obtenirNomEquipe($connexion, $idEquipe);
   
   echo "
   <br><center><h5>Combien de chambres souhaitez-vous pour le 
   groupe $nomEquipe dans cet établissement ?";
   
   echo "&nbsp;<select name='nbChambres'>";
   for ($i=0; $i<=$nbChambres; $i++)
   {
      echo "<option>$i</option>";
   }
   echo "
   </select></h5>
   <button type='submit'  class='btn btn-success mb-2' onclick='window.location.reload(false)' value='Rafraichir'/>Valider</button>&nbsp&nbsp&nbsp&nbsp
   <a href='modificationAttributions.php?action=demanderModifAttrib' class='btn btn-danger mb-2' role='button'>Annuler</a>
   </center>
</form>";

?>
