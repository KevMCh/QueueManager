/**
 * TURN-TIME
 *
 * UNIVERSIDAD DE LA LAGUNA
 * ESCUELA SUPERIOR DE INGENIERÍA Y TECNOLOGÍA
 *
 * @author	Kevin Martín
 * @version	0.0.0
 * @since 22/6/16
 * @email: marchinkev@gmail.com
 *
 * Class to connecting to a server.
 */
package es.ull.esit.queuemanager;

import android.app.Activity;
import android.content.ContentResolver;
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;
import java.util.ArrayList;

import es.ull.esit.queuemanager.notification.InstanceIDService;
import es.ull.esit.queuemanager.adapter.Ticket;
import es.ull.esit.queuemanager.adapter.TicketAdapter;

public class Database {

    private static final String URLWEBSERVICE = "URLWEB/app/";
    private static final String FILEGETQUEUES = "getQueuesUser.php";
    private static final String FILEINSERTUSER = "insertUserInQueue.php";


    private Context contextDatabase;
    private String idUser;
    private ConnectivityManager connectivityManager;

    public Database(Context context, ConnectivityManager connectivityManager,
                    ContentResolver contetResolver) {
        contextDatabase = context;
        idUser   = android.provider.Settings.System.getString(contetResolver,
                android.provider.Settings.System.ANDROID_ID);

        this.connectivityManager = connectivityManager;
    }

    public void setUserInQueue(String qrIDQueue, Settings settings) {
        int numNotifyUser = settings.getTurnNotifyUser();
        new PostRequest(qrIDQueue, numNotifyUser).execute();
    }

    public void getQueuesUser(ListView list, Context context) {
        new GetRequest(list, context).execute();
    }

    public void checkConnection() {
        NetworkInfo networkInfo = connectivityManager.getActiveNetworkInfo();
        if (networkInfo == null || !(networkInfo.isConnected())) {
            Toast.makeText(contextDatabase, "There's no connection", Toast.LENGTH_SHORT).show();
        }
    }

    public Context getContextDatabase() { return contextDatabase; }

    public String getIdUser() { return idUser; }

    public void setIdUser(String idUser) { this.idUser = idUser; }

    public void setContextDatabase(Context contextDatabase) {
        this.contextDatabase = contextDatabase;
    }

    /**
     * Private class that inserts the user in the queue.
     */
    private class PostRequest extends AsyncTask<Void, Void, Integer> {

        private String idQueue;
        private int numNotifyUser;

        public PostRequest(String qrIDQueue, int numNotifyUser) {
            idQueue = qrIDQueue;
            this.numNotifyUser = numNotifyUser;

            checkConnection();
        }

        @Override
        protected Integer doInBackground(Void... params) {
            String paramsRequest = null;
            try {
                paramsRequest = URLEncoder.encode("idQueue", "UTF-8")
                        + "=" + URLEncoder.encode(getIdQueue(), "UTF-8");

                paramsRequest += "&" + URLEncoder.encode("idUser", "UTF-8") + "="
                        + URLEncoder.encode(getIdUser(), "UTF-8");

                paramsRequest += "&" + URLEncoder.encode("tokenFCM", "UTF-8") + "="
                        + URLEncoder.encode(InstanceIDService.getRefreshedToken(), "UTF-8");

                paramsRequest += "&" + URLEncoder.encode("positionNotification", "UTF-8") + "="
                        + URLEncoder.encode(String.valueOf(numNotifyUser), "UTF-8");

            } catch(UnsupportedEncodingException e) {
                e.printStackTrace();
            }

            BufferedReader reader = null;

            try {
                URL url = new URL(URLWEBSERVICE + FILEINSERTUSER);
                URLConnection urlConnection = url.openConnection();
                urlConnection.setDoOutput(true);
                OutputStreamWriter wr = new OutputStreamWriter(urlConnection.getOutputStream());
                wr.write(paramsRequest);
                wr.flush();

                // Server response
                reader = new BufferedReader(new InputStreamReader(urlConnection.getInputStream()));
                String response = reader.readLine();

                return Integer.parseInt(response);

            } catch(Exception ex) {
                return 401;

            } finally {
                try {
                    assert reader != null;
                    reader.close();
                } catch(Exception ex) {
                    return 402;
                }
            }
        }

