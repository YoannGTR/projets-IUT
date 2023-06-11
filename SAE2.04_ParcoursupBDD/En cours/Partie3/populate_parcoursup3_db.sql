-- Populate
set schema 'parcoursup3';

-- TABLE temporaire
drop table if exists import_data;
create table import_data(
  session_annee                                                                   numeric(4)    not null,
  etablissement_statut                                                            varchar(40)   not null,
  etablissement_code_uai                                                          varchar(10)   not null, 
  etablissement_nom                                                               varchar(150)  not null,
  departement_code                                                                varchar(3)    not null,
  departement_nom                                                                 varchar(50)   not null, 
  region_nom                                                                      varchar(50)   not null, 
  academie_nom                                                                    varchar(50)   not null, 
  commune_nom                                                                     varchar(50)   not null,
  filiere_libelle                                                                 varchar(400)  not null, 
  selectivite                                                                     varchar(30)   not null, 
  filiere_libelle_tres_abrege                                                     varchar(30)   not null, 
  filiere_libelle_detaille                                                        varchar(400)  not null, 
  filiere_libelle_abrege                                                          varchar(100)  not null,
  filiere_libelle_detaille_bis                                                    varchar(150)  not null,
  filiere_libelle_tres_detaille                                                   varchar(400), -- peut être vide
  coordonnees_gps                                                                 varchar(30)   not null, 
  capacite                                                                        integer       not null, 
  effectif_total_candidats                                                        integer       not null, 
  effectif_total_candidates                                                       integer       not null,
  effectif_candidat_neo_bac_classes_type_general                                  integer       not null, 
  effectif_candidat_neo_bac_boursiers_classes_type_general                        integer       not null,
  effectif_candidat_neo_bac_classes_type_techno                                   integer       not null, 
  effectif_candidat_neo_bac_boursiers_classes_type_techno                         integer       not null,
  effectif_candidat_neo_bac_classes_type_pro                                      integer       not null,  
  effectif_candidat_neo_bac_boursiers_classes_type_pro                            integer       not null,
  effectif_candidat_classes_type_autres                                           integer       not null,
  effectif_total_proposition_admission                                            integer       not null, 
  effectif_total_admis                                                            integer       not null, 
  effectif_total_admises                                                          integer       not null,
  effectif_total_admis_boursiers_neo_bac                                          integer       not null, 
  effectif_total_admis_neo_bac                                                    integer       not null,
  effectif_admis_neo_bac_type_general                                             integer       not null, -- effectif_admis_neo_bac type_bac = general
  effectif_admis_neo_bac_type_techno                                              integer       not null, -- effectif_admis_neo_bac type_bac = techno
  effectif_admis_neo_bac_type_pro                                                 integer       not null, -- effectif_admis_neo_bac type_bac = pro
  effectif_admis_neo_bac_type_autres                                              integer       not null, -- effectif_admis_neo_bac type_bac = autres
  effectif_admis_neo_bac_selon_mention_type_mention_sans_info                     integer       not null,
  effectif_admis_neo_bac_selon_mention_type_mention_sans_mention                  integer       not null,
  effectif_admis_neo_bac_selon_mention_type_mention_assez_bien                    integer       not null,
  effectif_admis_neo_bac_selon_mention_type_mention_bien                          integer       not null,
  effectif_admis_neo_bac_selon_mention_type_mention_tres_bien                     integer       not null,
  effectif_admis_neo_bac_selon_mention_type_mention_tres_bien_fel                 integer       not null,
  effectif_admis_neo_bac_avec_mention_type_bac_general                            integer       not null,
  effectif_admis_neo_bac_avec_mention_type_bac_techno                             integer       not null,
  effectif_admis_neo_bac_avec_mention_type_bac_pro                                integer       not null,
  effectif_admis_meme_etablissement                                               integer, 
  effectif_admises_meme_etablissement                                             integer,
  effectif_admis_meme_academie                                                    integer       not null, 
  effectif_admis_meme_academie_pcv                                                integer,
  regroupement_1                                                                  varchar(100), 
  rang_dernier_appele_groupe1                                                     integer,
  regroupement_2                                                                  varchar(100), 
  rang_dernier_appele_groupe2                                                     integer,
  regroupement_3                                                                  varchar(100), 
  rang_dernier_appele_groupe3                                                     integer,
  list_com                                                                        varchar(60)   not null, 
  tri                                                                             varchar(20)   not null, 
  cod_aff_form                                                                    varchar(20)   not null,
  concours_communs_banques_epreuves                                               varchar(100),
  url_formation                                                                   varchar(150)
);

