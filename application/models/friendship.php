<?php
require_once 'basemodel.php';
class Friendship extends BaseModel
{
    function __construct($db) {
        parent::__construct($db,"friendship");
    }
    
    public function addFriendship($id1, $id2)
    {
        
        $sql = "INSERT INTO ".$this->table." (student_user_id , student_user_id1) 
        VALUES (:id1 ,:id2)";
        $query = $this->db->prepare($sql);
        $query->execute(array(':id1'=>$id1,':id2'=>$id2));

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
}