package es.ull.esit.queuemanager;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;

public class ShowMainMenu extends AppCompatActivity {

    private Button enterButton;
    private Button accessQueue;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.main);

        enterButton = ((Button) findViewById(R.id.enter));
        enterButton.setEnabled(true);
        enterButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent menu = new Intent(ShowMainMenu.this, ShowOptions.class);
                startActivity(menu);
            }
        });
    }

    public Button getEnterButton() { return enterButton; }

    public void setEnterButton(Button enterButton) { this.enterButton = enterButton; }
}
