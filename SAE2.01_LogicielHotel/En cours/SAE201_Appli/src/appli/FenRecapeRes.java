package appli;



import back.*;

import javafx.geometry.Insets; 
import javafx.geometry.Pos;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.layout.*;
import javafx.scene.paint.Color;
import javafx.stage.Stage;
import javafx.scene.control.TableCell;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
 
public class FenRecapeRes extends Stage {

	public FenRecapeRes()
	{
		this.setTitle("Récapitulatif de réservation");
		Scene laScene = new Scene(creerContenu()); 
		this.setScene(laScene);
		this.sizeToScene();
		this.setResizable(false);
	}
	
	
	private BorderPane mainLayout = new BorderPane();
	private HBox center = new HBox();
	private HBox header = new HBox();
	
	private GridPane formGridPane = new GridPane();
	private TableView<Chambre> tableView = new TableView<>();
	
	private Label title = new Label();
	private Label fieldNumRes = new Label();
	
	
	public BorderPane creerContenu()
	{
		formGridPane = createFormGridPane();
        tableView = createTableView();

        center.getChildren().addAll(formGridPane, tableView);
        center.setSpacing(20);
        center.setPadding(new Insets(20));

        title.setText("Numéro de réservation");
        title.setTextFill(Color.WHITE);
        title.setStyle("-fx-font-size: 20; -fx-text-fill: white; -fx-padding: 10;");
        
       
        fieldNumRes.setText("458419565195848");
        fieldNumRes.setStyle("-fx-background-color: #D9D9D9; -fx-text-fill: black; -fx-font-size: 15; -fx-padding: 6 20;");
		
        
		header.getChildren().addAll(title, fieldNumRes);
        header.setAlignment(Pos.CENTER_LEFT);
        header.setStyle("-fx-background-color: #4070EC;");
		
		mainLayout.setTop(header);
		mainLayout.setCenter(center);
		return mainLayout;
		
	}
	
	private Label clientLabel = new Label();
	private Label nameLabel = new Label();
	private TextField name = new TextField();
    private VBox nameTextField = new VBox();
    private Label numberLabel = new Label();
    private TextField number = new TextField();
    private VBox numberTextField = new VBox();
	private Label cityLabel = new Label();
    private TextField city = new TextField();
    private VBox cityTextField = new VBox();
    
    private Label dateLabel = new Label();
    private Label startDateLabel = new Label();
    private TextField dateStart = new TextField();
    private VBox startDatePicker = new VBox();
    private Label endDateLabel = new Label();
    private TextField dateEnd = new TextField();
    private VBox endDatePicker = new VBox();
    private Label reservationDateLabel = new Label();
    private TextField dateRes = new TextField();
    private VBox reservationDatePicker = new VBox();

