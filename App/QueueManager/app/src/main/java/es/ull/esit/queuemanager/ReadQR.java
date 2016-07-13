package es.ull.esit.queuemanager;

/**
 * Created by kevin on 8/6/16.
 */
import android.app.Activity;
import android.content.Context;
import android.net.ConnectivityManager;
import android.os.Bundle;
import android.content.Intent;
import android.view.View;
import android.widget.ImageButton;
import android.widget.Toast;

import es.ull.esit.queuemanager.com.google.zxing.IntentIntegrator;
import es.ull.esit.queuemanager.com.google.zxing.IntentResult;

public class ReadQR extends Activity {

    private ImageButton buttonReader;
    private Database database;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.readerqr);

        database = new Database(this, (ConnectivityManager)
                getSystemService(Context.CONNECTIVITY_SERVICE), getContentResolver());

        buttonReader = (ImageButton) findViewById(R.id.btReader);
        buttonReader.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                new IntentIntegrator(ReadQR.this).initiateScan();
            }
        });
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent intent) {
        final IntentResult scanResult = IntentIntegrator.parseActivityResult(requestCode, resultCode, intent);
        handleResult(scanResult);
    }

    private void handleResult(IntentResult scanResult) {
        if (scanResult != null) {
            createInDatabase(scanResult.getContents());
        } else {
            Toast.makeText(this, "No se ha leído código QR", Toast.LENGTH_SHORT).show();
        }
    }

    private void createInDatabase(String scanResult) {
        getDatabase().setUserInQueue(scanResult, ((Settings) this.getApplication()));
    }

    public ImageButton getButtonReader() { return buttonReader; }

    public void setButtonReader(ImageButton buttonReader) { this.buttonReader = buttonReader; }

    public Database getDatabase() { return database; }

    public void setDatabase(Database database) { this.database = database; }
}

