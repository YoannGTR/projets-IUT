package appli;


import back.*;
import javafx.geometry.Insets; 
import javafx.geometry.Pos;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.Image;
import javafx.scene.layout.*;
import javafx.scene.paint.Color;
import javafx.stage.Modality;
import javafx.stage.Stage;

public class FenMenu extends Stage
{
	public FenMenu()
	{
		this.setTitle("Menu"); 
		Scene laScene = new Scene(creerContenu());
		this.setScene(laScene);
		this.sizeToScene();
		this.setResizable(false);
		this.initModality(Modality.APPLICATION_MODAL);
		this.getIcons().add(new Image("file:images/chv.png"));
	}
	
	private VBox racine = new VBox();
	private HBox box1 = new HBox();
	private Label lbl1 = new Label("Catégorie: ");
	private ComboBox<String> tf1 = new ComboBox<String>();
	private HBox box2 = new HBox();
	private Label lbl2 = new Label("Numéro de\n chambre: ");
	private TextField tf2 = new TextField();
	private HBox box3 = new HBox();
	private Label lbl3 = new Label("Nombre \nd'occupants: ");
	private TextField tf3 = new TextField();
	private Button btn = new Button("Ajouter");
	private Label warning = new Label();
	
	public Parent creerContenu()
	{
		warning.setTextFill(Color.RED);
		warning.setStyle("-fx-font-size:12;"
						+ "-fx-padding: -5px 0px;");
		tf1.getItems().addAll("Économique", "Standard", "Supérieure", "Petite suite", "Suite supérieure");
		lbl1.setPrefWidth(100);
		lbl2.setPrefWidth(100);
		lbl3.setPrefWidth(100);
		box1.getChildren().addAll(lbl1, tf1);
		box2.getChildren().addAll(lbl2, tf2);
		box3.getChildren().addAll(lbl3, tf3);
		racine.getChildren().addAll(box1, box2, box3, btn, warning);
		racine.setPrefHeight(200);
		racine.setPadding(new Insets(10));
		racine.setSpacing(5);
		btn.setOnAction(e->{
			if(tf1.getValue().isEmpty() || tf2.getText().isEmpty() || tf3.getText().isEmpty())
			{
				warning.setText("champs vide");
			}
			else
			{
				try {
					Integer.parseInt(tf2.getText());
					Integer.parseInt(tf3.getText());
					if(Integer.parseInt(tf2.getText())>0 && Integer.parseInt(tf3.getText())>0)
					{
						Chambre ch = new Chambre(tf1.getValue(), tf2.getText(), Integer.parseInt(tf3.getText()));
						
						Main.addChambre(ch);
						
						this.close();
					}
					else
					{
						warning.setText("Les numéros ne peuvent pas etre négatifs");
					}
					
					
				} catch (Exception e2) {
					warning.setText("Le numéro de chambre et le\n nombre de personnes ne doivent\n contenir que des chiffres");
				}
				
			}
		});
		return racine;
	}
}
