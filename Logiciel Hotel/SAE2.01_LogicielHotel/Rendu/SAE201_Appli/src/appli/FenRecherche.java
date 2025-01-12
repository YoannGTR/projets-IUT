package appli;


  
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import back.AccesDonees;
import back.Client;
import back.Reservation;
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
	
	private Label titreCenterR = new Label();
	private Label titreCenterC = new Label();
	private Label descCenterC = new Label();
	private Label descCenterR = new Label();
	private HBox recherche = new HBox();
	private TextField chmpRechercheR = new TextField();
	private TextField chmpRechercheC = new TextField();
	private Image img = new Image("File:images/loupe.png");
	private ImageView imgLoupe = new ImageView(img);
	private Label warningC = new Label();
	private Label warningR = new Label();
	
	public void creerCenterClient()
	{
		recherche.getChildren().clear();
		recherche.getChildren().addAll(imgLoupe, chmpRechercheC);
		
		center.getChildren().clear();
		center.getChildren().addAll(titreCenterC, recherche, warningC, descCenterC);
		
		
	}
	public void creerCenterRes()
	{
		
		recherche.getChildren().clear();
		recherche.getChildren().addAll(imgLoupe, chmpRechercheR);
		
		center.getChildren().clear();
		center.getChildren().addAll(titreCenterR, recherche, warningR, descCenterR);
	}
	public Parent creerCenter()
	{
		titreCenterR.setText("Réservation");
		descCenterR.setText("  Renseignez un numéro de réservation. \n  FORMAT : \"01457852\"");
		titreCenterR.setStyle("-fx-font-size:40");
		descCenterR.setStyle("-fx-font-size:18");
		chmpRechercheR.setStyle("-fx-background-color:lightgray;");
		chmpRechercheR.setPrefHeight(30);
		chmpRechercheR.setPrefWidth(600);
		chmpRechercheR.setOnKeyPressed(e->{
			if (e.getCode().equals(KeyCode.ENTER)) {
	            if(verifyEntryRes(chmpRechercheR.getText()))
	            {
	            	Main.ouvrirAffRes(chmpRechercheR.getText());
	            	this.close();
	            }
	        }
		});
		warningR.setTextFill(Color.RED);
		warningR.setStyle("-fx-font-size:12;"
						+ "-fx-padding: -20px 0px;");
		

		titreCenterC.setText("Client");
		descCenterC.setText("  Renseignez les 3 premières lettres du nom et prénom du client.  "
							+ "\n  FORMAT : \"nnnppp\""
							+ "\nOU"
							+ "\n  Renseignez le numéro de téléphone du client.  "
							+ "\n  FORMAT : \"0600000000\"");
		titreCenterC.setStyle("-fx-font-size:40");
		descCenterC.setStyle("-fx-font-size:18");
		chmpRechercheC.setStyle("-fx-background-color:lightgray;");
		chmpRechercheC.setPrefHeight(30);
		chmpRechercheC.setPrefWidth(600);
		chmpRechercheC.setOnKeyPressed(e->{
			if (e.getCode().equals(KeyCode.ENTER)) {
	            if(verifyEntryClient(chmpRechercheC.getText()))
	            {
	            	Main.ouvrirAffClient(chmpRechercheC.getText());
	            	this.close();
	            }
	        }
		});
		warningC.setTextFill(Color.RED);
		warningC.setStyle("-fx-font-size:12;"
				+ "-fx-padding: -20px 0px;");
		
		
		imgLoupe.setFitHeight(30);
		imgLoupe.setFitWidth(30);
		
		recherche.getChildren().addAll(imgLoupe, chmpRechercheR);
		
		
		
		center.getChildren().addAll(titreCenterR, recherche, warningR, descCenterR);
		center.setSpacing(20);
		center.setAlignment(Pos.TOP_LEFT);
		center.setStyle("-fx-background-color: white;"
				+ "-fx-border-width: 0px 5px 5px 5px;"
				+ "-fx-border-color:black;"
				+ "-fx-padding:150px 50px 50px 80px;");
		center.setPrefHeight(500);
		center.setPrefWidth(800);
		
		return center;
	}
	public boolean verifyEntryRes(String texte)
	{
		if(texte.isEmpty())
		{
			warningR.setText("Veuillez entrez une valeur");
		}
		else 
		{
			texte = texte.replaceAll("\\s", "");
			System.out.println(texte);
			try 
			{
				Integer.parseInt(texte);
				//verifier si dans base de données
				
				if(texte.length()!=8)
				{
					warningR.setText("Le numéro de réservation est composé de 8 numéros");
				}
				else
				{
					if(resExist(texte))
					{
						return true;
					}
					else
					{
						warningR.setText("Ce numéro de réservation n'existe pas");
					}
				}
			}
			catch (Exception e) {
				warningR.setText("Le numéro de réservation n'est composé que de chiffres");
//				chmpRecherche.setText("");
				
			}
		}
		return false;
	}
	public boolean resExist(String numRes)
	{
		Reservation res = AccesDonees.getReservation(numRes); 
		if(res== null)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	public boolean verifyEntryClient(String texte)
	{
		
		if(texte.isEmpty())
		{
			warningC.setText("Veuillez entrer une valeur");
		}
		else 
		{
			texte = texte.replaceAll("\\s", "");
			try {
				Integer.parseInt(texte);
				//numéro de tel
				if(Integer.parseInt(texte)<0)
				{
					warningC.setText("Le numéro de téléphone ne peut pas être négatif");
				}
				else if(texte.length()!=10)
				{
					warningC.setText("Le numéro de téléphone est composé de 10 chiffres");
				}
				else if(telClientExist(texte))
				{
					return true;
				}
				else
				{
					warningC.setText("Ce numéro de telephone n'existe pas");
				}
				//verifier si dans base de données
			} catch (Exception e) {
				
				Pattern p = Pattern.compile("[a-z ]+", Pattern.CASE_INSENSITIVE);
				Matcher m = p.matcher(texte); 
				if(!m.find())
				{
					warningC.setText("Le format n'est pas valide. \nEntrez un numéro de téléphone ou les premières lettres du nom et prénom du client");
				}
				else if(texte.length()>6)
				{
					warningC.setText("N'entrez que les 3 premières lettres de son nom et de son prénom");
				}
				else if(texte.length()<6)
				{
					warningC.setText("vous devez entrer les 3 premières lettres de son nom et de son prénom");
				}
				else if(nomClientExist(texte))
				{
					return true;
				}
				else
				{
					warningC.setText("ce client n'existe pas");
				}
			}
		}
		return false;
	}
	
	public boolean telClientExist(String telCli)
	{
		Client cli = AccesDonees.getClientViaTel(telCli); 
		if(cli== null)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	public boolean nomClientExist(String nomPrenom)
	{
		Client cli = AccesDonees.getClientViaNom(nomPrenom); 
		System.out.println(cli);
		if(cli== null)
		{
			return false;
		}
		else
		{
			return true;
		}
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
		this.getIcons().add(new Image("file:images/chv.png"));
	}
}