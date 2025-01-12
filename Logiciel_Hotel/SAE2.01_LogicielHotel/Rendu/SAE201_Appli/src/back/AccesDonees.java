package back;

import java.util.ArrayList;
import java.util.Calendar;
import appli.*;

public class AccesDonees
{
	private static Calendar date = Calendar.getInstance();
	private static ArrayList<Reservation> reservations = new ArrayList<>();
	private static ArrayList<Client> clients = new ArrayList<>();
	private static ArrayList<Chambre> chambres = new ArrayList<>();

	static public void connexion() 
	{ 
		
		clients.add(new Client("Bertrand", "Delhalle", "0765214521", "BertrandDelhalle@gmail.com", "4 rue des champs", "Lannion", "22300"));
		clients.add(new Client("Lilian", "Alix", "0654248751", "LilianAlix@gmail.com", "19 impasse des tulipes", "Marseille", "13000"));
		clients.add(new Client("Gaetan", "Charrette", "0698525478", "GateanCharrette@free.fr", "3 place du général de gaulle", "Saint-Brieuc", "22000"));
		clients.add(new Client("Granville", "Lambert", "0956235874", "GranvilleLambert@gmail.com", "14 allée des pervenches", "Brest", "29200"));
		clients.add(new Client("Francis ", "Lachapelle", "0754124589", "FrancisLachapelle@gmail.com", "2 impasse des rousseau", "Paris", "75000"));
		clients.add(new Client("Astrid ", "Poirier", "0674846529", "AstridPoirier@gmail.com", "88 rue de nicolas", "Nice", "06000"));
		clients.add(new Client("Cosette ", "Caya", "0670708271", "CosetteCaya@gmail.com", "5 impasse St André", "Arrelles", "10340"));
		clients.add(new Client("Andrée ", "Cousteau", "0623524178", "AndréeCousteau@orange.fr", "8 allée des Clérey", "Dosnon", "10700"));
		clients.add(new Client("Evrard ", "Ruest", "0785965285", "EvrardRuest@free.fr", "1 rue des Daudes", "Engente", "10200"));

		chambres.add(new Chambre("Suite supérieure", "301", 4));
		chambres.add(new Chambre("Standard", "101", 2));
		chambres.add(new Chambre("Supérieure", "102", 3));
		chambres.add(new Chambre("Petite suite", "201", 3));
		chambres.add(new Chambre("Économique", "001", 4));
		chambres.add(new Chambre("Supérieure", "102", 3));
		chambres.add(new Chambre("Supérieure", "102", 3));
		chambres.add(new Chambre("Standard", "101", 2));
		chambres.add(new Chambre("Standard", "101", 2));
		chambres.add(new Chambre("Économique", "010", 4));
		chambres.add(new Chambre("Économique", "012", 4));
		chambres.add(new Chambre("Supérieure", "107", 3));
		chambres.add(new Chambre("Suite supérieure", "302", 4));
		chambres.add(new Chambre("Standard", "106", 2));
		chambres.add(new Chambre("Supérieure", "103", 3));
		chambres.add(new Chambre("Petite suite", "202", 3));
		chambres.add(new Chambre("Économique", "005", 4));
		
		date.set(2023, 6, 20);
		reservations.add(new Reservation((Calendar)date.clone(), 4, chambres,clients.get(0)));
		date.set(2023, 7, 15);
		reservations.add(new Reservation((Calendar)date.clone(), 3,chambres,clients.get(0)));
		date.set(2023, 7, 15);
		reservations.add(new Reservation((Calendar)date.clone(), 3,chambres,clients.get(1)));
		date.set(2023, 8, 15);
		reservations.add(new Reservation((Calendar)date.clone(), 4,chambres, clients.get(2)));
		date.set(2023, 9, 15);
		reservations.add(new Reservation((Calendar)date.clone(), 5,chambres, clients.get(3)));
		date.set(2023, 10, 15);
		reservations.add(new Reservation((Calendar)date.clone(), 4,chambres, clients.get(4)));
		date.set(2023, 11, 15);
		reservations.add(new Reservation((Calendar)date.clone(), 2,chambres, clients.get(5)));
		date.set(2023, 12, 15);
		reservations.add(new Reservation((Calendar)date.clone(), 10,chambres, clients.get(6)));
		
		// System.out.println(reservations);
	}
	static public ArrayList<Reservation> getLesRes()
	{
		return reservations;
	}
	static public ArrayList<Client> getLesClient()
	{
		return clients;
	}
	static public ArrayList<Chambre> getLesChambres()
	{
		return chambres;
	}
	static public void addChambre(Chambre c)
	{
		chambres.add(c);
		
	}

	static public ArrayList<Reservation> getLesResViaClient(Client cli)
	{
		ArrayList<Reservation> lesres = new ArrayList<>();
		for (int i = 0; i < reservations.size(); i++) {
			if(cli.getNumClient().equals(reservations.get(i).getNumClientRes()))
			{
				lesres.add(reservations.get(i));
			}
		}
		return lesres;
	}
	
	static public void modifierRes(Reservation res)
	{
		boolean trouve = false;
		int i=0;
		while (!trouve && i<reservations.size()) {
			if (reservations.get(i).getNum_res()==res.getNum_res()){
				reservations.set(i, res);
				trouve = true;
			}
			i++;
		}
	}
	static public void supprimerRes(Reservation res) {
		boolean trouve = false;
		int i=0;
		while (!trouve && i<reservations.size()) {
			if (reservations.get(i).getNum_res()==res.getNum_res()){
				reservations.remove(i);
				trouve = true;
			}
			i++;
		}
	}
	public static Reservation getReservation(String numRes)
    {
    	for (int i = 0; i < reservations.size(); i++) 
    	{
			//System.out.println("test2");
//			System.out.println(reservations.get(i).getNum_res()+" "+numRes+ " 00000001 " + String.format("%08d", 1).toString());
//			if(String.format("%08d", 1).equals(String.format("%08d", 1)))
//			{
//				System.out.println("testbrdl");
//			}
			if(reservations.get(i).getNum_res().equals(numRes))
			{
				System.out.println("test");
				return reservations.get(i);
				
			}
		}
    	
    	return null;
    }
	public static Client getClient(String numCli)
    {
    	for (int i = 0; i < clients.size(); i++) 
    	{
//			System.out.println(clients.get(i).getNumClient()+" "+numCli);
			if(clients.get(i).getNumClient().equals(numCli))
			{
				
				return clients.get(i);
				
			}
		}
    	
    	return null;
    }
	
	static public void supprimerChambre(ArrayList<Chambre> c)
	{
		chambres.clear();
		chambres.addAll(c);
	}
	
	public static Client getClientViaTel(String telCli)
    {
    	for (int i = 0; i < clients.size(); i++) 
    	{
			if(clients.get(i).getNumeroTelClient().equals(telCli))
			{
				
				return clients.get(i);
				
			}
		}
    	
    	return null;
    }
	public static Client getClientViaNom(String nomprenom)
    {
		String nom = nomprenom.substring(0, 3).toUpperCase();
		String prenom = nomprenom.substring(3, 6).toUpperCase();
    	for (int i = 0; i < clients.size(); i++) 
    	{
			if(clients.get(i).getPrenomClient().toUpperCase().contains(prenom)
				&& clients.get(i).getNomClient().toUpperCase().contains(nom))
			{
				
				return clients.get(i);
				
			}
		}
    	
    	return null;
    }

}
// /mnt/c/Users/yoann/Documents/Github/cours/clé/BUT_INFO_A1/S2/SAE/SAE201_Dev_Appli/appli/eclipse-workspace/SAE201_Appli/src/Back