-- IMPORT de toutes les données utilisées
WbImport -file=../../Data_ParcourSup/fr-esr-parcoursup_2022.csv
         -header=true
         -delimiter=';'
         -quoteChar='"' 
         -table=import_data
         -schema=parcoursup3
         -mode=insert
         -filecolumns=session_annee, etablissement_statut, etablissement_code_uai, etablissement_nom,
                      departement_code, departement_nom, region_nom, academie_nom, commune_nom,
                      filiere_libelle, selectivite, filiere_libelle_tres_abrege, filiere_libelle_detaille, 
                      filiere_libelle_abrege, filiere_libelle_detaille_bis, filiere_libelle_tres_detaille, 
                      coordonnees_gps, capacite, effectif_total_candidats, effectif_total_candidates, 
                      effectif_total_phase_principale, effectif_internat_phase_principale, 
                      effectif_neo_bac_general_phase_principale, effectif_neo_bac_general_phase_principale_boursier,
                      effectif_neo_bac_techno_phase_principale, effectif_neo_bac_techno_principale_boursier, 
                      effectif_neo_bac_pro_phase_principale, effectif_neo_bac_pro_phase_principale_boursier,
                      effectif_total_autres_phase_principale, effectif_total_phase_complementaire,
                      effectif_neo_bac_general_phase_complementaire, effectif_neo_bac_techno_phase_complementaire,
                      effectif_neo_bac_pro_phase_complementaire, effectif_total_autres_phase_complementaire,
                      effectif_total_classes_phase_principale, effectif_total_classes_phase_complementaire,
                      effectif_total_classes_internat_cpge, effectif_total_classes_hors_internat_cpge,
                      effectif_candidat_neo_bac_classes_type_general, 
                      effectif_candidat_neo_bac_boursiers_classes_type_general,
                      effectif_candidat_neo_bac_classes_type_techno, 
                      effectif_candidat_neo_bac_boursiers_classes_type_techno,
                      effectif_candidat_neo_bac_classes_type_pro, 
                      effectif_candidat_neo_bac_boursiers_classes_type_pro, effectif_candidat_classes_type_autres,
                      effectif_total_proposition_admission, effectif_total_admis, effectif_total_admises,
                      effectif_total_admis_phase_principale, effectif_total_admis_phase_complementaire,
                      effectif_proposition_admis_ouverture_procedure_principale, effectif_proposition_admis_avant_bac,
                      effectif_proposition_admis_avant_fin_procedure_principale, effectif_admis_en_internat, 
                      effectif_total_admis_boursiers_neo_bac, effectif_total_admis_neo_bac, 
                      effectif_admis_neo_bac_type_general, effectif_admis_neo_bac_type_techno,
                      effectif_admis_neo_bac_type_pro, effectif_admis_neo_bac_type_autres,
                      effectif_admis_neo_bac_selon_mention_type_mention_sans_info,
                      effectif_admis_neo_bac_selon_mention_type_mention_sans_mention,
                      effectif_admis_neo_bac_selon_mention_type_mention_assez_bien,
                      effectif_admis_neo_bac_selon_mention_type_mention_bien,
                      effectif_admis_neo_bac_selon_mention_type_mention_tres_bien,
                      effectif_admis_neo_bac_selon_mention_type_mention_tres_bien_fel,
                      effectif_admis_neo_bac_avec_mention_type_bac_general,
                      effectif_admis_neo_bac_avec_mention_type_bac_techno,
                      effectif_admis_neo_bac_avec_mention_type_bac_pro,
                      effectif_admis_meme_etablissement, effectif_admises_meme_etablissement,
                      effectif_admis_meme_academie, effectif_admis_meme_academis_pcv,
                      pourcent_proposition_admis_ouverture_procedure_principale, pourcent_proposition_avant_bac,
                      pourcent_proposition_admis_avant_fin_procedure_principale, pourcent_admises,
                      pourcent_neo_bac_admis_meme_academie, pourcent_neo_bac_admis_meme_academie_pcv,
                      pourcent_neo_bac_admis_meme_etablissement_bts_cpge, pourcent_neo_bac_admis_boursiers,
                      pourcent_neo_bac, pourcent_neo_bac_mention_sans_info, pourcent_neo_bac_mention_sans,
                      pourcent_neo_bac_mention_assez_bien, pourcent_neo_bac_mention_bien, 
                      pourcent_neo_bac_mention_très_bien, pourcent_neo_bac_mention_très_bien_felicitations,
                      pourcent_neo_bac_general, pourcent_neo_bac_general_avec_mention, pourcent_neo_bac_techno, 
                      pourcent_neo_bac_techno_avec_mention, pourcent_neo_bac_pro, pourcent_neo_bac_pro_avec_mention,
                      effectif_candidats_terminale_generale_avec_proposition_admis,
                      effectif_candidats_terminale_generale_boursiers_avec_proposition_admis,
                      effectif_candidats_terminale_techno_avec_proposition_admis,
                      effectif_candidats_terminale_techno_boursiers_avec_proposition_admis,
                      effectif_candidats_terminale_pro_avec_proposition_admis,
                      effectif_candidats_terminale_pro_boursiers_avec_proposition_admis,
                      effectif_autres_candidats_avec_proposition_admis, regroupement_1, rang_dernier_appele_groupe1,
                      regroupement_2, rang_dernier_appele_groupe2, regroupement_3, rang_dernier_appele_groupe3,
                      list_com, tri, cod_aff_form, concours_communs_banques_epreuves, url_formation, taux_acces,
                      part_terminale_generale_en_position_admis_phase_principale, 
                      part_terminale_techno_en_position_admis_phase_principale,
                      part_terminale_pro_en_position_admis_phase_principale,
                      etablissement_id_paysage, composante_id_paysage
         -importColumns=session_annee, etablissement_statut, etablissement_code_uai, etablissement_nom,
                      departement_code, departement_nom, region_nom, academie_nom, commune_nom, filiere_libelle, 
                      selectivite, filiere_libelle_tres_abrege, filiere_libelle_detaille, filiere_libelle_abrege,
                      filiere_libelle_detaille_bis, filiere_libelle_tres_detaille, coordonnees_gps, capacite, 
                      effectif_total_candidats, effectif_total_candidates, 
                      effectif_candidat_neo_bac_classes_type_general, 
                      effectif_candidat_neo_bac_boursiers_classes_type_general,
                      effectif_candidat_neo_bac_classes_type_techno, 
                      effectif_candidat_neo_bac_boursiers_classes_type_techno,
                      effectif_candidat_neo_bac_classes_type_pro, 
                      effectif_candidat_neo_bac_boursiers_classes_type_pro,
                      effectif_candidat_classes_type_autres,
                      effectif_total_proposition_admission, effectif_total_admis, effectif_total_admises, 
                      effectif_total_admis_boursiers_neo_bac, effectif_total_admis_neo_bac, 
                      effectif_admis_neo_bac_type_general, effectif_admis_neo_bac_type_techno,
                      effectif_admis_neo_bac_type_pro, effectif_admis_neo_bac_type_autres,
                      effectif_admis_neo_bac_selon_mention_type_mention_sans_info,
                      effectif_admis_neo_bac_selon_mention_type_mention_sans_mention,
                      effectif_admis_neo_bac_selon_mention_type_mention_assez_bien,
                      effectif_admis_neo_bac_selon_mention_type_mention_bien,
                      effectif_admis_neo_bac_selon_mention_type_mention_tres_bien,
                      effectif_admis_neo_bac_selon_mention_type_mention_tres_bien_fel,
                      effectif_admis_neo_bac_avec_mention_type_bac_general,
                      effectif_admis_neo_bac_avec_mention_type_bac_techno,
                      effectif_admis_neo_bac_avec_mention_type_bac_pro,
                      effectif_admis_meme_etablissement, effectif_admises_meme_etablissement,
                      effectif_admis_meme_academie, effectif_admis_meme_academis_pcv,
                      regroupement_1, rang_dernier_appele_groupe1, regroupement_2, rang_dernier_appele_groupe2,
                      regroupement_3, rang_dernier_appele_groupe3,
                      list_com, tri, cod_aff_form, concours_communs_banques_epreuves, url_formation;
