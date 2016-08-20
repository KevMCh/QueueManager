/**
 * TURN-TIME
 *
 * UNIVERSIDAD DE LA LAGUNA
 * ESCUELA SUPERIOR DE INGENIERÍA Y TECNOLOGÍA
 *
 * @author	Kevin Martín
 * @version	0.0.0
 * @since 3/6/16
 * @email: marchinkev@gmail.com
 *
 * Class to accede to the different functionalities (get QR code,
 * change settings and see the queue).
 */
package es.ull.esit.queuemanager;

import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.app.Activity;
import android.widget.Toast;

import es.ull.esit.queuemanager.com.google.zxing.IntentIntegrator;
import es.ull.esit.queuemanager.com.google.zxing.IntentResult;

public class ShowOptions extends Activity {

    private Database database;
    private Button getQRCodeButton;
    private Button settingsButton;
    private Button queuelistButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.menu);

        database = new Database(this, (ConnectivityManager)
                getSystemService(Context.CONNECTIVITY_SERVICE), getContentResolver());

        getQRCodeButton = ((Button) findViewById(R.id.qrButton));
        getQRCodeButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                new IntentIntegrator(ShowOptions.this).initiateScan();
            }
        });

        queuelistButton = ((Button) findViewById(R.id.queuelistButton));
        queuelistButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent queuelist = new Intent(ShowOptions.this, ShowQueue.class);
                startActivity(queuelist);

            }
        });

        settingsButton = ((Button) findViewById(R.id.settingsButton));
        settingsButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent changeSettings = new Intent(ShowOptions.this, ChangeSettings.class);
                startActivity(changeSettings);
            }
        });
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent intent) {
            final IntentResult scanResult = IntentIntegrator.parseActivityResult(requestCode, resultCode, intent);
            handleResult(scanResult);
    }

    private void handleResult(IntentResult scanResult) {
        if ((scanResult != null) && (scanResult.getContents() != null)) {
            createInDatabase(scanResult.getContents());
        } else {
            Toast.makeText(this, "No se ha leído código QR", Toast.LENGTH_SHORT).show();
        }
    }

    private void createInDatabase(String scanResult) {
        getDatabase().setUserInQueue(scanResult, ((Settings) this.getApplication()));
    }

    public Button getGetQRCodeButton() {
        return getQRCodeButton;
    }

    public Button getSettingsButton() {
        return settingsButton;
    }

    public void setGetQRCodeButton(Button getQRCodeButton) { this.getQRCodeButton = getQRCodeButton; }

    public void setSettingsButton(Button settingsButton) {
        this.settingsButton = settingsButton;
    }

    public Database getDatabase() { return database; }

    public void setDatabase(Database database) { this.database = database; }
}
