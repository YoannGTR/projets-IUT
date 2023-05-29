/**
 * @file Puissance4Final.c
 * 
 * @author GAUTIER Yoann
 * 
 * @brief Programme de puissance 4
 * 
 * @version 1.0
 * 
 * @date 26 novembre 2022
 * 
 * Ce programme permet de jouer au puissance 4 contre 
 * un autre utilisateur dans un même terminal
 * 
 */

#include <stdlib.h>
#include <stdio.h>
#include <stdbool.h>


/*************************************************
 *                    MACROS                     *
*************************************************/

/**
 * @def NBLIG
 * 
 * @brief Définit le nombre de lignes max d'un tableau
 * 
 */
#define NBLIG 6

/**
 * @def NBCOL
 * 
 * @brief Définit le nombre de colonnes max d'un tableau
 * 
 */
#define NBCOL 7


/**
 * @def COLOR_BOLD
 * 
 * @brief Permet d'afficher le texte qui suit en gras 
 * 
 */
#define COLOR_BOLD  "\e[1m"

/**
 * @def COLOR_OFF
 * 
 * @brief Permet d'afficher le texte qui suit avec les paramètres par défaut
 * 
 */
#define COLOR_OFF   "\e[m"


/****************************************************
 *                    CONSTANTES                    *
****************************************************/

/**
 * @var char PION_A
 * 
 * @brief Constante pour le caractère correspondant au 1er pion
 * 
 */
const char PION_A = 'x';
/**
 * @var char PION_B
 * 
 * @brief Constante pour le caractère correspondant au 2e pion
 * 
 */
const char PION_B = 'o';
/**
 * @var char VIDE
 * 
 * @brief Constante pour le caractère correspondant à une case vide
 * 
 */
const char VIDE = '_';
/**
 * @var INCONNU
 * 
 * @brief Constante pour le caractère correspondant a un vainqueur inexistant
 * 
 */
const char INCONNU = ' ';
/**
 * @var int COLONNE_DEBUT
 * 
 * @brief Constante pour le numéro de la colonne du millieu
 * 
 * C'est a cet endroit que ce place le jeton au dessus de la grille
 * 
 */
const int COLONNE_DEBUT = NBCOL/2;
/**
 * @var char Q
 * 
 * @brief Constante pour le caractère correspondant à l'action utilisateur de déplacer son jeton vers la gauche
 * 
 */
const char Q = 'Q';
/**
 * @var char D
 * 
 * @brief Constante pour le caractère correspondant à l'action utilisateur de déplacer son jeton vers la droite
 * 
 */
const char D = 'D';
/**
 * @var char ESPACE
 * 
 * @brief Constante pour le caractère correspondant à l'action utilisateur de placer son jeton
 * 
 */
const char ESPACE = ' ';


/**
 * @typedef tab
 * 
 * @brief Type tableau à 2 dimensions de NBLIG lignes et NBCOL colonnes
 * 
 * Le type tab sert a stocker la position des pions jouées dans la grille
 */
typedef char tab[NBLIG][NBCOL];


/*****************************************************
 *      DECLARATION DES PROCEDURES ET FONCTIONS      *
*****************************************************/

//procédures de début partie
void initGrille(tab grilleDebut);
bool afficherGrille(tab grille, char pion, int colonne);

//procédures et fonctions d'interraction utilisateur pour jouer
void jouer(tab grille, char pion, int *ligne, int *colonne);
int choisirColonne(tab grille, char pion, int colonne);
int trouverLigne(tab grille, int colonne);

//fonctions de vérification de fin de partie
bool grillePleine(tab grille);
bool estVainqueur(tab grille, int ligne, int colonne);
bool victoireHorizontale(tab grille,int ligne, int colonne, char pion);
bool victoireVerticale(tab grille,int ligne, int colonne, char pion);
bool victoireDiagonale1(tab grille,int ligne, int colonne, char pion);
bool victoireDiagonale2(tab grille,int ligne, int colonne, char pion);

//procédure d'affichage de fin de partie
void finDePartie(char pion);



/*****************************************************
 *                PROGRAMME PRINCIPAL                *
*****************************************************/

/**
 * @fn int main()
 * 
 * @brief Programme principal
 * 
 * @return 0 : le programme s'est bien éxecuté
 * 
 * Initialise les variables, prépare le debut de la partie.
 * Puis permet aux 2 joueurs de jouer chacun leur tour jusqu'a ce que la partie soit finie.
 * Enfin, affiche le nom du vainqueur, sinon une égalité.
 */