--         -keyColumns=etablissement_code_UAI;


-- ETABLISSEMENTS
insert into _etablissement(etablissement_statut,etablissement_code_UAI,etablissement_nom)
  select distinct etablissement_statut,etablissement_code_UAI,etablissement_nom
  from import_data;

select count(*) as nb_etablissements from _etablissement; -- 3926 pour 2022 sur 13644 lignes

 
-- REGIONS
insert into _region(region_nom)
  select distinct region_nom
  from import_data;

select count(*) as nb_regions from _region;

-- DEPARTEMENTS
insert into _departement(departement_code,departement_nom,region_nom)
  select distinct departement_code,departement_nom,region_nom
  from import_data;

select count(*) as nb_departements from _departement;

-- ACADEMIES
insert into _academie(academie_nom)
  select distinct academie_nom
  from import_data;

select count(*) as nb_academies from _academie;

commit;

-- COMMUNES
insert into _commune(commune_nom, departement_code)
  select distinct commune_nom, departement_code
  from import_data;

select count(*) as nb_communes from _commune;  

-- MENTIONS BAC
insert into _mention_bac(libelle_mention)
values ('Sans information'), 
       ('Sans mention'), 
       ('Assez bien'), 
       ('Bien'), 
       ('Très bien'), 
       ('Très bien avec félicitations du jury');

