# -*- coding: utf-8 -*-
"""
Created on Sun Apr  9 22:05:28 2023

@author: yoann
"""

class Cavalier2(object):
    def __init__(self, nbCol=None, nbLig=None):
        
        #vérifie si le nombre de cases est raisonnable, sinon le met automatiquement à 8
        
        if nbCol == None or nbCol>15 or nbCol<1:
            print("ERREUR, nombre de colonnes pas bon, mis automatiquement à 8")
            nbCol = 8
        if nbLig == None or nbLig>15 or nbLig<1:
            print("ERREUR, nombre de lignes pas bon, mis automatiquement à 8")
            nbLig = 8
            
            
        self._nbCol = nbCol
        self._nbLig = nbLig
        self._casesTot = nbLig*nbCol
        
        
        print(nbCol, nbLig)
        
    def parcours(self, colDep=None, ligDep=None):
        
        
        #vérifie si la case de départ est entrée et si elle fait partie de l'échiqier
        
        
        if colDep == None or colDep>self._nbCol or colDep<1:
            print("ERROR, colonne de départ pas bonne, mise automatiquement à 1")
            colDep = 1
        if ligDep == None or ligDep>self._nbLig or ligDep<1:
            print("ERROR, ligne de départ pas bonne, mise automatiquement à 1")
            ligDep = 1
            
            
        print(colDep,ligDep)
        self._colDep = colDep
        self._ligDep = ligDep
            
        
        #Initialise les variables
        
        case = (self._colDep, self._ligDep)
        chemin = []#liste des cases dans lordre
        casesVisit = {}#dictionnaire des cases visitées avec en indice la case et en attribut le nombre de coups essayés
        nbCaseVisit = 1
        echec = False
        reussite = False
        
        #enregistre la première case
        
        casesVisit[case]=0#premier essai de la case de départ
        chemin.append(case)#débute le chemin
        
        
        #tant que toutes les cases n'ont pas été visitées et que c'est pas un echec ou une reussite
        while nbCaseVisit<self._casesTot and echec == False:
            
            
            coupsPossibles = self.trouveCasesPossibles(case, casesVisit, nbCaseVisit)#liste des coups possible
            
            
            
            #affichage pour les gros code, pour savoir où on en est, optionnel (enlever les guillemet si on veut l'utiliser)
            
            if nbCaseVisit <6:
                
                print("numéro du coup          ",nbCaseVisit)
                #print("coup:" , coupsPossibles[casesVisit[case]])
                print("nb coup essayé : ", casesVisit[case]+1)
                print("nb coups tot : ", len(coupsPossibles))
                print("fin\n")
                
            
          
            
            #vérifie si on est a la case avant la case de départ
           
            
            #si on a pas exploré toutes les coups possibles
            if casesVisit[case]<len(coupsPossibles):#on vérifie si le nombre de coups essayé est inférieur au nombre de coups a tester
                
                casesVisit[case] +=1#on augmente de un le nb de coups essayé
                case = coupsPossibles[casesVisit[case]-1]#on passe a la prochaine case, la case devient la destination du prochain coups possible
                nbCaseVisit +=1
                chemin.append(case)#on rajoute la nouvelle case au chemin
                casesVisit[case]=0
                
                
            #si c'est la case du debut qui fail, on arrete
            elif (case == (self._colDep, self._ligDep)):
                echec = True
                
            #sinon on reprend en arrière(backtracking)
            else:
                nbCaseVisit-=1#on décrémente
                chemin.pop()#on supprime la derniere casse au chemin
                del casesVisit[case] #on réinitialise
                case= chemin[len(chemin)-1]# on revient a la case précédente
            
            
        if echec == True:
            print("pas de tour du cavalier possible")
            
        else:
            print("tour du cavalier:")
            self.afficher(chemin)
  
        return chemin
    
    
    #affiche le parcous du cavalier s'ur l'échiquier.
    def afficher(self, chemin):
        
        
        #initialise le plateau
        plateau = []
        for i in range(0, self._nbCol):
            plateau.append([])
            for j in range(0, self._nbLig):
                plateau[i].append(None)
        
        
        #remplis le plateau
        incr = 1
        for elem in chemin:
            col=elem[0]
            lig=elem[1]
            plateau[col-1][lig-1] = incr
            incr+=1
        
        #affiche le plateau
        for i in range(0, self._nbCol):
            for j in range(0, self._nbLig):
                if plateau[i][j] < 10:
                    print("[ ",plateau[i][j],"] ", end='')
                else:
                    print("[",plateau[i][j],"] ", end='')
            print("\n")
    
    
    #donne la liste des cases dans lequel le cavalier peut se déplacer à partir de la case donnée
    def trouveCasesPossibles(self, case, casesVisit, nbCaseVisit):
        
        #initialise les variables
        res = []
        x = case[0]
        y=case[1]
        
        #liste des coups possibles pour un cavalier
        mouvPossible = [
            (x + 2, y + 1), (x + 1, y + 2), (x - 1, y + 2), (x - 2, y + 1),
            (x - 2, y - 1), (x - 1, y - 2), (x + 1, y - 2), (x + 2, y - 1)
        ]
        
        #vérifie pour chaque mouv si c'est une case de l'echiquier et si elle a pas déja été visitée
        for (i,j) in mouvPossible:
                          
            if (i,j) not in casesVisit and self.mouvValide(i,j):
                res.append((i,j))
        
        return res
    
    
    
    #vériefie si la case visée fait partie de l'échiquier
    def mouvValide(self, i, j):
        
        res = False
        
        
        if( i>0 and j>0 and i <= self._nbCol and j <= self._nbLig):
            res = True
        return res
    
    