<title>Acceuil > Gestion établissements > Détail des établissements</title> 
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
$idEtablissement=$_REQUEST['idEtablissement'];  

// OBTENIR LE DÉTAIL DE L'ÉTABLISSEMENT SÉLECTIONNÉ

$lgEtab=obtenirDetailEtablissement($connexion, $idEtablissement);

$nom=$lgEtab['nom'];
$adresseRue=$lgEtab['adresseRue'];
$codePostal=$lgEtab['codePostal'];
$ville=$lgEtab['ville'];
$tel=$lgEtab['tel'];
$adresseElectronique=$lgEtab['adresseElectronique'];
$type=$lgEtab['type'];
$civiliteResponsable=$lgEtab['civiliteResponsable'];
$nomResponsable=$lgEtab['nomResponsable'];
$prenomResponsable=$lgEtab['prenomResponsable'];
$nombreChambresOffertes=$lgEtab['nombreChambresOffertes'];
?>
<center> <a href="index.php">Acceuil</a> > <a href="listeEtablissements.php">Gestion établissements</a> > <a href="detailEtablissement.php?idEtablissement=<?php echo $idEtablissement ?>">Détail des établissements</a> </center> <br>
<center>
    <h2> <?php echo $nom; ?> </h2>
</center>
<div class="mx-auto" style="width: 700px;">
    <table class="table table-hover">
        <tr>
            <td> id : </td>
            <td></td>
            <td> <?php echo $idEtablissement; ?> </td>
        </tr>
        <tr>
            <td> adresse : </td>
            <td></td>
            <td> <?php echo $adresseRue; ?> </td>
        </tr>
        <tr>
            <td> Code Postal : </td>
            <td></td>
            <td> <?php echo $codePostal; ?> </td>
        </tr>
        <tr>
            <td> Ville : </td>
            <td></td>
            <td> <?php echo $ville; ?> </td>
        </tr>
        <tr>
            <td> Téléphone : </td>
            <td></td>
            <td> <?php echo $tel; ?> </td>
        </tr>
        <tr>
            <td>E-Mail : </td>
            <td></td>
            <td> <?php echo $adresseElectronique; ?> </td>
        </tr>
        <tr>
            <td> Type : </td>
            <td></td>
            <td> 
            <?php
                if ($type == 1) {
                    echo "Etablissement Scolaire";
                }
                else {
                    echo "Autre";
                }
            ?> </td>
        </tr>
        <tr>
            <td> Responsable : </td>
            <td></td>
            <td> <?php echo $nomResponsable; ?> </td>
        </tr>
        <tr>
            <td> Offre : </td>
            <td></td>
            <td> <?php echo $nombreChambresOffertes; ?> </td>
        </tr>
    </table>
    <?php
// echo "
// <table width='60%' cellspacing='0' cellpadding='0' align='center' 
// class='tabNonQuadrille'>
   
//    <tr class='enTeteTabNonQuad'>
//       <td colspan='3'>$nom</td>
//    </tr>
//    <tr class='ligneTabNonQuad'>
//       <td  width='20%'> Id: </td>
//       <td>$idEtablissement</td>
//    </tr>
//    <tr class='ligneTabNonQuad'>
//       <td> Adresse: </td>
//       <td>$adresseRue</td>
//    </tr>
//    <tr class='ligneTabNonQuad'>
//       <td> Code postal: </td>
//       <td>$codePostal</td>
//    </tr>
//    <tr class='ligneTabNonQuad'>
//       <td> Ville: </td>
//       <td>$ville</td>
//    </tr>
//    <tr class='ligneTabNonQuad'>
//       <td> Téléphone: </td>
//       <td>$tel</td>
//    </tr>
//    <tr class='ligneTabNonQuad'>
//       <td> E-mail: </td>
//       <td>$adresseElectronique</td>
//    </tr>
//    <tr class='ligneTabNonQuad'>
//       <td> Type: </td>";
//       if ($type==1)
//       {
//          echo "<td> Etablissement scolaire </td>";
//       }
//       else
//       {
//          echo "<td> Autre établissement </td>";
//       }
//    echo "
//    </tr>
//    <tr class='ligneTabNonQuad'>
//       <td> Responsable: </td>
//       <td>$civiliteResponsable&nbsp; $nomResponsable&nbsp; $prenomResponsable
//       </td>
//    </tr> 
//    <tr class='ligneTabNonQuad'>
//       <td> Offre: </td>
//       <td>$nombreChambresOffertes&nbsp;chambre(s)</td>
//    </tr>
// </table>
// <table align='center'>
//    <tr>
//       <td align='center'><a href='listeEtablissements.php'>Retour</a>
//       </td>
//    </tr>
// </table>";
?>