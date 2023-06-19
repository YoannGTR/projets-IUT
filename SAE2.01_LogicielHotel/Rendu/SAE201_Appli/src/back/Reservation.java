package back;


import java.util.ArrayList;
import java.util.Calendar;
import java.lang.String;
import java.text.SimpleDateFormat;

public class Reservation {

    private static Calendar date = Calendar.getInstance();
    private static final String PATTERN_FORMAT = "dd/MM/yyyy";
    private static SimpleDateFormat formatter = new SimpleDateFormat(PATTERN_FORMAT);

    private Calendar date_creation; 
    private Calendar date_deb_sejour;
    private Calendar date_fin_sejour;
    private int nb_nuits;
    private String num_res;
    private ArrayList<Chambre> chambre_res;
    private String numClient;



    public Reservation(Calendar date_deb_sejour, int nb_nuits, ArrayList<Chambre> chambre_res,Client client) 
    {
        this.date_deb_sejour = date_deb_sejour;
        this.nb_nuits = nb_nuits;
        this.chambre_res = chambre_res;
       
        
        
        String tmp = String.format("%08d", AccesDonees.getLesRes().size());
        int i = 0;
        // AccesDonees.getLesRes().contains(AccesDonees.getReservation(tmp));
        while(AccesDonees.getReservation(tmp) != null)
        {
        	i+=1;
        	tmp = String.format("%08d", AccesDonees.getLesRes().size()+i);
        }
        this.num_res = tmp;

        this.numClient = client.getNumClient();
        client.addRes(this);

        this.date_deb_sejour.roll(Calendar.MONTH, false);
        this.date_fin_sejour =(Calendar) date_deb_sejour.clone();
        this.date_fin_sejour.add(Calendar.DAY_OF_YEAR, this.nb_nuits);
        this.date_creation = Calendar.getInstance();
    }


    // public Reservation()
    // {
    //     this.date_creation = Calendar.getInstance();
    //     reservations.add(this);
    //     this.num_res = String.format("%08d", reservations.size());
    //     System.out.println(num_res);

        
    // }
    @Override
    public String toString() {
        return "Reservation [\n chambre_res=" + chambre_res + ",\n date_creation=" + formatter.format(date_creation.getTime()) + ",\n date_deb_sejour="
                + formatter.format(date_deb_sejour.getTime()) + ",\n date_fin_sejour=" + getDate_fin_sejour_toString() + ",\n nb_nuits=" + nb_nuits + ", \n numClient="
                + numClient + ",\n num_res=" + num_res + "\n]";
                
    }
    
    public static void main(String[] args) {
        date.set(2021, 1, 15);
		Reservation res = new Reservation(
            date,
            4,
            new ArrayList<>(),
            new Client()
		);
        
        
        System.out.println(res.toString());
    }

    
    public Calendar getDate_creation() {
        return date_creation;
    }
    public String getDate_creation_toString() {
        return formatter.format(date_creation.getTime());
    }


    public void setDate_creation(Calendar date_creation) {
        this.date_creation = date_creation;
    }


    public Calendar getDate_deb_sejour() {
        return date_deb_sejour;
    }
    public String getDate_deb_sejour_toString() {
        return formatter.format(date_deb_sejour.getTime());
    }


    public void setDate_deb_sejour(Calendar date_deb_sejour) {
        this.date_deb_sejour = date_deb_sejour;
    }


    public Calendar getDate_fin_sejour() {
        return date_fin_sejour;
    }
    public String getDate_fin_sejour_toString() {
        return formatter.format(date_fin_sejour.getTime());
    }


    public void setDate_fin_sejour(Calendar date_fin_sejour) {
        this.date_fin_sejour = date_fin_sejour;
    }


    public int getNb_nuits() {
        return nb_nuits;
    }


    public void setNb_nuits(int nb_nuits) {
        this.nb_nuits = nb_nuits;
    }


    public String getNum_res() {
        return num_res;
    }


    public void setNum_res(String num_res) {
        this.num_res = num_res;
    }


    public ArrayList<Chambre> getChambre_res() {
        return chambre_res;
    }


    public void setChambre_res(ArrayList<Chambre> chambre_res) {
        this.chambre_res = chambre_res;
    }


    public String getNumClientRes() {
        return numClient;
    }


    public void setNumClientRes(String numClient) {
        this.numClient = numClient;
    }

//    public static void afficherResa(Reservation res)
//    {
//        if(reservations.contains(res))
//        {
//            //afficher res
//            System.out.println("reservation affichée");
//        }
//        else
//        {
//            System.out.println("reservation inexistante");
//
//        }
//    }

    public void modifierResa()
    {
        //ouvrir la fenetre de modif
        //enregistrer les modif
    }

    public void afficherMail()
    {
        //ouvrir la fenetre du mail
    }
//    public static void annulerResa(Reservation res)
//    {
//        //annuler resa
//        //message confirmation
//        if(reservations.contains(res))
//        {
//            reservations.remove(res);
//            System.out.println("reservation annulée");
//        }
//        else
//        {
//            System.out.println("reservation inexistante");
//
//        }
//
//    }
    
}


