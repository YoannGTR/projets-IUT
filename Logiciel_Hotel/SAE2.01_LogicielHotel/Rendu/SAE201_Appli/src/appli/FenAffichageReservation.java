package appli;

import javafx.scene.control.Label;
import javafx.scene.control.TableCell;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.Image;
import javafx.scene.input.MouseButton;
import javafx.scene.paint.Color;

import java.text.SimpleDateFormat;
import java.time.ZoneId;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.Optional;

import back.AccesDonees;
import back.Chambre;
import back.Client;
import back.Reservation;
import javafx.beans.binding.Bindings;
import javafx.beans.binding.BooleanBinding;
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.DatePicker;
import javafx.scene.layout.Background;
import javafx.scene.layout.BackgroundFill;
import javafx.scene.layout.BorderPane;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.HBox;
import javafx.scene.layout.Priority;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;
import javafx.scene.control.*;
import javafx.scene.control.Alert.AlertType;

public class FenAffichageReservation extends Stage{
	private static final String PATTERN_FORMAT = "dd/MM/yyyy";
    private static SimpleDateFormat formatter = new SimpleDateFormat(PATTERN_FORMAT);
	public FenAffichageReservation()
	{
		this.setTitle("Affichage Réservation");
		Scene laScene = new Scene(creerContenu()); 
		this.setScene(laScene);
		this.sizeToScene();
		this.setResizable(false);
		this.getIcons().add(new Image("file:images/chv.png"));
	}
	
	private BorderPane mainLayout = new BorderPane();
	private HBox center = new HBox();
	private HBox header = new HBox();
	
	private GridPane formGridPane = new GridPane();
	private TableView<Chambre> tableView = new TableView<>();
	
	private Label title = new Label();
	private TextField fieldNumRes = new TextField();
	private VBox boxNumRes = new VBox();
	private HBox hBoxBoutons = new HBox();
	private Button supprimer = new Button("Supprimer");
	private Button modifier = new Button("Modifier  ");
	private Button annuler = new Button(" Annuler   ");
	private Button confirmer = new Button("Confirmer");
	private HBox spacer = new HBox();
	private VBox warningBox = new VBox();
	private Label warning1 = new Label();
	private Label warning2 = new Label();
	private Label warning3 = new Label();
	private Label warning4 = new Label();
	private DatePicker datedeb = new DatePicker();
	private DatePicker datefin = new DatePicker();
	
	private String numRes = new String();
	private ArrayList<Chambre> chambres = new ArrayList<>();
	private ArrayList<Chambre> chambresASuppr = new ArrayList<>();
	private ArrayList<Chambre> chambresTemp = new ArrayList<>();
	
	private HBox footer = new HBox();
	private Button retour = new Button("Retour");
	
