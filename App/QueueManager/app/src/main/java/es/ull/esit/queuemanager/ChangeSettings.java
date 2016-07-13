package es.ull.esit.queuemanager;

import android.app.Activity;
import android.os.Bundle;
import android.widget.NumberPicker;
import android.widget.TextView;

/**
 * Created by kevin on 8/6/16.
 */
public class ChangeSettings extends Activity {

    private Settings settings;
    private NumberPicker turnNotifyUser;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.settings);

        turnNotifyUser = (NumberPicker) findViewById(R.id.notifyUser);
        settings = ((Settings) this.getApplication());

        turnNotifyUser.setValue(settings.getTurnNotifyUser());

        turnNotifyUser.setMinValue(0);
        turnNotifyUser.setMaxValue(10);
        turnNotifyUser.setWrapSelectorWheel(false);


        turnNotifyUser.setOnValueChangedListener(new NumberPicker.OnValueChangeListener() {
            public void onValueChange(NumberPicker picker, int oldVal, int newVal) {
                settings.setTurnNotifyUser(newVal);
            }
        });


    }

    public NumberPicker getTurnNotifyUser() {
        return turnNotifyUser;
    }

    public void setTurnNotifyUser(NumberPicker turnNotifyUser) {
        this.turnNotifyUser = turnNotifyUser;
    }
}
