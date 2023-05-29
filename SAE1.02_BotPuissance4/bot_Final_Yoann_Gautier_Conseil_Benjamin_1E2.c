#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <time.h>

#define LIGNE 6
#define COLONNE 7

typedef int t_grille[LIGNE][COLONNE];

int main(int argc, char** argv);
void chargerGrille(char** argv, t_grille grille);

int chercherLigne(t_grille laGrille, int col);
void botJoue(t_grille laGrille, char pion, int *column);
bool vicMtnMoi(t_grille laGrille, char lePion, int lig, int col);
bool vicMtnToi(t_grille laGrille, char lePion, int lig, int col);
bool jeTePiege(t_grille laGrille, char lePion, int lig, int col);
bool tuMePiege(t_grille laGrille, char lePion, int lig, int col);
bool jeTePiege2(t_grille laGrille, char lePion, int lig, int col);
bool tuMePiege2(t_grille laGrille, char lePion, int lig, int col);
bool jeTeCombo(t_grille laGrille, int lePion, int lig, int col);
bool tuMeCombo(t_grille laGrille, int lePion, int lig, int col);
bool alignSimple(t_grille laGrille, char lePion, int lig, int col);
bool randCentre(t_grille laGrille, char lePion, int lig, int col);
bool randCentre2(t_grille laGrille, char lePion, int lig, int col);
bool randCentre3(t_grille laGrille, char lePion, int lig, int col);

const int VIDE = 0;
const int JOUEUR = 1;
const int ADVERSAIRE = 2;


/*---------------------------------------------------
les ameliorations possèdent le mot clé "AMELIORATION"
-----------------------------------------------------*/

/*
* VOTRE STRATEGIE
*/
int maStrategie(t_grille grille)
{
    // TODO: Votre strategie de victoire. La seule fonction que vous aurez à modifier.
    // libre à vous d'en créer d'autres pour aérer votre code. 
    // La variable grille est un tableau à deux dimensions d'entiers, c'est la grille du tour. 
    // Un VIDE représente une case vide, 1 représente vos jetons et 2 représente les jetons adverses.
    // A vous de choisir le meilleur prochain coup !
    int column;
    botJoue(grille, 1, &column);
    // Retourne la meilleure colonne à jouer
    return column;
}

// La fonction principale reçoit la grille du tour et retourne le coup choisi
// Vous n'avez pas à modifier cette fonction
int main(int argc, char** argv) 
{
    t_grille grille;

    chargerGrille(argv, grille);

    return maStrategie(grille);
}

// Charge la grille du tour actuel
// Vous n'avez pas à modifier cette fonction
void chargerGrille(char** argv, t_grille grille) 
{
    for(int i = 0; i < LIGNE; i++)
        for(int j = 0; j < COLONNE; j++)
            grille[i][j] = atoi(argv[i * COLONNE + j + 1]);
}


int chercherLigne(t_grille laGrille, int col){
    int ligne = -1;

    while (ligne<LIGNE-1 && laGrille[ligne+1][col]==VIDE){
        ligne++;
    }
    return ligne;
}







void botJoue(t_grille laGrille, char pion, int *column)
{
    int line;
    srand( time( NULL ) );
    bool joue = false;
    int j;
    int cas = 0;
    int coups[COLONNE];
    int nbcoups = 0;

    //repete les verifications pour les 13 cas ou jusqu'a que le coup soit joué
    while(!joue && cas < 13)
    {
        for (int k = 0; k < COLONNE; k++)//reinitialise le tableau
        {
            coups[k] = -1;
        }
        j = 0;
        //vérifie pour chaque premiere case dispo si un des coups est possible
        while(j <= COLONNE)
        {
            if (j < COLONNE)//on rajoute un cas  pour si il y a plusieurs coups
            {
                line = chercherLigne(laGrille, j);
                if(line != -1)
                {
                    switch (cas)
                    {
                        // case -1:
                        //     joue = true;
                        //     coups[j] = j;
                        //     nbcoups++;
                        //     break;
                        case 0:
                            if(vicMtnMoi(laGrille, pion, line, j))
                            {
                                joue = true;
                                coups[j] = j;
                                nbcoups++;
                            }
                            break;

                        case 1:
                            if(vicMtnToi(laGrille, pion, line, j))
                            {
                                joue = true;
                                coups[j] = j;
                                nbcoups++;
                            }
                            break;

                        case 2:
                            if(jeTePiege(laGrille, pion, line, j))
                            {
                                if(!vicMtnToi(laGrille, pion, line-1, j))
                                {
                                    joue = true;
                                    coups[j] = j;
                                    nbcoups++;
                                } 
                            }
                            break;

                        case 3:
                            if(tuMePiege(laGrille, pion, line, j))
                            {
                                if(!vicMtnToi(laGrille, pion, line-1, j))
                                {
                                    joue = true;
                                    coups[j] = j;
                                    nbcoups++;
                                } 
                            }
                            break;

                         case 4:
                            if(jeTePiege2(laGrille, pion, line, j))
                            {
                                if(!vicMtnToi(laGrille, pion, line-1, j))
                                {
                                    joue = true;
                                    coups[j] = j;
                                    nbcoups++;
                                } 
                            }
                            break;

                        case 5:
                            if(tuMePiege2(laGrille, pion, line, j))
                            {
                                if(!vicMtnToi(laGrille, pion, line-1, j))
                                    {
                                        joue = true;
                                        coups[j] = j;
                                        nbcoups++;
                                    } 
                            }
                            break;
                        
                        case 6:
                            if(jeTeCombo(laGrille, pion, line, j))
                            {
                                 if(!vicMtnToi(laGrille, pion, line-1, j))
                                    {
                                        joue = true;
                                        coups[j] = j;
                                        nbcoups++;
                                    } 
                            }
                            break;
                        
                        case 7:
                            if(tuMeCombo(laGrille, pion, line, j))
                            {
                                if(!vicMtnToi(laGrille, pion, line-1, j))
                                    {
                                        joue = true;
                                        coups[j] = j;
                                        nbcoups++;
                                    } 
                            }
                            break;

                        case 8:
                            if(alignSimple(laGrille, pion, line, j))
                            {
                                if(!vicMtnToi(laGrille, pion, line-1, j))
                                    {
                                        joue = true;
                                        coups[j] = j;
                                        nbcoups++;
                                    } 
                                }
                            break;

                        case 9:
                            if(randCentre(laGrille, pion, line, j))
                            {
                                 if(!vicMtnToi(laGrille, pion, line-1, j))
                                    {
                                        joue = true;
                                        coups[j] = j;
                                        nbcoups++;
                                    } 
                            }
                            break;
                        
                        case 10:
                            if(randCentre2(laGrille, pion, line, j))
                            {
                                if(!vicMtnToi(laGrille, pion, line-1, j))
                                    {
                                        joue = true;
                                        coups[j] = j;
                                        nbcoups++;
                                    } 
                            }
                            break;

                        case 11:
                            if(randCentre3(laGrille, pion, line, j))
                            {
                                if(!vicMtnToi(laGrille, pion, line-1, j))
                                    {
                                        joue = true;
                                        coups[j] = j;
                                        nbcoups++;
                                    } 
                            }
                            break;

                        //cas par defaut
                        case 12:
                            joue = true;
                            coups[j] = j;
                            nbcoups++;
                            break;
                            
                        default:
                            break;
                    }
                }
                
            }
            if(j == COLONNE && joue)
            {
                *column = -1;
                int a = 0;
                //regarde les coups qu'on a et rand entre les coups disponible
                if (nbcoups == 1)
                {
                    while (*column == -1)
                    {
                        *column = coups[a];
                        a++;
                    }
                    
                }
                else
                {
                    while (*column == -1)
                    {
                        *column = coups[rand() % COLONNE];
                    }
                    
                }
                
                
            }   
            j++;
        }
        if (!joue)
        {
            cas++;
        }
        
    }
    
    
}


