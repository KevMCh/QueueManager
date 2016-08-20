/**
 * TURN-TIME
 *
 * UNIVERSIDAD DE LA LAGUNA
 * ESCUELA SUPERIOR DE INGENIERÍA Y TECNOLOGÍA
 *
 * @author	Kevin Martín
 * @version	0.0.0
 * @since 9/6/16
 * @email: marchinkev@gmail.com
 *
 * Class to show the queues in the view.
 */
package es.ull.esit.queuemanager;

import android.app.Activity;
import android.content.Context;
import android.net.ConnectivityManager;
import android.os.Bundle;
import android.widget.ListView;
import android.widget.TextView;

public class ShowQueue extends Activity {

    private Database database;                  // The server database
    private ListView queuesList;                // Item to show the list of queues

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.queuelist);

        queuesList = (ListView) findViewById(R.id.queueListText);

        database = new Database(this, (ConnectivityManager)
                getSystemService(Context.CONNECTIVITY_SERVICE), getContentResolver());

        database.getQueuesUser(queuesList, this);
    }
}