	public BorderPane creerContenu()
	{
		
        
        title.setText("Numéro de réservation");
        title.setTextFill(Color.WHITE);
        title.setStyle("-fx-font-size: 20; -fx-text-fill: white; -fx-padding: 10;");
        
        
        fieldNumRes.setEditable(false);
        fieldNumRes.setMaxWidth(100);
        fieldNumRes.setStyle("-fx-background-color: #D9D9D9; -fx-text-fill: black; -fx-font-size: 15;");
        fieldNumRes.setFocusTraversable(false);
        boxNumRes.getChildren().add(fieldNumRes);
        boxNumRes.setMaxHeight(50);
        boxNumRes.setStyle("-fx-background-color: #D9D9D9; -fx-padding: 0px 20px; -fx-background-radius:5px;");
        boxNumRes.setAlignment(Pos.CENTER);
        
        
        
		warningBox.getChildren().add(warning1);
		warningBox.setAlignment(Pos.CENTER_LEFT);
		warningBox.setStyle("-fx-background-radius:5px;");
        
        supprimer.setPadding(new Insets(10));
        supprimer.setOnAction(e->{
        
			Alert confirmation = new Alert(AlertType.CONFIRMATION,
					"Voulez-vous vraiment supprimer cette réservation ?",
					ButtonType.YES,
					ButtonType.NO);
			confirmation.setTitle("Suppression d'une réservation");
			Optional<ButtonType> result = confirmation.showAndWait();
			if(result.isPresent() && result.get() == ButtonType.YES)
			{
				AccesDonees.getLesRes().remove(AccesDonees.getReservation(numRes));
				this.close();
				Alert information = new Alert(AlertType.INFORMATION,
						"La réservation a été supprimée",
						ButtonType.OK);
				information.setTitle("Suppression d'une réservation");
				Optional<ButtonType> resultat = information.showAndWait();
			} 
			
            	
        	
        });
        
        modifier.setPadding(new Insets(10));
        modifier.setOnAction(e->creerModif());
        
        annuler.setPadding(new Insets(10));
        annuler.setOnAction(e->annulerModif());
        
        confirmer.setPadding(new Insets(10));
        confirmer.setOnAction(e->applyModif());
        
        hBoxBoutons.setSpacing(10);
        hBoxBoutons.setPadding(new Insets(10));
        hBoxBoutons.getChildren().addAll(supprimer, modifier);
        HBox.setHgrow(spacer, Priority.ALWAYS);
        
        header.setPadding(new Insets(15,0,15,5));
        
		header.getChildren().addAll(title, boxNumRes, spacer, hBoxBoutons);
        header.setAlignment(Pos.CENTER);
        header.setStyle("-fx-background-color: #4070EC;");
        header.setSpacing(10);
        
        retour.setPadding(new Insets(10));
        footer.setPadding(new Insets(10));
        retour.setAlignment(Pos.CENTER);
        footer.getChildren().addAll(retour);
        retour.setOnAction(e->{
        	annulerModif();
        	Stage test = new FenRecherche();
        	test.show();
        	this.close();
        });
        
        formGridPane = createFormGridPane();
        tableView = createTableView();
        
        center.getChildren().addAll(formGridPane, tableView);
        center.setSpacing(40);
        center.setPadding(new Insets(20,40,0,40));
		
		mainLayout.setTop(header);
		mainLayout.setCenter(center);
		mainLayout.setBottom(footer);
		return mainLayout;
	}
	
