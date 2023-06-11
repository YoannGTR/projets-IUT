set schema 'parcoursup2';


DELETE from _rang_dernier_appele_selon_regroupement;

DELETE from _effectif_selon_mention;

DELETE from _admissions_selon_type_neo_bac;

DELETE from _admissions_generalites;

DELETE from _regroupement;

DELETE from _type_bac;

DELETE from _mention_bac;

DELETE from _session;

DELETE from _formation;

DELETE from _filiere;

DELETE from _etablissement;

DELETE from _commune;

DELETE from _departement;

DELETE from _region;

DELETE From _academie;

insert into _academie(academie_nom)
  select distinct academie_nom 
  from import_data;


insert into _region(region_nom)
    select distinct region_nom
    from import_data;



insert into _departement(departement_code, departement_nom, region_nom)
    select distinct departement_code, departement_nom, region_nom
    from import_data;



insert into _commune(commune_nom, departement_code)
    select distinct commune_nom, departement_code
    from import_data;


insert into _etablissement(etablissement_code_UAI, etablissement_nom, etablissement_statut)
    select distinct etablissement_code_UAI, etablissement_nom, etablissement_statut
    from import_data;



-- pour filiere faire un join dans _formation

insert into _filiere(filiere_libelle, filiere_libelle_abrege, filiere_libelle_tres_abrege, filiere_libelle_detaille_bis)
    select distinct filiere_libelle, filiere_libelle_abrege, filiere_libelle_tres_abrege, filiere_libelle_detaille_bis
    from import_data;



insert into _formation(filiere_libelle_detaille, coordonnees_gps, list_com, cod_aff_form, tri, concours_communs_banques_epreuves, url_formation, filiere_id, etablissement_code_UAI, commune_nom, departement_code, academie_nom)
    select distinct filiere_libelle_detaille, coordonnees_gps, list_com, cod_aff_form, tri, concours_communs_banques_epreuves, url_formation, filiere_id, etablissement_code_UAI, commune_nom, departement_code, academie_nom
    from _filiere natural join import_data;



insert into _session(session_annee)
    select distinct session_annee
    from import_data;


insert into _mention_bac(libelle_mention) 
    VALUES ('Sans information'), ('Sans mention'), ('Assez bien'), ('Bien'), ('Très bien'), ('Très bien avec félicitations du jury');


insert into _type_bac(type_bac) 
    VALUES ('Bac général'), ('Bac technologique'), ('Bac professionnel'), ('Autres');
    


insert into _regroupement(libelle_regroupement)
    select distinct regroupement_1
    from import_data
    where regroupement_1 is not null
    union
    select distinct regroupement_2
    from import_data
    where regroupement_2 is not null
    union
    select distinct regroupement_3
    from import_data
    where regroupement_3 is not null;



insert into _admissions_generalites(cod_aff_form, session_annee, selectivite, capacite, effectif_total_candidats, effectif_total_candidates)
    select distinct cod_aff_form, session_annee, selectivite, capacite, effectif_total_candidats, effectif_total_candidates
        from import_data;





insert into _admissions_selon_type_neo_bac(cod_aff_form, session_annee, type_bac, effectif_candidat_neo_bac_classes)
        select distinct cod_aff_form, session_annee, type_bac, effectif_candidat_neo_bac_classes_type_general
            from import_data
                cross join _type_bac
                where type_bac = 'Bac général'
    union
        select distinct cod_aff_form, session_annee, type_bac, effectif_candidat_neo_bac_classes_type_techno
            from import_data 
                cross join _type_bac 
                where type_bac = 'Bac technologique'
    union
        select distinct cod_aff_form, session_annee,type_bac,effectif_candidat_neo_bac_classes_type_pro
            from import_data 
                cross join _type_bac 
                where type_bac = 'Bac professionnel';





insert into _effectif_selon_mention(cod_aff_form, session_annee, libelle_mention, effectif_admis_neo_bac_selon_mention)
        select distinct cod_aff_form, session_annee, libelle_mention, effectif_admis_neo_bac_selon_mention_type_mention_assez_bien
            from import_data 
                cross join _mention_bac 
                where libelle_mention = 'Assez bien'
    union
        select distinct cod_aff_form, session_annee, libelle_mention, effectif_admis_neo_bac_selon_mention_type_mention_bien
            from import_data 
                cross join _mention_bac 
                where libelle_mention = 'Bien'
    union
        select distinct cod_aff_form, session_annee, libelle_mention, effectif_admis_neo_bac_selon_mention_type_mention_sans_mention
            from import_data
                cross join _mention_bac
                where libelle_mention = 'Sans mention'
    union
        select distinct cod_aff_form, session_annee, libelle_mention, effectif_admis_neo_bac_selon_mention_type_mention_sans_info
            from import_data
                cross join _mention_bac
                where libelle_mention = 'Sans information'
    union
        select distinct cod_aff_form, session_annee, libelle_mention, effectif_admis_neo_bac_selon_mention_type_mention_tres_bien
            from import_data 
                cross join _mention_bac
                where libelle_mention = 'Très bien'
    union
        select distinct cod_aff_form, session_annee, libelle_mention, effectif_admis_neo_bac_selon_mention_type_mention_tres_bien_fel
            from import_data
                cross join _mention_bac
                where libelle_mention = 'Très bien avec félicitations du jury';





insert into _rang_dernier_appele_selon_regroupement(cod_aff_form, session_annee, libelle_regroupement, rang_dernier_appele)
        select distinct cod_aff_form, session_annee, regroupement_1, rang_dernier_appele_groupe1
            from import_data
            where regroupement_1 is not null
    union
        select distinct cod_aff_form, session_annee, regroupement_2, rang_dernier_appele_groupe2
            from import_data
            where regroupement_2 is not null
    union
        select distinct cod_aff_form, session_annee, regroupement_3, rang_dernier_appele_groupe3
            from import_data
            where regroupement_3 is not null;
            







