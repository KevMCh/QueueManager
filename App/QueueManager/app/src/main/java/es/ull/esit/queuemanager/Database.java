package es.ull.esit.queuemanager;

import android.content.ContentResolver;
import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.widget.ArrayAdapter;
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

/**
 * Created by kevin on 22/6/16.
 */
public class Database {

    private static final String URLWEBSERVICE = "URLWEB/app/";
    private static final String FILEGETQUEUES = "getQueuesUser.php";
    private static final String FILEINSERTUSER = "insertUserInQueue.php";


    private Context contextDatabase;
    private String idUser;

    public Database(Context context, ConnectivityManager connectivityManager,
                    ContentResolver contetResolver) {
        contextDatabase = context;
        idUser   = android.provider.Settings.System.getString(contetResolver,
                android.provider.Settings.System.ANDROID_ID);

        ConnectivityManager connMgr = connectivityManager;
        NetworkInfo networkInfo = connMgr.getActiveNetworkInfo();
        if (networkInfo == null || !(networkInfo.isConnected())) {
            Toast.makeText(contextDatabase, "There's no connection", Toast.LENGTH_SHORT).show();
        }
    }

    public void setUserInQueue(String qrIDQueue, Settings settings) {
        int numNotifyUser = settings.getTurnNotifyUser();
        new PostRequest(qrIDQueue, numNotifyUser).execute();
    }

    public void getQueuesUser(ListView list, Context context) {
        new GetRequest(list, context).execute();
    }

    public Context getContextDatabase() { return contextDatabase; }

    public String getIdUser() { return idUser; }

    public void setIdUser(String idUser) { this.idUser = idUser; }

    public void setContextDatabase(Context contextDatabase) {
        this.contextDatabase = contextDatabase;
    }

    private class PostRequest extends AsyncTask<Void, Void, Integer> {

        private String idQueue;
        private int numNotifyUser;

        public PostRequest(String qrIDQueue, int numNotifyUser) {
            idQueue = qrIDQueue;
            this.numNotifyUser = numNotifyUser;
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
                StringBuilder sb = new StringBuilder();
                String response = null;
                while((response = reader.readLine()) != null) {
                    sb.append(response + "\n");
                }
                return  Integer.parseInt(sb.toString());

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

    private class GetRequest extends AsyncTask<Void, Void, String> {

        private ListView queuesList;
        private Context context;

        public GetRequest(ListView list, Context contextView) {
            queuesList = list;
            context = contextView;
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
            ArrayList<String> data = new ArrayList<String>();
            try {
                JSONObject jsonRootObject = new JSONObject(result);
                JSONArray jsonArray = jsonRootObject.optJSONArray("Queues");

                for(int i = 0; i < jsonArray.length(); i++){
                    JSONObject jsonObject = jsonArray.getJSONObject(i);

                    int id = Integer.parseInt(jsonObject.optString("ID").toString());
                    int idEntity = Integer.parseInt(jsonObject.optString("IDEntity").toString());
                    String name = jsonObject.optString("Name").toString();
                    String listUsers = jsonObject.optString("ListUsers").toString();

                    String item = "Queue " + i + ": \n\tID: "+ id + "\n\tIDEntity: " + idEntity +
                            " \n\t Name: " + name + "\n\tLista de usuarios: " + listUsers + "\n\n";
                    data.add(item);
                }
                ArrayAdapter<String> adapter =
                        new ArrayAdapter<String> (getContext(), android.R.layout.simple_list_item_1, data);
                getQueuesList().setAdapter(adapter);

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
