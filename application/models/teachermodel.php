<?php

require_once 'basemodel.php';
class TeacherModel extends BaseModel
{
    function __construct($db) {
        parent::__construct($db,"teacher");
    }

  
    public function getAllTeachers(){
      $sql = "SELECT *
              FROM teacher ,user 
              WHERE teacher.user_id =user.id ;";
      $query = $this->db->prepare($sql);
      $query->execute();

      return $query->fetchAll();
  
    }
    public function getTeacherById($teacher_id){
      $sql = "SELECT concat(first_name,' ', last_name) as teachername , degree ,image_url
              FROM teacher ,user 
              WHERE teacher.user_id =user.id and $teacher_id=teacher.user_id ;";
      $query = $this->db->prepare($sql);
      $query->execute();

      return $query->fetch();
  
    }

    public function addTeacher($teacher_id,$degree){
      $sql = "INSERT INTO teacher (user_id,degree) VALUES (:id, :degree)";
      $query = $this->db->prepare($sql); 
      $query->execute(array(':id'=>$teacher_id, ':degree'=>$degree));
      

  }
    

    
}
