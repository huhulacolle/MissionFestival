<?php

include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

// CONNEXION AU SERVEUR MYSQL PUIS SÉLECTION DE LA BASE DE DONNÉES festival
$connexion=connect();
$ut8=utf8($connexion);
if (!$connexion)
{
   $AjoutErreur=ajouterErreur("Echec de la connexion au serveur MySql");
   afficherErreurs();
   exit();
}


// AFFICHER L'ENSEMBLE DES ÉTABLISSEMENTS
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// ÉTABLISSEMENT


?>
<div class="mx-auto" style="width: 900px;">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td colspan='4'>Etablissements</td>
            </tr>
            <?php
       $req=obtenirReqEtablissements();
   $rsEtab=$connexion->query($req);
   $lgEtab=$rsEtab->fetch(PDO::FETCH_ASSOC);
   // BOUCLE SUR LES ÉTABLISSEMENTS
   while ($lgEtab!=FALSE)
   {
      $idEtablissement=$lgEtab['idEtablissement'];
      $nom=$lgEtab['nom'];
      echo"
      <tr class='ligneTabNonQuad'>
         <td width='44%'>$nom</td>
         
         <td width='16%' align='center'> 
         <a href='detailEtablissement.php?idEtablissement=$idEtablissement'>
         Voir détail</a></td>
         
         <td width='16%' align='center'> 
         <a href='modificationEtablissement.php?action=demanderModifEtab&amp;idEtablissement=$idEtablissement'>
         Modifier</a></td>";
      	
         // S'il existe déjà des attributions pour l'établissement, il faudra
         // d'abord les supprimer avant de pouvoir supprimer l'établissement
			if (!existeAttributionsEtab($connexion, $idEtablissement))
			{
            echo "
            <td width='16%' align='center'> 
            <a href='suppressionEtablissement.php?action=demanderSupprEtab&amp;idEtablissement=$idEtablissement'>
            Supprimer</a></td>";
         }
         else
         {
            $occ=obtenirNbOccupEtablissement($connexion, $lgEtab['idEtablissement']);
            $occ=$connexion->query($occ);
            $occ=$occ->fetch(PDO::FETCH_ASSOC);
            $nboccupLibres = $lgEtab['nombreChambresOffertes'] - $occ['reservations'] ;
            echo "
            <td width='20%' align='center'> 
            Chambres libres : $nboccupLibres</td>";          
			}
      $lgEtab=$rsEtab->fetch(PDO::FETCH_ASSOC);
   }   
   echo "

";
?>
</div>
</table>
<div class="mx-auto" style="width: 1200px;">
    <table class="table table-borderless">
        <thead>
            <tr class='ligneTabNonQuad'>
                <td width='70%'></td>

                <td colspan='4'><a href='creationEtablissement.php?action=demanderCreEtab'>
                        Création d'un établissement</a></td>
            </tr>
    </table>
</div>

<?php

// echo "
// <table width='70%' cellspacing='0' cellpadding='0' align='center' 
// class='tabNonQuadrille'>
//    <tr class='enTeteTabNonQuad'>
//       <td colspan='4'>Etablissements</td>
//    </tr>";
     
//    $req=obtenirReqEtablissements();
//    $rsEtab=mysqli_query( $connexion,$req);
//    $lgEtab=mysqli_fetch_array($rsEtab);
//    // BOUCLE SUR LES ÉTABLISSEMENTS
//    while ($lgEtab!=FALSE)
//    {
//       $idEtablissement=$lgEtab['idEtablissement'];
//       $nom=$lgEtab['nom'];
//       echo $nom;
//       echo"
// 		<tr class='ligneTabNonQuad'>
//          <td width='52%'>$nom</td>
         
//          <td width='16%' align='center'> 
//          <a href='detailEtablissement.php?idEtablissement=$idEtablissement'>
//          Voir détail</a></td>
         
//          <td width='16%' align='center'> 
//          <a href='modificationEtablissement.php?action=demanderModifEtab&amp;idEtablissement=$idEtablissement'>
//          Modifier</a></td>";
      	
//          // S'il existe déjà des attributions pour l'établissement, il faudra
//          // d'abord les supprimer avant de pouvoir supprimer l'établissement
// 			if (!existeAttributionsEtab($connexion, $idEtablissement))
// 			{
//             echo "
//             <td width='16%' align='center'> 
//             <a href='suppressionEtablissement.php?action=demanderSupprEtab&amp;idEtablissement=$idEtablissement'>
//             Supprimer</a></td>";
//          }
//          else
//          {
//             echo "
//             <td width='16%'>&nbsp; </td>";          
// 			}
// 			echo "
//       </tr>";
//       $lgEtab=mysqli_fetch_array($rsEtab);
//    }   
//    echo "
//    <tr class='ligneTabNonQuad'>
//       <td colspan='4'><a href='creationEtablissement.php?action=demanderCreEtab'>
//       Création d'un établissement</a ></td>
//   </tr>
// </table>";

 ?>