bool vicMtnMoi(t_grille laGrille, char lePion, int lig, int col)
{
    int cpt,i,j;

    // regarder la verticale, en comptant le nombre de pions au Sud (inutile de regarder au Nord du pion qui vient de tomber)
    i = lig + 1;
    cpt = 0;
    while (i<LIGNE && laGrille[i][col]==lePion){
        cpt++;
        i++;
    }
    if (cpt>=3){
        return true;
    }

    // regarder l'horizontale, en comptant le nombre de pions Ã  l'Est et Ã  l'Ouest
    j = col-1;
    cpt = 0;
    // on regarde Ã  l'est
    while (j>=0 && laGrille[lig][j]==lePion){
        cpt++;
        j--;
    }
    j = col+1;
    // on regarde Ã  l'ouest
    while (j<COLONNE && laGrille[lig][j]==lePion){
        cpt++;
        j++;
    }
    if (cpt>=3 ){
        return true;
    }
    
    // regarder la diagonale descendante, en comptant le nombre de pions au Nord Ouest et au Sud Est
    i = lig-1;
    j = col-1;
    cpt = 0;
    // on regarde au Nord Ouest
    while (j>=0 && i>=0 && laGrille[i][j]==lePion){
        cpt++;
        i--;
        j--;
    }
    i = lig+1;
    j = col+1;
    // on regarde au Sud Est
    while (i<LIGNE && j<COLONNE && laGrille[i][j]==lePion){
        cpt++;
        i++;
        j++;
    }
    if (cpt>=3 ){
        return true;
    }
    // regarder la diagonale descendante, en comptant le nombre de pions au Nord Est et au Sud Ouest
    i = lig-1;
    j = col+1;
    cpt = 0;
    // on regarde au Nord Est
    while (j<COLONNE && i>=0 && laGrille[i][j]==lePion){
        cpt++;
        i--;
        j++;
    }
    i = lig+1;
    j = col-1;
    // on regarde au Sud Ouest
    while (i<LIGNE && j>=0 && laGrille[i][j]==lePion){
        cpt++;
        i++;
        j--;
    }
    if (cpt>=3 ){
        return true;
    }
    return false;
}


bool vicMtnToi(t_grille laGrille, char lePion, int lig, int col)
{
    if (lePion == JOUEUR)
    {
        lePion = ADVERSAIRE;
    }
    else
    {
        lePion = JOUEUR;
    }
    
    int cpt,i,j;

    // regarder la verticale, en comptant le nombre de pions au Sud (inutile de regarder au Nord du pion qui vient de tomber)
    i = lig + 1;
    cpt = 0;
    while (i<LIGNE && laGrille[i][col]==lePion){
        cpt++;
        i++;
    }
    if (cpt>=3){
        return true;
    }

    // regarder l'horizontale, en comptant le nombre de pions Ã  l'Est et Ã  l'Ouest
    j = col-1;
    cpt = 0;
    // on regarde Ã  l'est
    while (j>=0 && laGrille[lig][j]==lePion){
        cpt++;
        j--;
    }
    j = col+1;
    // on regarde Ã  l'ouest
    while (j<COLONNE && laGrille[lig][j]==lePion){
        cpt++;
        j++;
    }
    if (cpt>=3 ){
        return true;
    }
    
    // regarder la diagonale descendante, en comptant le nombre de pions au Nord Ouest et au Sud Est
    i = lig-1;
    j = col-1;
    cpt = 0;
    // on regarde au Nord Ouest
    while (j>=0 && i>=0 && laGrille[i][j]==lePion){
        cpt++;
        i--;
        j--;
    }
    i = lig+1;
    j = col+1;
    // on regarde au Sud Est
    while (i<LIGNE && j<COLONNE && laGrille[i][j]==lePion){
        cpt++;
        i++;
        j++;
    }
    if (cpt>=3 ){
        return true;
    }
    // regarder la diagonale descendante, en comptant le nombre de pions au Nord Est et au Sud Ouest
    i = lig-1;
    j = col+1;
    cpt = 0;
    // on regarde au Nord Est
    while (j<COLONNE && i>=0 && laGrille[i][j]==lePion){
        cpt++;
        i--;
        j++;
    }
    i = lig+1;
    j = col-1;
    // on regarde au Sud Ouest
    while (i<LIGNE && j>=0 && laGrille[i][j]==lePion){
        cpt++;
        i++;
        j--;
    }
    if (cpt>=3 ){
        return true;
    }
    return false;
}


