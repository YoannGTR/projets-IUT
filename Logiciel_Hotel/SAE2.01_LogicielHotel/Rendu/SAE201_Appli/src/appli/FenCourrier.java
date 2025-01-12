package appli;
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Label;
import javafx.scene.control.TableCell;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.control.skin.TableHeaderRow;
import javafx.scene.control.skin.TableViewSkinBase;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.*;
import javafx.scene.paint.Color;
import javafx.scene.text.Font;
import javafx.scene.text.FontWeight;
import javafx.stage.Modality;
import javafx.stage.Stage;
import javafx.stage.StageStyle;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

import back.AccesDonees;
import back.Chambre;
import back.Client;
import back.Reservation;

public class FenCourrier extends Stage{
    private BorderPane root = new BorderPane();
    private HBox header = new HBox();
    private VBox titlesBox = new VBox();
    private VBox objetBox = new VBox();
    private VBox contexteBox = new VBox();
    private VBox center = new VBox();
    private Label titreLabel = new Label();
    private Label objetLabel = new Label();
    private Label bonjour = new Label();
    private Label confirmationLabel = new Label();
    private Label hotelLabel = new Label();
    private HBox ligne1 = new HBox();
    private HBox ligne2 = new HBox();
    private Label hotelnomLabel = new Label();
    private HBox ligne3 = new HBox();
    private Label adresseLabel = new Label();
    private Label villeLabel = new Label();
    private Label dateLabel = new Label();
    private Label numeroResaLabel = new Label();
    private Label dateResaLabel = new Label();
    private Label periodeResaLabel = new Label();
    private Label destinataire = new Label();
    private Label adressePostalDesti = new Label();
    private Label villeDestinataire = new Label();
    private TableView<Chambre> tableView = new TableView<>();
    private HBox spacer1 = new HBox();
    private HBox spacer2 = new HBox();
    private HBox spacer3 = new HBox();
    
   
    public FenCourrier() {
    	this.setResizable(false);
        Scene scene = new Scene(creerContenu());
        this.sizeToScene();
        this.setScene(scene);
        this.getIcons().add(new Image("file:images/chv.png"));
    }
    
    private Parent creerContenu() {
    	
    	Date currentDate = new Date();
        SimpleDateFormat dateFormat = new SimpleDateFormat("dd/MM/yyyy");
        String dateString = dateFormat.format(currentDate);
        titreLabel.setText("Courrier de confirmation");

        this.setTitle("Courrier de confirmation - " + dateString);
    	
        titreLabel.setFont(Font.font("Arial", FontWeight.BOLD, 18));
        titreLabel.setText("Courrier de confirmation");
        titreLabel.setTextFill(Color.WHITE);
        titreLabel.setStyle("-fx-padding: 10 40 0 0;");

        hotelLabel.setFont(Font.font("Arial", FontWeight.BOLD, 14));
        hotelLabel.setTextFill(Color.WHITE);
        hotelLabel.setText("Hôtel du Cheval Blanc ****");
        

        ImageView logo = new ImageView(new Image("File:images/chv.png")); 
        logo.setPreserveRatio(true);
        logo.setFitHeight(100);
		logo.setFitWidth(100);
		
		titlesBox.getChildren().addAll(hotelLabel,titreLabel);
		titlesBox.setStyle("-fx-padding: 0 0 0 100;");
		titlesBox.setAlignment(Pos.CENTER);
        header.getChildren().addAll(titlesBox, logo);
        header.setStyle("-fx-background-color: #4070EC;"
        		+ "-fx-padding: 25;");
        
        
        objetLabel.setText("Objet : Confirmation de votre réservation au Cheval Blanc");
    	objetLabel.setStyle("-fx-padding: 0 0 10 0;");
    	bonjour.setText("Bonjour,");
    	bonjour.setStyle("-fx-padding: 0 0 10 0;");
    	confirmationLabel.setText("Nous sommes ravis de confirmer votre réservation à l’Hôtel du Cheval Blanc. Veuillez trouver ci-\ndessous les détails de votre réservation :");
    	
    	objetBox.setStyle("-fx-padding: 15 0 10 0;");
    	objetBox.getChildren().addAll(objetLabel,bonjour,confirmationLabel);
    	objetBox.setAlignment(Pos.CENTER_LEFT);
        
    	
    	hotelnomLabel.setText("Hôtel Cheval Blanc");
    	adresseLabel.setText("6 route des pins");
    	
    	HBox.setHgrow(spacer1, Priority.ALWAYS);
    	HBox.setHgrow(spacer2, Priority.ALWAYS);
    	HBox.setHgrow(spacer3, Priority.ALWAYS);
    	
    	ligne1.getChildren().addAll(hotelnomLabel,spacer1,destinataire);
    	ligne2.getChildren().addAll(adresseLabel,spacer2,adressePostalDesti);
    	ligne3.getChildren().addAll(villeLabel,spacer3,villeDestinataire);
    	
        villeLabel.setText("Marseille, 13000");
        dateLabel.setText(dateString);
        
        
        contexteBox.getChildren().addAll(ligne1, ligne2, ligne3,dateLabel,numeroResaLabel,dateResaLabel,periodeResaLabel);
        contexteBox.setStyle("-fx-padding: 15 0 10 25;");
        
        
        tableView = createTableView();
        tableView.setMaxWidth(302);
        
        center.getChildren().addAll(objetBox,contexteBox,tableView);
        center.setPadding(new Insets(20));
        center.setAlignment(Pos.CENTER);
        center.setStyle("-fx-border-color: #4070EC;");
        
        root.setTop(header);
        root.setCenter(center);
        return root;
    }
    
