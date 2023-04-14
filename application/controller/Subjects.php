<?php
if ( session_status() !== PHP_SESSION_ACTIVE )
session_start();

require_once "parentcontroller.php";

class Subjects extends Parentcontroller
{
    
    public function index()
    {
        parent::index();
        $subjects_model = $this->loadModel('SubjectModel');
        $subjects = $subjects_model->getAllSubjects();
        require 'application/views/_templates/header.php';
        require 'application/views/Subjects/index.php';
        require 'application/views/_templates/footer.php';
        $this->sweetalerts();
    }   
}