bool jeTePiege(t_grille laGrille, char lePion, int lig, int col)//AMELIORATION : verifie beaucoup plus de configurations differentes pour la meme strat que prévu initialement
{

    
    int cpt11, cpt12, cpt21, cpt22, i, j;
    // pas besoin de verifier la verticale car cette technique ne marche pas sur la verticale

    // regarder l'HORIZONTALE, en comptant le nombre de pions Ã  l'Est et Ã  l'Ouest
    j = col-1;
    cpt11 = 0;
    cpt12 = 0;
    cpt22 = 0;
    cpt21 = 0;
    // on regarde Ã  l'ouest
    //compte les jetons
    while (j>=0 && laGrille[lig][j]==lePion)
    {
        cpt11++;
        j--; 
    }
    //compte les trous
    while (j>=0 && laGrille[lig][j]==VIDE)
    {
        if (lig == 0 || laGrille[lig+1][j]!=VIDE)
        {
            cpt21++;
        }
        j--; 
    }

    j = col+1;
    // on regarde Ã  l'est
    //compte les jetons
    while (j<COLONNE && laGrille[lig][j]==lePion)
    {
        cpt12++;
        j++;
    }
    //compte les trous
    while (j<COLONNE && laGrille[lig][j]==VIDE){
        if (lig == 0 || laGrille[lig+1][j]!=VIDE)
        {
            cpt22++; 
        }
        j++;
    }

    //verifications
    if (cpt11==1 && cpt12==1 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    
    else if (cpt11>=2 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    else if (cpt12>=2 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    

    // regarder la DIAGONALE DESCENDANTE, en comptant le nombre de pions au Nord Ouest et au Sud Est
    i = lig-1;
    j = col-1;
    cpt11 = 0;
    cpt12 = 0;
    cpt22 = 0;
    cpt21 = 0;
    // on regarde au Nord Ouest//compte les jetons
    while (j>=0 && i>=0 && laGrille[i][j]==lePion)
    {
        cpt11++;
        i--;
        j--;
    }
    //compte les trous
    while (j>=0 && i>=0 && laGrille[i][j]==VIDE)
    {
        if (i == 0 || laGrille[i+1][j]!=VIDE)
        {
            cpt21++;
        }
        i--;
        j--;
    }



    i = lig+1;
    j = col+1;
    // on regarde au Sud Est
    //compte les jetons
    while (i<LIGNE && j<COLONNE && laGrille[i][j]==lePion)
    {
        cpt12++;
        i++;
        j++;
    }
    //compte les trous
    while (i<LIGNE && j<COLONNE && laGrille[i][j]==VIDE)
    {
        if (i == 0 || laGrille[i+1][j]!=VIDE)
        {
            cpt22++;
        }
        i++;
        j++;
    }



    //verifications
    if (cpt11==1 && cpt12==1 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    
    else if (cpt11>=2 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    else if (cpt12>=2 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }





    // regarder la DIAGONALE MONTANTE, en comptant le nombre de pions au Nord Est et au Sud Ouest
    i = lig-1;
    j = col+1;
    cpt11 = 0;
    cpt12 = 0;
    cpt22 = 0;
    cpt21 = 0;
    // on regarde au Nord Est
    //compte les jetons
    while (j<COLONNE && i>=0 && laGrille[i][j]==lePion)
    {
        cpt11++;
        i--;
        j++;
    }
    //compte les trous
    while (j<COLONNE && i>=0 && laGrille[i][j]==VIDE)
    {
        if ( i == 0 || laGrille[i+1][j]!=VIDE)
        {
            cpt21++;
        }
        i--;
        j++;
    }



    i = lig+1;
    j = col-1;
    // on regarde au Sud Ouest
    //compte les jetons
    while (i<LIGNE && j>=0 && laGrille[i][j]==lePion )
    {
        cpt12++;
        i++;
        j--;
    }
    //compte les trous
    while (i<LIGNE && j>=0 && laGrille[i][j]==VIDE)
    {
        if (i == 0 || laGrille[i+1][j]!=VIDE)
        {
            cpt22++;
        }
        i++;
        j--;
    }




    //verifications
    if (cpt11==1 && cpt12==1 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    
    else if (cpt11>=2 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    else if (cpt12>=2 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    return false;
}


bool tuMePiege(t_grille laGrille, char lePion, int lig, int col)//AMELIORATION : verifie beaucoup plus de configurations differentes pour la meme strat que prévu initialement
{
    if (lePion == JOUEUR)
    {
        lePion = ADVERSAIRE;
    }
    else
    {
        lePion = JOUEUR;
    }
    
    int cpt11, cpt12, cpt21, cpt22, i, j;
    // pas besoin de verifier la verticale car cette technique ne marche pas sur la verticale

    // regarder l'HORIZONTALE, en comptant le nombre de pions Ã  l'Est et Ã  l'Ouest
    j = col-1;
    cpt11 = 0;
    cpt12 = 0;
    cpt22 = 0;
    cpt21 = 0;
    // on regarde Ã  l'est
    //compte les jetons
    while (j>=0 && laGrille[lig][j]==lePion)
    {
        cpt11++;
        j--; 
    }
    //compte les trous
    while (j>=0 && laGrille[lig][j]==VIDE)
    {
        if (lig == 0 || laGrille[lig+1][j]!=VIDE)
        {
            cpt21++;
        }
        j--; 
    }

    j = col+1;
    // on regarde Ã  l'ouest
    //compte les jetons
    while (j<COLONNE && laGrille[lig][j]==lePion)
    {
        cpt12++;
        j++;
    }
    //compte les trous
    while (j<COLONNE && laGrille[lig][j]==VIDE){
        if (lig == 0 || laGrille[lig+1][j]!=VIDE)
        {
            cpt22++; 
        }
        j++;
    }

    //verifications
    if (cpt11==1 && cpt12==1 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    
    else if (cpt11>=2 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    else if (cpt12>=2 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    

    // regarder la DIAGONALE DESCENDANTE, en comptant le nombre de pions au Nord Ouest et au Sud Est
    i = lig-1;
    j = col-1;
    cpt11 = 0;
    cpt12 = 0;
    cpt22 = 0;
    cpt21 = 0;
    // on regarde au Nord Ouest//compte les jetons
    while (j>=0 && i>=0 && laGrille[i][j]==lePion)
    {
        cpt11++;
        i--;
        j--;
    }
    //compte les trous
    while (j>=0 && i>=0 && laGrille[i][j]==VIDE)
    {
        if (i == 0 || laGrille[i+1][j]!=VIDE)
        {
            cpt21++;
        }
        i--;
        j--;
    }



    i = lig+1;
    j = col+1;
    // on regarde au Sud Est
    //compte les jetons
    while (i<LIGNE && j<COLONNE && laGrille[i][j]==lePion)
    {
        cpt12++;
        i++;
        j++;
    }
    //compte les trous
    while (i<LIGNE && j<COLONNE && laGrille[i][j]==VIDE)
    {
        if (i == 0 || laGrille[i+1][j]!=VIDE)
        {
            cpt22++;
        }
        i++;
        j++;
    }



    //verifications
    if (cpt11==1 && cpt12==1 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    
    else if (cpt11>=2 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    else if (cpt12>=2 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }





    // regarder la DIAGONALE MONTANTE, en comptant le nombre de pions au Nord Est et au Sud Ouest
    i = lig-1;
    j = col+1;
    cpt11 = 0;
    cpt12 = 0;
    cpt22 = 0;
    cpt21 = 0;
    // on regarde au Nord Est
    //compte les jetons
    while (j<COLONNE && i>=0 && laGrille[i][j]==lePion)
    {
        cpt11++;
        i--;
        j++;
    }
    //compte les trous
    while (j<COLONNE && i>=0 && laGrille[i][j]==VIDE)
    {
        if ( i == 0 || laGrille[i+1][j]!=VIDE)
        {
            cpt21++;
        }
        i--;
        j++;
    }



    i = lig+1;
    j = col-1;
    // on regarde au Sud Ouest
    //compte les jetons
    while (i<LIGNE && j>=0 && laGrille[i][j]==lePion)
    {
        cpt12++;
        i++;
        j--;
    }
    //compte les trous
    while (i<LIGNE && j>=0 && laGrille[i][j]==VIDE)
    {
        if (i == 0 || laGrille[i+1][j]!=VIDE)
        {
            cpt22++;
        }
        i++;
        j--;
    }




    //verifications
    if (cpt11==1 && cpt12==1 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    
    else if (cpt11>=2 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    else if (cpt12>=2 && cpt21>=1 && cpt22>=1)
    {
        return true;
    }
    return false;
}


bool jeTePiege2(t_grille laGrille, char lePion, int lig, int col)//AMELIORATION : verifie beaucoup plus de configurations differentes pour la meme strat que prévu initialement
{
    
    int cpt, cpt1, cpt2, i, j;
    bool res;

    // regarder la VERTICALE, en comptant le nombre de pions au Sud (inutile de regarder au Nord du pion qui vient de tomber)
    //si les 2 en dessous sont lePion et que celui 2 au dessus est gagnant alors jouer ici
    i = lig+1;
    cpt = 0;
    cpt1 = 0;
    if (i<COLONNE-2)//verifie quon peut bel et bien check 2 en dessous
    {
        for(cpt = 0; cpt<2 ; cpt++)//ne fais que 2 fois
        {
            if (laGrille[i][col]==lePion)
            {
                cpt1++;
            }
            
            i++;
        }
    }
    if (cpt1==2 && lig >=2 && vicMtnMoi(laGrille, lePion, lig - 2, col))
    {
        return true;
    }
    


    // regarder l'HORIZONTALE, en comptant le nombre de pions Ã  l'Est et Ã  l'Ouest

    //CAS 1: le carré a vérifier est a une extremité

    j = col-1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;

    // on regarde Ã  l'ouest
    //verifie dabord en mettant le carré a une extrémité(1 4 6)
    while (j>=0 && (laGrille[lig][j]==lePion|| laGrille[lig][j]==VIDE) && cpt<3)
    {
        if (laGrille[lig][j]==VIDE)
        {
            if (vicMtnMoi(laGrille, lePion, lig-1, j))
            {
                res = true;
            }
            cpt1++;
        }
        
        cpt++;
        j--; 
    }
    if(cpt == 3 && res && cpt1 == 1)
    {
        return true;
    }

    j = col+1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    // on regarde Ã  l'est
    //verifie dabord en mettant le carré a une extrémité(1 4 6)
    while (j<COLONNE && (laGrille[lig][j]==lePion|| laGrille[lig][j]==VIDE) && cpt<3)
    {
        if (laGrille[lig][j]==VIDE)
        {
            if (vicMtnMoi(laGrille, lePion, lig-1, j))
            {
                res = true;
                cpt1++;
            }
        }
        cpt++;
        j++; 
    }
    if(cpt == 3 && res && cpt1 == 1)
    {
        return true;
    }

    //CAS 2.1 :l cas a verifier est au milieu des autres mais plus a l'est
    j = col-1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    //cherche du grand coté, a l'ouest
    while (j>=0 && (laGrille[lig][j]==lePion || laGrille[lig][j]==VIDE) && cpt<2)
    {
        if (laGrille[lig][j]==lePion)
        {
            cpt1++;
        }
        else if (laGrille[lig][j]==VIDE && vicMtnMoi(laGrille, lePion, lig-1, j))
        {
            cpt2++;
        }
        cpt++;
        j--; 
    }
    j = col+1;
    //cherche de l'autre coté, a l'est
    if (laGrille[lig][j]==lePion)
    {
        cpt1++;
        cpt++;
    }
    else if (laGrille[lig][j]==VIDE)
    {
        if (vicMtnMoi(laGrille, lePion, lig-1, j))
        {
            cpt2++;
        }
        cpt++;
    }
    //verification
    if(cpt == 3 && cpt2 == 1 && cpt1 == 2 )
    {
        return true;
    }

    //cas 2.2:l cas a verifier est au milieu des autres plus a louest
    j = col+1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    //compte les jetons
    while (j<COLONNE && (laGrille[lig][j]==lePion || laGrille[lig][j]==VIDE) && cpt<2)
    {
        if (laGrille[lig][j]==lePion)
        {
            cpt1++;
        }
        else if (laGrille[lig][j]==VIDE && vicMtnMoi(laGrille, lePion, lig-1, j))
        {
            cpt2++;
        }
        cpt++;
        j++; 
    }
    //cherche de l'autre coté, a l'est
    if (laGrille[lig][col-1]==lePion)
    {
        cpt1++;
        cpt++;
    }
    else if (laGrille[lig][col-1]==VIDE)
    {
        if (vicMtnMoi(laGrille, lePion, lig-1, j))
        {
            cpt2++;
        }
        cpt++;
    }
    //verification
    if(cpt == 3 && cpt2 == 1 && cpt1 == 2 )
    {
        return true;
    }


    // regarder la DIAGONALE DESCENDANTE, en comptant le nombre de pions au Nord Ouest et au Sud Est
    //CAS 1: le carré a vérifier est a une extremité
    j = col-1;
    i = lig-1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    // on regarde au Nord Ouest
    //verifie dabord en mettant le carré a une extrémité(1 4 6)
    while (j>=0 && i>=0 && (laGrille[i][j]==lePion|| laGrille[i][j]==VIDE) && cpt<3)
    {
        if (laGrille[i][j]==VIDE)
        {
            if (i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
            {
                res = true;
            }
        }
        cpt++;
        j--; 
        i--;
    }
    if(cpt==3 && res)
    {
        return true;
    }

    j = col+1;
    i = lig+1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    // on regarde au Sud Est
    //verifie dabord en mettant le carré a une extrémité(1 4 6)
    while (j<COLONNE && i<LIGNE && (laGrille[i][j]==lePion|| laGrille[i][j]==VIDE) && cpt<3)
    {
        if (laGrille[i][j]==VIDE)
        {
            if (i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
            {
                res = true;
            }
            
        }
        
        cpt++;
        j++;
        i++; 
    }
    if(cpt==3 && res)
    {
        return true;
    }



    //CAS 2.1:l cas a verifier est au milieu des autres mais plus a l'est
    j = col-1;
    i = lig-1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    //compte les jetons au nord ouest
    while (j>=0 && i>=0 && (laGrille[i][j]==lePion || laGrille[i][j]==VIDE) && cpt<2)
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
        }
        else if (laGrille[i][j]==VIDE && i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
        }
        cpt++;
        j--;
        i--;
    }
    
    //cherche de l'autre coté sud est
    j = col+1;
    i = lig+1;
    if (i<LIGNE && j<COLONNE )
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
            cpt++;
        }
        else if (laGrille[i][j]==VIDE && i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
            cpt++;
        }
    }
    
    //verification
    if(cpt == 3 && cpt2 == 1 && cpt1 == 2 )
    {
        return true;
    }

    //cas 2.2:l cas a verifier est au milieu des autres mais plus a l'ouest
    j = col+1;
    i = lig+1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    //compte les jetons au sud est
    while (j<COLONNE && i<LIGNE && (laGrille[i][j]==lePion || laGrille[i][j]==VIDE) && cpt<2)
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
        }
        else if (laGrille[i][j]==VIDE && i>= 1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
        }
        cpt++;
        j++; 
        i++;
    }
    //cherche de l'autre coté nord ouest
    j = col-1;
    i = lig-1;
    if (i>=0 && j>=0)
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
            cpt++;
        }
        else if (laGrille[i][j]==VIDE && i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
            cpt++;
        }
    }
    
    
    //verification
    if(cpt == 3 && cpt2 == 1 && cpt1 == 2 )
    {
        return true;
    }


    




    // regarder la DIAGONALE MONTANTE, en comptant le nombre de pions au Nord Est et au Sud Ouest
    //CAS 1: le carré a vérifier est a une extremité
    j = col+1;
    i = lig-1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    // on regarde au Nord est
    //verifie dabord en mettant le carré a une extrémité(1 4 6)
    while (j<=COLONNE && i>=0 && (laGrille[i][j]==lePion|| laGrille[i][j]==VIDE) && cpt<3)
    {
        if (laGrille[i][j]==VIDE)
        {
            if (i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
            {
                res = true;
            }
        }
        cpt++;
        j++; 
        i--;
    }
    if(cpt==3 && res)
    {
        return true;
    }

    j = col-1;
    i = lig+1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    // on regarde au Sud Ouest
    //verifie dabord en mettant le carré a une extrémité(1 4 6)
    while (j>=0 && (laGrille[i][j]==lePion|| laGrille[i][j]==VIDE) && cpt<3)
    {
        if (laGrille[i][j]==VIDE)
        {
            if (i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
            {
                res = true;
            }
            
        }
        
        cpt++;
        j--;
        i++; 
    }
    if(cpt==3 && res)
    {
        return true;
    }



    //CAS 2.1:l cas a verifier est au milieu des autres mais plus a l'ouest
    j = col+1;
    i = lig-1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    //compte les jetons au nord est
    while (j<COLONNE && i>=0 && (laGrille[i][j]==lePion || laGrille[i][j]==VIDE) && cpt<2)
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
        }
        else if (laGrille[i][j]==VIDE && i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
        }
        cpt++;
        j++;
        i--;
    }
    
    //cherche de l'autre coté sud ouest
    j = col-1;
    i = lig+1;
    if (i<LIGNE && j>=0 )
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
            cpt++;
        }
        else if (laGrille[i][j]==VIDE && i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
            cpt++;
        }
    }
    
    //verification
    if(cpt == 3 && cpt2 == 1 && cpt1 == 2 )
    {
        return true;
    }

    //cas 2.2:l cas a verifier est au milieu des autres mais plus a l'est
    j = col-1;
    i = lig+1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    //compte les jetons au sud ouest
    while (j>=0 && i<LIGNE && (laGrille[i][j]==lePion || laGrille[i][j]==VIDE) && cpt<2)
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
        }
        else if (laGrille[i][j]==VIDE && i>= 1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
        }
        cpt++;
        j--; 
        i++;
    }
    //cherche de l'autre coté nord est
    j = col+1;
    i = lig-1;
    if (i>=0 && j<COLONNE)
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
            cpt++;
        }
        else if (laGrille[i][j]==VIDE && i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
            cpt++;
        }
    }
    
    
    //verification
    if(cpt == 3 && cpt2 == 1 && cpt1 == 2 )
    {
        return true;
    }

    return false;//defaut
}


bool tuMePiege2(t_grille laGrille, char lePion, int lig, int col)//AMELIORATION : verifie beaucoup plus de configurations differentes pour la meme strat que prévu initialement
{
    if (lePion == JOUEUR)
    {
        lePion = ADVERSAIRE;
    }
    else
    {
        lePion = JOUEUR;
    }

    int cpt, cpt1, cpt2, i, j;
    bool res;

    // regarder la VERTICALE, en comptant le nombre de pions au Sud (inutile de regarder au Nord du pion qui vient de tomber)
    //si les 2 en dessous sont lePion et que celui 2 au dessus est gagnant alors jouer ici
    i = lig+1;
    cpt = 0;
    cpt1 = 0;
    if (i<=COLONNE-2)//verifie quon peut bel et bien check 2 en dessous
    {
        for(cpt = 0; cpt<2 ; cpt++)//ne fais que 2 fois
        {
            if (laGrille[i][col]==lePion)
            {
                cpt1++;
            }
            
            i++;
        }
    }
    if (cpt1==2 && lig >=2 && vicMtnMoi(laGrille, lePion, lig - 2, col))
    {
        return true;
    }
    


    // regarder l'HORIZONTALE, en comptant le nombre de pions Ã  l'Est et Ã  l'Ouest

    //CAS 1: le carré a vérifier est a une extremité

    j = col-1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;

    // on regarde Ã  l'ouest
    //verifie dabord en mettant le carré a une extrémité(1 4 6)
    while (j>=0 && (laGrille[lig][j]==lePion|| laGrille[lig][j]==VIDE) && cpt<3)
    {
        if (laGrille[lig][j]==VIDE)
        {
            if (vicMtnMoi(laGrille, lePion, lig-1, j))
            {
                res = true;
            }
            cpt1++;
        }
        
        cpt++;
        j--; 
    }
    if(cpt == 3 && res && cpt1 == 1)
    {
        return true;
    }

    j = col+1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    // on regarde Ã  l'est
    //verifie dabord en mettant le carré a une extrémité(1 4 6)
    while (j<COLONNE && (laGrille[lig][j]==lePion|| laGrille[lig][j]==VIDE) && cpt<3)
    {
        if (laGrille[lig][j]==VIDE)
        {
            if (vicMtnMoi(laGrille, lePion, lig-1, j))
            {
                res = true;
                cpt1++;
            }
        }
        cpt++;
        j++; 
    }
    if(cpt == 3 && res && cpt1 == 1)
    {
        return true;
    }

    //CAS 2.1 :l cas a verifier est au milieu des autres mais plus a l'est
    j = col-1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    //compte les jetons
    while (j>=0 && (laGrille[lig][j]==lePion || laGrille[lig][j]==VIDE) && cpt<2)
    {
        if (laGrille[lig][j]==lePion)
        {
            cpt1++;
        }
        else if (laGrille[lig][j]==VIDE && vicMtnMoi(laGrille, lePion, lig-1, j))
        {
            cpt2++;
        }
        cpt++;
        j--; 
    }
    j = col+1;
    //cherche de l'autre coté, a louest
    if (laGrille[lig][j]==lePion)
    {
        cpt1++;
        cpt++;
    }
    else if (laGrille[lig][j]==VIDE)
    {
        if (vicMtnMoi(laGrille, lePion, lig-1, j))
        {
            cpt2++;
        }
        cpt++;
    }
    //verification
    if(cpt == 3 && cpt2 == 1 && cpt1 == 2 )
    {
        return true;
    }

    //cas 2.2:l cas a verifier est au milieu des autres plus a louest
    j = col+1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    //compte les jetons
    while (j<COLONNE && (laGrille[lig][j]==lePion || laGrille[lig][j]==VIDE) && cpt<2)
    {
        if (laGrille[lig][j]==lePion)
        {
            cpt1++;
        }
        else if (laGrille[lig][j]==VIDE && vicMtnMoi(laGrille, lePion, lig-1, j))
        {
            cpt2++;
        }
        cpt++;
        j++; 
    }
    //cherche de l'autre coté, a l'est
    if (laGrille[lig][col-1]==lePion)
    {
        cpt1++;
        cpt++;
    }
    else if (laGrille[lig][col-1]==VIDE)
    {
        if (vicMtnMoi(laGrille, lePion, lig-1, j))
        {
            cpt2++;
        }
        cpt++;
    }
    //verification
    if(cpt == 3 && cpt2 == 1 && cpt1 == 2 )
    {
        return true;
    }


    // regarder la DIAGONALE DESCENDANTE, en comptant le nombre de pions au Nord Ouest et au Sud Est
    //CAS 1: le carré a vérifier est a une extremité
    j = col-1;
    i = lig-1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    // on regarde au Nord Ouest
    //verifie dabord en mettant le carré a une extrémité(1 4 6)
    while (j>=0 && i>=0 && (laGrille[i][j]==lePion|| laGrille[i][j]==VIDE) && cpt<3)
    {
        if (laGrille[i][j]==VIDE)
        {
            if (i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
            {
                res = true;
            }
        }
        cpt++;
        j--; 
        i--;
    }
    if(cpt==3 && res)
    {
        return true;
    }

    j = col+1;
    i = lig+1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    // on regarde au Sud Est
    //verifie dabord en mettant le carré a une extrémité(1 4 6)
    while (j<COLONNE && i<LIGNE && (laGrille[i][j]==lePion|| laGrille[i][j]==VIDE) && cpt<3)
    {
        if (laGrille[i][j]==VIDE)
        {
            if (i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
            {
                res = true;
            }
            
        }
        
        cpt++;
        j++;
        i++; 
    }
    if(cpt==3 && res)
    {
        return true;
    }



    //CAS 2.1:l cas a verifier est au milieu des autres mais plus a l'est
    j = col-1;
    i = lig-1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    //compte les jetons au nord ouest
    while (j>=0 && i>=0 && (laGrille[i][j]==lePion || laGrille[i][j]==VIDE) && cpt<2)
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
        }
        else if (laGrille[i][j]==VIDE && i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
        }
        cpt++;
        j--;
        i--;
    }
    
    //cherche de l'autre coté sud est
    j = col+1;
    i = lig+1;
    if (i<LIGNE && j<COLONNE )
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
            cpt++;
        }
        else if (laGrille[i][j]==VIDE && i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
            cpt++;
        }
    }
    
    //verification
    if(cpt == 3 && cpt2 == 1 && cpt1 == 2 )
    {
        return true;
    }

    //cas 2.2:l cas a verifier est au milieu des autres mais plus a l'ouest
    j = col+1;
    i = lig+1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    //compte les jetons au sud est
    while (j<COLONNE && i<LIGNE && (laGrille[i][j]==lePion || laGrille[i][j]==VIDE) && cpt<2)
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
        }
        else if (laGrille[i][j]==VIDE && i>= 1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
        }
        cpt++;
        j++; 
        i++;
    }
    //cherche de l'autre coté nord ouest
    j = col-1;
    i = lig-1;
    if (i>=0 && j>=0)
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
            cpt++;
        }
        else if (laGrille[i][j]==VIDE && i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
            cpt++;
        }
    }
    
    
    //verification
    if(cpt == 3 && cpt2 == 1 && cpt1 == 2 )
    {
        return true;
    }


    




    // regarder la DIAGONALE MONTANTE, en comptant le nombre de pions au Nord Est et au Sud Ouest
    //CAS 1: le carré a vérifier est a une extremité
    j = col+1;
    i = lig-1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    // on regarde au Nord est
    //verifie dabord en mettant le carré a une extrémité(1 4 6)
    while (j<=COLONNE && i>=0 && (laGrille[i][j]==lePion|| laGrille[i][j]==VIDE) && cpt<3)
    {
        if (laGrille[i][j]==VIDE)
        {
            if (i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
            {
                res = true;
            }
        }
        cpt++;
        j++; 
        i--;
    }
    if(cpt==3 && res)
    {
        return true;
    }

    j = col-1;
    i = lig+1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    // on regarde au Sud Ouest
    //verifie dabord en mettant le carré a une extrémité(1 4 6)
    while (j>=0 && (laGrille[i][j]==lePion|| laGrille[i][j]==VIDE) && cpt<3)
    {
        if (laGrille[i][j]==VIDE)
        {
            if (i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
            {
                res = true;
            }
            
        }
        
        cpt++;
        j--;
        i++; 
    }
    if(cpt==3 && res)
    {
        return true;
    }



    //CAS 2.1:l cas a verifier est au milieu des autres mais plus a l'ouest
    j = col+1;
    i = lig-1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    //compte les jetons au nord est
    while (j<COLONNE && i>=0 && (laGrille[i][j]==lePion || laGrille[i][j]==VIDE) && cpt<2)
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
        }
        else if (laGrille[i][j]==VIDE && i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
        }
        cpt++;
        j++;
        i--;
    }
    
    //cherche de l'autre coté sud ouest
    j = col-1;
    i = lig+1;
    if (i<LIGNE && j>=0 )
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
            cpt++;
        }
        else if (laGrille[i][j]==VIDE && i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
            cpt++;
        }
    }
    
    //verification
    if(cpt == 3 && cpt2 == 1 && cpt1 == 2 )
    {
        return true;
    }

    //cas 2.2:l cas a verifier est au milieu des autres mais plus a l'est
    j = col-1;
    i = lig+1;
    cpt = 0;
    cpt1 = 0;
    cpt2 = 0;
    res = false;
    //compte les jetons au sud ouest
    while (j>=0 && i<LIGNE && (laGrille[i][j]==lePion || laGrille[i][j]==VIDE) && cpt<2)
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
        }
        else if (laGrille[i][j]==VIDE && i>= 1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
        }
        cpt++;
        j--; 
        i++;
    }
    //cherche de l'autre coté nord est
    j = col+1;
    i = lig-1;
    if (i>=0 && j<COLONNE)
    {
        if (laGrille[i][j]==lePion)
        {
            cpt1++;
            cpt++;
        }
        else if (laGrille[i][j]==VIDE && i>=1 && vicMtnMoi(laGrille, lePion, i-1, j))
        {
            cpt2++;
            cpt++;
        }
    }
    
    
    //verification
    if(cpt == 3 && cpt2 == 1 && cpt1 == 2 )
    {
        return true;
    }

    return false;
}

