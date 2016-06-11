package es.ull.esit.queuemanager;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.app.Activity;

/**
 * Created by kevin on 3/6/16.
 */
public class ShowOptions extends Activity {

    private Button getQRCodeButton;
    private Button settingsButton;
    private Button queuelistButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.menu);

        getQRCodeButton = ((Button) findViewById(R.id.qrButton));
        getQRCodeButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent readQR = new Intent(ShowOptions.this, ReadQR.class);
                startActivity(readQR);

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
}
