<?php

if ( session_status() !== PHP_SESSION_ACTIVE )
session_start();

require_once "parentcontroller.php";

class Teacher extends Parentcontroller
{
    public function index($Tid = 0 )
    {
        if( $Tid == 0){
            $_SESSION["error"]= "invalid url";
            header('Location:'.URL.'home');
            return ;
        }
        parent::index();
        $usermodel= $this->loadModel('usersmodel');
        $teacher= $usermodel->getUserById($Tid);
        if($teacher->id !== $Tid){
            $_SESSION['error']= "There is no teacher with this id = $Tid";
            header('Location:'.URL.'home' );
            return ;
        }
        $sessions_model = $this->loadModel('SessionsModel');
        $sessions = $sessions_model->getAllSessionsForTeacher($Tid);
        $subjects_model = $this->loadModel('subjectmodel');
        $subjects = $subjects_model->getAllSubjectsForTeacher($Tid);
        $teacher_availabilities_model=$this->loadModel('availabilitymodel');
        $availabilities= $teacher_availabilities_model->getAllAvailabilities($Tid );
        require 'application/views/_templates/header.php';
        require 'application/views/teacher/index.php';
        require 'application/views/_templates/footer.php';
        $this->sweetalerts();
    }

    public function suggestSession($Tid = 0){
        if( $Tid == 0){
            $_SESSION["error"]= "invalid url";
            header('Location:'.URL.'home');
            return ;
        }
        parent::index();
        if(isset($_SESSION['role'])){
            if( $_SESSION['role'] =="student"){
                if(isset($_POST["sujestsession"])){
                    $session_model = $this->loadModel('SessionsModel');
                    if( !($_POST['selected_subject'] == 0) && !($_POST['selected_availability'] == 0) ){
                    $sessions = $session_model->getAllSessionsForTeacher($Tid);
                    foreach( $sessions as $session  ){
                        if( $session->t_a_id == $_POST['selected_availability'] && $session->s_id == $_POST['selected_subject']  ){
                            $_SESSION["error"]="This session is already suggested and is ".$session->status."!" ;
                            if( isset($_SERVER['HTTP_REFERER'])){
                                $url=$_SERVER['HTTP_REFERER'];
                                header("location:$url");
                                return ;
                            }
                            else{
                                header('Location:' . URL . 'home');
                                return ;
                            }
                        }
                    }
                    $session_id=$session_model->addSession($_POST['selected_subject'],$_POST['selected_availability'],'pending',0);
                    $studentsession_model = $this->loadModel('StudentSessionModel');
                    $studentsession_model->addStudentToSession($_SESSION["id"] , $session_id);
                    $_SESSION['success']="session added";
                    if( isset($_SERVER['HTTP_REFERER'])){
                        $url=$_SERVER['HTTP_REFERER'];
                        header("location:$url");
                        return ;
                    }
                    else{
                        header('Location:' . URL . 'home');
                        return ;
                    }
                    }
                    else{ 
                        if( ($_POST['selected_subject'] == 0) && ($_POST['selected_availability'] == 0) ){
                            $_SESSION['error']="please select a subject and a time";
                        }
                        else{
                            if( ($_POST['selected_subject'] == 0)){
                                $_SESSION['error']="please select a subject";
                            }
                            else{
                                $_SESSION['error']= "please select a time";
                            }
                        }  
                        if( isset($_SERVER['HTTP_REFERER'])){
                            $url=$_SERVER['HTTP_REFERER'];
                            header("location:$url");
                            return ;
                        }
                        else{
                            header('Location:' . URL . 'home');
                            return ;
                        }
                    }
                }
                else{
                    $_SESSION['error']="please submit your choices";
                    header('Location:'. URL .'home');
                 }
            }
            else{
                $_SESSION['error']="you are not authorized";
                header('Location:' . URL . 'home');
            }

        }
        else{
            $_SESSION['error']="you are not logged in";
            if(isset($_SERVER['HTTP_REFERER'])){
                $_SESSION["redirect"]=$_SERVER['HTTP_REFERER'];
            }
            else{
                $_SESSION["redirect"]= URL."home" ;
            }
            header('Location:'.URL.'login');
        }
    }


