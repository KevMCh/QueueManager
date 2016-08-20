package es.ull.esit.queuemanager.adapter;

import java.util.ArrayList;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import es.ull.esit.queuemanager.R;

public class TicketAdapter extends BaseAdapter {
	protected Activity activity;
	protected ArrayList<Ticket> tickets;
	
	public TicketAdapter(Activity activity, ArrayList<Ticket> tickets) {
		this.activity = activity;
		this.tickets = tickets;
	}

	@Override
	public int getCount() {
		return tickets.size();
	}


	@Override
	public Object getItem(int position) {
		return tickets.get(position);
	}


	@Override
	public long getItemId(int position) {
		return position;
	}


	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		View view = convertView;
		
        if(convertView == null) {
        	LayoutInflater inflater = (LayoutInflater) activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        	view = inflater.inflate(R.layout.itemticket, null);
        }
            
        Ticket ticket = tickets.get(position);
        
        TextView nameEntity = (TextView) view.findViewById(R.id.nameEntityView);
		nameEntity.setText("Entidad: " + ticket.getNameEntity());

		TextView nameQueue = (TextView) view.findViewById(R.id.nameQueueView);
		nameQueue.setText("Cola: " + ticket.getNameQueue());

		TextView positionUser = (TextView) view.findViewById(R.id.positionView);
		positionUser.setText("Posición: " + ticket.getPosition());

		TextView turn = (TextView) view.findViewById(R.id.turnView);
		turn.setText("Turno: " + ticket.getTurn());

		TextView date = (TextView) view.findViewById(R.id.dateView);
		date.setText("Fecha: " + ticket.getDate());

        return view;
	}

	public void setTickets(ArrayList tickets) {
		this.tickets = tickets;
	}

	public void setActivity(Activity activity) {
		this.activity = activity;
	}

	public Activity getActivity() {
		return activity;
	}

	public ArrayList<Ticket> getTickets() {
		return tickets;
	}
}
