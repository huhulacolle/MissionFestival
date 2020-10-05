<?php

include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

// CONNEXION AU SERVEUR MYSQL PUIS SÉLECTION DE LA BASE DE DONNÉES festival

$connexion=connect();
$ut8=utf8($connexion);
if (!$connexion)
{
   ajouterErreur("Echec de la connexion au serveur MySql");
   afficherErreurs();
   exit();
}

// CONSULTER LES ATTRIBUTIONS DE TOUS LES ÉTABLISSEMENTS

// IL FAUT QU'IL Y AIT AU MOINS UN ÉTABLISSEMENT OFFRANT DES CHAMBRES POUR  
// AFFICHER LE LIEN VERS LA MODIFICATION
$nbEtab=obtenirNbEtabOffrantChambres($connexion);
if ($nbEtab!=0)
{
   echo "
   <table width='30%' cellspacing='0' cellpadding='0' align='right'
   <tr><td>
   <a href='modificationAttributions.php?action=demanderModifAttrib'>
   Effectuer ou modifier les attributions</a></td></tr></table><br><br><br>";
   
   // POUR CHAQUE ÉTABLISSEMENT : AFFICHAGE D'UN TABLEAU COMPORTANT 2 LIGNES 
   // D'EN-TÊTE ET LE DÉTAIL DES ATTRIBUTIONS
   $req=obtenirReqEtablissementsAyantChambresAttribuées();
   $rsEtab=$connexion->query($req);
   $lgEtab=$rsEtab->fetch(PDO::FETCH_ASSOC);
   // BOUCLE SUR LES ÉTABLISSEMENTS AYANT DÉJÀ DES CHAMBRES ATTRIBUÉES
   while($lgEtab!=FALSE)
   {
      $idEtab=$lgEtab['idEtablissement'];
      $nomEtab=$lgEtab['nom'];
      
      echo "
      <div class='mx-auto' style='width: 700px;'>
      <table class='table table-bordered' width='60%' cellspacing='0' cellpadding='0' align='center' 
      class='tabQuadrille'>";
      
      $nbOffre=$lgEtab["nombreChambresOffertes"];
      $nbOccup=obtenirNbOccup($connexion, $idEtab);
      // Calcul du nombre de chambres libres dans l'établissement
      $nbChLib = $nbOffre - $nbOccup;
      
      // AFFICHAGE DE LA 1ÈRE LIGNE D'EN-TÊTE 
      echo "
      <tr class='enTeteTabQuad'>
         <td colspan='2' align='center'><strong>$nomEtab</strong>&nbsp;
         (Offre : $nbOffre&nbsp;&nbsp;Disponibilités : $nbChLib)
         </td>
      </tr>";
          
      // AFFICHAGE DE LA 2ÈME LIGNE D'EN-TÊTE 
      echo "
      <tr class='ligneTabQuad'>
         <td width='65%' align='left'><i><strong>Nom Equipe</strong></i></td>
         <td width='35%' align='left'><i><strong>Chambres attribuées</strong></i>
         </td>
      </tr>";
        
      // AFFICHAGE DU DÉTAIL DES ATTRIBUTIONS : UNE LIGNE PAR GROUPE AFFECTÉ 
      // DANS L'ÉTABLISSEMENT       
      $req=obtenirReqEquipesEtab($idEtab);
      $rsEquipe=$connexion->query($req);
      $lgEquipe=$rsEquipe->fetch(PDO::FETCH_ASSOC);
               
      // BOUCLE SUR LES GROUPES (CHAQUE GROUPE EST AFFICHÉ EN LIGNE)
      while($lgEquipe!=FALSE)
      {
         $idEquipe=$lgEquipe['idE'];
         $nomEquipe=$lgEquipe['nom'];
         echo "
         <tr class='ligneTabQuad'>
            <td width='65%' align='left'>$nomEquipe</td>";
         // On recherche si des chambres ont déjà été attribuées à ce groupe
         // dans l'établissement
         $nbOccupEquipe=obtenirNbOccupEquipe($connexion, $idEtab, $idEquipe);
         echo "
            <td width='35%' align='left'>$nbOccupEquipe</td>
         </tr>" ;
         $lgEquipe=$rsEquipe->fetch(PDO::FETCH_ASSOC);
      } // Fin de la boucle sur les groupes
      
      echo "
      </table><br><br>";
      $lgEtab=$rsEtab->fetch(PDO::FETCH_ASSOC);
   } // Fin de la boucle sur les établissements
}

?>