int main()
{
    //initialisation des variables
    char vainqueur;
    int ligne, colonne;
    tab grille;

    //préparation de la partie 
    initGrille(grille);
    vainqueur = INCONNU;
    afficherGrille(grille, PION_A, COLONNE_DEBUT);
    
    //jeu
    while (vainqueur==INCONNU && !grillePleine(grille))
    {
        //tour du 1er joueur
        printf("\nJoueur \"%c\", à toi de jouer :)\n", PION_A);
        jouer(grille, PION_A, &ligne, &colonne);
        afficherGrille(grille, PION_B, COLONNE_DEBUT);

        //vérifie si la partie est finie
        if (estVainqueur(grille, ligne, colonne))
        {
            vainqueur= PION_A;
        }
        else if (!grillePleine(grille))
        {
            //tour du 2e joueur
            printf("\nJoueur \"%c\", à toi de jouer :)\n", PION_B);
            jouer(grille, PION_B, &ligne, &colonne);
            afficherGrille(grille, PION_A, COLONNE_DEBUT);

            //vérifie si la partie est finie
            if (estVainqueur(grille, ligne, colonne))
            {
                vainqueur = PION_B;
            }
        }
    }

    //fin de la partie
    finDePartie(vainqueur);

    return EXIT_SUCCESS;
}

/*****************************************************
 *           PROCEDURES DE DEBUT DE PARTIE           *
*****************************************************/
/**
 * @brief Initialise le tableau grilleDebut
 * 
 * @param grilleDebut de type tab en entrée/sortie : le tableau à initialiser
 * 
 * Initialise le tableau grilleDebut en remplissant chaque case du tableau avec des _
 */
void initGrille(tab grilleDebut)
{
    for (int i = 0; i < NBLIG; i++)
    {
        for (int j = 0; j < NBCOL; j++)
        {
            grilleDebut[i][j] = VIDE;
        }
        
    }
}



/**
 * @fn bool afficherGrille(tab grille, char pion, int colonne)
 * 
 * @brief Affiche le jeu du puissance 4
 * 
 * @param grille de type tab en entrée : le tableau a afficher pour former la grille
 * @param pion de type char en entrée : le pion qui s'apprête à jouer
 * @param colonne de type int en entrée : la colonne au dessus de laquelle s'affiche le pion qui est en train d'être joué
 * @return true : il y a une victoire
 * @return false : il y n'y a pas de victoire
 * 
 * Vide le terminal 
 * Affiche les règles du jeu
 * Affiche le jeton à jouer
 * Affiche la grille composé des cases du tableau grille encadré par des []
 * Vérifie si il y a victoire,  et si c'est le cas, les jetons gagnants se mettent en gras
 * Affiche les touches pour jouer sur le coté de la grille
 */
