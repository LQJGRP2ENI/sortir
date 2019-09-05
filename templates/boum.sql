INSERT INTO archive(nom, date_heure_debut) SELECT (nom, date_heure_debut) FROM sortie WHERE sortie.archive_id=archive.id;

DELETE FROM sortie WHERE (DATE_ADD(sortie.date_heure_debut, INTERVAL (sortie.duree + 43830) MINUTE < LOCALTIME);