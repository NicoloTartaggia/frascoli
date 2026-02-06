PRAGMA journal_mode = MEMORY;
PRAGMA synchronous = OFF;
PRAGMA foreign_keys = OFF;
PRAGMA ignore_check_constraints = OFF;
PRAGMA auto_vacuum = NONE;
PRAGMA secure_delete = OFF;
BEGIN TRANSACTION;

DROP TABLE IF EXISTS doctrine_migration_versions;

CREATE TABLE doctrine_migration_versions (
    version TEXT NOT NULL PRIMARY KEY,
    executed_at DATETIME DEFAULT NULL,
    execution_time INTEGER DEFAULT NULL
);

INSERT INTO doctrine_migration_versions VALUES
('DoctrineMigrations\\Version20240530151623','2024-08-19 14:18:47',9),
('DoctrineMigrations\\Version20240819142126','2024-08-19 14:21:34',34);

DROP TABLE IF EXISTS luogo;

CREATE TABLE luogo (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome_card TEXT NOT NULL,
    descrizione_card TEXT,
    via_card TEXT,
    img_card TEXT DEFAULT NULL,
    slug TEXT NOT NULL,
    nome_cover TEXT NOT NULL,
    img_cover TEXT DEFAULT NULL,
    descrizione_cover TEXT,
    meta_title TEXT,
    meta_description TEXT,
    menu TEXT DEFAULT NULL,
    link_maps TEXT DEFAULT NULL,
    img_mappa TEXT DEFAULT NULL,
    indirizzo_full TEXT,
    orari_full TEXT,
    url_instagram TEXT DEFAULT NULL,
    url_facebook TEXT DEFAULT NULL,
    url_recensione TEXT DEFAULT NULL,
    telefono TEXT DEFAULT NULL,
    attivo INTEGER NOT NULL
);

INSERT INTO luogo VALUES
(1,'Frascolino Monselice','Osteria dove mangiare pesce fresco e assaporare una cucina autentica in ambiente conviviale.','Via Pellegrino 1','card-frascoli-padova.jpg','frascolino-monselice','Frascolino Monselice','cover-frascoli-padova-big.jpg','Frascolino Monselice è un luogo che accompagna ogni momento della giornata. Si inizia dalla colazione, con le proposte di pasticceria firmate Goody, per poi proseguire con aperitivi e cicchetti di pesce, nel solco della tradizione veneziana che contraddistingue Frascolino. La sera il locale si trasforma in ristorante, con una cucina che valorizza materie prime selezionate e piatti pensati per essere condivisi. Un punto di riferimento a Monselice dove convivialità, qualità e tradizione si incontrano, dal mattino alla sera.','Frascolino Monselice | Osteria di pesce','Il locale ideale dove mangiare pesce fresco e assaporare una cucina conviviale ad un ottimo rapporto qualità prezzo.','Menu_frascoli-web.pdf','https://maps.app.goo.gl/qLs98t7GRMSinAaF7','mappa-frascolino-monselice.png','<div><strong>Via Pellegrino 1<br>Monselice - Italia</strong><br>elena@canaeto.it<br>0429 535797&nbsp;</div>','<div><strong><br>Luned&igrave<br></strong>7:00 - 14:30<strong><br>Marted&igrave<br></strong>7:00 - 19:30<strong><br>Mercoled&igrave - Sabato<br></strong>7:00 - 23.30<strong><br>Domenica<br></strong>7:30 - 19:30</div>','https://www.instagram.com/frascolino.bacaro_monselice/','https://www.facebook.com/Goodybakerycaﬀetteria','https://www.tripadvisor.it/UserReviewEdit-g1063369-d27220947-Goody_Bakery-Monselice_Province_of_Padua_Veneto.html','049660505',1),
(2,'Frascolino Padova','Il nostro aperitivo è espressione della tradizione veneziana. Il bacareto dove i protagonisti sono le ombre e i cicchetti.','Via Altinate 103','card-cover-anteprima-frascolino.jpg','frascolino','Frascolino Padova','cover-frascolino-padova-big.jpg','Il nostro aperitivo a base di pesce è espressione autentica della tradizione veneziana. Frascolino è il bacareto a Padova dove gustare cicchetti freschi e abbondanti in un’atmosfera conviviale. La ricerca di materie prime del territorio è sempre al primo posto nella cucina dei nostri locali. Il richiamo è quello del bacaro in senso tradizionale dove i protagonisti sono le ombre e i cicchetti, seguiti da piatti in piccole porzioni.','L’aperitivo veneziano a Padova centro | Frascolino','Il nostro aperitivo è espressione della tradizione veneziana. Frascolino è il bacareto dove gustare cicchetti freschi e abbondanti in un’atmosfera conviviale.','menu frascolino onepage.pdf','https://www.google.it/maps/place/Via+Zabarella,+103,+35121+Padova+PD/@45.4087115,11.8763291,17z/data=!3m1!4b1!4m6!3m5!1sX''477eda5a612bc8c7'':X''2d54addb909cd744''!8m2!3d45.4087078!4d11.8789094!16s%2Fg%2F11h6c8lgk_?entry=ttu&g_ep=EgoyMDI0MTAwOS4wIKXMDSoASAFQAw%3D%3D','mappa-mappa-frascolino-padova.jpg','<div><strong>Via degli Zabarella 103<br>Padova - Italia<br></strong>elena@canaeto.it&nbsp;<br>0490960354</div>','<div><strong><br>Luned&igrave - Gioved&igrave<br></strong>15.30 - 23.30<br><strong>Venerd&igrave - Domenica<br></strong>11.30 - 23.30<br><br></div>','https://www.instagram.com/frascolinobacaro/','https://www.facebook.com/profile.php?id=61581182619585','https://www.tripadvisor.it/UserReviewEdit-g187867-d28984850-Frascolino_Bacaro-Padua_Province_of_Padua_Veneto.html','0490960354',1);

DROP TABLE IF EXISTS messenger_messages;

CREATE TABLE messenger_messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    body TEXT NOT NULL,
    headers TEXT NOT NULL,
    queue_name TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    available_at DATETIME NOT NULL,
    delivered_at DATETIME DEFAULT NULL
);

DROP TABLE IF EXISTS user;

CREATE TABLE user (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL,
    nome TEXT NOT NULL,
    cognome TEXT NOT NULL,
    img_profilo TEXT DEFAULT NULL,
    roles TEXT NOT NULL,
    password TEXT NOT NULL
);

INSERT INTO user VALUES
(1,'nicolo.tartaggia@gmail.com','Nicolò','Tartaggia',NULL,'["ROLE_ADMIN", "ROLE_SUPERADMIN"]','$2y$13$LfjWxkSIcxE6sJ1XDx7n2evcxfxsVqQD3ijrTIoP7/7PoNmWAeg0K');

CREATE INDEX messenger_messages_IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name);
CREATE INDEX messenger_messages_IDX_75EA56E0E3BD61CE ON messenger_messages (available_at);
CREATE INDEX messenger_messages_IDX_75EA56E016BA31DB ON messenger_messages (delivered_at);
CREATE UNIQUE INDEX user_UNIQ_8D93D649E7927C74 ON user (email);

COMMIT;
PRAGMA ignore_check_constraints = ON;
PRAGMA foreign_keys = ON;
PRAGMA journal_mode = WAL;
PRAGMA synchronous = NORMAL;