    private TableColumn<Chambre, String> categorieCol = new TableColumn<>();
	private TableColumn<Chambre, String> numeroCol = new TableColumn<>();
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
        personnesCol.setCellValueFactory(new PropertyValueFactory<>("nbPersonnes"));

        // Définir les largeurs des colonnes
        categorieCol.setPrefWidth(100);
        numeroCol.setPrefWidth(100);
        personnesCol.setPrefWidth(100);
        
        
        categorieCol.setCellFactory(col -> new TableCell<Chambre, String>(){
        	public void updateItem(String item, boolean empty) {
	            super.updateItem(item, empty);
	
	            if (empty || item == null) {
	                  int index = getIndex();
	                  if (index % 2 == 0) {
	                      setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.4), null, null)));
	                  } else {
	                      setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.6), null, null)));
	                  }
	                  setText(null);
	             } 
	             else {
	                  int index = getIndex();
	                  if (index % 2 == 0) {
	                      setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.4), null, null)));
	                  } else {
	                      setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.6), null, null)));
	                  }
	                  setText(item.toString());
	              }
	          }
        });
        
        numeroCol.setCellFactory(col -> new TableCell<Chambre, String>(){
        	public void updateItem(String item, boolean empty) {
	            super.updateItem(item, empty);
	
	            if (empty || item == null) {
	                  int index = getIndex();
	                  if (index % 2 == 0) {
	                      setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.4), null, null)));
	                  } else {
	                      setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.6), null, null)));
	                  }
	                  setText(null);
	             } 
	             else {
	                  int index = getIndex();
	                  if (index % 2 == 0) {
	                      setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.4), null, null)));
	                  } else {
	                      setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.6), null, null)));
	                  }
	                  setText(item.toString());
	              }
	          }
        });
        personnesCol.setCellFactory(col -> new TableCell<Chambre, Integer>(){
        	public void updateItem(Integer item, boolean empty) {
	            super.updateItem(item, empty);
	
	            if (empty || item == null) {
	                  int index = getIndex();
	                  if (index % 2 == 0) {
	                      setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.4), null, null)));
	                  } else {
	                      setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.6), null, null)));
	                  }
	                  setText(null);
	             } 
	             else {
	                  int index = getIndex();
	                  if (index % 2 == 0) {
	                      setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.4), null, null)));
	                  } else {
	                      setBackground(new Background(new BackgroundFill(Color.web("#4070EC", 0.6), null, null)));
	                  }
	                  setText(item.toString());
	              }
	          }
        });

        tableView.getColumns().addAll(categorieCol, numeroCol, personnesCol);

        return tableView;
	}
	
	public void init(Reservation res) {
		Client client = AccesDonees.getClient(res.getNumClientRes());
		Reservation reservation = AccesDonees.getReservation(res.getNum_res());
		destinataire.setText(client.getPrenomClient() + " " + client.getNomClient());
    	adressePostalDesti.setText(client.getAdresse());
    	villeDestinataire.setText(client.getVille() + "," + client.getCodePostal());
		numeroResaLabel.setText("Numéro de réservation :" + reservation.getNum_res());
        dateResaLabel.setText("Date de réservation " + reservation.getDate_creation_toString());
        periodeResaLabel.setText("Période de réservation " + reservation.getDate_deb_sejour_toString() + " au " + reservation.getDate_fin_sejour_toString());
		tableView.getItems().addAll(res.getChambre_res());
	}
}
