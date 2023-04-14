<?php
if ( session_status() !== PHP_SESSION_ACTIVE )
session_start();

require_once 'parentcontroller.php';


class mySubjects extends Parentcontroller
{
    public function index($Tid = 0  , $Sid = 0 )
    {
        if( $Tid == 0 || $Sid == 0){
            $_SESSION["error"]= "invalid url";
            header('Location:'.URL.'home');
            return ;
        }
        parent::index();
    	$subjects_model = $this->loadModel('SubjectModel');
        $subject = $subjects_model->getSubjectsById($Tid , $Sid);
        $teachers_model=$this->loadModel('teachermodel');
        $teachers=$teachers_model->getTeacherById( $Tid );
        $subjectsOfTeacher = $subjects_model->getAllSubjectsForTeacher($Tid);
        require 'application/views/_templates/header.php';
        require 'application/views/mySubjects/index.php';
        require 'application/views/_templates/footer.php';
        $this->sweetalerts();
    }
   
}
