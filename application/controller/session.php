<?php
if ( session_status() !== PHP_SESSION_ACTIVE )
session_start();

require_once 'parentcontroller.php';

class Session extends Parentcontroller
{
    public function index()
    {
        parent::index();
        if(isset($_SESSION['role'])){
            if($_SESSION['role']=='teacher'){
                 
                $sessions_model = $this->loadModel('SessionsModel');
                $sessions = $sessions_model->getAllSessionsForTeacher($_SESSION['id']);
                $studentsession_model = $this->loadModel('StudentSessionModel');
                require 'application/views/_templates/header.php';
                require 'application/views/sessions/index.php';
                require 'application/views/_templates/footer.php';
                $this->sweetalerts();
            }
            else{
                $_SESSION['error']="you are not authorized";
                header('Location:' . URL . 'home ');
            }
        }
        else{
            $_SESSION['error']="you are not logged in";
            $_SESSION["redirect"]= $_SERVER['HTTP_REFERER'];
            header('Location:' . URL . 'login');
        }
        
      
    }

    public function acceptSession($Sid=0){
        if( $Sid == 0){
            $_SESSION["error"]= "invalid url";
            header('Location:'.URL.'home');
            return ;
        }
        parent::index();
        if(isset($_SESSION['role'])){
            if( $_SESSION['role'] =="teacher"){
                $sessions_model = $this->loadModel('SessionsModel');
                $teacher= $sessions_model-> getTeacherInSession( $_SESSION['id'] , $Sid );
                if( $teacher->id == $_SESSION['id'] ){
                    if(isset($_POST["addTopic"])){
                        $sessions_model->acceptSession( $Sid , $_POST["topic"]);
                        $_SESSION["success"]="Accepted session";
                        header("location:".URL."session");
                        return ;
                    }
                    else{
                        $sessions= $sessions_model->getAllSessionsForTeacher($_SESSION['id']);
                        foreach( $sessions as $session ){
                            if( $teacher->date == $session->date && $session->status == "accepted" ){
                                $flag=false;
                                if( date( "H:i", strtotime($teacher->from_) ) <=  date( "H:i", strtotime($session->from_) ) &&  date( "H:i", strtotime($session->from_) ) <  date( "H:i", strtotime($teacher->to ) )){
                                    $flag=true;
                                    
                                }
                                if(  date( "H:i", strtotime($session->from_) ) <= date( "H:i", strtotime($teacher->from_) ) &&  date( "H:i", strtotime($teacher->from_) ) < date( "H:i", strtotime($session->to_) ) ){
                                    $flag=true;
                                }
                                if($flag){
                                    $_SESSION["error"]="Time conflicted with your accepted sessions";
                                    header("location:".URL."session");
                                    return ;
                                }
                                
                            }
                            else{
                                continue;
                            }
                        }
                        require 'application/views/sessions/addtopic.php';
                        return ;
                    }
                }
                else{
                    $_SESSION["error"]="This is not your session";
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

    public function rejectSession($Sid=0){
        if( $Sid == 0){
            $_SESSION["error"]= "invalid url";
            header('Location:'.URL.'home');
            return ;
        }
        parent::index();
        if(isset($_SESSION['role'])){
            if( $_SESSION['role'] =="teacher"){
                $sessions_model = $this->loadModel('SessionsModel');
                $teacher= $sessions_model-> getTeacherInSession( $_SESSION['id'] , $Sid );
                if( $teacher->id == $_SESSION['id'] ){
                    if(isset($_POST["reject_reason"])){
                        $sessions_model->rejectSession( $Sid , $_POST["reject_reason"]);
                        $_SESSION["success"]="Rejected the session";
                        header("location:".URL."session");
                        return ;
                    }
                    else{
                        $session= $sessions_model->getSessionById($Sid);
                        if( $session->status != "accepted"){
                            require 'application/views/sessions/rejectreason.php';
                            return ;
                        }
                        else{
                                $_SESSION["error"]= "invalid url";
                                header('Location:'.URL.'home');
                                return ;
                        }   
                    }
                }
                else{
                    $_SESSION["error"]="This is not your session";
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

   
   
}
