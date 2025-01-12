# Docker

Compétence 3 : réaliser

## Resumé

Création d'un evironnement de travail similaire sur tout les ordinateurs grace à docker.  
Cet environnement permettait de génerer un fichier PDF à partir d'un document texte rempli par l'utilisateur.

## Info clées

- **Etat** : Fini  
- **Nombre de personnes** : 4  
- **Date** : Janvier 2023  
- **Langages** : Bash, HTML, CSS, PHP

## Etapes
Cet algorithme, effectué en PHP dans un environnement Docker, génère ce pdf en plusieurs étapes:
- Fusion d'un document texte et d'un fichier de configuration pour générer un fichier texte.
- Création d'un fichier HTML à partir de ce fichier
- Transformation de ce fichier HTML en document PDF
- Repetition de ces étapes pour chaque fichier texte fourni et regroupement des PDF générés dans une archive tar.gz

## Description

Ce projet consistait à créer un programme permettant de générer un fichier PDF à partir d’un document texte saisi par l'utilisateur. Cet algorithme s'exécute dans un environnement  isolé grâce à Docker. Cela permet à l’algorithme de fonctionner exactement de la même manière sur n'importe quel ordinateur, sur n'importe quel système d’exploitation.

## Information suplémentaires et prise de recul

Ce projet était en colaboration avec [Benjamin Conseil](https://github.com/conseil-benjamin), [Ethan Mancelon](https://github.com/EthanMancelon), [Pierrig Malnoë](https://github.com/VenomSE30). 

Ce projet m’a fait découvrir l’importance d’avoir un environnement isolé et identique sur toutes les machines, pour que l'algorithme fonctionne de la même manière sur la machine de l’utilisateur que sur la notre.