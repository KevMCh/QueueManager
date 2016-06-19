package es.ull.esit.queuemanager;

import android.app.Activity;
import android.os.Bundle;
import android.provider.Settings;
import android.widget.TextView;

import com.firebase.client.DataSnapshot;
import com.firebase.client.Firebase;
import com.firebase.client.FirebaseError;
import com.firebase.client.ValueEventListener;

import java.util.ArrayList;

import es.ull.esit.queuemanager.es.ull.esit.queue.Node;
import es.ull.esit.queuemanager.es.ull.esit.queue.Queue;

/**
 * Created by kevin on 9/6/16.
 */
public class ShowQueue extends Activity {

    private final String URLFIREBASE = "https://queuelist.firebaseio.com/";

    private Firebase firebase;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.queuelist);

        Firebase.setAndroidContext(this);
        firebase = new Firebase(URLFIREBASE);

        firebase.addValueEventListener(new ValueEventListener() {

            @Override
            public void onDataChange(DataSnapshot snapshot) {
                TextView listText = (TextView) findViewById(R.id.queueListText);

                ArrayList<Queue> queuesList = new ArrayList<Queue> ();

                for (DataSnapshot entity: snapshot.getChildren()) {
                    String id = Settings.System.getString(getContentResolver(),
                            Settings.System.ANDROID_ID);

                    if(entity.hasChild(id)){
                        Queue queue = new Queue(entity.getKey());
                        for (DataSnapshot child: entity.getChildren()) {
                            Node node = new Node(child.getKey().toString(), child.getValue().toString());
                            queue.push(node);
                        }
                        queuesList.add(queue);
                    }
                }

                String allQueue = "";
                for(int i = 0; i < queuesList.size(); i++) {
                    allQueue += "\n\n" + queuesList.get(i).getEntity() + ":\n";

                    for(int j = 0; j < queuesList.get(i).getList().size(); j++) {

                        allQueue += queuesList.get(i).getList().get(j).toString();
                    }
                }

                listText.setText(allQueue);
            }

            @Override
            public void onCancelled(FirebaseError error) {

            }
        });
    }
}
