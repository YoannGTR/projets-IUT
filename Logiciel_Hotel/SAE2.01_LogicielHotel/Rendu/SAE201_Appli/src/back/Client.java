package back;

import java.util.ArrayList;
import java.lang.String;
public class Client
{
    private String numClient;
    private String nomClient;
    private String prenomClient;
    private String numeroTelClient;
    private String mailClient;
    private String adresse;
    private String ville;
    private String codePostal;
    private ArrayList<Reservation> listeReservations = new ArrayList<>();

    public Client()
    {
        numClient = "0123456";
    }
    
    public Client(String prenomClient, String nomClient, String numeroTelClient, String mailClient, String adresse, String ville, String codePostal) {
        this.nomClient = nomClient;
        this.prenomClient = prenomClient;
        this.numeroTelClient = numeroTelClient;
        this.mailClient = mailClient;
        this.adresse = adresse;
        this.ville = ville;
        this.codePostal = codePostal;

        String tmp = String.format("%08d", AccesDonees.getLesClient().size());
        int i = 0;
        while(AccesDonees.getClient(tmp)!=null)
        {
        	i+=1;
        	tmp = String.format("%08d", AccesDonees.getLesClient().size()+i);
        }

        this.numClient = tmp;
    }
    public String getAdresse() {
        return adresse;
    }

    public void setAdresse(String adresse) {
        this.adresse = adresse;
    }

    public String getVille() {
        return ville;
    }

    public void setVille(String ville) {
        this.ville = ville;
    }
    public String getCodePostal() {
        return codePostal;
    }

    public void setCodePostal(String codePostal) {
        this.codePostal = codePostal;
    }

    public String getNumClient() {
        return numClient;
    }
    public void setNumClient(String numClient) {
        this.numClient = numClient;
    }
    public String getNomClient() {
        return nomClient;
    }
    public void setNomClient(String nomClient) {
        this.nomClient = nomClient;
    }
    public String getPrenomClient() {
        return prenomClient;
    }
    public void setPrenomClient(String prenomClient) {
        this.prenomClient = prenomClient;
    }
    public String getNumeroTelClient() {
        return numeroTelClient;
    }
    public void setNumeroTelClient(String numeroTelClient) {
        this.numeroTelClient = numeroTelClient;
    }
    public String getMailClient() {
        return mailClient;
    }
    public void setMailClient(String mailClient) {
        this.mailClient = mailClient;
    }
  
    public ArrayList<Reservation> getListeReservations() {
        return listeReservations;
    }
    public void setListeReservations(ArrayList<Reservation> listeReservations) {
        this.listeReservations = listeReservations;
    }

    public void addRes(Reservation res)
    {
        if (!listeReservations.contains(res)) {
            listeReservations.add(res);
        }
        else
        {
            System.out.println("error");
        }
    }


    @Override
    public String toString() {
        return "Client [\n adresse=" + adresse + ",\n listeReservations=" + listeReservations + ",\n mailClient=" + mailClient
                + ",\n nomClient=" + nomClient + ",\n numClient=" + numClient + ",\n numeroTelClient=" + numeroTelClient
                + ",\n prenomClient=" + prenomClient + ",\n ville=" + ville + "\n]";
    }

    
}

