package es.ull.esit.queuemanager;

/**
 * Created by kevin on 8/6/16.
 */
import android.app.Activity;
import android.content.ActivityNotFoundException;
import android.os.Bundle;
import android.content.Intent;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import com.firebase.client.DataSnapshot;
import com.firebase.client.Firebase;
import com.firebase.client.FirebaseError;
import com.firebase.client.ValueEventListener;

import es.ull.esit.queuemanager.com.google.zxing.IntentIntegrator;
import es.ull.esit.queuemanager.com.google.zxing.IntentResult;

public class ReadQR extends Activity {

    private final String URLFIREBASE = "https://queuelist.firebaseio.com/";

    private ImageButton buttonReader;
    private Firebase firebase;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.readerqr);

        buttonReader = (ImageButton) findViewById(R.id.btReader);
        buttonReader.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                new IntentIntegrator(ReadQR.this).initiateScan();
            }
        });

        Firebase.setAndroidContext(this);
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent intent) {
        final IntentResult scanResult = IntentIntegrator.parseActivityResult(requestCode, resultCode, intent);
        handleResult(scanResult);
    }

    private void handleResult(IntentResult scanResult) {
        if (scanResult != null) {
            updateViews(scanResult.getContents(), scanResult.getFormatName());
        } else {
            Toast.makeText(this, "No se ha leído nada", Toast.LENGTH_SHORT).show();
        }
    }

    private void updateViews(String scanResult, String scanResultFormat) {
        /* ((TextView) findViewById(R.id.codeFormat)).setText(scanResultFormat);
        final TextView codeResult = (TextView)findViewById(R.id.codeResult);
        codeResult.setText(scanResult); */

        Firebase.setAndroidContext(this);
        firebase = new Firebase(URLFIREBASE).child(scanResult).child(
                android.provider.Settings.System.getString(getContentResolver(),
                        android.provider.Settings.System.ANDROID_ID));
        firebase.setValue("Default");
    }

    public ImageButton getButtonReader() { return buttonReader; }

    public void setButtonReader(ImageButton buttonReader) { this.buttonReader = buttonReader; }

}

