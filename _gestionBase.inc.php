<?php

// FONCTIONS DE CONNEXION

function connect()
{
 $hote="localhost";
   $login="root";
   $mdp="";
   return mysqli_connect($hote, $login, $mdp);
}
function selectBase($connexion)
{
   $bd="FestivalM2L";
   $query="SET CHARACTER SET utf8";
   // Modification du jeu de caractères de la connexion
   $res=mysqli_query($connexion, $query); 
   $ok=mysqli_select_db( $connexion, $bd);
   return $ok;
}

// FONCTIONS DE GESTION DES ÉTABLISSEMENTS

function obtenirReqEtablissements()
{
   $req="select idEtablissement, nom from Etablissement order by idEtablissement";
   return $req;
}

function obtenirReqEtablissementsOffrantChambres()
{
   $req="select idEtablissement, nom, nombreChambresOffertes from Etablissement where 
         nombreChambresOffertes!=0 order by id";
   return $req;
}

function obtenirReqEtablissementsAyantChambresAttribuées()
{
   $req="select distinct idEtablissement, nom, nombreChambresOffertes from Etablissement, 
         Attribution where id = idEtab order by id";
   return $req;
}

function obtenirDetailEtablissement($connexion, $id)
{
   $req="select * from Etablissement where idEtablissement='$id'";
   $rsEtab=mysql_query($req, $connexion);
   return mysql_fetch_array($rsEtab);
}

function supprimerEtablissement($connexion, $id)
{
   $req="delete from Etablissement where idEtablissement='$id'";
   mysql_query($req, $connexion);
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
   
   mysql_query($req, $connexion);
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
   
   mysql_query($req, $connexion);
}


function estUnIdEtablissement($connexion, $id)
{
   $req="select * from Etablissement where id='$id'";
   $rsEtab=mysql_query($req, $connexion);
   return mysql_fetch_array($rsEtab);
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
   $rsEtab=mysql_query($req, $connexion);
   return mysql_fetch_array($rsEtab);
}

function obtenirNbEtab($connexion)
{
   $req="select count(*) as nombreEtab from Etablissement";
   $rsEtab=mysql_query($req, $connexion);
   $lgEtab=mysql_fetch_array($rsEtab);
   return $lgEtab["nombreEtab"];
}

function obtenirNbEtabOffrantChambres($connexion)
{
   $req="select count(*) as nombreEtabOffrantChambres from Etablissement where 
         nombreChambresOffertes!=0";
   $rsEtabOffrantChambres=mysql_query($req, $connexion);
   $lgEtabOffrantChambres=mysql_fetch_array($rsEtabOffrantChambres);
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

function obtenirReqIdNomGroupesAHeberger()
{
   $req="select idE, nom from Equipe where hebergement='O' order by idE";
   return $req;
}

function obtenirNomGroupe($connexion, $id)
{
   $req="select nom from Equipe where idE='$id'";
   $rsGroupe=mysql_query($req, $connexion);
   $lgGroupe=mysql_fetch_array($rsGroupe);
   return $lgGroupe["nom"];
}

// FONCTIONS RELATIVES AUX ATTRIBUTIONS

// Teste la présence d'attributions pour l'établissement transmis    
function existeAttributionsEtab($connexion, $id)
{
   $req="select * From Attribution where idEtab='$id'";
   $rsAttrib=mysql_query($req, $connexion);
   return mysql_fetch_array($rsAttrib);
}

// Retourne le nombre de chambres occupées pour l'id étab transmis
function obtenirNbOccup($connexion, $idEtab)
{
   $req="select IFNULL(sum(nombreChambres), 0) as totalChambresOccup from
        Attribution where idEtab='$idEtab'";
   $rsOccup=mysql_query($req, $connexion);
   $lgOccup=mysql_fetch_array($rsOccup);
   return $lgOccup["totalChambresOccup"];
}

// Met à jour (suppression, modification ou ajout) l'attribution correspondant à
// l'id étab et à l'id groupe transmis
function modifierAttribChamb($connexion, $idEtab, $idEquipe, $nbChambres)
{
   $req="select count(*) as nombreAttribGroupe from Attribution where idEtab=
        '$idEtab' and idGroupe='$idGroupe'";
   $rsAttrib=mysql_query($req, $connexion);
   $lgAttrib=mysql_fetch_array($rsAttrib);
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
   mysql_query($req, $connexion);
}

// Retourne la requête permettant d'obtenir les id et noms des groupes affectés
// dans l'établissement transmis
function obtenirReqGroupesEtab($id)
{
   $req="select distinct idE, nom from Equipe, Attribution where 
        Attribution.idEquipe=Equipe.ide and idEtab='$id'";
   return $req;
}
            
// Retourne le nombre de chambres occupées par le groupe transmis pour l'id étab
// et l'id groupe transmis
function obtenirNbOccupGroupe($connexion, $idEtab, $idEquipe)
{
   $req="select nombreChambres From Attribution where idEtab='$idEtab'
        and idE='$idEquipe'";
   $rsAttribGroupe=mysql_query($req, $connexion);
   if ($lgAttribGroupe=mysql_fetch_array($rsAttribGroupe))
      return $lgAttribGroupe["nombreChambres"];
   else
      return 0;
}

?>
