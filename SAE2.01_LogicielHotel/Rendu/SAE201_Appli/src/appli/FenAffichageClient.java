package appli;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

import back.*;
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TableCell;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.Image;
import javafx.scene.input.MouseButton;
import javafx.scene.layout.Background;
import javafx.scene.layout.BackgroundFill;
import javafx.scene.layout.BorderPane;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.HBox;
import javafx.scene.layout.VBox;
import javafx.scene.paint.Color;
import javafx.scene.text.Text;
import javafx.stage.Stage; 

public class FenAffichageClient extends Stage{
	public FenAffichageClient()
	{
		this.setTitle("Affichage Client"); 
		Scene laScene = new Scene(creerContenu());
		this.setScene(laScene);
		this.sizeToScene();
		this.setResizable(false);
		this.getIcons().add(new Image("file:images/chv.png"));
	}
	private VBox vBox = new VBox();
	private Label reservation = new Label();
	Label clientLabel = new Label();
	private Label nom = new Label();
	private TextField nomField = new TextField();
	private Label prenom = new Label();
	private TextField prenomField = new TextField();
	private Label telephone = new Label();
	private TextField telephoneField = new TextField();
	private Label mail = new Label();
	private TextField mailField = new TextField();
	private Label adresse = new Label();
	private TextField adresseField = new TextField();
	private Label ville = new Label();
	private TextField villeField = new TextField();
	private TextField villeField2 = new TextField();
	private Label title = new Label();
	private Label fieldNumClient = new Label();
	private HBox header = new HBox();
	private BorderPane mainLayout = new BorderPane();
	private HBox center = new HBox();
	private GridPane formGridPane = new GridPane();
	private TableView<Reservation> formTableView = new TableView<>();
	private Button retour = new Button("Retour");
	private HBox footer = new HBox();
	public Parent creerContenu() {
		title.setText("Numéro de Client");
        title.setTextFill(Color.WHITE);
        title.setStyle("-fx-font-size: 20;"
        		+ " -fx-text-fill: white;"
        		+ " -fx-padding: 10;");
        
        fieldNumClient.setText("14511551");
        
        fieldNumClient.setStyle("-fx-background-color: #D9D9D9;"
        		+ " -fx-text-fill: black;"
        		+ " -fx-font-size: 15;"
        		+ " -fx-padding: 6 20;"
        		+ "-fx-background-radius: 7px;");
        
		header.getChildren().addAll(title, fieldNumClient);
        header.setAlignment(Pos.CENTER_LEFT);
        header.setStyle("-fx-background-color: #4070EC;");
		
		retour.setPadding(new Insets(10));
        footer.setPadding(new Insets(10));
        retour.setAlignment(Pos.CENTER);
        footer.getChildren().addAll(retour);
        
        formGridPane = createFormGridPane();
        formTableView = createTableView();
        
        reservation.setText("Réservations");
        reservation.setStyle("-fx-font-weight: bold;"
	                + "-fx-border-width: 0 0 1 0;"
	                + "-fx-underline: true;"
	                + "-fx-font: 20 arial;"
	                + "-fx-padding: 15");
        vBox.getChildren().addAll(reservation,formTableView);
        center.getChildren().addAll(formGridPane,vBox);
        center.setSpacing(20);
        center.setPadding(new Insets(20));
        
        
		mainLayout.setTop(header);
		mainLayout.setCenter(center);
		mainLayout.setBottom(footer);
		
		retour.setOnAction(e->{
	        	Stage test = new FenRecherche();
	        	test.show();
	        	this.close();
	    });
		
		formTableView.setOnMouseClicked(e->{
			if(e.getClickCount()==2 && e.getButton()==MouseButton.PRIMARY && e.getTarget() instanceof Text) {
               Main.ouvrirAffRes(formTableView.getSelectionModel().getSelectedItem().getNum_res());
               this.close();
            }
        });
		
		return mainLayout;
	}
	
