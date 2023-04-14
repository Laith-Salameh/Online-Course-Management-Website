<?php

require_once 'basemodel.php';
class Teacher_AvailabilityModel extends BaseModel
{
    function __construct($db) {
        parent::__construct($db,"teacher_availability");
    }

    public function addTeacherAvailability($teacherid, $availabilityid , $isclosed )
    {
        $sql = "INSERT INTO ".$this->table." (teacher_user_id , availability_id , is_availability_closed) 
        VALUES (:teacher_user_id , :availability_id , :is_availability_closed)";
        $query = $this->db->prepare($sql);
        $query->execute(array(":teacher_user_id"=>$teacherid , ":availability_id"=>$availabilityid , ":is_availability_closed"=>$isclosed)); 
        
        
    }

    public function getTeacherIdByAvailability($id){
        $sql="SELECT teacher_user_id as id from teacher_availability where id= :id ;";
        $query = $this->db->prepare($sql);
        $query->execute(array(":id"=>$id));
  
        return $query->fetch();
    
    }
    public function getAvailabilityId($id){
        $sql="SELECT availability_id as id from teacher_availability where id=$id ;";
        $query = $this->db->prepare($sql);
        $query->execute();
  
        return $query->fetch();
    }
    

    

    
}