bool afficherGrille(tab grille, char pion, int colonne)
{
    system("clear");//permet d'envoyer une commande au terminal: en l'occurence ici, "clear", ce qui permet denlever tout ce qui etait affiché dans le terminal

    //initialisations des variables
    int i;
    int j;
    bool vainqueur = false;

    //affiche les regles du jeu
    printf("BUT du JEU : aligner 4 de ses jetons horizontalement,\nverticalement ou diagonalement le premier.\n\nDÉROULEMENT DU JEU\nLe puissance 4 se joue à 2 joueurs qui jouent chacun leur tour. Ils\nchoisissent la colonne dans laquelle ils souhaitent placer leur\njeton. Le jeton tombe alors à l’emplacement libre le plus bas de la colonne.\nLa partie s’arrête avec la victoire de l’un des joueurs lorsqu’il\narrive à aligner 4 de ses jetons ou par une égalité lorsqu’il n’y a\nplus d’emplacement disponible pour le jetons.\n\n");

    for (i = 0; i <= NBLIG; i++)//<= car on affiche une ligne en plus au début pour deplacer le jeton
    {
        if(i==0)
        {
            //ligne ou s'affiche le jeton que l'on déplace
            for (j = 0; j <= NBCOL; j++)
            {
                //met le jeton au dessus de la colonne que choisit le joueur, sinon au dessus de COLONNE_DEBUT
                if (j == colonne)
                {
                    printf(" %c ", pion);
                }
                else
                {
                    printf("    ");
                }                
            }
            printf("\n");
        }
        else
        {
            //lignes de la grille
            for (j = 0; j < NBCOL; j++)
            {
                //cases de la grille
                if (pion == PION_A)
                {
                    //lorsque c'est à A de jouer, on vérifie si chaque pion du joueur B est vainqueur grace aux fonctions victoire* . Si c'est le cas, on met vainqueur à true
                    if ((grille[i-1][j] == PION_B) && (victoireDiagonale1(grille, i-1, j, PION_B) || victoireDiagonale2(grille, i-1, j, PION_B) || victoireHorizontale(grille, i-1, j, PION_B) || victoireVerticale(grille, i-1, j, PION_B)))
                    {
                        vainqueur = true;
                    }
                    else//sinon on ecris la case normalement
                    {
                        printf("[%c] " , grille[i-1][j]);
                    }
                }
                else if (pion == PION_B)
                {
                    //lorsque c'est à B de jouer, on vérifie si chaque pion de A est vainqueur grace aux fonctions victoire* . Si c'est le cas, on met vainqueur à true
                    if ((grille[i-1][j] == PION_A) && (victoireDiagonale1(grille, i-1, j, PION_A) || victoireDiagonale2(grille, i-1, j, PION_A) || victoireHorizontale(grille, i-1, j, PION_A) || victoireVerticale(grille, i-1, j, PION_A)))
                    {
                        vainqueur = true;
                    }
                    else//sinon on ecris la case normalement
                    {
                        printf("[%c] " , grille[i-1][j]);
                    }
                }
                
            }
            //affiche les commandes sur le coté de la grille
            switch (i)
            {
                case 1:
                    printf("  Commandes :");
                    break;
                case 2:
                    printf("  Q : déplacer le jeton vers la gauche");
                    break;
                case 3:
                    printf("  D : déplacer le jeton vers la droite");
                    break;
                case 4:
                    printf("  ESPACE : placer le jeton");
                    break;
            }
            printf("\n");
            
        }
    }
    
    return vainqueur;
}




/**
 * @fn int choisirColonne(tab grille, char pion, int colonne)
 * 
 * @brief Permet de déplacer le jeton que le joueur s'apprete à jouer.
 * 
 * @param grille de type tab en entrée : le tableau de la grille au dessus de laquelle le joueur se déplace 
 * @param pion de type char en entrée : le pion que le joueur déplace
 * @param colonne de type int en entrée : la colonne au dessus de laquelle se situe le pion au début de la fonction
 * @return int : numéro de la colonne choisie par le joueur
 * 
 * Le jeton se déplace au dessus de la grille grace à Q et D. 
 * Si un autre caractère est saisie ou que plusieurs caractères sont utilisés en meme temps, ils ne sont pas comptabilisés. Le pion ne peut pas aller à plus de 3 cases de la colonne de départ.
 * A chaque déplacement on réaffiche la grille.
 * La fonction s'arrete lorsque le joueur valide la colonne avec espace et la fonction retourne le numéro de la colonne.
 */
int choisirColonne(tab grille, char pion, int colonne)
{
    //déclaration des variables
    int colonneFin = colonne;
    int decalage = 0;
    char caractere = '?';
    
    
    
    while (caractere != ESPACE)
    {
        //lis le caractère du joueur
        caractere = getchar();

        //permet d'eviter les retours chariots et la lecture de plusieurs caracteres a la suite. En effet, on met a à 0 ce qui nous fait rentrer dans la boucle, puis on lui attribue la valeur de getchar jusqu'a ce que a vaille le caractère du retour chariot(la touche entrée \n)ou qui'il vaille ce que renvoie getchar lorsque il n'a rien lu(EOF)
        int a = 0; 
        while (a != '\n' && a != EOF)
        { 
            a = getchar ();
        }      



        if (caractere == Q)//si le caractere lu est q, le pion se déplace a gauche sauf si il est déja sur la colonne tout a gauche
        {
            if(decalage>-3)
            {
                decalage--;
                colonneFin = colonne + decalage;
            }
        }
        else if (caractere == D)//si le caractere lu est d, le pion se déplace a droite sauf si il est déjà sur la colonne tout à droite
        {
            if(decalage<3)
            {
                decalage++;
                colonneFin = colonne + decalage;             
            }
        }
        //affiche la le jeu avec le pion décallé si il l'est
        afficherGrille(grille, pion, colonneFin);
        printf("\nJoueur \"%c\", à toi de jouer :)\n", pion);
    }

    return colonneFin;
}



