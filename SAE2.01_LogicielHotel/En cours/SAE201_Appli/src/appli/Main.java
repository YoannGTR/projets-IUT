package appli;

import back.*;
import javafx.application.Application;
import javafx.stage.Modality;
import javafx.stage.Stage; 
 
public class Main extends Application
{
	static private FenAffichageRes fAffRes = new FenAffichageRes();
	static private FenAffichageClient fAffCli = new FenAffichageClient();
	
	public void start(Stage primaryStage){
		AccesDonees.connexion(); 
		primaryStage = new FenRecapeRes();
//		primaryStage = new FenRecherche();
		primaryStage.show();
		fAffRes.initModality(Modality.APPLICATION_MODAL);
		fAffCli.initModality(Modality.APPLICATION_MODAL);
	}
	public static void main(String[] args) {
		Application.launch(); 
	} 
	
	static public boolean ouvrirAffRes(String numRes) 
	{
//		fonction getRes a partir du numéro de res
		Reservation res = AccesDonees.getReservation(numRes); 
		if(res== null)
		{
			System.out.println("false");
			return false;
		}
		else
		{
			System.out.println("true");
			fAffRes.init(res);
			fAffRes.show(); 
			return true;
		}
		
		
	}
	static public boolean ouvrirAffClient(String numCli)
	{
//		fonction getRes a partir du numéro de res
		Client client = AccesDonees.getClient(numCli); 
		if(client== null)
		{
			System.out.println("false");
			return false;
		}
		else
		{
			System.out.println("true");
			fAffCli.init(client);
			fAffCli.show(); 
			return true;
		}
		
		
	}
	
}