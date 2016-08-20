/**
 * TURN-TIME
 *
 * UNIVERSIDAD DE LA LAGUNA
 * ESCUELA SUPERIOR DE INGENIERÍA Y TECNOLOGÍA
 *
 * @author	Kevin Martín
 * @version	0.0.0
 * @since 12/7/16
 * @email: marchinkev@gmail.com
 *
 * Class to save the settings.
 */
package es.ull.esit.queuemanager;

import android.app.Application;

public class Settings extends Application {

    private int turnNotifyUser;
    private boolean vibrate;
    private boolean sound;

    public Settings () {
        turnNotifyUser = 0;
        vibrate = true;
        sound = true;
    }

    public int getTurnNotifyUser() {
        return turnNotifyUser;
    }

    public void setTurnNotifyUser(int turnNotifyUser) {
        this.turnNotifyUser = turnNotifyUser;
    }

    public boolean isVibrate() {
        return vibrate;
    }

    public boolean isSound() {
        return sound;
    }

    public void setVibrate(boolean vibrate) {
        this.vibrate = vibrate;
    }

    public void setSound(boolean sound) {
        this.sound = sound;
    }
}