bool jeTeCombo(t_grille laGrille, int lePion, int lig, int col){
    // checker à partir de la ligne 3 car en dessous pas possible de faire une liaison de 3 en verticale ou diagonale
    int i, j;
    int cpt1 = 0; // nombre pions nous appartenant à la suite à en horizontal : 0/1 ou 2
    int cpt2 = 0; // nombre pions nous appartenant à la suite en vertical        : 0/1 ou 2
    int cpt3 = 0; // nombre pions nous appartenant à la suite en diago montante      : 0/1 ou 2    
    int cpt4 = 0; // nombre pions nous appartenant à la suite en diago descendante      : 0/1 ou 2     
    int bk = 0; //nombre de bloc empechant puiss4 : o/1/2
    bool res = false;


    if (vicMtnMoi(laGrille, lePion, lig, col) == true)  // si placer un pion à cet indice de colonne nous fait gagner alors on le pose
    {
        res = true;
    }
    else{
        // checker si en dessous de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        while( j <= 2 && lig+j < LIGNE && laGrille[lig+j][col] == lePion) {
            cpt1++;
            j++;
        }
        if (lig-1 < 0)
        {
            bk++;
        }
        if (bk > 0)
        {
            cpt1=0;
        }


        // checker si à droite de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        bk = 0;
        
        while( j <= 2 && col+j < COLONNE && laGrille[lig][col+j] == lePion) {
            cpt2++;
            j++;
        }
        if ((col+j < COLONNE && laGrille[lig][col+j] != VIDE) || col+j >= COLONNE)
        {
            bk++;
        }
        
        
        // checker si à gauche de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        while( j <= 2 && col-j >= 0 && laGrille[lig][col-j] == lePion) {
            cpt2++;
            j++;
        }
        if ((col-j >= 0 && laGrille[lig][col-j] != VIDE) || col-j < 0)
        {
            bk++;
        }
        // vérification possibilité de puissance 4 après le combo
        if (bk > 1)
        {
            cpt2 = 0;
        }



        // checker si sur la diago descendante à droite de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        i = 1;
        bk = 0;
        while( j <= 2 && i<=2 && col+j < COLONNE && lig+i < LIGNE && laGrille[lig+i][col+j] == lePion) {
            cpt3++;
            i++;
            j++;
        }
        if ((col+j < COLONNE && lig+i < LIGNE && laGrille[lig+i][col+j] != VIDE) || lig+i >= LIGNE || col+j >= COLONNE)
        {
            bk++;
            
        }

        // checker si sur la diago descendante à gauche de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        i = 1;
        while( j <= 2 && col-j >= 0 && lig-i >= 0 && laGrille[lig-i][col-j] == lePion) {
            cpt3++;
            j++;
            i++;
        }
        if ((col-j >= 0 && lig-i >= 0 && laGrille[lig-i][col-j] != VIDE) || col-j < 0 || lig-i < 0)
        {
            bk++;
        }
        // vérification possibilité de puissance 4 après le combo
        if (bk > 1)
        {
            cpt3 = 0;
        }

        // checker si sur la diago montante à droite de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        i = 1;
        bk = 0;
        while( j <= 2 && i<=2 && col+j < COLONNE && lig-i >= 0 && laGrille[lig-i][col+j] == lePion) {
            cpt4++;
            i++;
            j++;
        }
        if ((col+j < COLONNE && lig-i >= 0 && laGrille[lig+i][col+j] != VIDE) || lig-i < 0 || col+j >= COLONNE)
        {
            bk++;
        }

        // checker si sur la diago montante à gauche de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        i = 1;
        while( j <= 2 && col-j >= 0 && lig+i < LIGNE && laGrille[lig+i][col-j] == lePion) {
            cpt4++;
            j++;
            i++;
        }
        if ((col-j >= 0 && lig+i < LIGNE && laGrille[lig+i][col-j] != VIDE) || col-j < 0 || lig+i >= LIGNE)
        {
            bk++;
        }
        // vérification possibilité de puissance 4 après le combo
        if (bk > 1)
        {
            cpt4 = 0;
        }


        if ((cpt1>=2 && cpt2>=2) || (cpt1>=2 && cpt3>=2) || (cpt1>=2 && cpt4>=2) ||(cpt2>=2 && cpt3>=2) || (cpt2>=2 && cpt4>=2) || (cpt3>=2 && cpt4>=2))
        {
            res=true;
        }
    }
        
    return res;
}


