package es.ull.esit.queuemanager;

/**
 * Created by kevin on 23/6/16.
 */
public class Queue {

    private int id;
    private int idEntity;
    private String name;

    public Queue (int id_, int idEnt_, String nam){
        id = id_;
        idEntity = idEnt_;
        name = nam;
    }

    public String toString (){
        return "ID: " + id + "IDEntity: " + idEntity + "Name: " + name;
    }
}
