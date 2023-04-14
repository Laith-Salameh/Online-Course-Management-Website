<?php

require_once 'basemodel.php';
class SubjectModel extends BaseModel
{
    function __construct($db) {
        parent::__construct($db,"subject");
    }

    public function addSubject($subname, $subdescription,$tid, $sub_max_students)
    {
        $sql = "INSERT INTO ".$this->table." (name , description, teacher_user_id, max_students, status) 
        VALUES (:name ,:description,:teacher_user_id, :max_students ,:status)";
        $query = $this->db->prepare($sql);
        $query->execute(array(':name'=>$subname,':description'=>$subdescription,':teacher_user_id'=>$tid,':max_students'=>$sub_max_students , ':status'=>"pending")); 
        
        
    }
    public function getAllSubjectsForTeacher($tid){
      $sql = "SELECT name , description , first_name, last_name , subject.id as id, subject.image_url as img , teacher.rating as rating
              FROM subject, teacher ,user 
              WHERE subject.teacher_user_id = teacher.user_id and teacher.user_id = user.id and :tid = teacher.user_id and subject.status != :isdeleted ;";
      $query = $this->db->prepare($sql);
      $query->execute(array( ':tid' => $tid , ":isdeleted"=>"is_deleted" ));

      return $query->fetchAll();
  
    }
    
    public function getAllSubjects(){
        $sql = "SELECT name , description , first_name, last_name , subject.id as Subjectid , subject.teacher_user_id as Teacherid , category , status 
                FROM subject, teacher ,user 
                WHERE subject.teacher_user_id=teacher.user_id and teacher.user_id =user.id and subject.status != :isdeleted ;";
        $query = $this->db->prepare($sql);
        $query->execute(array(":isdeleted"=>"is_deleted"));
  
        return $query->fetchAll();
    
      }
  
      public function getSubjectsById($teacher_id,$subject_id){
        $sql = "SELECT name , description , first_name, last_name , subject.id 
                FROM subject, teacher ,user 
                WHERE subject.teacher_user_id=teacher.user_id and teacher.user_id =user.id and :teacher_id=teacher.user_id and subject.id = :subject_id;";
        $query = $this->db->prepare($sql);
        $query->execute(array(":teacher_id"=>$teacher_id ,":subject_id"=>$subject_id ));
  
        return $query->fetch();
    
      }

      public function getSubjectByName($subject_name){
        $sql = "SELECT * FROM subject WHERE name = :subject_name ;";
        $query = $this->db->prepare($sql);
        $query->execute(array(':subject_name'=>$subject_name));
  
        return $query->fetch();
    
      }
      public function reactivateSubject($subject_id,$teacher_id){
        
        $sql = "UPDATE subject SET status = :status, teacher_user_id= :teacher WHERE id= :id ;";
        $query = $this->db->prepare($sql);
        $query->execute(array(':status'=>"pending" , ":teacher"=>$teacher_id , ":id"=>$subject_id));

      }
    
      public function getSubjectForSession($session_id){

        $sql="SELECT subject.name as subject_name, subject.id as subject_id from subject,session where session.id= :session_id and subject.id = session.subject_id ;";
        $query = $this->db->prepare($sql);
        $query->execute(array(":session_id"=>$session_id));
  
        return $query->fetch();
    
      }
      
    public function searchForSubject($search_data) {
      $search_data = strip_tags($search_data);
      $sql = "SELECT name, image_url as img , teacher_user_id as Tid , id
      from subject
      WHERE (subject.name LIKE '%$search_data%')";
      $query = $this->db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
    }

    public function acceptSubject($subject_id , $cat , $img){
      $sql = "UPDATE subject SET status =:status , category= :cat , image_url= :img  WHERE id=:subject_id";
      $query = $this->db->prepare($sql);
      $query->execute(array(":status"=>"accepted" , ":cat"=>$cat , ":subject_id"=>$subject_id , ":img"=>$img));  
    }
    public function deleteSubject($subject_id){
      $sql = "UPDATE subject SET status =:status WHERE id=:subject_id";
      $query = $this->db->prepare($sql);
      $query->execute(array(':status'=>"is_deleted" , ':subject_id'=>$subject_id));
    }

    public function deleteSubjectsForTeacher($teacher_id){
      $sql = "UPDATE subject SET status =:status WHERE teacher_user_id=$teacher_id";
      $query = $this->db->prepare($sql);
      $query->execute(array(':status'=>"is_deleted"));
    }

    public function changeImage($subject_id , $img){
      $sql = "UPDATE subject SET image_url=:img WHERE id=$subject_id";
      $query = $this->db->prepare($sql);
      $query->execute(array(':img'=>$img));
    }

    
}