bool tuMeCombo(t_grille laGrille, int lePion, int lig, int col){
    // checker à partir de la ligne 3 car en dessous pas possible de faire une liaison de 3 en verticale ou diagonale
    int i, j;
    int cpt1 = 0; // nombre pions nous appartenant à la suite à en horizontal : 0/1 ou 2
    int cpt2 = 0; // nombre pions nous appartenant à la suite en vertical        : 0/1 ou 2
    int cpt3 = 0; // nombre pions nous appartenant à la suite en diago montante      : 0/1 ou 2    
    int cpt4 = 0; // nombre pions nous appartenant à la suite en diago descendante      : 0/1 ou 2     
    int bk = 0; //nombre de bloc empechant puiss4 : o/1/2
    bool res = false;
    if (lePion == JOUEUR)
    {
        lePion = ADVERSAIRE;
    }
    else
    {
        lePion = JOUEUR;
    }

    if (vicMtnToi(laGrille, lePion, lig, col) == true)  // si placer un pion à cet indice de colonne nous fait gagner alors on le pose
    {
        res = true;
    }
    else{
        // checker si en dessous de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        while( j <= 2 && lig+j < LIGNE && laGrille[lig+j][col] == lePion) {
            cpt1++;
            j++;
        }
        if (lig-1 < 0)
        {
            bk++;
        }
        if (bk > 0)
        {
            cpt1=0;
        }


        // checker si à droite de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        bk = 0;
        
        while( j <= 2 && col+j < COLONNE && laGrille[lig][col+j] == lePion) {
            cpt2++;
            j++;
        }
        if ((col+j < COLONNE && laGrille[lig][col+j] != VIDE) || col+j >= COLONNE)
        {
            bk++;
        }
        
        
        // checker si à gauche de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        while( j <= 2 && col-j >= 0 && laGrille[lig][col-j] == lePion) {
            cpt2++;
            j++;
        }
        if ((col-j >= 0 && laGrille[lig][col-j] != VIDE) || col-j < 0)
        {
            bk++;
        }
        // vérification possibilité de puissance 4 après le combo
        if (bk > 1)
        {
            cpt2 = 0;
        }



        // checker si sur la diago descendante à droite de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        i = 1;
        bk = 0;
        while( j <= 2 && i<=2 && col+j < COLONNE && lig+i < LIGNE && laGrille[lig+i][col+j] == lePion) {
            cpt3++;
            i++;
            j++;
        }
        if ((col+j < COLONNE && lig+i < LIGNE && laGrille[lig+i][col+j] != VIDE) || lig+i >= LIGNE || col+j >= COLONNE)
        {
            bk++;
            
        }

        // checker si sur la diago descendante à gauche de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        i = 1;
        while( j <= 2 && col-j >= 0 && lig-i >= 0 && laGrille[lig-i][col-j] == lePion) {
            cpt3++;
            j++;
            i++;
        }
        if ((col-j >= 0 && lig-i >= 0 && laGrille[lig-i][col-j] != VIDE) || col-j < 0 || lig-i < 0)
        {
            bk++;
        }
        // vérification possibilité de puissance 4 après le combo
        if (bk > 1)
        {
            cpt3 = 0;
        }

        // checker si sur la diago montante à droite de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        i = 1;
        bk = 0;
        while( j <= 2 && i<=2 && col+j < COLONNE && lig-i >= 0 && laGrille[lig-i][col+j] == lePion) {
            cpt4++;
            i++;
            j++;
        }
        if ((col+j < COLONNE && lig-i >= 0 && laGrille[lig+i][col+j] != VIDE) || lig-i < 0 || col+j >= COLONNE)
        {
            bk++;
        }

        // checker si sur la diago montante à gauche de l'indice colonne on retrouve 2 pions à nous
        j = 1;
        i = 1;
        while( j <= 2 && col-j >= 0 && lig+i < LIGNE && laGrille[lig+i][col-j] == lePion) {
            cpt4++;
            j++;
            i++;
        }
        if ((col-j >= 0 && lig+i < LIGNE && laGrille[lig+i][col-j] != VIDE) || col-j < 0 || lig+i >= LIGNE)
        {
            bk++;
        }
        // vérification possibilité de puissance 4 après le combo
        if (bk > 1)
        {
            cpt4 = 0;
        }


        if ((cpt1>=2 && cpt2>=2) || (cpt1>=2 && cpt3>=2) || (cpt1>=2 && cpt4>=2) ||(cpt2>=2 && cpt3>=2) || (cpt2>=2 && cpt4>=2) || (cpt3>=2 && cpt4>=2))
        {
            res=true;
        }
    }
        
    return res;
}