	  private GridPane createFormGridPane() {
		  
		  	
	    	formGridPane.setPadding(new Insets(10));
	    	formGridPane.setHgap(10);
	    	formGridPane.setVgap(10);
	        
	        clientLabel.setStyle("-fx-font-weight: bold;"
	                + "-fx-border-width: 0 0 1 0;"
	                + "-fx-underline: true;"
	                + "-fx-font: 20 arial;");
	        clientLabel.setTextFill(Color.BLACK);
	        clientLabel.setText("Client");
	        clientLabel.setPadding(new Insets(5));

	        nom.setStyle("-fx-font-weight: bold;"
	                + "-fx-border-width: 0 0 1 0;"
	                + "-fx-font: 20 arial;");
	        nom.setTextFill(Color.BLACK);
	        nom.setText("Nom :");
	        nom.setPadding(new Insets(5));
	        
	        nomField.setMinHeight(50);
	        nomField.setMaxWidth(160);
	        nomField.setAlignment(Pos.CENTER);
	        nomField.setStyle("-fx-background-color: #D9D9D9;"
	        		+ " -fx-text-fill: black;"
	        		+ " -fx-font-size: 15;"
	        		+ " -fx-padding: 2 10;"
	        		+ "-fx-background-radius: 7px;");
	        nomField.setEditable(false);
	     
	        prenom.setStyle("-fx-font-weight: bold;"
	                + "-fx-border-width: 0 0 1 0;"
	                + "-fx-font: 20 arial;");
	        prenom.setTextFill(Color.BLACK);
	        prenom.setText("Prenom : ");
	        prenom.setPadding(new Insets(5));
	        
	        prenomField.setMinHeight(50);
	        prenomField.setMaxWidth(160);
	        prenomField.setAlignment(Pos.CENTER);
	        prenomField.setStyle("-fx-background-color: #D9D9D9;"
	        		+ " -fx-text-fill: black;"
	        		+ " -fx-font-size: 15;"
	        		+ " -fx-padding: 2 10;"
	        		+ "-fx-background-radius: 7px;");
	        prenomField.setEditable(false);

	        
	        telephone.setStyle("-fx-font-weight: bold;"
	                + "-fx-border-width: 0 0 1 0;"
	                + "-fx-font: 20 arial;");
	        telephone.setTextFill(Color.BLACK);
	        telephone.setText("Téléphone : ");
	        telephone.setPadding(new Insets(5));
	        
	        telephoneField.setMinHeight(50);
	        telephoneField.setMaxWidth(160);
	        telephoneField.setAlignment(Pos.CENTER);
	        telephoneField.setStyle("-fx-background-color: #D9D9D9;"
	        		+ " -fx-text-fill: black;"
	        		+ " -fx-font-size: 15;"
	        		+ " -fx-padding: 2 10;"
	        		+ "-fx-background-radius: 7px;");
	        telephoneField.setEditable(false);

	        
	        mail.setStyle("-fx-font-weight: bold;"
	                + "-fx-border-width: 0 0 1 0;"
	                + "-fx-font: 20 arial;");
	        mail.setTextFill(Color.BLACK);
	        mail.setText("Mail : ");
	        mail.setPadding(new Insets(5));
	        
	        mailField.setMinHeight(50);
	        mailField.setMaxWidth(160);
	        mailField.setAlignment(Pos.CENTER);
	        mailField.setStyle("-fx-background-color: #D9D9D9;"
	        		+ " -fx-text-fill: black;"
	        		+ " -fx-font-size: 15;"
	        		+ " -fx-padding: 2 10;"
	        		+ "-fx-background-radius: 7px;");
	        mailField.setEditable(false);

	        
	        adresse.setStyle("-fx-font-weight: bold;"
	                + "-fx-border-width: 0 0 1 0;"
	                + "-fx-font: 20 arial;");
	        adresse.setTextFill(Color.BLACK);
	        adresse.setText("Adresse : ");
	        
	        adresseField.setMinHeight(50);
	        adresseField.setMaxWidth(160);
	        adresseField.setAlignment(Pos.CENTER);
	        adresseField.setStyle("-fx-background-color: #D9D9D9;"
	        		+ " -fx-text-fill: black;"
	        		+ " -fx-font-size: 15;"
	        		+ " -fx-padding: 2 10;"
	        		+ "-fx-background-radius: 7px;");
	        adresseField.setEditable(false);

	        ville.setStyle("-fx-font-weight: bold;"
	                + "-fx-border-width: 0 0 1 0;"
	                + "-fx-font: 20 arial;");
	        ville.setTextFill(Color.BLACK);
	        ville.setText("Ville : ");
	        ville.setPadding(new Insets(5));
	        
	        villeField.setMinHeight(50);
	        villeField.setMaxWidth(160);
	        villeField.setAlignment(Pos.CENTER);
	        villeField.setStyle("-fx-background-color: #D9D9D9;"
	        		+ " -fx-text-fill: black;"
	        		+ " -fx-font-size: 15;"
	        		+ " -fx-padding: 2 10;"
	        		+ "-fx-background-radius: 7px;");
	        villeField.setEditable(false);

	        villeField2.setMinHeight(50);
	        villeField2.setMaxWidth(160);
	        villeField2.setAlignment(Pos.CENTER);
	        villeField2.setStyle("-fx-background-color: #D9D9D9;"
	        		+ " -fx-text-fill: black;"
	        		+ " -fx-font-size: 15;"
	        		+ " -fx-padding: 2 10;"
	        		+ "-fx-background-radius: 7px;");
	        villeField2.setEditable(false);

	        

	        formGridPane.add(clientLabel, 0, 0);
	        formGridPane.add(nom, 0, 1);
	        formGridPane.add(nomField, 1, 1);
	        formGridPane.add(prenom, 0, 2);
	        formGridPane.add(prenomField, 1, 2);
	        formGridPane.add(telephone, 0, 3);
	        formGridPane.add(telephoneField, 1, 3);
	        formGridPane.add(mail, 0, 4);
	        formGridPane.add(mailField, 1, 4);
	        formGridPane.add(adresse, 0, 5);
	        formGridPane.add(adresseField, 1, 5);
	        formGridPane.add(ville, 0, 6);
	        formGridPane.add(villeField, 1, 6);
	        formGridPane.add(villeField2, 2, 6);


	        return formGridPane;
	    }
	  
	  
	  	private TableColumn<Reservation, String> reservationCol = new TableColumn<>();
	    private TableColumn<Reservation, Calendar> debutCol = new TableColumn<>();
	    private TableColumn<Reservation, Calendar> finCol = new TableColumn<>();
	    private static final String PATTERN_FORMAT = "dd/MM/yyyy";
	    private static SimpleDateFormat formatter = new SimpleDateFormat(PATTERN_FORMAT);