/**
 * @fn int trouverLigne(tab grille, int colonne)
 * 
 * @brief Cherche dans la ligne où le pion se place
 * 
 * @param grille de type tab en entrée : le tableau dans lequel on va venir chercher une ligne disponible
 * @param colonne de type int en entrée : la colonne choisie par le joueur
 * @return int : le numéro de la ligne où le jeton se place
 * @return int : -1 si aucune ligne n'est disponible
 * 
 * Cherche la premiere ligne disponible de la colonne choisie et entrée en parametre, en partant du bas. 
 * 
 */
int trouverLigne(tab grille, int colonne)
{
    //déclaration des variables
    int ligne = NBLIG - 1;
    bool pleine = false;
    
    //cherche une ligne vide en partant de la cases du bas et remontant jusqu'en haut. Continue jusqu'a ce que toute les cases soient vérifiées ou que une des cases soit vide
    while (VIDE!=grille[ligne][colonne] && pleine == false)
    {
        if(ligne>0)
        {
           ligne--; 
        }
        else
        {
            pleine = true;
            ligne = -1;
        }
    }
    return ligne;
}







/**
 * @fn void jouer(tab grille, char pion, int *ligne, int *colonne)
 * 
 * @brief Fais jouer un joueur et place le jeton à la place choisie dans la grille
 * 
 * @param grille de type tab en entrée/sortie : le tableau de la grille dans laquelle on va jouer
 * @param pion de type char en entrée : le pion qui joue ce tour-ci
 * @param ligne de type int en entrée/sortie : la ligne où le jeton est placé
 * @param colonne de type int en entrée/sortie : la colonne où le jeton est placé
 * 
 * Permet de choisir la colonne où on joue puis vérifie si on peut jouer dans cette colonne. 
 * Si c'est le cas, place le jeton dans la grille, sinon recommence. 
 * Donne en paramètres d'entrée-sortie la colonne et la ligne où le pion a été joué.
 */
void jouer(tab grille, char pion, int *ligne, int *colonne)
{
    *ligne = -1;
    while( *ligne == -1)
    {
        
        *colonne = choisirColonne(grille, pion, COLONNE_DEBUT);
        *ligne = trouverLigne(grille, *colonne);

        
    }
    grille[*ligne][*colonne] = pion;
    
    
}


/**
 * @fn bool grillePleine(tab grille)
 * 
 * @brief Vérifie si la grille est pleine
 * 
 * @param grille de type tab en entrée : le tableau à vérifier
 * @return true : le tableau est plein
 * @return false : il reste de la place dans le tableau
 */
bool grillePleine(tab grille)
{
    //declaration des variables
    bool pleine = true;

    //vérifie si chaque cases de la grille est remplie. 
    for (int i = 0; i < NBLIG; i++)
    {
        for (int j = 0; j < NBCOL; j++)
        {
            if (grille[i][j]==VIDE)
            {
                pleine = false;
            }
        }  
    } 
    return pleine;  
}



/**
 * @fn bool victoireHorizontale(tab grille,int ligne, int colonne, char pion)
 * 
 * @brief Vérifie si il y a une victoire horizontalement
 * 
 * @param grille de type tab en entrée : le tableau à vérifier
 * @param ligne de type int en entrée : la ligne du pion a vérifier
 * @param colonne de type int en entrée : la colonne du pion a vérifier
 * @param pion de type char en entrée : le pion que l'on doit vérifier
 * @return true : le pion fait partie des pions vainqueurs
 * @return false : le pion ne fait pas partie des éventuels pions vainqueurs
 * 
 * Si le pion fait partie des pions vainqueurs, il s'affiche en gras
 */
bool victoireHorizontale(tab grille,int ligne, int colonne, char pion)
{
   
    bool vainqueur = false;

    //verifie tout les cas de victoire horizontale possible du pion
    if (
        (colonne-3 >= 0 && pion == grille[ligne][colonne-1] && pion == grille[ligne][colonne-2] && pion == grille[ligne][colonne-3]) || 
        (colonne-2 >= 0 && colonne+1 < NBCOL && pion == grille[ligne][colonne-1] && pion == grille[ligne][colonne-2] && pion == grille[ligne][colonne+1]) || 
        (colonne-1 >= 0 && colonne+2 < NBCOL && pion == grille[ligne][colonne-1] && pion == grille[ligne][colonne+2] && pion == grille[ligne][colonne+1]) || 
        (colonne+3 < NBCOL && pion == grille[ligne][colonne+3] && pion == grille[ligne][colonne+2] && pion == grille[ligne][colonne+1])
        )
    {
        vainqueur = true;
        
        printf("[");
        printf(COLOR_BOLD"%c"COLOR_OFF , pion);//COLOR_BOLD permet de mettre le texte en gras et COLOR_OFF permet de reinitialiser par défaut sa mise en forme
        printf("] ");
       
    }
    return vainqueur;
}