        @Override
        protected void onPostExecute(Integer result) {
            if(result == 200){
                Toast.makeText(getContextDatabase(), "Creada con éxito", Toast.LENGTH_SHORT).show();
            } else {
                Toast.makeText(getContextDatabase(), "Error accediendo a la cola", Toast.LENGTH_SHORT).show();
            }
        }

        public void setIdQueue(String idQueue) { this.idQueue = idQueue; }

        public String getIdQueue() { return idQueue; }
    }

    /**
     * Private class in order to receive all queue where the user waits.
     */
    private class GetRequest extends AsyncTask<Void, Void, String> {

        private ListView queuesList;
        private Context context;

        public GetRequest(ListView list, Context contextView) {
            queuesList = list;
            context = contextView;

            checkConnection();
        }

        @Override
        protected String doInBackground(Void... params) {
            String paramsRequest = null;

            try {
                paramsRequest = URLEncoder.encode("idUser", "UTF-8")
                        + "=" + URLEncoder.encode(getIdUser(), "UTF-8");

            } catch (UnsupportedEncodingException e) {
                e.printStackTrace();
            }

            BufferedReader reader = null;

            try {
                URL url = new URL(URLWEBSERVICE + FILEGETQUEUES);
                URLConnection urlConnection = url.openConnection();
                urlConnection.setDoOutput(true);
                OutputStreamWriter wr = new OutputStreamWriter(urlConnection.getOutputStream());
                wr.write(paramsRequest);
                wr.flush();

                // Server response
                reader = new BufferedReader(new InputStreamReader(urlConnection.getInputStream()));
                StringBuilder sb = new StringBuilder();
                String response = null;

                while ((response = reader.readLine()) != null) {
                    sb.append(response);
                }

                return sb.toString();

            } catch (Exception e) {
                e.printStackTrace();
                return "Server error ocurred";

            } finally {
                try {
                    assert reader != null;
                    reader.close();
                } catch (Exception e) {
                    e.printStackTrace();
                    return "Error to closed the server";
                }
            }
        }

        @Override
        protected void onPostExecute(String result) {
            final ArrayList<Ticket> listTickets = new ArrayList();
            try {
                JSONObject jsonRootObject = new JSONObject(result);
                JSONArray jsonArray = jsonRootObject.optJSONArray("Queues");

                for(int i = 0; i < jsonArray.length(); i++){
                    JSONObject jsonObject = jsonArray.getJSONObject(i);

                    String nameEntity = jsonObject.optString("NameEntity").toString();
                    String nameQueue = jsonObject.optString("NameQueue").toString();
                    int turn = Integer.parseInt(jsonObject.optString("Turn").toString());
                    int position = Integer.parseInt(jsonObject.optString("Position").toString());
                    String date = jsonObject.optString("Date").toString();

                    Ticket ticket = new Ticket(nameEntity, nameQueue, turn, position, date);
                    listTickets.add(ticket);
                }

                TicketAdapter adapter = new TicketAdapter((Activity) getContext(), listTickets);
                getQueuesList().setAdapter(adapter);

                getQueuesList().setOnItemClickListener(new AdapterView.OnItemClickListener() {
                    @Override
                    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                        Intent intent = new Intent((Activity) getContext(),
                                ShowSimpleTicket.class);
                        intent.putExtra("ticket", listTickets.get(position));
                        getContext().startActivity(intent);

                    }
                });

            } catch (JSONException e) {
                e.printStackTrace();
            }
        }

        public ListView getQueuesList() { return queuesList; }

        public void setQueuesList(ListView queuesList) { this.queuesList = queuesList; }

        public Context getContext() { return context; }

        public void setContext(Context context) { this.context = context; }
    }
}
