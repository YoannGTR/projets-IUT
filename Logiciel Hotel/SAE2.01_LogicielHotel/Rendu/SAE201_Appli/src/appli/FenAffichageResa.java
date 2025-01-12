package appli;

import back.*;
import javafx.application.Application;
import javafx.beans.property.SimpleIntegerProperty;
import javafx.beans.property.SimpleStringProperty;
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.Image;
import javafx.scene.layout.*;
import javafx.scene.paint.Color;
import javafx.stage.Stage;
import javafx.scene.control.TableCell;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;


public class FenAffichageResa extends Application {
	
    @Override
    public void start(Stage primaryStage) {
        primaryStage.setTitle("Récapitulatif de réservation");
        primaryStage.setResizable(false);

        GridPane formGridPane = createFormGridPane();
        TableView<Chambre> tableView = createTableView();

        HBox root = new HBox(formGridPane, tableView);
        root.setSpacing(10);
        root.setPadding(new Insets(10));

        HBox header = new HBox();
        header.setStyle("-fx-background-color: #4070EC;");
        Label title = new Label("Numéro de réservation");
        title.setTextFill(Color.WHITE);
        Label fieldNumRes = new Label("458419565195848");

        title.setStyle("-fx-font-size: 20; -fx-text-fill: white; -fx-padding: 10;");
        fieldNumRes.setStyle("-fx-background-color: #D9D9D9; -fx-text-fill: black; -fx-font-size: 15; -fx-padding: 6 20;");

        HBox.setHgrow(header, Priority.ALWAYS);
        HBox.setHgrow(fieldNumRes, Priority.ALWAYS);
        header.getChildren().addAll(title, fieldNumRes);
        header.setAlignment(Pos.CENTER_LEFT);

        VBox mainLayout = new VBox();
        mainLayout.getChildren().addAll(header, root);

        Scene scene = new Scene(mainLayout, 960, 420);
        primaryStage.setScene(scene);
        primaryStage.show();
    }

    private GridPane createFormGridPane() {
        GridPane gridPane = new GridPane();
        gridPane.setPadding(new Insets(10));
        gridPane.setHgap(10);
        gridPane.setVgap(10);
        Label clientLabel = new Label("Client");
        clientLabel.setStyle("-fx-font-weight: bold;"
                + "-fx-border-color: #FFFFFF;"
                + "-fx-border-width: 0 0 1 0;"
                + "-fx-underline: true;"
                + "-fx-font: 20 arial;");
        clientLabel.setTextFill(Color.BLACK);
        HBox header = new HBox();
        header.setStyle("-fx-background-color: #4070EC;");
        Label title = new Label("Numéro de réservation");
        title.setTextFill(Color.WHITE);
        Label fieldNumRes = new Label("lenumero");
        fieldNumRes.setStyle("-fx-background-color: #D9D9D9;");

        title.setStyle("-fx-font-size: 20; -fx-text-fill: white; -fx-padding: 10;");
        fieldNumRes.setStyle("-fx-text-fill: white; -fx-font-size: 16; -fx-padding: 10;");
        
        HBox.setHgrow(header, Priority.ALWAYS);
        HBox.setHgrow(fieldNumRes, Priority.ALWAYS);
        header.getChildren().addAll(title, fieldNumRes);
        header.setAlignment(Pos.CENTER_LEFT);
        Label nameLabel = new Label("Nom et prénom du client :");
        Label name = new Label("Camille Onette");
        nameLabel.setTextFill(Color.BLACK);
        VBox nameTextField = new VBox();
        nameTextField.getChildren().add(name);
        nameTextField.setStyle("-fx-background-color: #D9D9D9;");
        nameTextField.setPadding(new Insets(10));

        Label numberLabel = new Label("Numéro du client :");
        Label number = new Label("55881451441");
        numberLabel.setTextFill(Color.BLACK);
        VBox numberTextField = new VBox();
        numberTextField.getChildren().add(number);
        numberTextField.setStyle("-fx-background-color: #D9D9D9;");
        numberTextField.setPadding(new Insets(10));

        Label cityLabel = new Label("Ville du client :");
        Label city = new Label("Lannilis");
        cityLabel.setTextFill(Color.BLACK);
        VBox cityTextField = new VBox();
        cityTextField.getChildren().add(city);
        cityTextField.setStyle("-fx-background-color: #D9D9D9;");
        cityTextField.setPadding(new Insets(10));

        Label dateLabel = new Label("Dates");
        dateLabel.setStyle("-fx-font-weight: bold;"
                + "-fx-border-color: #FFFFFF;"
                + "-fx-border-width: 0 0 1 0;"
                + "-fx-underline: true;"
                + "-fx-font: 20 arial;");
        dateLabel.setTextFill(Color.BLACK);

        Label startDateLabel = new Label("Date de début de séjour :");
        Label dateStart = new Label("12-06-2023");
        startDateLabel.setTextFill(Color.BLACK);
        VBox startDatePicker = new VBox();
        startDatePicker.getChildren().add(dateStart);
        startDatePicker.setStyle("-fx-background-color: #D9D9D9;");
        startDatePicker.setPadding(new Insets(10));

        Label endDateLabel = new Label("Date de fin de séjour :");
        Label dateEnd = new Label("18-06-2023");
        endDateLabel.setTextFill(Color.BLACK);
        VBox endDatePicker = new VBox();
        endDatePicker.getChildren().add(dateEnd);
        endDatePicker.setStyle("-fx-background-color: #D9D9D9;");
        endDatePicker.setPadding(new Insets(10));

        Label reservationDateLabel = new Label("Date de réservation :");
        Label dateRes = new Label("01-06-2023");
        VBox reservationDatePicker = new VBox();
        reservationDateLabel.setTextFill(Color.BLACK);
        reservationDatePicker.getChildren().add(dateRes);
        reservationDatePicker.setStyle("-fx-background-color: #D9D9D9;");
        reservationDatePicker.setPadding(new Insets(10));

        gridPane.add(clientLabel, 0, 0);
        gridPane.add(nameLabel, 0, 1);
        gridPane.add(nameTextField, 1, 1);
        gridPane.add(numberLabel, 0, 2);
        gridPane.add(numberTextField, 1, 2);
        gridPane.add(cityLabel, 0, 3);
        gridPane.add(cityTextField, 1, 3);
        gridPane.add(dateLabel, 0, 4);
        gridPane.add(startDateLabel, 0, 5);
        gridPane.add(startDatePicker, 1, 5);
        gridPane.add(endDateLabel, 0, 6);
        gridPane.add(endDatePicker, 1, 6);
        gridPane.add(reservationDateLabel, 0, 7);
        gridPane.add(reservationDatePicker, 1, 7);

        return gridPane;
    }

