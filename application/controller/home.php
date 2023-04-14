<?php

if ( session_status() !== PHP_SESSION_ACTIVE )
session_start();

require_once 'parentcontroller.php';

class Home extends Parentcontroller
{
    public function index()
    {
        parent::index();
        require 'application/views/_templates/header.php';
        require 'application/views/home/index.php';
        require 'application/views/_templates/footer.php';
        $this->sweetalerts();
        
    }

    public function search( ){
        if(isset($_POST["search-query"])){
            $_SESSION["search"]="yes";
            $_SESSION['search-query']= $_POST["search-query"];
            if( isset ($_SERVER['HTTP_REFERER'])){
                $url= $_SERVER['HTTP_REFERER'];
                header("location:$url");
            }
            else{
                header("location:".URL."Home");
            }
        }
        else{
            $_SESSION["error"]= "invalid url!";
            if( isset ($_SERVER['HTTP_REFERER'])){
                $url= $_SERVER['HTTP_REFERER'];
                header("location:$url");
            }
            else{
                header("location:".URL."Home");
            }
        }
        return ;
    }
 
    public function addSubject(){ 
        parent::index();
        if(isset($_SESSION['role'])){
            if( $_SESSION['role'] =="teacher"){
                if(isset($_POST["subjectSubmit"])){
                    if($_POST['name']!=="" && $_POST['count']!==""){
                        $subjects_model = $this->loadModel('SubjectModel');
                        $subject=$subjects_model->getSubjectByName($_POST['name']);
                        if($subject==NULL){
                            $subjects_model->addSubject($_POST['name'], $_POST['description'], $_SESSION['id'], $_POST['count']);
                            $url=$_SERVER['HTTP_REFERER'];
                            header("location:$url");
                            return ;
                        }
                        else if($subject->status == "is_deleted"){
                            $subjects_model->reactivateSubject($subject->id,$_SESSION["id"]);
                            header('Location:' . URL . 'home ');
    
                        }
                        else{
                            $_SESSION['error']="Subject already exists";
                            header('Location:' . URL . 'home ');
    
                        }
                    }
                else{
                    $_SESSION['error']="please enter important fields maked with *";
                    header('Location:' . URL . 'home ');

                }
                    
                    
                }
                else{
                    $_SESSION['error']="invalid call of url";
                    header('Location:' . URL . 'home ');
                }
            }
            else{
                $_SESSION['error']="you are not authorized";
                header('Location:' . URL . 'home ');

            }
        
        }
        else{
            $_SESSION['error']="you are not logged in";
            $_SESSION["redirect"]= $_SERVER['HTTP_REFERER'];
            header('Location:'.URL.'login');
        }

    }
   public function addAvailableTime()
   {
        parent::index();
        if(isset($_SESSION['role'])){
            if( $_SESSION['role'] =="teacher"){
                if(isset($_POST["add_available_time"])){
                    if($_POST["from-hours"]!=="" && $_POST["to-hours"]!=="" && $_POST["from-minuts"]!=="" && $_POST["to-minuts"]!==""){
                        $format24="/^(2[0-3]|1[0-9]|[0-9])$/";
                        $format60="/^[1-5]?[0-9]$/";
                        if(preg_match($format24,$_POST["from-hours"]) && preg_match($format24,$_POST["to-hours"]) && preg_match($format60,$_POST["from-minuts"]) &&  preg_match($format60,$_POST["to-minuts"])){
                            $availability_model = $this->loadModel('AvailabilityModel');
                            $teacher_availability_model = $this->loadModel('teacher_availabilitymodel');
                            $availabilities=$availability_model->getAllAvailabilities($_SESSION['id']);
                            $chosen_date=date_create_from_format("d/M/Y",$_POST["selected_date"]);
                            $chosen_date=date_format($chosen_date,"Y-m-d");
                            if($_POST['to-hours'] < $_POST['from-hours'] || ( $_POST['to-hours'] == $_POST['from-hours'] && $_POST['to-minuts'] < $_POST['from-minuts'] ) ){
                                //first day
                                $from1 = sprintf("%02d" ,$_POST['from-hours']).':'.sprintf("%02d",$_POST['from-minuts']) ;
                                $to1= "23:59" ; 
                                $flag=false;
                                foreach($availabilities as $availability){
                                    if($availability->date == $chosen_date){
                                        if( date( "H:i", strtotime($from1) ) <=  date( "H:i", strtotime($availability->from_) ) &&  date( "H:i", strtotime($availability->from_) ) <  date( "H:i", strtotime($to1 ) )){
                                            $flag=true;
                                            break;    
                                        }
                                        else if(  date( "H:i", strtotime($availability->from_) ) <= date( "H:i", strtotime($from1) ) &&  date( "H:i", strtotime($from1) ) < date( "H:i", strtotime($availability->to_) ) ){
                                            $flag=true;
                                            break;
                                        }

                                    }
                                   
                                }
                                //second day
                                $from2 =  "00:00" ;
                                $to2=  sprintf("%02d" , $_POST['to-hours']).':'.sprintf("%02d", $_POST['to-minuts']) ;
                                $adate=date('d/M/Y', strtotime($chosen_date."+1 days"));
                                $second_date=date_create_from_format("d/M/Y",$adate);
                                $second_date=date_format($second_date,"Y-m-d");
                                foreach($availabilities as $availability){
                                    if($availability->date == $second_date){
                                        if( date( "H:i", strtotime($from2) ) <=  date( "H:i", strtotime($availability->from_) ) &&  date( "H:i", strtotime($availability->from_) ) <  date( "H:i", strtotime($to2) )){
                                            $flag=true;
                                            break;    
                                        }
                                        else if(  date( "H:i", strtotime($availability->from_) ) <= date( "H:i", strtotime($from2) ) &&  date( "H:i", strtotime($from2) ) < date( "H:i", strtotime($availability->to_) ) ){
                                            $flag=true;
                                            break;
                                        }

                                    }
                                   
                                }
                                if($flag){
                                    $_SESSION["error"]="Time conflicted with an existed availability";
                                    $_SESSION["action"]= "#create-Time";
                                    header("location:".URL."home");
                                    return ;
                                }
                                else{
                                    $availability_id = $availability_model->addAvailableTime($chosen_date,$from1, $to1 );
                                    $teacher_availability_model->addTeacherAvailability( $_SESSION['id']  , $availability_id  , "open" );
                                    $availability_id = $availability_model->addAvailableTime($second_date,$from2, $to2 );
                                    $teacher_availability_model->addTeacherAvailability( $_SESSION['id']  , $availability_id  , "open" );
                                }
                            }
                            else{
                                //one day
                                $from = sprintf("%02d",$_POST['from-hours']).':'.sprintf("%02d",$_POST['from-minuts']) ;
                                $to=  sprintf("%02d",$_POST['to-hours']).':'.sprintf("%02d",$_POST['to-minuts']) ;
                                $flag=false;
                                foreach($availabilities as $availability){
                                    if($availability->date == $chosen_date){
                                        if( date( "H:i", strtotime($from) ) <=  date( "H:i", strtotime($availability->from_) ) &&  date( "H:i", strtotime($availability->from_) ) <  date( "H:i", strtotime($to ) )){
                                            $flag=true;
                                            break;    
                                        }
                                        else if(  date( "H:i", strtotime($availability->from_) ) <= date( "H:i", strtotime($from) ) &&  date( "H:i", strtotime($from) ) < date( "H:i", strtotime($availability->to_) ) ){
                                            $flag=true;
                                            break;
                                        }

                                    }
                                   
                                }
                                if($flag){
                                    $_SESSION["error"]="Time conflicted with an existed availability";
                                    $_SESSION["action"]= "#create-Time";
                                    header("location:".URL."home");
                                    return ;
                                }
                                else{
                                    $availability_id = $availability_model->addAvailableTime($chosen_date,$from, $to );
                                    $teacher_availability_model->addTeacherAvailability( $_SESSION['id']  , $availability_id  , "open" );
                                }


                            }
                            $url=$_SERVER['HTTP_REFERER'];
                            header("location:$url");
                        }
                        else{
                            $_SESSION['error']="invalid time values";
                            $_SESSION["action"]="#create-Time";
                            header('Location: '.URL.'home');
                            return;

                        }
                        
                    

                    }
                    else{
                        $_SESSION['error']="please fill all the fields";
                        $_SESSION["action"]="#create-Time";
                        header('Location: '.URL.'home');
                        return;
                    }
                    
                }
                else{
                    $_SESSION['error']="invalid call of url";
                    header('Location: '.URL.'home');
                }
            }
            else{
            $_SESSION['error']="you are not authorized";
            header('Location: '.URL.'home');
            }

        }
        else{
            $_SESSION['error']="you are not logged in";
            header('Location: '.URL.'login');
        }
    }


}
