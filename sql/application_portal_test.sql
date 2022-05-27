CREATE TABLE IF NOT EXISTS sql6495374.application_portal (
	id INT AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	email VARCHAR(256) UNIQUE NOT NULL,
	contact_no VARCHAR(256) NOT NULL,
	school VARCHAR(256) NOT NULL,
	branch VARCHAR(256) NOT NULL,
	course VARCHAR(256) NOT NULL,
	skills VARCHAR(256) NOT NULL,
	gdrive_link VARCHAR(256) NOT NULL,
	created_at TIMESTAMP NOT NULL,
    	PRIMARY KEY(id)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS sql6495374.application_portal_admin (
	id INT AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	email VARCHAR(256) NOT NULL,
	username VARCHAR(128) NOT NULL,
	password VARCHAR(256) NOT NULL,
	role VARCHAR(256) NOT NULL,
	created_at TIMESTAMP NOT NULL,
    	PRIMARY KEY(id)
)ENGINE=INNODB;