	public void creerModif()
	{
		this.setTitle("Modification");
		hBoxBoutons.getChildren().clear();
		hBoxBoutons.getChildren().addAll(annuler, confirmer);
		fieldNumRes.setStyle("-fx-text-fill: black; -fx-font-size: 15;");
		header.getChildren().clear();
		HBox.setHgrow(warningBox, Priority.ALWAYS);
		header.getChildren().addAll(title, boxNumRes, warningBox, hBoxBoutons);
		warning1.setText("");
		warning2.setText("");
		warning3.setText("");
		warning4.setText("");
		warning1.setTextFill(Color.RED);
		warning1.setStyle("-fx-font-size:12;"
						+ "-fx-padding: 10px;");
		
		startDatePicker.getChildren().clear();
		endDatePicker.getChildren().clear();
		try {
			datedeb.setValue(formatter.parse(dateStart.getText()).toInstant().atZone(ZoneId.systemDefault()).toLocalDate());
		} catch (Exception e) {
			// TODO: handle exception
			System.out.println("Format incorrect");
		}
		try {
			datefin.setValue(formatter.parse(dateEnd.getText()).toInstant().atZone(ZoneId.systemDefault()).toLocalDate());
		} catch (Exception e) {
			// TODO: handle exception
			System.out.println("Format incorrect");
		}
		
		startDatePicker.getChildren().add(datedeb);
		endDatePicker.getChildren().add(datefin);

		
		dateEnd.setStyle("");
		dateStart.setStyle("");
		
		fieldNumRes.setEditable(true);
		dateStart.setEditable(true);
		dateEnd.setEditable(true);
		
		formGridPane.getChildren().clear();
		formGridPane.add(clientLabel, 0, 0);
        formGridPane.add(numberLabel, 0, 1);
        formGridPane.add(numberTextField, 1, 1);
        formGridPane.add(warning2, 0, 2, 2,1);
        formGridPane.add(dateLabel, 0, 3);
        formGridPane.add(startDateLabel, 0, 4);
        formGridPane.add(startDatePicker, 1, 4);
        formGridPane.add(warning3, 0, 5, 2,1);
        formGridPane.add(endDateLabel, 0, 6);
        formGridPane.add(endDatePicker, 1, 6);
        formGridPane.add(warning4, 0, 7, 2,1);
        
        
        BooleanBinding rien = Bindings.equal(tableView.getSelectionModel().selectedIndexProperty(), -1);
        
		optionSupprimer.disableProperty().bind(Bindings.when(rien).then(true).otherwise(false));
        tableView.setOnMouseClicked(e->{
        	if(e.getButton()==MouseButton.SECONDARY)
			{
				tableView.setContextMenu(menu);
			}
        });
        optionSupprimer.setOnAction(e->{
        	Alert confirmation = new Alert(AlertType.CONFIRMATION,
					"Voulez-vous vraiment supprimer cette chambre ?",
					ButtonType.YES,
					ButtonType.NO);
				confirmation.setTitle("Suppression d'une chambre");
				Optional<ButtonType> result = confirmation.showAndWait();
				if(result.isPresent() && result.get() == ButtonType.YES)
				{
					this.supTemp((tableView.getSelectionModel().getSelectedItem()));
				}
        });
        optionAjouter.setOnAction(e->{
        	Stage tmp = new FenMenu();
        	tmp.show();
        });
        chambresASuppr.addAll(chambres);
        tableView.getItems().clear();
        tableView.getItems().addAll(chambresASuppr);
        
        System.out.println(chambres.toString());
        System.out.println(chambresASuppr.toString()+"\n\n\n");
	}
	