/**
 * @fn bool victoireVerticale(tab grille,int ligne, int colonne, char pion)
 * 
 * @brief Vérifie si il y a une victoire verticalement
 * 
 * @param grille de type tab en entrée : le tableau à vérifier
 * @param ligne de type int en entrée : la ligne du pion a vérifier
 * @param colonne de type int en entrée : la colonne du pion a vérifier
 * @param pion de type char en entrée : le pion que l'on doit vérifier
 * @return true : le pion fait partie des pions vainqueurs
 * @return false : le pion ne fait pas partie des éventuels pions vainqueurs
 * 
 * Si le pion fait partie des pions vainqueurs, il s'affiche en gras
 */
bool victoireVerticale(tab grille,int ligne, int colonne, char pion)
{
    bool vainqueur = false;

    //verifie tout les cas de victoire verticale possible du pion
    if (
        (ligne-3 >= 0 && pion == grille[ligne-1][colonne] && pion == grille[ligne-2][colonne] && pion == grille[ligne-3][colonne]) ||
        (ligne-2 >= 0 && ligne+1 < NBLIG && pion == grille[ligne-1][colonne] && pion == grille[ligne-2][colonne] && pion == grille[ligne+1][colonne]) ||
        (ligne-1 >= 0 && ligne+2 < NBCOL && pion == grille[ligne-1][colonne] && pion == grille[ligne+2][colonne] && pion == grille[ligne+1][colonne]) ||
        (ligne+3 < NBLIG && pion == grille[ligne+3][colonne] && pion == grille[ligne+2][colonne] && pion == grille[ligne+1][colonne])
        )
    {
        vainqueur = true;
        printf("[");
        printf(COLOR_BOLD"%c"COLOR_OFF , pion);//COLOR_BOLD permet de mettre le texte en gras et COLOR_OFF permet de reinitialiser par défaut sa mise en forme
        printf("] ");
    }
    return vainqueur;
}

/**
 * @fn bool victoireDiagonale1(tab grille,int ligne, int colonne, char pion)
 * 
 * @brief Vérifie si il y a une victoire diagonalement du haut à gauche au bas à droite
 * 
 * @param grille de type tab en entrée : le tableau à vérifier
 * @param ligne de type int en entrée : la ligne du pion a vérifier
 * @param colonne de type int en entrée : la colonne du pion a vérifier
 * @param pion de type char en entrée : le pion que l'on doit vérifier
 * @return true : le pion fait partie des pions vainqueurs
 * @return false : le pion ne fait pas partie des éventuels pions vainqueurs
 * 
 * Si le pion fait partie des pions vainqueurs, il s'affiche en gras
 */
bool victoireDiagonale1(tab grille,int ligne, int colonne, char pion)
{
    bool vainqueur = false;

    //verifie tout les cas de victoire diagonale haut-gauche->bas-droite possible du pion
    if (
        (colonne-3 >= 0 && ligne-3 >= 0 && pion == grille[ligne-1][colonne-1] && pion == grille[ligne-2][colonne-2] && pion == grille[ligne-3][colonne-3]) || 
        (ligne+1 < NBLIG && colonne-2 >= 0 && ligne-2 >= 0 && colonne+1 < NBCOL && pion == grille[ligne-1][colonne-1] && pion == grille[ligne-2][colonne-2] && pion == grille[ligne+1][colonne+1]) || 
        (ligne+2 < NBLIG && colonne-1 >= 0 && ligne-1 >= 0 && colonne+2 < NBCOL && pion == grille[ligne-1][colonne-1] && pion == grille[ligne+2][colonne+2] && pion == grille[ligne+1][colonne+1]) || 
        (ligne+3 < NBLIG && colonne+3 < NBCOL && pion == grille[ligne+3][colonne+3] && pion == grille[ligne+2][colonne+2] && pion == grille[ligne+1][colonne+1])
        )
    {
        vainqueur = true;
        printf("[");
        printf(COLOR_BOLD"%c"COLOR_OFF , pion);//COLOR_BOLD permet de mettre le texte en gras et COLOR_OFF permet de reinitialiser par défaut sa mise en forme
        printf("] ");
    }
    return vainqueur;
}

