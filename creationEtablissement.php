<?php

include "_debut.inc.php";
include "_gestionBase.inc.php";
include "_controlesEtGestionErreurs.inc.php";

// CONNEXION AU SERVEUR MYSQL PUIS SÉLECTION DE LA BASE DE DONNÉES festival

$connexion = connect();
$ut8=utf8($connexion);
// CRÉER UN ÉTABLISSEMENT

// Déclaration du tableau des civilités
$tabCivilite = array("M.", "Mme", "Melle");

$action = $_REQUEST['action'];

// S'il s'agit d'une création et qu'on ne "vient" pas de ce formulaire (on
// "vient" de ce formulaire uniquement s'il y avait une erreur), il faut définir
// les champs à vide sinon on affichera les valeurs précédemment saisies
if ($action == 'demanderCreEtab') {
    $id = '';
    $nom = '';
    $adresseRue = '';
    $ville = '';
    $codePostal = '';
    $tel = '';
    $adresseElectronique = '';
    $type = 0;
    $civiliteResponsable = 'Monsieur';
    $nomResponsable = '';
    $prenomResponsable = '';
    $nombreChambresOffertes = '';
} else {
    $id = $_REQUEST['id'];
    $nom = $_REQUEST['nom'];
    $adresseRue = $_REQUEST['adresseRue'];
    $codePostal = $_REQUEST['codePostal'];
    $ville = $_REQUEST['ville'];
    $tel = $_REQUEST['tel'];
    $adresseElectronique = $_REQUEST['adresseElectronique'];
    $type = $_REQUEST['type'];
    $civiliteResponsable = $_REQUEST['civiliteResponsable'];
    $nomResponsable = $_REQUEST['nomResponsable'];
    $prenomResponsable = $_REQUEST['prenomResponsable'];
    $nombreChambresOffertes = $_REQUEST['nombreChambresOffertes'];

    verifierDonneesEtabC($connexion, $id, $nom, $adresseRue, $codePostal, $ville,
        $tel, $nomResponsable, $nombreChambresOffertes);
    if (nbErreurs() == 0) {
        creerEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, $ville,
            $tel, $adresseElectronique, $type, $civiliteResponsable,
            $nomResponsable, $prenomResponsable, $nombreChambresOffertes);
    }
}
?>

<form method='POST' action='creationEtablissement.php?'>
    <input type='hidden' value='validerCreEtab' name='action'>
    <center>
        <h4> Nouvel Etablissement </h4>
    </center>
    <?php
$nb = '0123456789';
$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$id = '035';
for ($i = 0; $i < 4; $i++) {
    $id .= $nb[rand(0, strlen($nb) - 1)];
}
$id[7] = $chars[rand(0, strlen($chars) - 1)];
?>
    <div class="mx-auto" style="width: 800px;">
        <table class="table table-hover">
            <tr>
                <td> id : <input type='text' class="form-control" name='id' <?php echo "value='" . $id . "'" ?> size='1'
                        maxlength='8' readonly>
                    <br>
                </td>
                <td>
                <td></td>
                </td>
            </tr>
            <tr>
                <td>Nom : <input type="text" class="form-control" name="nom" maxlength="45" required></td>
                <td>Adresse :<input type="text" class="form-control" name="adresseRue" maxlength="45" required></td>
                <td>Code Postal :<input type="number" class="form-control" name="codePostal"
                        onKeyDown="if(this.value.length==5 && event.keyCode!=8) return false;"></td>
            </tr>
            <tr>
                <td>Ville :<input type="text" class="form-control" name="ville" maxlength="35" required></td>
                <td>Téléphone :<input type="tel" class="form-control" name="tel" maxlength="10" required></td>
                <td>E-mail (non obligatoire) :<input type="email" class="form-control" name="adresseElectronique"
                        maxlength="70"></td>
            </tr>
            <tr>
                <br> <br>
                <td> <br> <strong> Type: </strong> </td>

                <td> <br> <input type='radio' name='type' value='1' checked> Etablissement Scolaire </td>
                <td> <br> <input type='radio' name='type' value='0'> autre </td>
            </tr>

            </td>
            </tr>
            <tr>
                <td> <br> <br> <strong>Responsable :</strong></td>
                </select>
                <td> <br> Nom : <input type="text" class="form-control" name="nomResponsable" size="26" maxlength="25">
                </td>
                <td> <br> Prénom : <input type="text" class="form-control" name="prenomResponsable" size="26"
                        maxlength="25"> </td>
            </tr>
            <tr>
                <td></td>
                <td> <br> Civilité :
                    <select class="form-control" name='civiliteResponsable'>
                        <?php
                    for ($i = 0; $i < 3; $i = $i + 1) {
                    if ($tabCivilite[$i] == $civiliteResponsable) {
                        echo "<option>".$tabCivilite[$i]."</option>";
                    } else {
                        echo "<option>".$tabCivilite[$i]."</option>";
                        }
                    }

                    ?>
                </td>
                <td> <br> Nombre chambres offertes :<input type="number" class="form-control"
                        name="nombreChambresOffertes" size="1"
                        onKeyDown="if(this.value.length==3 && event.keyCode!=8) return false;"></td>

            </tr>
        </table>
    </div>
    <div class="mx-auto" style="width: 1000px;">
        <table class="table table-borderless">
            <thead>
                <tr class='ligneTabNonQuad'>
                    <td width='85%'></td>
                    <td><button type="submit" value="Valider" class="btn btn-primary mb-2">Valider</button></td>
                </tr>
        </table>
    </div>
    <?php

// En cas de validation du formulaire : affichage des erreurs ou du message de
// confirmation
if ($action=='validerCreEtab')
{
   if (nbErreurs()!=0)
   {
      afficherErreurs();
   }
   else
   {
      echo '<meta http-equiv="refresh" content="0 ; URL=listeEtablissements.php">';
   }
}

?>