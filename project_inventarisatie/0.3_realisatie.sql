-- 0.3: Realisatie.sql maken
CREATE TABLE auteur (
  id INT(11) AUTO_INCREMENT,
  voornaam VARCHAR(255) NOT NULL,
  tussenvoegsel VARCHAR(255),
  achternaam VARCHAR(255) NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  geboortedatum DATE NOT NULL, 
  wachtwoord VARCHAR(255) NOT NULL,
  omschrijving TEXT,

  PRIMARY KEY(id)
);

CREATE TABLE artikel (
  id INT(11) AUTO_INCREMENT,
  auteur_id INT(11),
  tag_id INT(11),
  titel VARCHAR(255) NOT NULL,
  afbeelding VARCHAR(255),
  uitleg TEXT NOT NULL,
  code_blok TEXT,
  datum_wijzig DATETIME DEFAULT CURRENT_TIMESTAMP,
  datum_creatie DATETIME,

  PRIMARY KEY (id),
  FOREIGN KEY (auteur_id) REFERENCES auteur(id),
  FOREIGN KEY (tag_id) REFERENCES tag(id)
);

CREATE TABLE tag (
  id INT(11) AUTO_INCREMENT,
  titel VARCHAR(255) NOT NULL,
    
  PRIMARY KEY(id)
);

CREATE TABLE artikel_tag (
  artikel_id INT(11) NOT NULL,
  tag_id INT(11) NOT NULL,
    
  FOREIGN KEY (artikel_id) REFERENCES artikel(id),
  FOREIGN KEY (tag_id) REFERENCES tag(id)
);

CREATE TABLE waardering (
  id INT(11) AUTO_INCREMENT,
  auteur_id INT(11) NOT NULL,
  artikel_id INT(11) NOT NULL,

  score INT(1) NOT NULL,
    
  PRIMARY KEY (id),
  FOREIGN KEY (auteur_id) REFERENCES auteur(id),
  FOREIGN KEY (artikel_id) REFERENCES artikel(id)
);