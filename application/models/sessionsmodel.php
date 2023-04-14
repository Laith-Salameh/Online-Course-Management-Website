<?php
require_once 'basemodel.php';
class SessionsModel extends BaseModel
{
    function __construct($db) {
        parent::__construct($db,"session");
    }

    public function getAllSessions()
    {
        $sql = "SELECT * FROM ".$this->table.",subject WHERE session.subject_id = subject.id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getTeacherInSession( $Tid , $Sid ){
        $sql = "SELECT teacher_availability.teacher_user_id as id , availability.date as date , availability.from as from_ , availability.to as to_
                FROM ".$this->table.", teacher_availability , availability 
                WHERE session.teacher_availability_id =  teacher_availability.id 
                        and  teacher_availability.teacher_user_id = :Tid
                        and teacher_availability.availability_id = availability.id
                        and session.id = :Sid; ";
        $query = $this->db->prepare($sql);
        $query->execute(array(":Tid"=>$Tid , ":Sid"=> $Sid));
        return $query->fetch();
    }

    public function getAllSessionsForTeacher($teacher_id)
    {
        $sql = "SELECT session.id as id,name ,max_students , count , availability.from as from_  , 
                        availability.to as to_ , date , session.status as status , teacher_availability.id as t_a_id , subject.id as s_id , topic, rating
                FROM ".$this->table.",subject, teacher_availability , availability
                WHERE teacher_availability_id = teacher_availability.id 
                and teacher_availability.availability_id = availability.id
                and session.subject_id = subject.id 
                and :teacher_id = subject.teacher_user_id  ;";
        $query = $this->db->prepare($sql);
        $query->execute(array(":teacher_id"=>$teacher_id));
        return $query->fetchAll();
    }

    public function getAllSessionsForStudent($id)
    {
        $sql = "SELECT session.id as id
        FROM  session, student_session 
        WHERE  session.id = student_session.session_id 
                and student_session.student_user_id = :id
                and session.status != 'closed' and session.status != 'accepted' and session.status != 'rejected'  ;";
        $query = $this->db->prepare($sql);
        $query->execute(array(":id"=>$id));
        return $query->fetchAll();
    }
    
    public function addSession( $subject_id , $teacher_availability_id , $status , $count){

        $sql = "INSERT INTO ".$this->table."(  subject_id , teacher_availability_id , status , count  )  VALUES 
        (  :subject_id , :teacher_availability_id , :status , :count); " ;
        $query = $this->db->prepare($sql);
        $query->execute(array(  ':subject_id'=>$subject_id , ':teacher_availability_id'=>$teacher_availability_id , ':status'=> $status , ":count"=>$count ) );
    
        $Sid= $this->db->lastInsertId();
        $this->IncrementSessionCount($Sid);

        return $Sid;
    }

    public function getSessionById($Sid)
    {
        $sql = "SELECT session.id as session_id , count , max_students as max , session.status
                FROM ".$this->table.", subject WHERE session.id = $Sid and session.subject_id = subject.id ;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function getSessionInformation($Sid)
    {
        $sql = "SELECT session.id as session_id , count , max_students as max , session.status
                FROM ".$this->table.", subject ,  WHERE session.id = $Sid and session.subject_id = subject.id ;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function IncrementSessionCount($Sid){
        $session= $this->getSessionById($Sid);
        if( $session->count < $session->max ){
            $sql = "Update ".$this->table." 
                SET session.count = session.count +1
                Where session.id = $Sid ;";
        $query = $this->db->prepare($sql);
        $query->execute();
        if( ($session->count + 1) == $session->max){
            $sql = "Update ".$this->table." 
                SET session.status = ".'"full"'."
                Where session.id = $Sid ;";
            $query = $this->db->prepare($sql);
            $query->execute();         
        }
        return true;

        }
        
        return false;
    }

    public function decrementSessionCount($Sid){
        $session= $this->getSessionById($Sid);
        if( ($session->count  == $session->max ) && ($session->status !== "accepted")  ){
            $sql = "Update ".$this->table." 
                SET session.status = ".'"pending"'."
                Where session.id = $Sid ;";
            $query = $this->db->prepare($sql);
            $query->execute();         
        }
        $sql = "Update ".$this->table." 
            SET session.count = session.count -1
            Where session.id = $Sid ;";
        $query = $this->db->prepare($sql);
        $query->execute();
        if( ($session->count -1) == 0 ) {
            $sql = "DELETE FROM session
                    WHERE session.id = $Sid ;";
            $query = $this->db->prepare($sql);
            $query->execute();
        }
        
    }

    public function acceptSession($Sid , $topic){
        $sql = "Update ".$this->table." 
                SET session.status = ".'"accepted"'.", session.topic = :topic
                Where session.id = :sid ;";
            $query = $this->db->prepare($sql);
            $query->execute(array(":sid"=>$Sid , ":topic"=>$topic)); 
        
    }
    public function rejectSession($Sid , $reason ){
        $sql = "Update ".$this->table." 
                SET session.status = ".'"rejected"'.", session.reject_reason= :reason
                Where session.id = :Sid ;";
            $query = $this->db->prepare($sql);
            $query->execute(array(":reason"=>$reason ,":Sid"=>$Sid) ); 
        
    }
    public function cancelSession($Sid ){
        $sql = "Update ".$this->table." 
                SET session.status = ".'"pending"'." 
                Where session.id = $Sid ;";
            $query = $this->db->prepare($sql);
            $query->execute(); 
        
    }

    public function acceptSessionByAdmin($session_id){
        $sql = "UPDATE session SET status =:status WHERE id=:session_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':status'=>"closed" , ':session_id'=>$session_id));  

    }
    public function rejectSessionByAdmin($session_id , $reason){
        $sql = "UPDATE session SET status =:status , reject_reason=:reason WHERE id=:session_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':status'=>"rejected" , ':reason'=>$reason ,':session_id'=>$session_id));  

    }
    public function getEverySession()
    {
        $sql = "SELECT * FROM session ;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
 
    
    
}
