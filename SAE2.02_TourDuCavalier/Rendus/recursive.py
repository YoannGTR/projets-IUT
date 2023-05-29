def is_valid_move(board, x, y, visited):
    """
    Vérifie si la case (x, y) est une case valide et n'a pas encore été visitée.
    """
    return 0 <= x < len(board) and 0 <= y < len(board) and board[x][y] not in visited


def get_valid_moves(board, x, y, visited):
    """
    Retourne les mouvements valides à partir de la case (x, y) en vérifiant bien
    si le mouvement, est un mouvement valide.
    """
    moves = [
        (x + 2, y + 1), (x + 1, y + 2), (x - 1, y + 2), (x - 2, y + 1),
        (x - 2, y - 1), (x - 1, y - 2), (x + 1, y - 2), (x + 2, y - 1)
    ]
    return [(i, j) for i, j in moves if is_valid_move(board, i, j, visited) and (i, j) not in visited]

def dfs(board, start, visited, path, is_start=True):
    """
    Recherche en profondeur d'un parcours hamiltonien à partir de la case de départ 'start'.
    """
    visited.add(start)
    path.append(start)
    if len(path) == len(board) ** 2:  # tous les sommets ont été visités
        return True
    for move in get_valid_moves(board, *start, visited):
        if is_start and move == path[0] and len(path) > 1:  # ferme le tour hamiltonien
            path.append(path[0])
            return True
        if dfs(board, move, visited, path, False):
            return True
    visited.remove(start)
    path.pop()
    return False


def find_hamiltonian_tour(board, start):
    """
    Creation du plateau de jeu, attribution à un numéro pour chaque case du plateau visité. 
    Utilisation de la fonction dfs, pour chercher un tour hamiltonien en profondeur.
    En fonction du résultat de la fonction dfs, on retourne soit le chemin trouvé, ou alors None.
    """
    visited = set()
    path = []
    count = 1  # initialisation du compteur
    if dfs(board, start, visited, path):
        for i, j in path:
            board[i][j] = str(count)  # attribution d'un chiffre à chaque case visitée
            count += 1
        return path
    return None

def print_board(board):
    """
    Affichage du plateau de jeu
    """
    for row in board:
        print(' '.join(str(c) if c is not None else "." for c in row))

def main():
    """
    fonction principale avec choix de la taille du plateau, ainsi
    que l'endroit ou l'on souhaite poser le pion. Egalement l'affichage
    des resultats de la fonction de recherche du tour hamiltonien.
    """

    # création d'un échiquier vide
    nombre = int(input("Nombre de colonnes et lignes (ex : 6, 7, 8 ...): "))
    board = [[None] * nombre for _ in range(nombre)]

    # saisie de la case de départ
    x = int(input(f"Entrez la ligne de la case de départ, entre 0 et {nombre-1} : "))
    y = int(input(f"Entrez la colonne de la case de départ, entre 0 et {nombre-1} : "))
    start = (x, y)

    # recherche d'un tour hamiltonien à partir de la case de départ
    tour = find_hamiltonian_tour(board, start)
    if tour:
        print(f"Tour hamiltonien trouvé à partir de la case {start} :")
        print_board(board)
    else:
        print(f"Pas de tour hamiltonien à partir de la case {start}")
        print("Fin de la recherche")

if __name__ == "__main__":
    main()