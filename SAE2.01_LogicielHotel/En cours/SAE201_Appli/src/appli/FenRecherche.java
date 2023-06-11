package appli;


  
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.KeyCode;
import javafx.scene.layout.BorderPane;
import javafx.scene.layout.HBox;
import javafx.scene.layout.VBox;
import javafx.scene.paint.Color;
import javafx.stage.Stage;

public class FenRecherche extends Stage{
	
	private Label titre1 = new Label("Réservations");
	private Label titre2 = new Label("Clients");
	private VBox resTitre = new VBox();
	private VBox clientTitre = new VBox();
	private BorderPane racine = new BorderPane();
	private HBox top = new HBox();
	private VBox center = new VBox();
//	private int numOnglet = 0;
	public Parent creerTop()
	{
		top.setPrefHeight(50);
		top.setPrefWidth(800);
		
		titre2.setStyle("-fx-font-size:30");
		titre1.setStyle("-fx-font-size:30");
		
		resTitre.setAlignment(Pos.CENTER);
		resTitre.getChildren().addAll(titre1);
		resTitre.setPrefSize(400, 200);
		resTitre.setOnMousePressed(e->{
			creerTopRes();
			creerCenterRes();
		});
		
		clientTitre.getChildren().addAll(titre2);
		clientTitre.setPrefSize(400, 200);
		clientTitre.setAlignment(Pos.CENTER);
		clientTitre.setOnMousePressed(e->{
			creerTopClient();
			creerCenterClient();
		});
		
		//partie res de base
		titre2.setTextFill(Color.WHITE);
		titre1.setTextFill(Color.BLACK);
		
		

		
		resTitre.setStyle("-fx-background-radius:0px 20px 0px 0px;"
						+ "-fx-background-color: white;"
						+ "-fx-border-width: 5px 5px 0 5px;"
						+ "-fx-border-color:black;"
						+ "-fx-margin:0px;"
						+ "-fx-border-radius: 0 17px 0 0;");
		
		clientTitre.setStyle("-fx-background-color: #4070EC;"
				+ "-fx-border-width: 0px 0px 5px 0px;"
				+ "-fx-border-color:black;");
		
		
		top.getChildren().addAll(resTitre, clientTitre);
		top.setStyle("-fx-background-color: #4070EC;");
		
		return top;
	}
	public void creerTopRes()
	{	
		

		titre2.setTextFill(Color.WHITE);
		titre1.setTextFill(Color.BLACK);
		
		

		
		resTitre.setStyle("-fx-background-radius:0px 20px 0px 0px;"
						+ "-fx-background-color: white;"
						+ "-fx-border-width: 5px 5px 0 5px;"
						+ "-fx-border-color:black;"
						+ "-fx-margin:0px;"
						+ "-fx-border-radius: 0 17px 0 0;");
		
		clientTitre.setStyle("-fx-background-color: #4070EC;"
				+ "-fx-border-width: 0px 0px 5px 0px;"
				+ "-fx-border-color:black;");
		
	}
	public void creerTopClient()
	{	
	
		titre1.setTextFill(Color.WHITE);
		titre2.setTextFill(Color.BLACK);
		
		
		
		resTitre.setStyle("-fx-background-color: #4070EC;"
				+ "-fx-border-width: 0px 0px 5px 0px;"
				+ "-fx-border-color:black;");
		clientTitre.setStyle("-fx-background-radius:20px 0px 0px 0px;"
						+ "-fx-background-color: white;"
						+ "-fx-border-width: 5px 5px 0 5px;"
						+ "-fx-border-color:black;"
						+ "-fx-margin:0px;"
						+ "-fx-border-radius: 17px 0 0 0;");
	}
	
	private Label titreCenter = new Label();
	private Label descCenter = new Label();
	private HBox recherche = new HBox();
	private TextField chmpRecherche = new TextField();
	private Image img = new Image("File:images/loupe.png");
	private ImageView imgLoupe = new ImageView(img);
	private Label warning = new Label();
	