	    public TableView<Reservation> createTableView() {
	        reservationCol.setText("Réservation");
	        debutCol.setText("Début");
	        finCol.setText("Fin");
	        reservationCol.setStyle("-fx-alignment:CENTER;");
	        debutCol.setStyle("-fx-alignment:CENTER;");
	        finCol.setStyle("-fx-alignment:CENTER;");

	        reservationCol.setCellValueFactory(new PropertyValueFactory<>("num_res"));
	        debutCol.setCellValueFactory(new PropertyValueFactory<>("date_deb_sejour"));
	        finCol.setCellValueFactory(new PropertyValueFactory<>("date_fin_sejour"));

	        // Définir les largeurs des colonnes
	        reservationCol.setPrefWidth(100);
	        debutCol.setPrefWidth(100);
	        finCol.setPrefWidth(100);

	        
	        reservationCol.setCellFactory(col -> new TableCell<Reservation, String>(){
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
	        
	        debutCol.setCellFactory(col -> new TableCell<Reservation, Calendar>(){
	            public void updateItem(Calendar item, boolean empty) {
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
	                      setText(formatter.format(item.getTime()));
	                  }
	              }
	        });
	        finCol.setCellFactory(col -> new TableCell<Reservation, Calendar>(){
	            public void updateItem(Calendar item, boolean empty) {
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
	                      setText(formatter.format(item.getTime()));
	                  }
	              }
	        });
	        formTableView.getColumns().addAll(reservationCol, debutCol, finCol);
	        return formTableView;
	    }
	    
	    public void init(Client client)
		{
			
			nomField.setText(client.getNomClient());
			fieldNumClient.setText(client.getNumClient());
	        prenomField.setText(client.getPrenomClient());
	        telephoneField.setText(client.getNumeroTelClient());
	        mailField.setText(client.getMailClient());
	        adresseField.setText(client.getAdresse());
	        villeField.setText(client.getVille());
	        villeField2.setText(client.getCodePostal());
	        formTableView.getItems().addAll(AccesDonees.getLesResViaClient(client));
		}
}