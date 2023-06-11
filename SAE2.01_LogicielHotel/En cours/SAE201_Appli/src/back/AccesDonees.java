package back;

import java.util.ArrayList;
import java.util.Calendar;
import appli.*;

public class AccesDonees
{
	private static Calendar date = Calendar.getInstance();
	private static ArrayList<Reservation> reservations = new ArrayList<>();
	private static ArrayList<Client> clients = new ArrayList<>();

	static public void connexion() 
	{ 
		
		clients.add(new Client("Allain", "Terrieur", "01 02 03 04 05", "allainTerrieur@gmal.com", "4 rue des champs", "nomVille"));
		clients.add(new Client("Allain", "Terrieur", "01 02 03 04 05", "allainTerrieur@gmal.com", "4 rue des champs", "nomVille"));
		clients.add(new Client("Allain", "Terrieur", "01 02 03 04 05", "allainTerrieur@gmal.com", "4 rue des champs", "nomVille"));
		clients.add(new Client("Allain", "Terrieur", "01 02 03 04 05", "allainTerrieur@gmal.com", "4 rue des champs", "nomVille"));
		clients.add(new Client("Allain", "Terrieur", "01 02 03 04 05", "allainTerrieur@gmal.com", "4 rue des champs", "nomVille"));
		clients.add(new Client("Allain", "Terrieur", "01 02 03 04 05", "allainTerrieur@gmal.com", "4 rue des champs", "nomVille"));
		clients.add(new Client("Allain", "Terrieur", "01 02 03 04 05", "allainTerrieur@gmal.com", "4 rue des champs", "nomVille"));
		clients.add(new Client("Allain", "Terrieur", "01 02 03 04 05", "allainTerrieur@gmal.com", "4 rue des champs", "nomVille"));
		clients.add(new Client("Allain", "Terrieur", "01 02 03 04 05", "allainTerrieur@gmal.com", "4 rue des champs", "nomVille"));

		
		
		date.set(2022, 6, 15);
		reservations.add(new Reservation(date, 4,new ArrayList<>(),clients.get(0)));
		date.set(2022, 7, 15);
		reservations.add(new Reservation(date, 3,new ArrayList<>(),clients.get(1)));
		date.set(2022, 8, 15);
		reservations.add(new Reservation(date, 4,new ArrayList<>(), clients.get(2)));
		date.set(2022, 9, 15);
		reservations.add(new Reservation(date, 5,new ArrayList<>(), clients.get(3)));
		date.set(2022, 10, 15);
		reservations.add(new Reservation(date, 4,new ArrayList<>(), clients.get(4)));
		date.set(2022, 11, 15);
		reservations.add(new Reservation(date, 2,new ArrayList<>(), clients.get(5)));
		date.set(2022, 12, 15);
		reservations.add(new Reservation(date, 10,new ArrayList<>(), clients.get(6)));
		
		// System.out.println(reservations);
	}
	static public ArrayList getLesRes()
	{
		return reservations;
	}
	static public ArrayList getLesClient()
	{
		return clients;
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
//	public static void main(String[] args) {
//		connexion();
//	}
}
// /mnt/c/Users/yoann/Documents/Github/cours/clé/BUT_INFO_A1/S2/SAE/SAE201_Dev_Appli/appli/eclipse-workspace/SAE201_Appli/src/Back