/**
 * @fn bool victoireDiagonale2(tab grille,int ligne, int colonne, char pion)
 * 
 * @brief Vérifie si il y a une victoire diagonalement du haut à droite au bas à gauche
 * 
 * @param grille de type tab en entrée : le tableau à vérifier
 * @param ligne de type int en entrée : la ligne du pion a vérifier
 * @param colonne de type int en entrée : la colonne du pion a vérifier
 * @param pion de type char en entrée : le pion que l'on doit vérifier
 * @return true : le pion fait partie des pions vainqueurs
 * @return false : le pion ne fait pas partie des éventuels pions vainqueurs
 * 
 * Si le pion fait partie des pions vainqueurs, il s'affiche en gras
 */
bool victoireDiagonale2(tab grille,int ligne, int colonne, char pion)
{
    bool vainqueur = false;

    //vérifie tout si les verifications quyi suivent ne provoquent pas un dépassement de tableau
    //puis verifie tout les cas de victoire diagonale haut-droite->bas-gauche possible du pion
    if (
        (ligne+3 < NBLIG && colonne-3 >= 0 && pion == grille[ligne+1][colonne-1] && pion == grille[ligne+2][colonne-2] && pion == grille[ligne+3][colonne-3]) ||
        (ligne+2 < NBLIG && colonne-2 >= 0 && ligne-1 >= 0 && colonne+1 < NBCOL && pion == grille[ligne+1][colonne-1] && pion == grille[ligne+2][colonne-2] && pion == grille[ligne-1][colonne+1]) ||
        (ligne+1 < NBLIG && colonne-1 >= 0 && ligne-2 >= 0 && colonne+2 < NBCOL && pion == grille[ligne+1][colonne-1] && pion == grille[ligne-2][colonne+2] && pion == grille[ligne-1][colonne+1]) || 
        (ligne-3 >= 0 && colonne+3 < NBLIG && pion == grille[ligne-3][colonne+3] && pion == grille[ligne-2][colonne+2] && pion == grille[ligne-1][colonne+1])
        )
    {
        vainqueur = true;
        printf("[");
        printf(COLOR_BOLD"%c"COLOR_OFF , pion);//COLOR_BOLD permet de mettre le texte en gras et COLOR_OFF permet de reinitialiser par défaut sa mise en forme
        printf("] ");
    }
    return vainqueur;
}



/**
 * @fn bool estVainqueur(tab grille, int ligne, int colonne)
 * 
 * @brief Vérifie si il y a un vainqueur
 * 
 * @param grille de type tab en entrée : le tableau à vérifier
 * @param ligne de type int en entrée : la ligne du pion qui vient d'être joué
 * @param colonne de type int en entrée : la colonne du pion qui vient d'être joué
 * @return true : il y a une victoire
 * @return false : il n'y a pas de victoire
 * 
 * Affiche la grille avec les pions gagnants modifiés en gras si il y a un vainqueur
 */
bool estVainqueur(tab grille, int ligne, int colonne)
{
    //définition des variables
    char pion = grille[ligne][colonne];
    bool vainqueur;

    //affiche la grille eventuellement modifiée et attribue la valeur de afficherGrille à vainqueur
    if (pion == PION_A)
    {
        vainqueur = afficherGrille(grille, PION_B, COLONNE_DEBUT);
    }
    else if (pion== PION_B)
    {
        vainqueur = afficherGrille(grille, PION_A, COLONNE_DEBUT);
    }
    
    return vainqueur;
}

/**
 * @fn void finDePartie(char pion)
 * 
 * @brief affiche un message de fin de partie
 * 
 * @param pion de type char en entrée : pion du vainqueur ou pion INCONNNU
 * 
 * Affiche un message avec le nom du vainqueur si il y en a un, sinon affiche un message d'égalité
 */
void finDePartie(char pion)
{
    if (pion == PION_A)
    {
        printf("\nVICTOIRE : Joueur \"%c\" a gagné ! Bien joué à toi !\n", PION_A);
    }
    else if (pion == PION_B)
    {
        printf("\nVICTOIRE : Joueur \"%c\" a gagné ! Bien joué à toi !\n", PION_B);
    }
    else if(pion == INCONNU)
    {
        printf("\nEGALITE : Vous ne pouvez plus placer de jetons. La partie est donc terminée mais vous pouvez toujours recommencer :)\n");
    }
    
}
