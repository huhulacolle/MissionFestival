<?php

// FONCTIONS DE CONNEXION

function connect()
{
 $hote="localhost";
   $login="root";
   $mdp="";

   return new PDO("mysql:host=$hote;dbname=FestivalM2L", $login, $mdp);
}

function utf8($connexion)
{
   return $connexion->exec("Set character set utf8");
}
// FONCTIONS DE GESTION DES ÉTABLISSEMENTS

function obtenirReqEtablissements()
{
   $req="select idEtablissement, nom,nombreChambresOffertes from Etablissement order by idEtablissement";
   return $req;
}

function obtenirReqEtablissementsOffrantChambres()
{
   $req="select idEtablissement, nom, nombreChambresOffertes from Etablissement where 
         nombreChambresOffertes!=0 order by idEtablissement";
   return $req;
}

function obtenirReqEtablissementsAyantChambresAttribuées()
{
   $req="select distinct idEtablissement, nom, nombreChambresOffertes from Etablissement, 
         Attribution where idEtablissement = idEtab order by idEtablissement";
   return $req;
}

function obtenirDetailEtablissement($connexion, $id)
{
   $req="select * from Etablissement where idEtablissement='$id'";
   $rsEtab=$connexion->query($req);
   return $rsEtab->fetch(PDO::FETCH_ASSOC);
}

function supprimerEtablissement($connexion, $id)
{
   $req="delete from Etablissement where idEtablissement='$id'";
   $connexion->exec($req);
}
 
function modifierEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, 
                               $ville, $tel, $adresseElectronique, $type, 
                               $civiliteResponsable, $nomResponsable, 
                               $prenomResponsable, $nombreChambresOffertes)
{  
   $nom=str_replace("'", "''", $nom);
   $adresseRue=str_replace("'","''", $adresseRue);
   $ville=str_replace("'","''", $ville);
   $adresseElectronique=str_replace("'","''", $adresseElectronique);
   $nomResponsable=str_replace("'","''", $nomResponsable);
   $prenomResponsable=str_replace("'","''", $prenomResponsable);
  
   $req="update Etablissement set nom='$nom',adresseRue='$adresseRue',
         codePostal='$codePostal',ville='$ville',tel='$tel',
         adresseElectronique='$adresseElectronique',type='$type',
         civiliteResponsable='$civiliteResponsable',nomResponsable=
         '$nomResponsable',prenomResponsable='$prenomResponsable',
         nombreChambresOffertes='$nombreChambresOffertes' where idEtablissement='$id'";
   
   $connexion->exec($req);
}

function creerEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, 
                            $ville, $tel, $adresseElectronique, $type, 
                            $civiliteResponsable, $nomResponsable, 
                            $prenomResponsable, $nombreChambresOffertes)
{ 
   $nom=str_replace("'", "''", $nom);
   $adresseRue=str_replace("'","''", $adresseRue);
   $ville=str_replace("'","''", $ville);
   $adresseElectronique=str_replace("'","''", $adresseElectronique);
   $nomResponsable=str_replace("'","''", $nomResponsable);
   $prenomResponsable=str_replace("'","''", $prenomResponsable);
   
   $req="insert into Etablissement values ('$id', '$nom', '$adresseRue', 
         '$codePostal', '$ville', '$tel', '$adresseElectronique', '$type', 
         '$civiliteResponsable', '$nomResponsable', '$prenomResponsable',
         '$nombreChambresOffertes')";
   
   $connexion->query($req);
}


function estUnIdEtablissement($connexion, $id)
{
   $req="select * from Etablissement where idEtablissement='$id'";
   $rsEtab=$connexion->query($req);
   return $rsEtab->fetch(PDO::FETCH_ASSOC);
}

function estUnNomEtablissement($connexion, $mode, $id, $nom)
{
   $nom=str_replace("'", "''", $nom);
   // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
   // on vérifie la non existence d'un autre établissement (id!='$id') portant 
   // le même nom
   if ($mode=='C')
   {
      $req="select * from Etablissement where nom='$nom'";
   }
   else
   {
      $req="select * from Etablissement where nom='$nom' and idEtablissement!='$id'";
   }
   $rsEtab=$connexion->query($req);
   return $rsEtab->fetch(PDO::FETCH_ASSOC);
}

