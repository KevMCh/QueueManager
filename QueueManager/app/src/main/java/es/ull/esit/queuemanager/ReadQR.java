package es.ull.esit.queuemanager;

/**
 * Created by kevin on 8/6/16.
 */
import android.app.Activity;
import android.content.ActivityNotFoundException;
import android.os.Bundle;
import android.content.Intent;
import android.view.View;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import es.ull.esit.queuemanager.com.google.zxing.IntentIntegrator;
import es.ull.esit.queuemanager.com.google.zxing.IntentResult;

public class ReadQR extends Activity {

    private ImageButton buttonReader;

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
        ((TextView) findViewById(R.id.codeFormat)).setText(scanResultFormat);
        final TextView codeResult = (TextView)findViewById(R.id.codeResult);
        codeResult.setText(scanResult);
    }

    public ImageButton getButtonReader() { return buttonReader; }

    public void setButtonReader(ImageButton buttonReader) { this.buttonReader = buttonReader; }

}

