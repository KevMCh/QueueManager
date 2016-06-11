package es.ull.esit.queuemanager.es.ull.esit.queue;

/**
 * Created by kevin on 10/6/16.
 */
public class Node {

    private String id;
    private String details;

    public Node(String id, String details){
        this.id = id;
        this.details = details;
    }

    public String toString(){
        return " - " + getId() + " " + getDetails() + "\n";
    }

    public String getDetails() { return details; }

    public String getId() { return id; }

    public void setDetails(String details) { this.details = details; }

    public void setId(String id) { this.id = id; }
}
