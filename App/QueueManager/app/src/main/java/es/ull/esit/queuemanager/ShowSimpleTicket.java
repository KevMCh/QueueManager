package es.ull.esit.queuemanager;

import android.app.Activity;
import android.os.Bundle;
import android.widget.TextView;

import es.ull.esit.queuemanager.adapter.Ticket;

/**
 * Created by kevin on 18/8/16.
 */
public class ShowSimpleTicket extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.simpleticket);

        Ticket ticket = (Ticket) getIntent().getExtras().getSerializable("ticket");

        TextView nameEntity = ((TextView) findViewById(R.id.nameEntitySimpleTicketView));
        nameEntity.setText("Entidad: " + ticket.getNameEntity().toString());
        TextView nameQueue = ((TextView) findViewById(R.id.nameQueueSimpleTicketView));
        nameQueue.setText("Cola: " + ticket.getNameQueue());
        TextView position = ((TextView) findViewById(R.id.positionSimpleTicketView));
        position.setText("Posición: " + String.valueOf(ticket.getPosition()));
        TextView turn = ((TextView) findViewById(R.id.turnSimpleTicketView));
        turn.setText("Turno: " + String.valueOf(ticket.getTurn()));
        TextView date = ((TextView) findViewById(R.id.dateSimpleTicketView));
        date.setText("Fecha: " + ticket.getDate());
    }
}