-- SESSIONS
insert into _session(session_annee) 
  select distinct session_annee
  from import_data;
  
-- REGROUPEMENTS
insert into _regroupement(libelle_regroupement)
  select regroupement_1 from import_data where regroupement_1 is not null
  union
  select regroupement_2 from import_data where regroupement_2 is not null
  union
  select regroupement_3 from import_data where regroupement_3 is not null;
  
select count(libelle_regroupement) as nb_regroupements from _regroupement;

-- TYPE BAC
insert into _type_bac(type_bac)
values ('Bac général'), ('Bac technologique'), ('Bac professionnel'), ('Autres');

-- FILIERES
insert into _filiere(filiere_libelle, filiere_libelle_tres_abrege, filiere_libelle_abrege, 
                     filiere_libelle_detaille_bis)
select distinct filiere_libelle, filiere_libelle_tres_abrege, filiere_libelle_abrege, 
                     filiere_libelle_detaille_bis
from import_data;

select count(*) as nb_filieres from _filiere; -- 3534

-- FORMATIONS
/*
select count(*) from import_data;                        -- 13644
select count(distinct url_formation) from import_data;   -- 13095
select count(distinct coordonnees_gps) from import_data; -- 5698
select count(distinct cod_aff_form) from import_data;    -- 13644 --> ID
select count(distinct filiere_libelle_detaille) from import_data; -- 11529
*/

insert into _formation (filiere_libelle_detaille, coordonnees_gps, list_com, cod_aff_form, 
                        concours_communs_banques_epreuves, url_formation, tri, etablissement_code_uai, commune_nom,
                        departement_code, academie_nom, filiere_id)
  select distinct filiere_libelle_detaille, coordonnees_gps, list_com, cod_aff_form, 
         concours_communs_banques_epreuves, url_formation, tri, etablissement_code_uai, commune_nom,
         departement_code, academie_nom, filiere_id
  from import_data natural join _filiere;

select count(*) as nb_formations from _formation; -- 13644

-- ADMISSIONS GENERALITES
insert into _admissions_generalites(selectivite, capacite, effectif_total_candidats, effectif_total_candidates,
                                    effectif_total_proposition_admission, effectif_total_admis, effectif_total_admises,
                                    effectif_total_admis_boursiers_neo_bac, effectif_total_admis_neo_bac,
                                    effectif_admis_meme_etablissement, effectif_admises_meme_etablissement,
                                    effectif_admis_meme_academie, effectif_admis_meme_academie_pcv,
                                    cod_aff_form, session_annee)
  select selectivite, capacite, effectif_total_candidats, effectif_total_candidates,
         effectif_total_proposition_admission, effectif_total_admis, effectif_total_admises,
         effectif_total_admis_boursiers_neo_bac, effectif_total_admis_neo_bac,
         effectif_admis_meme_etablissement, effectif_admises_meme_etablissement,
         effectif_admis_meme_academie, effectif_admis_meme_academie_pcv,
         cod_aff_form, session_annee -- 2022 dans notre fichier
  from import_data;