	public GridPane createFormGridPane() {
		
		formGridPane.setPadding(new Insets(10));
		formGridPane.setHgap(10);
		formGridPane.setVgap(10);
		
		
        clientLabel.setText("Client");
        clientLabel.setStyle("-fx-font-weight: bold;"
                + "-fx-border-color: #FFFFFF;"
                + "-fx-border-width: 0 0 1 0;"
                + "-fx-underline: true;"
                + "-fx-font: 20 arial;");
        clientLabel.setTextFill(Color.BLACK);
        

        
        nameLabel.setText("Nom et prénom du client :");
        nameLabel.setTextFill(Color.BLACK);
        name.setText("Camille Onette");
        name.setEditable(false);
        name.setStyle("-fx-background-color: #D9D9D9;-fx-font-size:14px;");
        name.setFocusTraversable(false);
        name.setPrefWidth(100);
        
        nameTextField.setAlignment(Pos.CENTER);
        nameTextField.getChildren().add(name);
        nameTextField.setStyle("-fx-background-color: #D9D9D9;");
        nameTextField.setPadding(new Insets(3));
        

        
        numberLabel.setText("Numéro du client :");
        numberLabel.setTextFill(Color.BLACK);
        number.setText("55881451441");
        number.setEditable(false);
        number.setStyle("-fx-background-color: #D9D9D9;-fx-font-size:14px;");
        number.setFocusTraversable(false);
        number.setPrefWidth(100);
        numberTextField.setAlignment(Pos.CENTER);
        numberTextField.getChildren().add(number);
        numberTextField.setStyle("-fx-background-color: #D9D9D9;");
        numberTextField.setPadding(new Insets(3));

        
        
        cityLabel.setText("Ville du client :");
        cityLabel.setTextFill(Color.BLACK);
        city.setText("Lannilis");
        city.setEditable(false);
        city.setStyle("-fx-background-color: #D9D9D9;-fx-font-size:14px;");
        city.setFocusTraversable(false);
        city.setPrefWidth(100);
        cityTextField.setAlignment(Pos.CENTER);
        cityTextField.getChildren().add(city);
        cityTextField.setStyle("-fx-background-color: #D9D9D9;");
        cityTextField.setPadding(new Insets(3));
        
        
        dateLabel.setText("Dates");
        dateLabel.setStyle("-fx-font-weight: bold;"
                + "-fx-border-color: #FFFFFF;"
                + "-fx-border-width: 0 0 1 0;"
                + "-fx-underline: true;"
                + "-fx-font: 20 arial;");
        dateLabel.setTextFill(Color.BLACK);

        
        startDateLabel.setText("Date de début de séjour :");
        startDateLabel.setTextFill(Color.BLACK);
        dateStart.setText("12-06-2023");
        dateStart.setEditable(false);
        dateStart.setStyle("-fx-background-color: #D9D9D9;-fx-font-size:14px;");
        dateStart.setFocusTraversable(false);
        dateStart.setPrefWidth(100);
        startDatePicker.setAlignment(Pos.CENTER);
        startDatePicker.getChildren().add(dateStart);
        startDatePicker.setStyle("-fx-background-color: #D9D9D9;");
        startDatePicker.setPadding(new Insets(3));


        
        endDateLabel.setText("Date de fin de séjour :"); 
        endDateLabel.setTextFill(Color.BLACK);
        dateEnd.setText("18-06-2023");
        dateEnd.setEditable(false);
        dateEnd.setStyle("-fx-background-color: #D9D9D9;-fx-font-size:14px;");
        dateEnd.setFocusTraversable(false);
        dateEnd.setPrefWidth(100);
        endDatePicker.setAlignment(Pos.CENTER);
        endDatePicker.getChildren().add(dateEnd);
        endDatePicker.setStyle("-fx-background-color: #D9D9D9;");
        endDatePicker.setPadding(new Insets(3));
        
        
        reservationDateLabel.setText("Date de réservation :");
        dateRes.setText("01-06-2023");
        reservationDateLabel.setTextFill(Color.BLACK);
        dateRes.setEditable(false);
        dateRes.setStyle("-fx-background-color: #D9D9D9;-fx-font-size:14px;");
        dateRes.setFocusTraversable(false);
        dateRes.setPrefWidth(100);
        reservationDatePicker.setAlignment(Pos.CENTER);
        reservationDatePicker.getChildren().add(dateRes);
        reservationDatePicker.setStyle("-fx-background-color: #D9D9D9;");
        reservationDatePicker.setPadding(new Insets(3));

        formGridPane.add(clientLabel, 0, 0);
        formGridPane.add(nameLabel, 0, 1);
        formGridPane.add(nameTextField, 1, 1);
        formGridPane.add(numberLabel, 0, 2);
        formGridPane.add(numberTextField, 1, 2);
        formGridPane.add(cityLabel, 0, 3);
        formGridPane.add(cityTextField, 1, 3);
        formGridPane.add(dateLabel, 0, 4);
        formGridPane.add(startDateLabel, 0, 5);
        formGridPane.add(startDatePicker, 1, 5);
        formGridPane.add(endDateLabel, 0, 6);
        formGridPane.add(endDatePicker, 1, 6);
        formGridPane.add(reservationDateLabel, 0, 7);
        formGridPane.add(reservationDatePicker, 1, 7);

        return formGridPane;
	}
	private TableColumn<Chambre, String> categorieCol = new TableColumn<>();
	private TableColumn<Chambre, Integer> numeroCol = new TableColumn<>();
	private TableColumn<Chambre, Integer> personnesCol = new TableColumn<>();
	
	
	private TableView<Chambre> createTableView() {
		
        categorieCol.setText("Catégorie(s) \nchambre(s)");
        numeroCol.setText("Numéro(s) \nchambre(s)");
        personnesCol.setText("Nombre de \npersonnes");
        categorieCol.setStyle("-fx-alignment:CENTER;");
        numeroCol.setStyle("-fx-alignment:CENTER;");
        personnesCol.setStyle("-fx-alignment:CENTER;");
        
        categorieCol.setCellValueFactory(new PropertyValueFactory<>("categorie"));
        numeroCol.setCellValueFactory(new PropertyValueFactory<>("numero"));
        personnesCol.setCellValueFactory(new PropertyValueFactory<>("personnes"));

        // Définir les largeurs des colonnes
        categorieCol.setPrefWidth(100);
        numeroCol.setPrefWidth(100);
        personnesCol.setPrefWidth(100);

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

        // Appliquer la classe de cellule personnalisï¿½e ï¿½ chaque colonne
        categorieCol.setCellFactory(col -> new CustomTableCell<>());
        numeroCol.setCellFactory(col -> new CustomTableCell<>());
        personnesCol.setCellFactory(col -> new CustomTableCell<>());

        tableView.getColumns().addAll(categorieCol, numeroCol, personnesCol);
        tableView.getItems().add(new Chambre("Standard", 101, 2));
        tableView.getItems().add(new Chambre("Deluxe", 202, 4));
        tableView.getItems().add(new Chambre("Suite", 301, 3));

        return tableView;
	}
}