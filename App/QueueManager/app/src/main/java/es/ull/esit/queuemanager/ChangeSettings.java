/**
 * TURN-TIME
 *
 * UNIVERSIDAD DE LA LAGUNA
 * ESCUELA SUPERIOR DE INGENIERÍA Y TECNOLOGÍA
 *
 * @author	Kevin Martín
 * @version	0.0.0
 * @since 8/6/16
 * @email: marchinkev@gmail.com
 *
 * Class to change the settings (vibration, sound and shift of notification).
 */
package es.ull.esit.queuemanager;

import android.app.Activity;
import android.os.Bundle;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.NumberPicker;
import android.widget.TextView;

public class ChangeSettings extends Activity {

    private Settings settings;
    private NumberPicker turnNotifyUser;
    private CheckBox vibrateCheckbox;
    private CheckBox soundCheckbox;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.settings);

        turnNotifyUser = (NumberPicker) findViewById(R.id.notifyUser);
        vibrateCheckbox = (CheckBox) findViewById(R.id.checkBoxVibration);
        soundCheckbox = (CheckBox) findViewById(R.id.checkBoxSound);
        settings = ((Settings) this.getApplication());

        vibrateCheckbox.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener(){
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked){
                if (isChecked) {
                    settings.setVibrate(true);
                } else {
                    settings.setVibrate(false);
                }
            }
        });

        soundCheckbox.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener(){
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked){
                if (isChecked) {
                    settings.setSound(true);
                } else {
                    settings.setSound(false);
                }
            }
        });

        if(settings.isVibrate()){
            vibrateCheckbox.setChecked(true);
        } else {
            vibrateCheckbox.setChecked(false);
        }

        if(settings.isSound()){
            soundCheckbox.setChecked(true);
        } else {
            soundCheckbox.setChecked(false);
        }

        turnNotifyUser.setMinValue(0);
        turnNotifyUser.setMaxValue(10);
        turnNotifyUser.setWrapSelectorWheel(false);


        turnNotifyUser.setOnValueChangedListener(new NumberPicker.OnValueChangeListener() {
            public void onValueChange(NumberPicker picker, int oldVal, int newVal) {
                settings.setTurnNotifyUser(newVal);
            }
        });

        turnNotifyUser.setSelected(false);
        turnNotifyUser.setValue(settings.getTurnNotifyUser());
    }

    public NumberPicker getTurnNotifyUser() {
        return turnNotifyUser;
    }

    public void setTurnNotifyUser(NumberPicker turnNotifyUser) {
        this.turnNotifyUser = turnNotifyUser;
    }
}