select count(*) from _admissions_generalites; -- 13644, autant que de formations

-- ADMISSIONS SELON TYPE NEO BAC
insert into _admissions_selon_type_neo_bac(
  effectif_candidat_neo_bac_classes, effectif_candidat_neo_bac_boursiers_classes,
  effectif_admis_neo_bac, effectif_admis_neo_bac_avec_mention,
  cod_aff_form, type_bac, session_annee)
  select  effectif_candidat_neo_bac_classes_type_general, effectif_candidat_neo_bac_boursiers_classes_type_general,
          effectif_admis_neo_bac_type_general, effectif_admis_neo_bac_avec_mention_type_bac_general,
          cod_aff_form, 'Bac général', session_annee
  from import_data
  union -- Bac techno
  select  effectif_candidat_neo_bac_classes_type_techno, effectif_candidat_neo_bac_boursiers_classes_type_techno,
          effectif_admis_neo_bac_type_techno, effectif_admis_neo_bac_avec_mention_type_bac_techno,
          cod_aff_form, 'Bac technologique', session_annee
  from import_data
  union -- Bac Pro
  select  effectif_candidat_neo_bac_classes_type_pro, effectif_candidat_neo_bac_boursiers_classes_type_pro,
          effectif_admis_neo_bac_type_pro, effectif_admis_neo_bac_avec_mention_type_bac_pro,
          cod_aff_form, 'Bac professionnel', session_annee
  from import_data
  union -- Autres
  select  effectif_candidat_classes_type_autres, NULL,  -- pas d'info sur les boursiers non neo-bac
          effectif_admis_neo_bac_type_autres, NULL,     -- pas d'info sur les mentions non neo-bac
          cod_aff_form, 'Autres', session_annee
  from import_data;
  
select count(*) from _admissions_selon_type_neo_bac; -- 4x13644 = 54576

-- EFFECTIF SELON MENTION
insert into _effectif_selon_mention(cod_aff_form, session_annee, libelle_mention, effectif_admis_neo_bac_selon_mention)
  select cod_aff_form, session_annee, 'Sans information', effectif_admis_neo_bac_selon_mention_type_mention_sans_info from import_data
  union
  select cod_aff_form, session_annee, 'Sans mention', effectif_admis_neo_bac_selon_mention_type_mention_sans_mention from import_data  
  union
  select cod_aff_form, session_annee, 'Assez bien', effectif_admis_neo_bac_selon_mention_type_mention_assez_bien from import_data 
  union
  select cod_aff_form, session_annee, 'Bien', effectif_admis_neo_bac_selon_mention_type_mention_bien from import_data 
  union
  select cod_aff_form, session_annee, 'Très bien', effectif_admis_neo_bac_selon_mention_type_mention_tres_bien from import_data 
  union
  select cod_aff_form, session_annee, 'Très bien avec félicitations du jury', 
         effectif_admis_neo_bac_selon_mention_type_mention_tres_bien_fel from import_data;

select count(*) as nb_effectif_selon_mention from _effectif_selon_mention; -- 81864 = 6x13644

-- RANG DERNIER APPELE SELON REGROUPEMENT
insert into _rang_dernier_appele_selon_regroupement(cod_aff_form, session_annee, libelle_regroupement, rang_dernier_appele)
  select cod_aff_form, session_annee, regroupement_1, rang_dernier_appele_groupe1
  from import_data where regroupement_1 is not null and rang_dernier_appele_groupe1 is not null
  union
  select cod_aff_form, session_annee, regroupement_2, rang_dernier_appele_groupe2
  from import_data where regroupement_2 is not null and rang_dernier_appele_groupe2 is not null
  union
  select cod_aff_form, session_annee, regroupement_3, rang_dernier_appele_groupe3
  from import_data where regroupement_3 is not null and rang_dernier_appele_groupe3 is not null;
  
select count(*) as nb_rang_dernier_appele_selon_regroupement from _rang_dernier_appele_selon_regroupement; -- 13570 + 6094 + 3774 = 23438

-- ON NETTOIE
drop table import_data;

commit;