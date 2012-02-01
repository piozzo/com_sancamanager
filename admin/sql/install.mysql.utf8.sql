DROP TABLE IF EXISTS `#__sm`;
DROP TABLE IF EXISTS `#__sm_squadre`;
DROP TABLE IF EXISTS `#__sm_cat_squadre`;
DROP TABLE IF EXISTS `#__sm_ruoli`;
DROP TABLE IF EXISTS `#__sm_persone`;
DROP TABLE IF EXISTS `#__sm_stagioni_sportive`;
DROP TABLE IF EXISTS `#__sm_tornei`;
DROP TABLE IF EXISTS `#__sm_squadre_tornei`;
DROP TABLE IF EXISTS `#__sm_giornate`;
DROP TABLE IF EXISTS `#__sm_incontri`;
DROP TABLE IF EXISTS `#__sm_permessi_utenti`;
DROP TABLE IF EXISTS `#__sm_articoli_gare`;
DROP TABLE IF EXISTS `#__sm_assoc_articoli_match`;
DROP TABLE IF EXISTS `#__sm_diritti_aggiornamento_campionati`;
DROP TABLE IF EXISTS `#__sm_diritti_articoli_gare`;

 
CREATE TABLE `#__sm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `greeting` varchar(25) NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '0',
  `params` TEXT NOT NULL DEFAULT '',
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE  TABLE `#__sm_squadre` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `id_categoria_sportiva` INT NOT NULL DEFAULT '0',
  `id_stagione` INT NOT NULL DEFAULT '0' ,
  `url_foto` VARCHAR(45) NOT NULL DEFAULT '' ,
  `descrizione` VARCHAR(45) NOT NULL DEFAULT '' ,
  `ids_persone` VARCHAR(80) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE  TABLE `#__sm_cat_squadre` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `descrizione` VARCHAR(45) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE  TABLE `#__sm_ruoli` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `descrizione` VARCHAR(45) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE  TABLE `#__sm_persone` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL DEFAULT '',
  `cognome` VARCHAR(45) NOT NULL DEFAULT '',
  `data_di_nascita` VARCHAR(45) NOT NULL DEFAULT '',
  `id_ruolo` INT NOT NULL DEFAULT '0',
  `def_img` VARCHAR(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE  TABLE `#__sm_stagioni_sportive` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `descrizione` VARCHAR(45) NOT NULL DEFAULT '',
  `stagione_corrente` BOOLEAN NOT NULL DEFAULT '0',
  `ids_persone` VARCHAR(45) NOT NULL DEFAULT '',
  `anno` VARCHAR(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) 
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE  TABLE `#__sm_tornei` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `descrizione` VARCHAR(90) NOT NULL DEFAULT '' ,
  `id_categoria_sportiva` INT NOT NULL DEFAULT 0 ,
  `id_stagione_sportiva` INT NOT NULL DEFAULT 0 ,
  `ids_squadre` VARCHAR(90) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE  TABLE `#__sm_squadre_tornei` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL DEFAULT '' ,
  `citta` VARCHAR(45) NOT NULL DEFAULT '' ,
  `descrizione` VARCHAR(45) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`) 
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE  TABLE `#__sm_giornate` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL DEFAULT '' ,
  `id_torneo` INT NOT NULL DEFAULT 0 ,
  `data` VARCHAR(45) NOT NULL DEFAULT '' ,
  `ora` VARCHAR(45) NOT NULL DEFAULT '' ,
  `descrizione` VARCHAR(45) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`) 
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE  TABLE `#__sm_incontri` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `id_giornata` INT NOT NULL DEFAULT 0 ,
  `data` VARCHAR(45) NOT NULL DEFAULT '' ,
  `ora` VARCHAR(45) NOT NULL DEFAULT '' ,
  `luogo` VARCHAR(45) NOT NULL DEFAULT '' ,
  `id_squadra1` INT NOT NULL DEFAULT 0 ,
  `id_squadra2` INT NOT NULL DEFAULT 0 ,
  `reti_squadra1` INT DEFAULT NULL ,
  `reti_squadra2` INT DEFAULT NULL ,
  PRIMARY KEY (`id`) 
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE  TABLE `#__sm_permessi_utenti` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `id_utente` INT NOT NULL DEFAULT 0 ,
  `ids_tornei` INT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `jos_sm_articoli_gare` (
  `ID` int(11) NOT NULL auto_increment,
  `id_gara` int(11) default NULL,
  `idut_creazione` int(5) default NULL,
  `idut_modifica` int(5) default NULL,
  `timestamp_creazione` timestamp NULL default NULL,
  `timestamp_modifica` timestamp NULL default NULL,
  `testo_articolo` text,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `jos_sm_assoc_articoli_match` (
  `id_articolo` int(11) NOT NULL,
  `id_match` int(11) NOT NULL,
  PRIMARY KEY  (`id_articolo`,`id_match`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `jos_sm_diritti_aggiornamento_campionati` (
  `id_utente` int(11) NOT NULL default '0',
  `id_campionato` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_utente`,`id_campionato`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `jos_sm_diritti_articoli_gare` (
  `id_utente` int(11) NOT NULL,
  `id_campionato` int(11) NOT NULL,
  PRIMARY KEY  (`id_utente`,`id_campionato`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;