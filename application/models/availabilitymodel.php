<?php
require_once 'basemodel.php';
class AvailabilityModel extends BaseModel
{
    function __construct($db) {
        parent::__construct($db,"availability");
    }
    
    public function addAvailableTime($date, $from,$to)
    {
        
        $sql = "INSERT INTO ".$this->table." (date , availability.from, availability.to) 
        VALUES (:date ,:from,:to)";
        $query = $this->db->prepare($sql);
        $query->execute(array(':date'=>$date,':from'=>$from,':to'=>$to));

        return $this->db->lastInsertId();
    
    }
    public function getAllAvailabilities($teacher_id){
        $sql = "SELECT availability.from as from_ ,availability.to as to_ , availability.date , teacher_availability.id as id_
                FROM availability, teacher_availability
                WHERE availability_id=availability.id and teacher_user_id= $teacher_id ;";
        $query = $this->db->prepare($sql);
        $query->execute();
  
        return $query->fetchAll();
    
      }
      public function getAvailabilityById($availability_id){

        $sql = "SELECT *
        FROM availability
        WHERE :availability_id= availability.id  ;";
        $query = $this->db->prepare($sql);
        $query->execute( array( ":availability_id" => $availability_id) );

        return $query->fetch();

      }

}