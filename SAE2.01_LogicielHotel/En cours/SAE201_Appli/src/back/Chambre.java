package back;

import javafx.beans.property.SimpleIntegerProperty;
import javafx.beans.property.SimpleStringProperty;

public class Chambre  
{
        private SimpleStringProperty categorie;
        private SimpleIntegerProperty numero;
        private SimpleIntegerProperty personnes;

        public Chambre(String categorie, int numero, int personnes) {
            this.categorie = new SimpleStringProperty(categorie);
            this.numero = new SimpleIntegerProperty(numero);
            this.personnes = new SimpleIntegerProperty(personnes);
        }

        public String getCategorie() {
            return categorie.get();
        }

        public void setCategorie(String categorie) {
            this.categorie.set(categorie);
        }

        public SimpleStringProperty categorieProperty() {
            return categorie;
        }

        public int getNumero() {
            return numero.get();
        }

        public void setNumero(int numero) {
            this.numero.set(numero);
        }

        public SimpleIntegerProperty numeroProperty() {
            return numero;
        }

        public int getPersonnes() {
            return personnes.get();
        }

        public void setPersonnes(int personnes) {
            this.personnes.set(personnes);
        }

        public SimpleIntegerProperty personnesProperty() {
            return personnes;
        }
    }