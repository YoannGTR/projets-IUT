package back;


public class Chambre  
{
        private String categorie;
        private String numero;
        private int nbPersonnes;

        public Chambre(String categorie, String numero, int nbPersonnes) {
            this.categorie = categorie;
            this.numero = numero;
            this.nbPersonnes = nbPersonnes;
        }
        public String getCategorie() {
            return categorie;
        }

        public void setCategorie(String categorie) {
            this.categorie = categorie;
        }


        public String getNumero() {
            return numero;
        }

        public void setNumero(String numero) {
            this.numero = numero;
        }


        public int getNbPersonnes() {
            return nbPersonnes;
        }

        public void setNbPersonnes(int nbPersonnes) {
            this.nbPersonnes = nbPersonnes;
        }

    }