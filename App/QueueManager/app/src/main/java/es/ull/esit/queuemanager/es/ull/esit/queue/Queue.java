package es.ull.esit.queuemanager.es.ull.esit.queue;

import java.util.ArrayList;

/**
 * Created by kevin on 10/6/16.
 */
public class Queue {

    private String entity;
    private ArrayList<Node> list;

    public Queue (String nameEntity){
        entity = nameEntity;
        list = new ArrayList<Node> ();
    }

    public void push(Node dato){
        getList().add(dato);
    }

    public Node pop(){
        if (!getList().isEmpty()){
            return getList().get(0);
        }

        System.out.println("Empty queue");
        return null;
    }

    public void empty(){
        while(!getList().isEmpty()){
            getList().remove(0);
        }
    }

    public ArrayList<Node> getList() { return list; }

    public void setList(ArrayList<Node> list) { this.list = list; }

    public String getEntity() { return entity; }

    public void setEntity(String entity) { this.entity = entity; }
}
