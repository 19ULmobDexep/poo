<?php

require_once 'bbd.php';
require_once 'events.php';
require_once 'agenda.php';
require_once 'mainObjectBDD.php';

class People extends MainObjectBDD {


    //findOne--------------------------------------------------------------------

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
        $query = 'SELECT * FROM '.static::$tableName.' '.$where ;
        $res = $bdd->query($query);
        $res->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $res->fetch();
    }


    //getAllEvents-----------------------------------------------------------------

    public function getAllEvents($filters=[]){
        $bdd = BDD::getConnexion() ;
        $query = '';
        $res = $bdd->query($query) ;
        return $res->fetchAll(PDO::FETCH_CLASS, 'Events');

        var_dump($query);
    }





    
}