	public void creerCenterClient()
	{
		chmpRecherche.setText("");
		warning.setText("");
		titreCenter.setText("Client");
		descCenter.setText("Renseignez les premières lettres du nom du client ou son numéro de téléphone");
		chmpRecherche.setOnKeyPressed(e->{
			if (e.getCode().equals(KeyCode.ENTER)) {
				System.out.println("essai");
	            if(verifyEntryClient())
	            {
	            	 
	            	
	            	 
	            	System.out.println("test");
	            	if(Main.ouvrirAffClient(chmpRecherche.getText()))
	            	{
	            		this.close();
	            	}
	            	else
	            	{
	            		warning.setText("Ce numéro n'existe pas");
	            	}
	            	
	            }
	        }
		});
	}
	public void creerCenterRes()
	{
		chmpRecherche.setText("");
		warning.setText("");
		titreCenter.setText("Réservation");
		descCenter.setText("Renseignez un numéro de réservation");
		chmpRecherche.setOnKeyPressed(e->{
			if (e.getCode().equals(KeyCode.ENTER)) {
				System.out.println("essai");
	            if(verifyEntryRes())
	            {
	            	
	            	
	            	 
	            	System.out.println("test");
	            	if(Main.ouvrirAffRes(chmpRecherche.getText()))
	            	{
	            		this.close();
	            	}
	            	else
	            	{
	            		warning.setText("Ce numéro n'existe pas");
	            	}
	            	
	            }
	        }
		});
	}
	public Parent creerCenter()
	{
		//de base
		titreCenter.setText("Réservation");
		descCenter.setText("Renseignez un numéro de réservation");
		
		
		titreCenter.setStyle("-fx-font-size:40");
		descCenter.setStyle("-fx-font-size:20");
		
		
		chmpRecherche.setStyle("-fx-background-color:lightgray;");
		chmpRecherche.setPrefHeight(30);
		chmpRecherche.setPrefWidth(600);
		
		
		
		imgLoupe.setFitHeight(30);
		imgLoupe.setFitWidth(30);
		
		recherche.getChildren().addAll(imgLoupe, chmpRecherche);
		chmpRecherche.setOnKeyPressed(e->{
			if (e.getCode().equals(KeyCode.ENTER)) {
				System.out.println("essai");
	            if(verifyEntryRes())
	            {
	            	
	            	
	            	 
	            	System.out.println("test");
	            	if(Main.ouvrirAffRes(chmpRecherche.getText()))
	            	{
	            		this.close();
	            	}
	            	else
	            	{
	            		warning.setText("Ce numéro n'existe pas");
	            	}
	            	
	            }
	        }
		});
		warning.setTextFill(Color.RED);
		
		center.getChildren().addAll(titreCenter, descCenter, recherche, warning);
		center.setSpacing(20);
		center.setAlignment(Pos.CENTER_LEFT);
		center.setPadding(new Insets(100));
		center.setStyle("-fx-background-color: white;"
				+ "-fx-border-width: 0px 5px 5px 5px;"
				+ "-fx-border-color:black;");
		center.setPrefHeight(500);
		center.setPrefWidth(800);
		
		return center;
	}
	public boolean verifyEntryRes()
	{
		if(chmpRecherche.getText().isEmpty())
		{
			warning.setText("Veuillez entrez une valeur");
		}
		else if(chmpRecherche.getText().length()!=8)
		{
			warning.setText("Le numéro de réservation est composé de 8 caractères");
		}
		else 
		{
			try {
				Integer.parseInt(chmpRecherche.getText());
				//verifier si dans base de données
				
				return true;
			} catch (Exception e) {
				warning.setText("Le numéro de réservation n'est composé que de chiffres");
//				chmpRecherche.setText("");
				
			}
		}
		return false;
	}
	public boolean verifyEntryClient()
	{
		if(chmpRecherche.getText().isEmpty())
		{
			warning.setText("Veuillez entrer une valeur");
		}
		else 
		{
			try {
				Integer.parseInt(chmpRecherche.getText());
				//numéro de tel
				if(chmpRecherche.getText().length()!=8)
				{
					warning.setText("Le numéro de téléphone est composé de 8 chiffres");
				}
				else
				{
					return true;
				}
				//verifier si dans base de données
			} catch (Exception e) {
				//nom et prenom
				//verifier si dans base de données
			}
		}
		return false;
	}
	 
	public Parent creerContenu()
	{
		
		racine.setTop(creerTop());
		racine.setBottom(creerCenter());
		return racine;
	}
	public FenRecherche()
	{
		//super();
		this.setTitle("Rechercher"); 
		Scene laScene = new Scene(creerContenu());
		this.setScene(laScene);
		this.sizeToScene();
		this.setResizable(false);
	}
}