bool alignSimple(t_grille laGrille, char lePion, int lig, int col)
{
    //ne joue que si il y a une posibilité de victoire par la suite
    int cpt,i,j, v;

    // regarder la verticale, en comptant le nombre de pions au Sud (inutile de regarder au Nord du pion qui vient de tomber)
    i = lig + 1;
    cpt = 0;
    while (i<LIGNE && laGrille[i][col]==lePion){
        cpt++;
        i++;
    }
    //verifie si une victoire peut etre envisagée
    if (cpt>=2 && laGrille[lig-1][col]==VIDE){
        return true;
    }

    // regarder l'horizontale, en comptant le nombre de pions Ã  l'Est et Ã  l'Ouest
    j = col-1;
    cpt = 0;
    v = 0;
    // on regarde Ã  l'est
    while (j>=0 && laGrille[lig][j]==lePion){
        cpt++;
        j--;
    }
    //verifie si une victoire peut etre envisagée
    if (laGrille[lig][j]==VIDE)
    {
        v++;
    }
    
    j = col+1;
    // on regarde Ã  l'ouest
    while (j<COLONNE && laGrille[lig][j]==lePion){
        cpt++;
        j++;
    }
    //verifie si une victoire peut etre envisagée
    if (laGrille[lig][j]==VIDE)
    {
        v++;
    }
    if (cpt>=2 && v>=1){
        return true;
    }
    
    // regarder la diagonale descendante, en comptant le nombre de pions au Nord Ouest et au Sud Est
    i = lig-1;
    j = col-1;
    cpt = 0;
    v = 0;
    // on regarde au Nord Ouest
    while (j>=0 && i>=0 && laGrille[i][j]==lePion){
        cpt++;
        i--;
        j--;
    }
    //verifie si une victoire peut etre envisagée
    if (laGrille[i][j]==VIDE)
    {
        v++;
    }
    i = lig+1;
    j = col+1;
    
    // on regarde au Sud Est
    while (i<LIGNE && j<COLONNE && laGrille[i][j]==lePion){
        cpt++;
        i++;
        j++;
    }
    //verifie si une victoire peut etre envisagée
    if (laGrille[i][j]==VIDE)
    {
        v++;
    }
    if (cpt>=2 && v>=1){
        return true;
    }
    // regarder la diagonale descendante, en comptant le nombre de pions au Nord Est et au Sud Ouest
    i = lig-1;
    j = col+1;
    cpt = 0;
    v = 0;
    // on regarde au Nord Est
    while (j<COLONNE && i>=0 && laGrille[i][j]==lePion){
        cpt++;
        i--;
        j++;
    }
    //verifie si une victoire peut etre envisagée
    if (laGrille[i][j]==VIDE)
    {
        v++;
    }
    i = lig+1;
    j = col-1;
    // on regarde au Sud Ouest
    while (i<LIGNE && j>=0 && laGrille[i][j]==lePion){
        cpt++;
        i++;
        j--;
    }
    //verifie si une victoire peut etre envisagée
    if (laGrille[i][j]==VIDE)
    {
        v++;
    }
    if (cpt>=2 && v>=1){
        return true;
    }
    return false;
}


