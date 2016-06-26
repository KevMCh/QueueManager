package es.ull.esit.queuemanager;

import android.app.Activity;
import android.content.Context;
import android.net.ConnectivityManager;
import android.os.Bundle;
import android.widget.TextView;

/**
 * Created by kevin on 9/6/16.
 */
public class ShowQueue extends Activity {

    private Database database;
    private TextView queuesList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.queuelist);

        queuesList = (TextView) findViewById(R.id.queueListText);

        database = new Database(this, (ConnectivityManager)
                getSystemService(Context.CONNECTIVITY_SERVICE), getContentResolver());

        database.getQueuesUser(queuesList);
    }
}
