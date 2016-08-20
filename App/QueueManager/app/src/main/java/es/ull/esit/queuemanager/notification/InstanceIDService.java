/**
 * TURN-TIME
 *
 * UNIVERSIDAD DE LA LAGUNA
 * ESCUELA SUPERIOR DE INGENIERÍA Y TECNOLOGÍA
 *
 * @author	Kevin Martín
 * @version	0.0.0
 * @since 7/7/16
 * @email: marchinkev@gmail.com
 *
 * Class with the token of firebase.
 */
package es.ull.esit.queuemanager.notification;

import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.FirebaseInstanceIdService;

public class InstanceIDService extends FirebaseInstanceIdService {

    private String refreshedToken;

    @Override
    public void onTokenRefresh() {
        refreshedToken = FirebaseInstanceId.getInstance().getToken();
    }

    public static String getRefreshedToken() {
        return FirebaseInstanceId.getInstance().getToken();
    }

    public void setRefreshedToken(String refreshedToken) {
        this.refreshedToken = refreshedToken;
    }
}