function obtenirNbEtab($connexion)
{
   $req="select count(*) as nombreEtab from Etablissement";
   $rsEtab=$connexion->query($req);
   $lgEtab=$rsEtab->fetch(PDO::FETCH_ASSOC);
   return $lgEtab["nombreEtab"];
}

function obtenirNbEtabOffrantChambres($connexion)
{
   $req="select count(*) as nombreEtabOffrantChambres from Etablissement where 
         nombreChambresOffertes!=0";
   $rsEtabOffrantChambres=$connexion->query($req);
   $lgEtabOffrantChambres=$rsEtabOffrantChambres->fetch(PDO::FETCH_ASSOC);
   return $lgEtabOffrantChambres["nombreEtabOffrantChambres"];
}

// Retourne false si le nombre de chambres transmis est inférieur au nombre de 
// chambres occupées pour l'établissement transmis 
// Retourne true dans le cas contraire
function estModifOffreCorrecte($connexion, $idEtab, $nombreChambres)
{
   $nbOccup=obtenirNbOccup($connexion, $idEtab);
   return ($nombreChambres>=$nbOccup);
}

// FONCTIONS RELATIVES AUX GROUPES

function obtenirReqIdNomEquipeAHeberger()
{
   $req="select idE, nom from Equipe where hebergement='O' order by idE";
   return $req;
}

function obtenirNomEquipe($connexion, $id)
{
   $req="select nom from Equipe where idE='$id'";
   $rsEquipe=$connexion->query($req);
   $lgEquipe=$rsEquipe->fetch(PDO::FETCH_ASSOC);
   return $lgEquipe["nom"];
}

// FONCTIONS RELATIVES AUX ATTRIBUTIONS

// Teste la présence d'attributions pour l'établissement transmis    
function existeAttributionsEtab($connexion, $idEtablissement)
{
   $req="select * From Attribution where idEtab='$idEtablissement'";
   $rsAttrib=$connexion->query($req);
   return $rsAttrib->fetch(PDO::FETCH_ASSOC);
}

// Retourne le nombre de chambres occupées pour l'id étab transmis
function obtenirNbOccup($connexion, $idEtab)
{
   $req="select IFNULL(sum(nombreChambres), 0) as totalChambresOccup from
        Attribution where idEtab='$idEtab'";
   $rsOccup=$connexion->query($req);
   $lgOccup=$rsOccup->fetch(PDO::FETCH_ASSOC);
   return $lgOccup["totalChambresOccup"];
}

// Met à jour (suppression, modification ou ajout) l'attribution correspondant à
// l'id étab et à l'id groupe transmis
function modifierAttribChamb($connexion, $idEtab, $idEquipe, $nbChambres)
{
   $req="select count(*) as nombreAttribGroupe from Attribution where idEtab=
        '$idEtab' and idEquipe='$idEquipe'";
   $rsAttrib=$connexion->query($req);
   $lgAttrib=$rsAttrib->fetch(PDO::FETCH_ASSOC);
   if ($nbChambres==0)
      $req="delete from Attribution where idEtab='$idEtab' and idEquipe='$idEquipe'";
   else
   {
      if ($lgAttrib["nombreAttribGroupe"]!=0)
         $req="update Attribution set nombreChambres=$nbChambres where idEtab=
              '$idEtab' and idEquipe='$idEquipe'";
      else
         $req="insert into Attribution values('$idEtab','$idEquipe', $nbChambres)";
   }
   $connexion->exec($req);
}

// Retourne la requête permettant d'obtenir les id et noms des groupes affectés
// dans l'établissement transmis
function obtenirReqEquipesEtab($id)
{
   $req="select distinct idE, nom from Equipe, Attribution where 
        Attribution.idEquipe=Equipe.ide and idEtab='$id'";
   return $req;
}
            
// Retourne le nombre de chambres occupées par le groupe transmis pour l'id étab
// et l'id groupe transmis
function obtenirNbOccupEquipe($connexion, $idEtab, $idEquipe)
{
   $req="select nombreChambres From Attribution where idEtab='$idEtab'
        and idEquipe='$idEquipe'";
   $rsAttribEquipe=$connexion->query($req);
   if ($lgAttribEquipe=$rsAttribEquipe->fetch(PDO::FETCH_ASSOC))
      return $lgAttribEquipe["nombreChambres"];
   else
      return 0;
}

function obtenirNbOccupEtablissement($connexion, $idEtab)
{
   $req="select sum(nombreChambres) as reservations From Attribution where idEtab='$idEtab'";
   return $req;
}
?>

