package appli;

import java.util.ArrayList;

import back.*;
import javafx.application.Application;
import javafx.stage.Modality;
import javafx.stage.Stage; 
 
public class Main extends Application
{
	static private FenAffichageReservation fAffRes = new FenAffichageReservation();
	static private FenAffichageClient fAffCli = new FenAffichageClient();
	static private FenRecapeRes fRecapRes = new FenRecapeRes();
	static private FenCourrier fCourrier = new FenCourrier();
	
	public void start(Stage primaryStage){
		AccesDonees.connexion(); 
		fAffRes.initModality(Modality.APPLICATION_MODAL);
		fAffCli.initModality(Modality.APPLICATION_MODAL);

		primaryStage = new FenRecherche();
		primaryStage.show();

		
	}
	public static void main(String[] args) {
		Application.launch(); 
	} 
	
	static public void ouvrirAffRes(String numRes) 
	{
//		fonction getRes a partir du numéro de res
		Reservation res = AccesDonees.getReservation(numRes); 
		
		fAffRes.init(res);
		fAffRes.show(); 
		
		
	}
	static public void ouvrirAffClient(String donnee)
	{
//		fonction getRes a partir du numéro de res
		boolean isNum;
		try {
			Integer.parseInt(donnee);
			isNum=true;
		} catch (Exception e) {
			isNum =false;
		}
		Client client;
		if(isNum)
		{
			client = AccesDonees.getClientViaTel(donnee); 
		}
		else
		{
			client = AccesDonees.getClientViaNom(donnee); 
		}
		
		
		fAffCli.init(client);
		fAffCli.show();
		
		
	}
	static public void ouvrirRecapRes(String numRes) 
	{
		Reservation res = AccesDonees.getReservation(numRes); 
		
		fRecapRes.init(res);
		fRecapRes.show(); 
		
		
	}
	static public void ouvrirMail(String numRes) 
	{

		Reservation res = AccesDonees.getReservation(numRes); 
		
		fCourrier.init(res);
		fCourrier.show(); 
		
		
	}
	static public void ouvrirMenu()
	{
		FenMenu menu = new FenMenu(); 
		menu.show();
	}
	
	static public void supprimerChambre(ArrayList<Chambre> c) 
	{
		fAffRes.supprimerChambre(c);
		AccesDonees.supprimerChambre(c);
	}
	static public void addChambre(Chambre c) 
	{
		fAffRes.addChambre(c);
		AccesDonees.addChambre(c);
	}
	
	
}