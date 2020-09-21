
USE FestivalM2L;

DROP TABLE IF EXISTS `Attribution`;
DROP TABLE IF EXISTS `Equipe`;
DROP TABLE IF EXISTS `Etablissement`;
DROP TABLE IF EXISTS `Sport`;
 
create table Etablissement 
(idEtablissement char(8) not null, 
nom varchar(45) not null,
adresseRue varchar(45) not null, 
codePostal char(5) not null, 
ville varchar(35) not null,
tel varchar(13) not null,
adresseElectronique varchar(70),
typeEtab integer(1) not null,
civiliteResponsable varchar(12) not null,
nomResponsable varchar(25) not null,
prenomResponsable varchar(25),
nombreChambresOffertes integer,
constraint pk_Etablissement primary key(idEtablissement))
ENGINE=INNODB;

create table Sport
(idSport integer(2) not null,
libelleSport varchar(45) not null,
constraint pk_Sport primary key(idSport))
ENGINE=INNODB;

create table Equipe
(idE char(4) not null, 
nom varchar(40) not null, 
identiteResponsable varchar(40) default null,
adressePostale varchar(120) default null,
nombrePersonnes integer not null, 
nomPays varchar(40) not null, 
hebergement char(1) not null, 
numSport integer(2) not null,
constraint pk_Equipe primary key(idE),
constraint fk_Equipe foreign key(numSport) references Sport(idSport))
ENGINE=INNODB;

create table Attribution
(idEtab char(8) not null, 
idEquipe char(4) not null, 
nombreChambres integer not null,
constraint pk_Attribution primary key(idEtab, idEquipe), 
constraint fk1_Attribution foreign key(idEtab) references Etablissement(idEtablissement),
constraint fk2_Attribution foreign key(idEquipe) references Equipe(idE)) 
ENGINE=INNODB;
