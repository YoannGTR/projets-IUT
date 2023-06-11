import csv

#Fonction pour creer la vue avec les colonnes souhaitees
def creer_vue_csv(fichier_entree, fichier_sortie):
   colonnes_souhaitees = ['Code départemental de l’établissement', 'Département de l’établissement', 'Région de l’établissement', 'pourcentage_mention_admis',
                          "%% d’admis dont filles", 'nombre_formations', 'nombre_etablissements',
                          'nombre_formations_proposees', 'effectif_total_moyen_candidats']
  
   with open(fichier_entree, 'r', newline='') as csv_entree, open(fichier_sortie, 'w', newline='') as csv_sortie:
       lecteur = csv.DictReader(csv_entree)
       ecriture = csv.DictWriter(csv_sortie, fieldnames=colonnes_souhaitees)
       ecriture.writeheader()


       for ligne in lecteur:
           print(ligne)
           nouvelle_ligne = {colonne: ligne[colonne] for colonne in colonnes_souhaitees}
           ecriture.writerow(nouvelle_ligne)


# Exemple d'utilisation
fichier_entree = 'fr-esr-parcoursup_2022.csv'
fichier_sortie = 'nouveau_csv.csv'


creer_vue_csv(fichier_entree, fichier_sortie)
