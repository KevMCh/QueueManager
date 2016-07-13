package es.ull.esit.queuemanager;

import android.app.Application;

/**
 * Created by kevin on 12/7/16.
 */
public class Settings extends Application {

    private int turnNotifyUser;

    public Settings () {
        turnNotifyUser = 0;
    }

    public int getTurnNotifyUser() {
        return turnNotifyUser;
    }

    public void setTurnNotifyUser(int turnNotifyUser) {
        this.turnNotifyUser = turnNotifyUser;
    }
}
