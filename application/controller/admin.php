<?php
if ( session_status() !== PHP_SESSION_ACTIVE )
session_start();

require_once 'parentcontroller.php';



class Admin extends Parentcontroller
{
    
    public function index()
    {
        parent::index();
        $users_model = $this->loadModel("usersmodel");
        $users = $users_model->getAllUsers();
        $sessions_model = $this->loadModel("sessionsmodel");
        $sessions = $sessions_model->getEverySession();
        $subjects_model = $this->loadModel("subjectmodel");
        $subjects1=$subjects_model->getAllSubjects();
        $teacher_availability_model= $this->loadModel("teacher_availabilitymodel");
        $availability_model=$this->loadModel("availabilitymodel");
        $student_session_model=$this->loadModel("studentsessionmodel");
        if( isset($_SESSION["session_id2"]) ) $session_comments= $student_session_model->getCommentsForSession($_SESSION["session_id2"]) ;
        require 'application/views/_templates/header.php';
        require 'application/views/admin/index.php';
        require 'application/views/_templates/footer.php';
        $this->sweetalerts();
    }


    public function changePassword($user_id ){
        parent::index();
        if(isset($_SESSION['role'])){
            if($_SESSION['role']=="admin"){
                if(isset($_POST["change_pass_submit"])){
                    if($_POST["new_password"]){
                        $newpassword=$_POST["new_password"];
                        if(strlen($newpassword)>=6){
                            $users_model=$this->loadModel("usersmodel");           
                            $new_hash=$users_model->passwordHash($newpassword);
                            $users_model->changePassword($user_id, $new_hash);
                        }
                        else{
                            $_SESSION["error"]="password length should be at least 6";
                        }
                    }
                    else{
                        $_SESSION["error"]="you didn't enter password please do before submitting";
                        
                    }
                    header('Location:' . URL . 'admin');
                    return;

                }
               
            }
        }
    }
    public function changeRole($user_id){
        parent::index();
        if(isset($_SESSION['role'])){
            if($_SESSION['role']=="admin"){
                if(isset($_POST["change_role_submit"])){
                    $new_role=$_POST["new_role"];
                    $users_model=$this->loadModel("usersmodel");
                    $user=$users_model->getUserById($user_id);
                    $current_role=$user->role;
                    if($current_role==$new_role){
                        header('Location:' . URL . 'admin');
                        return;
                    }
                    else{
                        if($current_role=="admin"){
                            $users_model->changeRole($user_id, $new_role);
                            if($new_role=="teacher"){
                                $teachers_model=$this->loadModel("teachermodel");
                                $teacher=$teachers_model->getTeacherByID($user_id);
                                if($teacher==NULL){
                                    $teachers_model->addTeacher($user_id , "degree");
                                }
                                
                            }
                            else {
                                
                                $students_model=$this->loadModel("studentsmodel");
                                $students_model->addStudent($user_id);
                            }
                            header('Location:' . URL . 'admin');
                            return;
                        }
                        else{
                            $availability_model=$this->loadModel("availabilitymodel");
                            $availabilities=$availability_model->getAllAvailabilities($user_id);
                            $flag=true;
                            
                            foreach($availabilities as $availability){
                                $today = date("Y-m-d");
                                $availability_date = $availability->date; //from database  
                                $today_time = strtotime($today);
                                $availability_date_time = strtotime($availability_date);
                                $availibility_from=$availability->from_;
                                $form=strtotime($availibility_from);
                                $now=date("H:i");
    
                                if($availability_date_time > $today_time || ($availability_date_time == $today_time && $from >= $now ) ){
                                    $flag=false;
                                    break;
                                }
                            }
                            if($flag==false){
                                $_SESSION["error"]="This user has a session to attend";
                                header('Location:' . URL . 'admin');
                                return;
                            }
                            else{
                                if($current_role =="teacher"){
                                    $subjects_model=$this->loadModel("subjectmodel");
                                    $subjects_model->deleteSubjectsForTeacher($user->id);
                                    if($new_role == "student"){
                                        echo "freom teacher to studeent";
                                        $users_model->changeRole($user->id, $new_role);
                                        $students_model=$this->loadModel("studentsmodel");
                                        $students_model->addStudent($user_id);
                                    }
                                    else{
                                        $users_model->changeRole($user->id, $new_role);
                                    }
                                    header('Location:' . URL . 'admin');
                                    return;
                                }
                                else{
                                    if($new_role == "teacher"){
                                        echo "from student to teacher";
                                        $users_model->changeRole($user->id, $new_role);
                                        $teachers_model=$this->loadModel("teachermodel");
                                        $teacher=$teachers_model->getTeacherByID($user_id);
                                        if($teacher==NULL){
                                            $teachers_model->addTeacher($user_id , "degree");
                                        }
                                    }
                                    else{
                                        $users_model->changeRole($user->id, $new_role);
                                    }
                                
                                       header('Location:' . URL . 'admin');
                                    return;
                                }

                            }
                                
                        }
                                                                    
                    }

                }                                        

            }
        }
    }
    public function acceptSession($session_id){
        parent::index();
        if(isset($_SESSION['role'])){
            if($_SESSION['role']=="admin"){
                if(isset($_POST["accept_submit"])){
                    $link=$_POST["session_link"];
                    $sessions_model=$this->loadModel("sessionsmodel");
                    $sessions_model->acceptSessionByAdmin($session_id);
                    $_SESSION["action1"]="#sessions-admin";
                    header('Location:' . URL . 'admin');
                    return;
                }
            }
        }
    }
    public function rejectSession($session_id){
        parent::index();
        if(isset($_SESSION['role'])){
            if($_SESSION['role']=="admin"){
                if(isset($_POST["reject_submit"])){
                    $reason=$_POST["reject_session_reason"];
                    $sessions_model=$this->loadModel("sessionsmodel");
                    $sessions_model->rejectSessionByAdmin($session_id , $reason);
                    $_SESSION["action1"]="#sessions-admin";
                    header('Location:' . URL . 'admin');
                    return;
                }
            }
        }
    }
    public function acceptSubject($subject_id){
        parent::index();
        if(isset($_SESSION['role'])){
            if($_SESSION['role']=="admin"){
                if(isset($_POST["accept_subject_submit"])){
                    $uploadOk = 0;
                    $target_dir = "public/img/subjects/";
                    $target_file = $target_dir . basename($_FILES["subject_img"]["name"]);
                    if($_FILES["subject_img"]["name"]!=""){
                        $target_dir = "public/img/subjects/";
                        $target_file = $target_dir . basename($_FILES["subject_img"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                        if(isset($_POST["accept_subject_submit"])) {
                            $check = getimagesize($_FILES["subject_img"]["tmp_name"]);
                            if($check !== false) {
                                $uploadOk = 1;
                            }
                            else {
                                $uploadOk = 0;
                            }
                        }
                    }
                    move_uploaded_file($_FILES["subject_img"]["tmp_name"], $target_dir.$subject_id.'.'.$imageFileType);
                    $img_url=$target_dir.$subject_id.'.'.$imageFileType;    
                    $cat=$_POST["choose_category"];
                    $subjects_model=$this->loadModel("subjectmodel");
                    $subjects_model->acceptSubject($subject_id , $cat , $img_url);
                    $_SESSION["action1"]="#subjects-admin";
                    header('Location:' . URL . 'admin');
                    return;
                }
            }
        }
    }
    public function rejectSubject($subject_id){
        parent::index();
        if(isset($_SESSION['role'])){
            if($_SESSION['role']=="admin"){
                if(isset($_POST["reject_subject_submit"])){
                    $reason=$_POST["subject_reject"];
                    $subjects_model=$this->loadModel("subjectmodel");
                    $subjects_model->deleteSubject($subject_id);
                    $_SESSION["action1"]="#subjects-admin";
                    header('Location:' . URL . 'admin');
                    return;
                }
            }
        }
    }
    public function deleteSubject($subject_id){
        parent::index();
        if(isset($_SESSION['role'])){
            if($_SESSION['role']=="admin"){
                if(isset($_POST["subject_deletion_submit"])){
                    $subjects_model=$this->loadModel("subjectmodel");
                    $subjects_model->deleteSubject($subject_id);
                    $_SESSION["action1"]="#subjects-admin";
                    header('Location:' . URL . 'admin');
                    return;
                }
              
            }
        }
    }
    public function changeSubjectImage($subject_id){
        parent::index();
        if(isset($_SESSION['role'])){
            if($_SESSION['role']=="admin"){
                if(isset($_POST["change_img_submit"])){
                    $uploadOk = 0;
                    $target_dir = "public/img/subjects/";
                    $target_file = $target_dir . basename($_FILES["new_subject_img"]["name"]);
                    if($_FILES["new_subject_img"]["name"]!=""){
                        $target_dir = "public/img/subjects/";
                        $target_file = $target_dir . basename($_FILES["new_subject_img"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                        if(isset($_POST["change_img_submit"])) {
                            $check = getimagesize($_FILES["new_subject_img"]["tmp_name"]);
                            if($check !== false) {
                                $uploadOk = 1;
                            }
                            else {
                                $uploadOk = 0;
                            }
                        }
                    }    
                    move_uploaded_file($_FILES["new_subject_img"]["tmp_name"], $target_dir.$subject_id.'.'.$imageFileType);
                    $img_url=$target_dir.$subject_id.'.'.$imageFileType;
                    $subjects_model=$this->loadModel("subjectmodel");
                    $subjects_model->changeImage($subject_id , $img_url);
                    $_SESSION["action1"]="#subjects-admin";
                    header('Location:' . URL . 'admin');
                    
                    return;
                   
                }
              
            }
        }

    }


    public function viewcomments($Sid = 0){
        if( $Sid == 0){
            $_SESSION['error']="invalid URL!";
            header('Location:' . URL . 'admin');
            return ;
        }
        $session_model = $this->loadModel('SessionsModel');
        $session= $session_model->getSessionById($Sid);
        if( $session->session_id !== $Sid ){
            $_SESSION['error']= "There is no Session with this id = $Sid";
            header('Location:'.URL.'admin' );
            return ;
        }
        
        $_SESSION["comments"]= "#display";
        $_SESSION["session_id2"]= $Sid;
        $_SESSION["action1"]="#sessions-admin";
        header('Location:' . URL . 'admin');
            return;
    }




   
}
