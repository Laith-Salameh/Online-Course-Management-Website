<?php

require_once 'basemodel.php';

class StudentsModel extends BaseModel
{
    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db) {
        parent::__construct($db,"student");
    }
    

    public function addStudent($student_id){
        $sql = "INSERT INTO student (user_id) VALUES (:id)";
        $query = $this->db->prepare($sql); 
        $query->execute(array(':id'=>$student_id));
        

    }
} 