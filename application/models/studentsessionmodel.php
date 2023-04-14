<?php
require_once 'basemodel.php';
class StudentSessionModel extends BaseModel
{
    function __construct($db) {
        parent::__construct($db,"student_session");
    }

    public function getAllStudents($session_id)
    {
        $sql = "SELECT first_name , last_name , image_url as img , user.id as id
                FROM ".$this->table.",session , student , user 
                WHERE student_session.student_user_id = student.user_id  
                            and student.user_id = user.id 
                            and session.id = student_session.session_id 
                            and session.id = $session_id ;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getStudentFromSession($id,$session_id)
    {
        $sql = "SELECT user.id as id
                FROM ".$this->table.",session , student , user 
                WHERE student_session.student_user_id = student.user_id  
                            and student.user_id = user.id 
                            and session.id = student_session.session_id 
                            and session.id = :session_id 
                            and user.id = :id ; ";
        $query = $this->db->prepare($sql);
        $query->execute(array(":session_id"=>$session_id , ":id"=>$id));
        return $query->fetch();
    }

    public function addStudentToSession($student_id , $session_id){
        $sql = "INSERT INTO ".$this->table."( student_user_id , session_id  )  VALUES 
        ( :student_user_id , :session_id  ); " ;
        $query = $this->db->prepare($sql);
        $query->execute(array(  ':student_user_id'=>$student_id , ":session_id"=>$session_id ) );        
    }

    public function deleteStudentFromSession( $id , $Sid){
        $sql = "DELETE FROM student_session
                WHERE session_id = $Sid and student_user_id= $id";
        $query = $this->db->prepare($sql);
        $query->execute();
    }


    public function getSession_User($student_id){
        $sql = "select session.id as id , name, topic, availability.from as from_ ,availability.to as to_ , availability.date, first_name, last_name, rate , teacher.user_id as Tid
        from   student_session,  session,   availability,  teacher_availability,   teacher,   subject ,  user
        where student_session.student_user_id = :student_id
		and session.id = student_session.session_id
		and session.subject_id = subject.id
		and session.teacher_availability_id = teacher_availability.id
        and session.status = 'closed'
		and teacher_availability.availability_id = availability.id
		and teacher_availability.teacher_user_id = teacher.user_id
		and teacher.user_id = user.id;" ;
        $query = $this->db->prepare($sql);
        $query->execute(array(":student_id"=>$student_id));
        return $query->fetchALL();
    }

    public function addRating($session_id, $student_id, $rate ){
        $sql = "UPDATE student_session
            SET rate = :rate
            WHERE :session_id = student_session.session_id
            AND student_user_id = :student_id ;";
            $query = $this->db->prepare($sql);
            $query->execute(array(":rate"=>$rate , ":student_id"=>$student_id , ":session_id"=>$session_id));
    }

    public function addComment($session_id, $student_id, $comment){
        $sql = "UPDATE student_session
            SET comment = :comment
            WHERE :session_id = student_session.session_id
            AND student_user_id = :student_id ;";
            $query = $this->db->prepare($sql);
            $query->execute(array(":comment"=>$comment , ":student_id"=>$student_id , ":session_id"=>$session_id));
    }

    public function getCommentsForSession($Sid){
        $sql="  SELECT comment , CONCAT(first_name , ' ' , last_name) as name , image_url as img
                FROM     user , student , student_session, session
                WHERE   user.id = student.user_id
                        and student.user_id = student_session.student_user_id
                        and student_session.session_id = session.id
                        and session.id = :Sid 
                        and comment is not NULL ; ";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":Sid"=>$Sid));
        return $query->fetchALL();
    }
    public function getRatings($session_id){
        $sql = "SELECT rate
        FROM student_session 
        WHERE session_id = :session_id 
              ;";
        $query = $this->db->prepare($sql);
        $query->execute(array(":session_id"=>$session_id));
        return $query->fetchAll();
    }
    public function getSessionRating($session_id){
        $sum=0;
        $count=0;
        $session_ratings = $this->getRatings($session_id);
        foreach($session_ratings as $sessionrating){
            $sum = $sum + (int)$sessionrating->rate ;
            if( 0 != (int)$sessionrating->rate ) $count++;
        }
        if($count!=0)
        return $sum/$count;
        else return 0;
    }




    
   

    
    
}
