DROP SCHEMA IF EXISTS parcoursup cascade;

CREATE SCHEMA parcoursup;
SET SCHEMA 'parcoursup';



CREATE TABLE _type_bac
(
    type_bac VARCHAR(17),

    CONSTRAINT type_bac_pk PRIMARY KEY(type_bac)

);

CREATE TABLE _session
(
    session_annee INTEGER,

    CONSTRAINT session_pk PRIMARY KEY(session_annee)
);

CREATE TABLE _regroupement
(
    libelle_regroupement VARCHAR(68),

    CONSTRAINT regroupement_pk PRIMARY KEY(libelle_regroupement)
    

);

CREATE TABLE _mention_bac
(
    libelle_mention VARCHAR(36),

    CONSTRAINT mention_bac_pk PRIMARY KEY(libelle_mention)


);






CREATE TABLE _filiere(
    filiere_id INTEGER,
    filiere_libelle VARCHAR(279),
    filiere_libelle_tres_abrege VARCHAR(17),
    filiere_libelle_abrege VARCHAR(66),
    filliere_libelle_detaille_bis VARCHAR(119),

    CONSTRAINT filiere_pk
        PRIMARY KEY (filiere_id)
);

CREATE TABLE _academie(
    academie_nom VARCHAR(19),

    CONSTRAINT academie_pk
        PRIMARY KEY (academie_nom)
);

CREATE TABLE _etablisement(
    etablisement_code_uai VARCHAR(8),
    etablisement_nom VARCHAR(134),
    etablisement_statut VARCHAR(32),

    CONSTRAINT etablisement_pk
        PRIMARY KEY (etablisement_code_uai)
);

CREATE TABLE _region(
    region_nom VARCHAR(26),

    CONSTRAINT region_pk
        PRIMARY KEY (region_nom)
);

CREATE TABLE _departement(
    departement_code VARCHAR(3),
    departement_nom VARCHAR(23),

    region_nom VARCHAR(26),

    CONSTRAINT departement_pk
        PRIMARY KEY (departement_code),

    CONSTRAINT departement
        FOREIGN KEY (region_nom)
        REFERENCES _region(region_nom)
);

CREATE TABLE _commune(
    commune_nom VARCHAR(29),
    departement_code VARCHAR(3),


    CONSTRAINT commune_pk
        PRIMARY KEY (commune_nom, departement_code),

    CONSTRAINT commune_fk1
        FOREIGN KEY (departement_code)
        REFERENCES _departement(departement_code)
);





CREATE TABLE _formation(
    cod_aff_form VARCHAR(5),
    filliere_libelle_detaille VARCHAR(335),
    coordonnees_gps VARCHAR(18),
    list_com VARCHAR(44),
    concours_communs_banque_epreuve VARCHAR(98),
    url_formation VARCHAR(91), 
    tri VARCHAR(19),

    filiere_id INTEGER,
    academie_nom VARCHAR(19),
    etablisement_code_uai VARCHAR(8),
    commune_nom VARCHAR(29),
    departement_code VARCHAR(23),


    CONSTRAINT formation_pk
        PRIMARY KEY (cod_aff_form),

    CONSTRAINT formation_fk1
        FOREIGN KEY (filiere_id)
        REFERENCES _filiere(filiere_id),

    CONSTRAINT formation_fk2
        FOREIGN KEY (academie_nom)
        REFERENCES _academie(academie_nom),

    CONSTRAINT formation_fk3
        FOREIGN KEY (etablisement_code_uai)
        REFERENCES _etablisement(etablisement_code_uai),

    CONSTRAINT formation_fk4
        FOREIGN KEY (commune_nom, departement_code)
        REFERENCES _commune(commune_nom, departement_code)
);

CREATE TABLE _admission_generalites
(
    selectivite VARCHAR(23),
    capacite INTEGER,
    effectif_total_candidat INTEGER,
    effectif_total_candidates INTEGER,

    session_annee INTEGER,
    cod_aff_form VARCHAR(5),

    CONSTRAINT admission_generalites_pk 
        PRIMARY KEY(session_annee, cod_aff_form),

    CONSTRAINT admission_generalites_fk1 
        FOREIGN KEY(session_annee) REFERENCES _session(session_annee),

    CONSTRAINT admission_generalites_fk2  
        FOREIGN KEY(cod_aff_form) REFERENCES _formation(cod_aff_form)
);

CREATE TABLE _effectif_selon_mention
(
    effectif_admis_neo_bac_selon_mention INTEGER,

    cod_aff_form VARCHAR(5),
    libelle_mention VARCHAR(36),
    session_annee INTEGER,

    CONSTRAINT effectif_selon_mention_pk 
        PRIMARY KEY(effectif_admis_neo_bac_selon_mention),

    CONSTRAINT effectif_selon_mention_fk1
        FOREIGN KEY(cod_aff_form) REFERENCES _formation(cod_aff_form),

    CONSTRAINT effectif_selon_mention_fk2
        FOREIGN KEY(session_annee) REFERENCES _session(session_annee),
        
    CONSTRAINT effectif_selon_mention_fk3 
        FOREIGN KEY(libelle_mention) REFERENCES _mention_bac(libelle_mention)
);

CREATE TABLE _admissions_selon_type_neo_bac
(
    effectif_candidat_neo_bac_classes INTEGER,

    cod_aff_form VARCHAR(5),
    session_annee INTEGER,
    type_bac VARCHAR(17),

    CONSTRAINT admissions_selon_type_neo_bac_pk 
        PRIMARY KEY(effectif_candidat_neo_bac_classes),
    CONSTRAINT admissions_selon_type_neo_bac_fk1
        FOREIGN KEY(cod_aff_form) REFERENCES _formation(cod_aff_form),

    CONSTRAINT admissions_selon_type_neo_bac_fk2
        FOREIGN KEY(session_annee) REFERENCES _session(session_annee),

    CONSTRAINT admissions_selon_type_neo_bac_fk3
        FOREIGN KEY(type_bac) REFERENCES _type_bac(type_bac)


);

CREATE TABLE _rang_dernier_appele_selon_regroupement
(
    rang_dernier_appele INTEGER,

    cod_aff_form VARCHAR(5),
    session_annee INTEGER,
    libelle_regroupement VARCHAR(68),

    CONSTRAINT rang_dernier_appele_selon_regroupement_pk 
        PRIMARY KEY(rang_dernier_appele),

    CONSTRAINT rang_dernier_appele_selon_regroupement_fk1
        FOREIGN KEY(cod_aff_form) REFERENCES _formation(cod_aff_form),

    CONSTRAINT rang_dernier_appele_selon_regroupement_fk2
        FOREIGN KEY(session_annee) REFERENCES _session(session_annee),

    CONSTRAINT rang_dernier_appele_selon_regroupement_fk3
        FOREIGN KEY(libelle_regroupement) REFERENCES _regroupement(libelle_regroupement)

);



