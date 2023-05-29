#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Fri Mar 31 08:37:13 2023

@author: yoagautier
"""

import cavalier as cav


nbcol = int(input("Entrez le nombre de colonnes(entre 1 et 15): "))
nblig = int(input("Entrez le nombre de lignes(entre 1 et 15): "))
print("Entrez la ligne de la case de départ (entre 1 et ",nblig,"): ", end='')
lig = int(input())
print("Entrez la colonne de la case de départ (entre 1 et ",nbcol,"): ", end='')
col = int(input())
 
 
tour = cav.Cavalier(nbcol, nblig)
print(tour.parcours(col,lig))