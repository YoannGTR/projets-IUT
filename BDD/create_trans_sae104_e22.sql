set schema 'transmusicales';


DROP TABLE IF EXISTS _annee CASCADE;
DROP TABLE IF EXISTS _type_musique CASCADE;
DROP TABLE IF EXISTS _groupe_artiste CASCADE;
DROP TABLE IF EXISTS _pays CASCADE;
DROP TABLE IF EXISTS _ville CASCADE;
DROP TABLE IF EXISTS _a_pour CASCADE;
DROP TABLE IF EXISTS _edition CASCADE;
DROP TABLE IF EXISTS _formation CASCADE;
DROP TABLE IF EXISTS _representation CASCADE;
DROP TABLE IF EXISTS _lieu CASCADE;
DROP TABLE IF EXISTS _concert CASCADE;



CREATE TABLE _annee
(
    an NUMERIC(4) NOT NULL,
    CONSTRAINT annee_pk
        PRIMARY KEY (an)
);



CREATE TABLE _type_musique(
    type_m CHAR(50) NOT NULL,
    CONSTRAINT type_musique_pk 
        PRIMARY KEY (type_m)
);



CREATE TABLE _pays
(
    nom_p CHAR(50) NOT NULL,
    CONSTRAINT pays_pk
        PRIMARY KEY (nom_p)
);



CREATE TABLE _ville
(
    nom_v CHAR(100) NOT NULL,
    se_situe CHAR(50),
    CONSTRAINT ville_pk
        PRIMARY KEY (nom_v),
    CONSTRAINT ville_fk1
        FOREIGN KEY(se_situe) REFERENCES _pays(nom_p)
);



CREATE TABLE _groupe_artiste (
    id_groupe_artiste CHAR(20) NOT NULL,
    nom_groupe_artiste CHAR(50),
    site_web CHAR(50),
    sortie_discographique NUMERIC(4),
    debut NUMERIC(4),
    type_principal CHAR(50),
    type_ponctuel CHAR(50),
    a_pour_origine CHAR(50),
    CONSTRAINT groupe_artiste_pk
        PRIMARY KEY (id_groupe_artiste),
    CONSTRAINT groupe_artiste_fk1 FOREIGN KEY(sortie_discographique)
        REFERENCES _annee(an),
    CONSTRAINT groupe_artiste_fk2 FOREIGN KEY(debut)
        REFERENCES _annee(an),
    CONSTRAINT groupe_artiste_fk3 FOREIGN KEY(type_ponctuel)
        REFERENCES _type_musique(type_m),
    CONSTRAINT groupe_artiste_fk4 FOREIGN KEY (type_principal)
        REFERENCES _type_musique(type_m),
    CONSTRAINT groupe_artiste_fk5 FOREIGN KEY (a_pour_origine)
        REFERENCES _pays(nom_p)
);



CREATE TABLE _formation (
    libelle_formation CHAR(50) NOT NULL,
    CONSTRAINT formation_pk 
        PRIMARY KEY(libelle_formation)
);



CREATE TABLE _a_pour
(
    id_groupe_artiste CHAR(20) NOT NULL,
    libelle_formation CHAR(50),
    CONSTRAINT a_pour_pk
        PRIMARY KEY (id_groupe_artiste,libelle_formation),
    CONSTRAINT a_pour_fk1 FOREIGN KEY (id_groupe_artiste)
        REFERENCES _groupe_artiste(id_groupe_artiste),
    CONSTRAINT a_pour_fk2 FOREIGN KEY (libelle_formation)
        REFERENCES _formation(libelle_formation)
);



CREATE TABLE _edition 
(
    nom_edition CHAR(50) NOT NULL,
    annee_edition NUMERIC(4),
    CONSTRAINT edition_pk
        PRIMARY KEY (nom_edition),
    CONSTRAINT edition_fk1
        FOREIGN KEY (annee_edition) REFERENCES _annee(an)
);



CREATE TABLE _concert(
    no_concert CHAR(20) NOT NULL,
    titre CHAR(50),
    resumee CHAR(1000),
    duree NUMERIC(10),
    tarif FLOAT(5),
    est_de CHAR(50),
    se_deroule CHAR(50),
    CONSTRAINT _concert_pk
        PRIMARY KEY (no_concert),
    CONSTRAINT _concert_fk1 FOREIGN KEY (est_de) 
        REFERENCES _type_musique(type_m),
    CONSTRAINT _concert_fk2 FOREIGN KEY (se_deroule) 
        REFERENCES _edition(nom_edition)
);



CREATE TABLE _lieu(
    id_lieu CHAR(20) NOT NULL,
    nom_lieu CHAR(100),
    accesPMR BOOLEAN,
    capacite_max NUMERIC(6),
    type_lieu CHAR(20),
    dans CHAR(100),
    CONSTRAINT _lieu_pk 
        PRIMARY KEY (id_lieu),
    CONSTRAINT _lieu_fk1 FOREIGN KEY (dans) 
        REFERENCES _ville(nom_v)
);



CREATE TABLE _representation(
    numero_representation CHAR(50) NOT NULL,
    correspond_à CHAR(50),
    a_lieu_dans CHAR(20),
    jouée_par CHAR(20),
    CONSTRAINT representation_pk 
        PRIMARY KEY (numero_representation),
    CONSTRAINT representation_fk1 FOREIGN KEY (correspond_à)  
        REFERENCES _concert(no_concert),
    CONSTRAINT representation_fk2 FOREIGN KEY (a_lieu_dans) 
        REFERENCES _lieu(id_lieu),
    CONSTRAINT representation_fk3 FOREIGN KEY (jouée_par) 
        REFERENCES _groupe_artiste(id_groupe_artiste)
);