    private TableView<Chambre> createTableView() {
        TableView<Chambre> tableView = new TableView<>();
        TableColumn<Chambre, String> categorieCol = new TableColumn<>("Catégorie chambre(s)");
        TableColumn<Chambre, Integer> numeroCol = new TableColumn<>("Numéro chambre(s)");
        TableColumn<Chambre, Integer> personnesCol = new TableColumn<>("Nombre personnes");

        categorieCol.setCellValueFactory(new PropertyValueFactory<>("categorie"));
        numeroCol.setCellValueFactory(new PropertyValueFactory<>("numero"));
        personnesCol.setCellValueFactory(new PropertyValueFactory<>("personnes"));

        // Définir les largeurs des colonnes
        categorieCol.setPrefWidth(200);
        numeroCol.setPrefWidth(200);
        personnesCol.setPrefWidth(200);

        // Classe de cellule personnalisée pour la couleur de fond
        class CustomTableCell<T> extends TableCell<Chambre, T> {
            @Override
            protected void updateItem(T item, boolean empty) {
                super.updateItem(item, empty);

                if (empty || item == null) {
                    int index = getIndex();
                    if (index % 2 == 0) {
                        setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.4), null, null)));
                    } else {
                        setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.6), null, null)));
                    }
                    setText(null);
                } else {
                    int index = getIndex();
                    if (index % 2 == 0) {
                        setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.4), null, null)));
                    } else {
                        setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.6), null, null)));
                    }
                    setText(item.toString());
                }
            }
        }

        // Appliquer la classe de cellule personnalisée à chaque colonne
        categorieCol.setCellFactory(col -> new CustomTableCell<>());
        numeroCol.setCellFactory(col -> new CustomTableCell<>());
        personnesCol.setCellFactory(col -> new CustomTableCell<>());

        tableView.getColumns().addAll(categorieCol, numeroCol, personnesCol);
        tableView.getItems().add(new Chambre("Standard", 101, 2));
        tableView.getItems().add(new Chambre("Deluxe", 202, 4));
        tableView.getItems().add(new Chambre("Suite", 301, 3));

        return tableView;
    }
    /*
    public class Chambre {
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
    */

}	

