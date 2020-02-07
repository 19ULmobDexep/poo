<?php

require_once 'bbd.php';
require_once 'agenda.php';
require_once 'people.php';
require_once 'mainObjectBDD.php';


class Events extends MainObjectBDD {

    //Construct
    //getAllPeople


    
    /**
     * titre
     * @var mixed|null
     */
    protected $title = null;
    /**
     * @var Agenda
     */
    protected $idAgenda=null;
    /**
     * @var Date
     */
    protected $date=null;
    /**
     *duration
     *@var mixed|null
     */
    protected $duration = null;
     /**
      * id unique
      * @var null
      */
    protected $id = null;

    
    protected static $tableName='events';
    public static $_authorisedUpdate = ['title', 'date', 'duration', 'idAgenda'];


    public function __construct($id=null) {
        parent::__construct($id) ;
        $this->agenda = new Agenda($this->idAgenda) ;
        $this->people = new People($this->idPeople) ;
    }


    // findAllBydate-----------------------------------------------------------------------------------------

    public static function findAll($filters=[]){        
        $bdd = BDD::getConnexion();

        $clauses=[];
        foreach($filters as $k => $f) {
            $clauses[] = $k.'='.$bdd->quote($f);
        }
        $where = '';
        if(!empty($clauses)) {
            $where = ' WHERE '.implode(' AND ', $clauses);
        }

        $query = 'SELECT * FROM agendaevents.events WHERE date="2020-03-06" ';
        var_dump($query);
        $res = $bdd->query($query);
        return $res->fetchAll(PDO::FETCH_CLASS, 'Events');
    }


    // findAllPeople--------------------------------------------------------------------------------------------

    public static function findAll($filters=[]){        
        $bdd = BDD::getConnexion();

        $clauses=[];
        foreach($filters as $k => $f) {
            $clauses[] = $k.'='.$bdd->quote($f);
        }
        $where = '';
        if(!empty($clauses)) {
            $where = ' WHERE '.implode(' AND ', $clauses);
        }

        $query = 'SELECT * FROM '.static::$tableName.' as c INNER JOIN event_people as cp ON c.id=cp.idPeople '.$where ;
        $res = $bdd->query($query);
        $res->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $res->fetch();
    }


    // findOne--------------------------------------------------------------------------------------------------

    public static function findOne($filters=[]) {
            
        $bdd = BDD::getConnexion();
        $where = '';
        $clauses = [];
        foreach ($filters as $k => $filter) {
            $clauses[] = $k.'='.$bdd->quote($filter) ;
        }
        if (!empty($clauses)) {
            $where = ' WHERE '.implode(' AND ', $clauses);
        }
        $res = $bdd->query('SELECT * FROM agendaevents.people '.$where.'LIMIT 0,1');
        $res->setFetchMode(PDO::FETCH_CLASS, 'Events') ;
        return $res->fetch();
    }


}