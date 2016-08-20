package es.ull.esit.queuemanager.adapter;

import java.io.Serializable;

@SuppressWarnings("serial")
public class Ticket implements Serializable {
	protected String nameEntity;
	protected String nameQueue;
	protected int turn;
	protected int position;
	protected String date;

	public Ticket(String nameEntity, String name, int turn, int position, String date) {
		this.nameEntity = nameEntity;
		this.nameQueue = name;
		this.turn = turn;
		this.position = position;
		this.date = date;
	}

	public String getNameEntity() {
		return nameEntity;
	}

	public String getNameQueue() {
		return nameQueue;
	}

	public int getTurn() {
		return turn;
	}

	public void setNameEntity(String nameEntity) {
		this.nameEntity = nameEntity;
	}

	public void setTurn(int turn) {
		this.turn = turn;
	}

	public void setNameQueue(String name) {
		this.nameQueue = name;
	}

	public int getPosition() {
		return position;
	}

	public void setPosition(int position) {
		this.position = position;
	}

	public String getDate() {
		return date;
	}

	public void setDate(String date) {
		this.date = date;
	}
}
