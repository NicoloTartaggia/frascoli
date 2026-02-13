SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS doctrine_migration_versions;
CREATE TABLE doctrine_migration_versions (
    version VARCHAR(191) NOT NULL,
    executed_at DATETIME DEFAULT NULL,
    execution_time INT DEFAULT NULL,
    PRIMARY KEY (version)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO doctrine_migration_versions (version, executed_at, execution_time) VALUES
('DoctrineMigrations\\Version20240530151623','2024-08-19 14:18:47',9),
('DoctrineMigrations\\Version20240819142126','2024-08-19 14:21:34',34);

DROP TABLE IF EXISTS luogo;
CREATE TABLE luogo (
    id INT AUTO_INCREMENT NOT NULL,
    nome_card VARCHAR(255) NOT NULL,
    descrizione_card LONGTEXT DEFAULT NULL,
    via_card VARCHAR(255) DEFAULT NULL,
    img_card VARCHAR(255) DEFAULT NULL,
    slug VARCHAR(255) NOT NULL,
    nome_cover VARCHAR(255) NOT NULL,
    img_cover VARCHAR(255) DEFAULT NULL,
    descrizione_cover LONGTEXT DEFAULT NULL,
    meta_title VARCHAR(255) DEFAULT NULL,
    meta_description LONGTEXT DEFAULT NULL,
    menu VARCHAR(255) DEFAULT NULL,
    link_maps LONGTEXT DEFAULT NULL,
    img_mappa VARCHAR(255) DEFAULT NULL,
    indirizzo_full LONGTEXT DEFAULT NULL,
    orari_full LONGTEXT DEFAULT NULL,
    url_instagram VARCHAR(255) DEFAULT NULL,
    url_facebook VARCHAR(255) DEFAULT NULL,
    url_recensione VARCHAR(255) DEFAULT NULL,
    telefono VARCHAR(50) DEFAULT NULL,
    attivo TINYINT(1) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO luogo VALUES
(1,'Frascolino Monselice','Osteria dove mangiare pesce fresco e assaporare una cucina autentica in ambiente conviviale.','Via Pellegrino 1','card-frascoli-padova.jpg','frascolino-monselice','Frascolino Monselice','cover-frascoli-padova-big.jpg','Frascolino Monselice è un luogo che accompagna ogni momento della giornata. Si inizia dalla colazione, con le proposte di pasticceria firmate Goody, per poi proseguire con aperitivi e cicchetti di pesce, nel solco della tradizione veneziana che contraddistingue Frascolino. La sera il locale si trasforma in ristorante, con una cucina che valorizza materie prime selezionate e piatti pensati per essere condivisi. Un punto di riferimento a Monselice dove convivialità, qualità e tradizione si incontrano, dal mattino alla sera.','Frascolino Monselice | Osteria di pesce','Il locale ideale dove mangiare pesce fresco e assaporare una cucina conviviale ad un ottimo rapporto qualità prezzo.','Menu_frascoli-web.pdf','https://maps.app.goo.gl/qLs98t7GRMSinAaF7','mappa-frascolino-monselice.png','<div><strong>Via Pellegrino 1<br>Monselice - Italia</strong><br>elena@canaeto.it<br>0429 535797&nbsp;</div>','<div><strong><br>Luned&igrave<br></strong>7:00 - 14:30<strong><br>Marted&igrave<br></strong>7:00 - 19:30<strong><br>Mercoled&igrave - Sabato<br></strong>7:00 - 23.30<strong><br>Domenica<br></strong>7:30 - 19:30</div>','https://www.instagram.com/frascolino.bacaro_monselice/','https://www.facebook.com/Goodybakerycaﬀetteria','https://www.tripadvisor.it/UserReviewEdit-g1063369-d27220947-Goody_Bakery-Monselice_Province_of_Padua_Veneto.html','049660505',1),
(2,'Frascolino Padova','Il nostro aperitivo è espressione della tradizione veneziana. Il bacareto dove i protagonisti sono le ombre e i cicchetti.','Via Altinate 103','card-cover-anteprima-frascolino.jpg','frascolino','Frascolino Padova','cover-frascolino-padova-big.jpg','Il nostro aperitivo a base di pesce è espressione autentica della tradizione veneziana. Frascolino è il bacareto a Padova dove gustare cicchetti freschi e abbondanti in un’atmosfera conviviale. La ricerca di materie prime del territorio è sempre al primo posto nella cucina dei nostri locali. Il richiamo è quello del bacaro in senso tradizionale dove i protagonisti sono le ombre e i cicchetti, seguiti da piatti in piccole porzioni.','L’aperitivo veneziano a Padova centro | Frascolino','Il nostro aperitivo è espressione della tradizione veneziana. Frascolino è il bacareto dove gustare cicchetti freschi e abbondanti in un’atmosfera conviviale.','menu frascolino onepage.pdf','https://www.google.it/maps/place/Via+Zabarella,+103,+35121+Padova+PD/','mappa-mappa-frascolino-padova.jpg','<div><strong>Via degli Zabarella 103<br>Padova - Italia<br></strong>elena@canaeto.it&nbsp;<br>0490960354</div>','<div><strong><br>Luned&igrave - Gioved&igrave<br></strong>15.30 - 23.30<br><strong>Venerd&igrave - Domenica<br></strong>11.30 - 23.30<br><br></div>','https://www.instagram.com/frascolinobacaro/','https://www.facebook.com/profile.php?id=61581182619585','https://www.tripadvisor.it/UserReviewEdit-g187867-d28984850-Frascolino_Bacaro-Padua_Province_of_Padua_Veneto.html','0490960354',1);

DROP TABLE IF EXISTS messenger_messages;
CREATE TABLE messenger_messages (
    id INT AUTO_INCREMENT NOT NULL,
    body LONGTEXT NOT NULL,
    headers LONGTEXT NOT NULL,
    queue_name VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    available_at DATETIME NOT NULL,
    delivered_at DATETIME DEFAULT NULL,
    PRIMARY KEY (id),
    INDEX IDX_QUEUE_NAME (queue_name),
    INDEX IDX_AVAILABLE_AT (available_at),
    INDEX IDX_DELIVERED_AT (delivered_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS user;
CREATE TABLE user (
    id INT AUTO_INCREMENT NOT NULL,
    email VARCHAR(180) NOT NULL,
    nome VARCHAR(255) NOT NULL,
    cognome VARCHAR(255) NOT NULL,
    img_profilo VARCHAR(255) DEFAULT NULL,
    roles JSON NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE INDEX UNIQ_USER_EMAIL (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO user (id, email, nome, cognome, img_profilo, roles, password) VALUES
(1,'nicolo.tartaggia@gmail.com','Nicolò','Tartaggia',NULL,'["ROLE_ADMIN", "ROLE_SUPERADMIN"]','$2y$13$LfjWxkSIcxE6sJ1XDx7n2evcxfxsVqQD3ijrTIoP7/7PoNmWAeg0K');

SET FOREIGN_KEY_CHECKS = 1;