bool randCentre(t_grille laGrille, char lePion, int lig, int col)//AMELIORATION : joue dans la colonne la plus au centre en hauteur au lieu de la colonne la plus basse prévu initialement
{
    const int MID = 3;
    const int MID2 = 2;
    bool res = false;
    int a , b , c;
    
    if (col == 3)
    {
        a = lig; 
        b = chercherLigne(laGrille,2);
        c = chercherLigne(laGrille, 4);
        if(a>=MID)
        {
            a= a-MID;
        }
        else
        {
            a = -a+MID2;
        }
        if (b>=MID)
        {
            b = b-MID;
        }
        else
        {
            b = -b+MID2;
        }
        if (c>=MID)
        {
            c = c-MID;
        }
        else
        {
            c = -c+MID2;
        }
        if (a>=b && a>=c)
        {
            res=true;
        }
        
    }

    else if (col == 2)
    {
        a = lig; 
        b = chercherLigne(laGrille,3);
        c = chercherLigne(laGrille, 4);
        if(a>=MID)
        {
            a= a-MID;
        }
        else
        {
            a = -a+MID2;
        }
        if (b>=MID)
        {
            b = b-MID;
        }
        else
        {
            b = -b+MID2;
        }
        if (c>=MID)
        {
            c = c-MID;
        }
        else
        {
            c = -c+MID2;
        }
        if (a>=b && a>=c)
        {
            res=true;
        }
    }
    
    else if (col == 4)
    {
        a = lig; 
        b = chercherLigne(laGrille,2);
        c = chercherLigne(laGrille, 3);
        if(a>=MID)
        {
            a= a-MID;
        }
        else
        {
            a = -a+MID2;
        }
        if (b>=MID)
        {
            b = b-MID;
        }
        else
        {
            b = -b+MID2;
        }
        if (c>=MID)
        {
            c = c-MID;
        }
        else
        {
            c = -c+MID2;
        }
        if (a>=b && a>=c)
        {
            res=true;
        }
    }
    return res;
}