	public void resetModif()
	{
		this.setTitle("Affichage Réservation");
		hBoxBoutons.getChildren().clear();
		hBoxBoutons.getChildren().addAll(supprimer, modifier);
		fieldNumRes.setStyle("-fx-background-color: #D9D9D9; -fx-text-fill: black; -fx-font-size: 15;");
		header.getChildren().clear();
		HBox.setHgrow(spacer, Priority.ALWAYS);
		header.getChildren().addAll(title, boxNumRes, spacer, hBoxBoutons);
		warning1.setStyle("");
		
		startDatePicker.getChildren().clear();
		startDatePicker.getChildren().add(dateStart);
		endDatePicker.getChildren().clear();
		endDatePicker.getChildren().add(dateEnd);
		
		name.setStyle("-fx-background-color: #D9D9D9; -fx-text-fill: black; -fx-font-size: 15; -fx-padding: 2 10;");
		number.setStyle("-fx-background-color: #D9D9D9; -fx-text-fill: black; -fx-font-size: 15; -fx-padding: 2 10;");
		dateStart.setStyle("-fx-background-color: #D9D9D9; -fx-text-fill: black; -fx-font-size: 15; -fx-padding: 2 10;");
		dateEnd.setStyle("-fx-background-color: #D9D9D9; -fx-text-fill: black; -fx-font-size: 15; -fx-padding: 2 10;");
		
		
		
		fieldNumRes.setEditable(false);
		dateStart.setEditable(false);
		dateEnd.setEditable(false);
		
		formGridPane.getChildren().clear();
		formGridPane.add(clientLabel, 0, 0);
        formGridPane.add(nameLabel, 0, 1);
        formGridPane.add(nameTextField, 1, 1);
        formGridPane.add(numberLabel, 0, 2);
        formGridPane.add(numberTextField, 1, 2);
        formGridPane.add(dateLabel, 0, 3);
        formGridPane.add(startDateLabel, 0, 4);
        formGridPane.add(startDatePicker, 1, 4);
        formGridPane.add(endDateLabel, 0, 5);
        formGridPane.add(endDatePicker, 1, 5);
        
        tableView.setOnMouseClicked(e->{
        	if(e.getButton()==MouseButton.SECONDARY)
			{
				
			}
        });
        
        optionSupprimer.setOnAction(null);
        
	}
	public void annulerModif()
	{
		resetModif();
		fieldNumRes.setText(numRes);
		tableView.getItems().clear();
		tableView.getItems().addAll(chambres);
		chambresASuppr.clear();
		System.out.println(chambres.toString());
        System.out.println(chambresASuppr.toString()+"\n\n\n");
	}
	public void applyModif()
	{
		String texte1 = fieldNumRes.getText().replaceAll("\\s", "");
		String texte2 = formatter.format(Date.from(datedeb.getValue().atStartOfDay(ZoneId.systemDefault()).toInstant()));
//		System.out.println(texte2);
		String texte3 = formatter.format(Date.from(datefin.getValue().atStartOfDay(ZoneId.systemDefault()).toInstant()));
//		System.out.println(texte3);
//		System.out.println(texte3);
		
		if(verifyNumR(texte1) && verifyDateDeb(texte2) && verifyDateFin(texte3))
		{
			resetModif();
			System.out.println("testeur");
			numRes = texte1;
			Calendar calendar = Calendar.getInstance();
			calendar.setTime(Date.from(datedeb.getValue().atStartOfDay(ZoneId.systemDefault()).toInstant()));
//			res.setDate_deb_sejour(calendar);
			dateStart.setText(texte2);
			Calendar calendar2 = Calendar.getInstance();
			calendar2.setTime(Date.from(datefin.getValue().atStartOfDay(ZoneId.systemDefault()).toInstant()));
//			res.setDate_deb_sejour(calendar2);
			dateEnd.setText(texte3);
			Main.supprimerChambre(chambresASuppr);
			Main.ouvrirMail(numRes);
			Main.ouvrirRecapRes(numRes);
			
			this.close();
			
		}
		
	}
	public boolean verifyNumR(String texte)
	{
		if(texte.isEmpty())
		{
			warning1.setStyle("-fx-font-size:12;"
					+ "-fx-padding: 10px;"
					+ "-fx-background-color:lightgray;"
					+ "-fx-background-radius:5px;");
			warning1.setText("Champs obligatoire");
		}
		else 
		{
			try 
			{
				Integer.parseInt(texte);
				//verifier si dans base de données
				
				if(texte.length()!=8)
				{
					warning1.setStyle("-fx-font-size:12;"
							+ "-fx-padding: 10px;"
							+ "-fx-background-color:lightgray;"
							+ "-fx-background-radius:5px;");
					warning1.setText("Le numéro de réservation\nest composé de 8 chiffres");
				}
				else
				{
					if(numRes.equals(texte) || !resExist(texte))
					{
						warning1.setText("");
						warning1.setStyle("");
						return true;
					}
					else
					{
						warning1.setStyle("-fx-font-size:12;"
								+ "-fx-padding: 10px;"
								+ "-fx-background-color:lightgray;"
								+ "-fx-background-radius:5px;");
						warning1.setText("Ce numéro de réservation \nexiste déja");
					}
				}
			}
			catch (Exception e) {
				warning1.setStyle("-fx-font-size:12;"
						+ "-fx-padding: 10px;"
						+ "-fx-background-color:lightgray;"
						+ "-fx-background-radius:5px;");
				warning1.setText("Le numéro de réservation\n ne doit être composé\n que de chiffres");
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
	public boolean verifyDateDeb(String texte)
	{
		if(texte.isEmpty())
		{
			warning3.setText("Champs obligatoire");
			return false;
		}
		try {
			if(formatter.parse(texte).before(Calendar.getInstance().getTime()))
			{
				warning3.setText("La date ne doit pas précéder celle d'aujourd'hui");
				return false;
			}
			else
			{
				warning3.setText("");
				return true;
			}
		} catch (Exception e) {
			// TODO: handle exception
			warning3.setText("Erreur de format. La date doit etre sous la forme dd/MM/yyyy");
			return false;
		}
	}
	public boolean verifyDateFin(String texte)
	{
		if(texte.isEmpty())
		{
			warning4.setText("Champs obligatoire");
			return false;
		}
		try {
			if(formatter.parse(texte).before(Calendar.getInstance().getTime()))
			{
				warning4.setText("La date ne doit pas précéder celle d'aujourd'hui");
				return false;
			}
			else if(formatter.parse(texte).before(Date.from(datedeb.getValue().atStartOfDay(ZoneId.systemDefault()).toInstant())))
			{
				warning4.setText("La date de départ ne doit pas précéder celle d'arrivée");
				return false;
			}
			else
			{
				warning4.setText("");
				return true;
			}
		} catch (Exception e) {
			// TODO: handle exception
			warning4.setText("Erreur de format. La date doit etre sous la forme dd/MM/yyyy");
			return false;
		}
	}
	
	
	private Label clientLabel = new Label("Client");
	private Label nameLabel = new Label("Prénom et nom du client :");
	private TextField name = new TextField("Camille Onette");
	private VBox nameTextField = new VBox();
	private Label numberLabel = new Label("Numéro du client :");
    private TextField number = new TextField("55881451441");
    private VBox numberTextField = new VBox();
    private Label dateLabel = new Label("Dates");
    private Label startDateLabel = new Label("Date de début de séjour :  ");
    private TextField dateStart = new TextField("12-06-2023");
    private VBox startDatePicker = new VBox();
    private Label endDateLabel = new Label("Date de fin de séjour :");
    private TextField dateEnd = new TextField("18-06-2023");
    private VBox endDatePicker = new VBox();
    
    

	
	
    private GridPane createFormGridPane() {
        
    	formGridPane.setPadding(new Insets(10));
    	formGridPane.setHgap(10);
    	formGridPane.setVgap(10);
        
        clientLabel.setStyle("-fx-font-weight: bold;"
                + "-fx-border-color: #FFFFFF;"
                + "-fx-border-width: 0 0 1 0;"
                + "-fx-underline: true;"
                + "-fx-font: 20 arial;");
        clientLabel.setTextFill(Color.BLACK);
        
        
        
        name.setEditable(false);
        
        name.setStyle("-fx-background-color: #D9D9D9; -fx-text-fill: black; -fx-font-size: 15;");
        nameLabel.setTextFill(Color.BLACK);
        
        nameTextField.setMaxWidth(200);
        nameTextField.getChildren().add(name);
        nameTextField.setStyle("-fx-background-color: #D9D9D9;");
        nameTextField.setPadding(new Insets(10));

        
        number.setEditable(false);
       
        number.setStyle("-fx-background-color: #D9D9D9; -fx-text-fill: black; -fx-font-size: 15; -fx-padding: 2 10;");
        numberLabel.setTextFill(Color.BLACK);
        
        numberTextField.setMaxWidth(160);
        numberTextField.getChildren().add(number);
        numberTextField.setStyle("-fx-background-color: #D9D9D9;");
        numberTextField.setPadding(new Insets(10));

        
        dateLabel.setStyle("-fx-font-weight: bold;"
                + "-fx-border-color: #FFFFFF;"
                + "-fx-border-width: 0 0 1 0;"
                + "-fx-underline: true;"
                + "-fx-font: 20 arial;");
        dateLabel.setTextFill(Color.BLACK);

        
        startDateLabel.setTextFill(Color.BLACK);
        
        dateStart.setEditable(false);
        
        dateStart.setStyle("-fx-background-color: #D9D9D9; -fx-text-fill: black; -fx-font-size: 15; -fx-padding: 2 10;");
        
        startDatePicker.setMaxWidth(160);
        startDatePicker.getChildren().add(dateStart);
        startDatePicker.setStyle("-fx-background-color: #D9D9D9;");
        startDatePicker.setPadding(new Insets(10));

       
        dateEnd.setEditable(false);
        
        dateEnd.setStyle("-fx-background-color: #D9D9D9; -fx-text-fill: black; -fx-font-size: 15; -fx-padding: 2 10;");
        endDateLabel.setTextFill(Color.BLACK);
        
        endDatePicker.setMaxWidth(160);
        endDatePicker.getChildren().add(dateEnd);
        endDatePicker.setStyle("-fx-background-color: #D9D9D9;");
        endDatePicker.setPadding(new Insets(10));

        
		warning2.setTextFill(Color.RED);
		warning2.setStyle("-fx-font-size:12;"
						+ "-fx-padding: -5px 0px;");
		warning3.setTextFill(Color.RED);
		warning3.setStyle("-fx-font-size:12;"
						+ "-fx-padding: -5px 0px;");
		warning4.setTextFill(Color.RED);
		warning4.setStyle("-fx-font-size:12;"
						+ "-fx-padding: -5px 0px;");
        
        
		formGridPane.add(clientLabel, 0, 0);
        formGridPane.add(nameLabel, 0, 1);
        formGridPane.add(nameTextField, 1, 1);
        formGridPane.add(numberLabel, 0, 2);
        formGridPane.add(numberTextField, 1, 2);
        formGridPane.add(dateLabel, 0, 3);
        formGridPane.add(startDateLabel, 0, 4);
        formGridPane.add(startDatePicker, 1, 4);
        formGridPane.add(endDateLabel, 0, 5);
        formGridPane.add(endDatePicker, 1, 5);

        return formGridPane;
    }
    
    private TableColumn<Chambre, String> categorieCol = new TableColumn<>();
	private TableColumn<Chambre, String> numeroCol = new TableColumn<>();
	private TableColumn<Chambre, Integer> personnesCol = new TableColumn<>();
	
	private MenuItem optionAjouter = new MenuItem("Ajouter des chambres");
	private MenuItem optionSupprimer = new MenuItem("Supprimer la chambre sélectionnée");
	private ContextMenu menu = new ContextMenu(optionAjouter,
			new SeparatorMenuItem(),
			optionSupprimer);
	public void supTemp(Chambre C)
	{
		chambresASuppr.remove(C);
		tableView.getItems().clear();
		tableView.getItems().addAll(chambresASuppr);
	}
	public void supprimerChambre(ArrayList<Chambre> cAS)
	{
		tableView.getItems().clear(); 
		tableView.getItems().addAll(cAS); 
	}
	
	public void addChambre(Chambre c)
	{
		chambresASuppr.add(c);
		tableView.getItems().add(c);
	}
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

        // DÃ©finir les largeurs des colonnes
        categorieCol.setPrefWidth(100);
        numeroCol.setPrefWidth(100);
        personnesCol.setPrefWidth(100);
        
        
        

        // Appliquer la classe de cellule personnalisÃ¯Â¿Â½e Ã¯Â¿Â½ chaque colonne
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
	
	public void init(Reservation res)
	{
		Client client = AccesDonees.getClient(res.getNumClientRes());
		fieldNumRes.setText(res.getNum_res());
		numRes = fieldNumRes.getText();
		name.setText(client.getPrenomClient()+" "+client.getNomClient());
		number.setText(res.getNumClientRes());
		dateStart.setText(res.getDate_deb_sejour_toString());
		dateEnd.setText(res.getDate_fin_sejour_toString());
		tableView.getItems().addAll(res.getChambre_res());
		chambres = res.getChambre_res();
	}

}


