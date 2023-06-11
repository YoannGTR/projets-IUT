package appli;

import back.*;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Label;
import javafx.scene.layout.VBox;
import javafx.stage.Stage; 

public class FenAffichageClient extends Stage{
	public FenAffichageClient()
	{
		this.setTitle("AffichageClient"); 
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
	public void creer(Client cli)
	{
		donnees0.setText(""+cli.getNomClient());
		donnees1.setText(cli.getPrenomClient());
		donnees2.setText(cli.getAdresse());
		donnees3.setText(cli.getNumeroTelClient());
		donnees4.setText(cli.getNumClient());
		donnees5.setText(cli.getVille());
		// donnees6.setText(res.getChambre_res());
	}
	public void init(Client cli)
	{
		creer(cli);
		   
	}
}