package appli;

import back.*;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Label;
import javafx.scene.layout.VBox;
import javafx.stage.Stage; 

public class FenAffichageRes extends Stage{
	public FenAffichageRes()
	{
		this.setTitle("Affichage");
		Scene laScene = new Scene(creerContenu());
		this.setScene(laScene);
		this.sizeToScene(); 
		this.setResizable(false);
	}
	private VBox racine = new VBox();
	private Label donnees0 = new Label();
	private Label donnees1 = new Label();
	private Label donnees2 = new Label();
	private Label donnees3 = new Label();
	private Label donnees4 = new Label();
	private Label donnees5 = new Label();
	private Label donnees6 = new Label();
	public Parent creerContenu()
	{
		// donnees.setText("test");
		racine.getChildren().addAll(donnees0,donnees1,donnees2,donnees3,donnees4,donnees5,donnees6);
		return racine;
	}
	public void creer(Reservation res)
	{
		donnees0.setText(""+res.getNb_nuits());
		donnees1.setText(res.getNumClientRes());
		donnees2.setText(res.getNum_res());
		donnees3.setText(res.getDate_creation_toString());
		donnees4.setText(res.getDate_deb_sejour_toString());
		donnees5.setText(res.getDate_fin_sejour_toString());
		// donnees6.setText(res.getChambre_res());
	}
	public void init(Reservation res)
	{
		creer(res);
		   
	}
}