bool randCentre2(t_grille laGrille, char lePion, int lig, int col)//AMELIORATION : joue dans la colonne la plus au centre en hauteur au lieu de la colonne la plus basse prévu initialement
{
    bool res = false;
    int a, b;
    const int MID = 3;
    const int MID2 = 2;
    if (col == 5)
    {
        a = lig; 
        b = chercherLigne(laGrille,1);
        if(a>=MID)
        {
            a= a-MID;
        }
        else
        {
            a = -a+MID2;
        }
        if (b>=MID)
        {
            b = b-MID;
        }
        else
        {
            b = -b+MID2;
        }
        if (a>=b)
        {
            res=true;
        }
    }
    else if (col == 1)
    {
        a = lig; 
        b = chercherLigne(laGrille,5);
        if(a>=MID)
        {
            a= a-MID;
        }
        else
        {
            a = -a+MID2;
        }
        if (b>=MID)
        {
            b = b-MID;
        }
        else
        {
            b = -b+MID2;
        }
        if (a>=b)
        {
            res=true;
        }
    }
    return res;
}


bool randCentre3(t_grille laGrille, char lePion, int lig, int col)//AMELIORATION : joue dans la colonne la plus au centre en hauteur au lieu de la colonne la plus basse prévu initialement
{
    bool res = false;
    int a, b;
    const int MID = 3;
    const int MID2 = 2;
    if (col == 6)
    {
        a = lig; 
        b = chercherLigne(laGrille,0);
        if(a>=MID)
        {
            a= a-MID;
        }
        else
        {
            a = -a+MID2;
        }
        if (b>=MID)
        {
            b = b-MID;
        }
        else
        {
            b = -b+MID2;
        }
        if (a>=b)
        {
            res=true;
        }
    }
    else if (col == 0)
    {
        a = lig; 
        b = chercherLigne(laGrille,6);
        if(a>=MID)
        {
            a= a-MID;
        }
        else
        {
            a = -a+MID2;
        }
        if (b>=MID)
        {
            b = b-MID;
        }
        else
        {
            b = -b+MID2;
        }
        if (a>=b)
        {
            res=true;
        }
    }
    return res;
}