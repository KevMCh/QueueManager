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
 * Class that believes the notifications received.
 */
package es.ull.esit.queuemanager.notification;

import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.media.RingtoneManager;
import android.net.Uri;
import android.support.v4.app.NotificationCompat;

import com.google.firebase.messaging.FirebaseMessagingService;
import com.google.firebase.messaging.RemoteMessage;

import es.ull.esit.queuemanager.R;
import es.ull.esit.queuemanager.Settings;
import es.ull.esit.queuemanager.ShowSimpleTicket;
import es.ull.esit.queuemanager.adapter.Ticket;

public class NotificationMessage extends FirebaseMessagingService {

    private final static long[] PATTERN = {0, 500, 300, 1000, 500};
    private String title;
    private String message;
    private Ticket ticket;

    @Override
    public void onMessageReceived(RemoteMessage remoteMessage) {
        title = remoteMessage.getData().get("title");
        message = remoteMessage.getData().get("message");
        ticket = new Ticket(remoteMessage.getData().get("nameEntity"),
                            remoteMessage.getData().get("nameQueue"),
                            Integer.parseInt(remoteMessage.getData().get("position")),
                            Integer.parseInt(remoteMessage.getData().get("turn")),
                            remoteMessage.getData().get("date"));
        showNotification();
    }

    private void showNotification() {
        Intent intent = new Intent(this, ShowSimpleTicket.class);
        intent.putExtra("ticket", getTicket());
        intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);

        PendingIntent pendingIntent = PendingIntent.getActivity(this, 0, intent,
                PendingIntent.FLAG_UPDATE_CURRENT);

        Uri defaultSoundUri= RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION);

        NotificationCompat.Builder notificationBuilder = new NotificationCompat.Builder(this)
                .setAutoCancel(true)
                .setContentTitle(getTitle())
                .setContentText(getMessage())
                .setSmallIcon(R.mipmap.ic_launcher)
                .setContentIntent(pendingIntent);

        if(((Settings) this.getApplication()).isVibrate()){
            notificationBuilder.setVibrate(PATTERN);
        }

        if(((Settings) this.getApplication()).isSound()){
            notificationBuilder.setSound(defaultSoundUri);
        }

        NotificationManager notificationManager =
                (NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE);

        notificationManager.notify(0, notificationBuilder.build());
    }

    public String getMessage() {
        return message;
    }

    public static long[] getPATTERN() {
        return PATTERN;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public Ticket getTicket() {
        return ticket;
    }

    public void setTicket(Ticket ticket) {
        this.ticket = ticket;
    }
}
