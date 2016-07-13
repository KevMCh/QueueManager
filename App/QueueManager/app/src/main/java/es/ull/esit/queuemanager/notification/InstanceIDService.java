package es.ull.esit.queuemanager.notification;

/**
 * Created by kevin on 7/7/16.
 */
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