    public function enrollInSession($Sid){
        parent::index();
        if(isset($_SESSION['role'])){
            if( $_SESSION['role'] =="student"){
                    $id= $_SESSION["id"];
                    $session_model = $this->loadModel('SessionsModel');
                    $session= $session_model->getSessionById($Sid);
                    if( $session->session_id !== $Sid){
                        $_SESSION['error']= "There is no Session with this id = $Sid";
                        header('Location:'.URL.'home' );
                        return ;
                    }
                    $studentsession_model = $this->loadModel('StudentSessionModel');
                    $student = $studentsession_model->getStudentFromSession($id,$Sid);
                    if( $student->id == $id ){
                        $_SESSION['error']="Already Enrolled";
                        if( isset($_SERVER['HTTP_REFERER'])){
                            $url=$_SERVER['HTTP_REFERER'];
                            header("location:$url");
                            return ;
                        }
                        else{
                            header('Location:' . URL . 'home');
                            return ;
                        }
                    }
                    if( $session->status === "pending"  ){
                        $session_model->IncrementSessionCount($Sid);
                        $studentsession_model->addStudentToSession($_SESSION["id"] , $Sid);
                        $_SESSION['success']="enrolled";
                        if( isset($_SERVER['HTTP_REFERER'])){
                            $url=$_SERVER['HTTP_REFERER'];
                            header("location:$url");
                            return ;
                        }
                        else{
                            header('Location:' . URL . 'home');
                            return ;
                        }
                    }
                    else{
                        $_SESSION['error']="Session is $session->status";
                        if( isset($_SERVER['HTTP_REFERER'])){
                            $url=$_SERVER['HTTP_REFERER'];
                            header("location:$url");
                            return ;
                        }
                        else{
                            header('Location:' . URL . 'home');
                            return ;
                        }
                    }

                    
                }
                else{
                    $_SESSION['error']="you are not authorized";
                    if( isset($_SERVER['HTTP_REFERER'])){
                        $url=$_SERVER['HTTP_REFERER'];
                        header("location:$url");
                        return ;
                    }
                    else{
                        header('Location:' . URL . 'home');
                        return ;
                    }
                }
               
            }
        else{
            $_SESSION['error']="you are not logged in";
            if(isset($_SERVER['HTTP_REFERER'])){
                $_SESSION["redirect"]=$_SERVER['HTTP_REFERER'];
            }
            else{
                $_SESSION["redirect"]= URL."home" ;
            }
            header('Location:'.URL.'login');
        }


    }
    public function CancelSession($Sid){
        parent::index();
        if(isset($_SESSION['role'])){
            if( $_SESSION['role'] =="student"){
                    $id= $_SESSION["id"];
                    $session_model = $this->loadModel('SessionsModel');
                    $session= $session_model->getSessionById($Sid);
                    if( $session->session_id !== $Sid){
                        $_SESSION['error']= "There is no Session with this id = $Sid";
                        header('Location:'.URL.'home' );
                        return ;
                    }
                    $studentsession_model = $this->loadModel('StudentSessionModel');
                    $student= $studentsession_model->getStudentFromSession($id,$Sid);
                    if( $student->id == $id){
                        if( $session->status === "pending" || $session->status === "full"   ){
                            $studentsession_model->deleteStudentFromSession($_SESSION["id"] , $Sid);
                            $session_model->decrementSessionCount($Sid);
                            $_SESSION['success']="Canceled";
                            if(isset($_SERVER['HTTP_REFERER'])){
                                $url=$_SERVER['HTTP_REFERER'];
                                header("location:$url");
                                return ;
                            }
                            else{
                                header("location:".URL."home");
                                return ;
                            }
                        }
                        else{
                            $_SESSION['error']="Session is $session->status";
                            if( isset($_SERVER['HTTP_REFERER'])){
                                $url=$_SERVER['HTTP_REFERER'];
                                header("location:$url");
                                return ;
                            }
                            else{
                                header('Location:' . URL . 'home');
                                return ;
                            } 
                        }
                    }
                    else{
                        $_SESSION['error']="you are not enrolled in this session";
                        if(isset($_SERVER['HTTP_REFERER'])){
                            $url=$_SERVER['HTTP_REFERER'];
                            header("location:$url");
                            return ;
                        }
                        else{
                            header("location:".URL."home");
                            return ;
                        }
                    }
                }
                else{
                    $_SESSION['error']="you are not authorized";
                    if( isset($_SERVER['HTTP_REFERER'])){
                        $url=$_SERVER['HTTP_REFERER'];
                        header("location:$url");
                        return ;
                    }
                    else{
                        header('Location:' . URL . 'home');
                        return ;
                    }
                }
               
            }
        else{
            $_SESSION['error']="you are not logged in";
            if(isset($_SERVER['HTTP_REFERER'])){
                $_SESSION["redirect"]=$_SERVER['HTTP_REFERER'];
            }
            else{
                $_SESSION["redirect"]= URL."home" ;
            }
            header('Location:'.URL.'login');
        }


    }
   
   
}
