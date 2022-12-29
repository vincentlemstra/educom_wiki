-- 0.3: Realisatie.sql maken
CREATE TABLE author (
  id INT(11) AUTO_INCREMENT,
  firstname VARCHAR(255) NOT NULL,
  preposition VARCHAR(255),
  lastname VARCHAR(255) NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  date_birth DATE NOT NULL, 
  password VARCHAR(255) NOT NULL,
  description TEXT,

  PRIMARY KEY(id)
);

CREATE TABLE article (
  id INT(11) AUTO_INCREMENT,
  author_id INT(11),
  title VARCHAR(255) NOT NULL,
  img VARCHAR(255),
  explanation TEXT NOT NULL,
  code_block TEXT,
  date_edit DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_create DATETIME,

  PRIMARY KEY (id),
  FOREIGN KEY (author_id) REFERENCES author(id)
);

CREATE TABLE tag (
  id INT(11) AUTO_INCREMENT,
  tagname VARCHAR(255) NOT NULL,
    
  PRIMARY KEY(id)
);

CREATE TABLE article_tag (
  article_id INT(11) NOT NULL,
  tag_id INT(11) NOT NULL,
    
  CONSTRAINT article_tag_pk PRIMARY KEY (article_id, tag_id),
  FOREIGN KEY (article_id) REFERENCES article(id),
  FOREIGN KEY (tag_id) REFERENCES tag(id)
);

CREATE TABLE rating (
  author_id INT(11) NOT NULL,
  article_id INT(11) NOT NULL,
  rating INT(1) NOT NULL,
    
  CONSTRAINT rating_pk PRIMARY KEY (author_id, article_id),
  FOREIGN KEY (author_id) REFERENCES author(id),
  FOREIGN KEY (article_id) REFERENCES article(id)
);