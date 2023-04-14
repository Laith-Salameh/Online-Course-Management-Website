<?php

if ( session_status() !== PHP_SESSION_ACTIVE )
session_start();

require_once 'parentcontroller.php';

class Login extends Parentcontroller
{
    
    public function index()
    {  
        
        require 'application/views/login/index.php';
        require 'application/views/_templates/footer.php';
        $this->sweetalerts();
        
    }
    public function error(){
        $_SESSION['error']="you are not logged in";
        $this->index();
        
    }

    public function logedin(){
        if(isset($_POST["login"])){
            $users_model=$this->loadModel("UsersModel");
            $user=$users_model->getUserByEmail($_POST["my_email"]);
            if($user!=null){
                $password=$_POST["my_password"];
                $hash= $users_model->passwordHash($password);
                if($hash == $user->password_hash)
                {
                    $_SESSION["id"]=$user->id;
                    $_SESSION["role"]= $user->role;
                    $_SESSION["url"]= $user->image_url;
                   
                    if(isset($_POST['remember_me']) && $_POST['remember_me'] == 'checked'){
                        setcookie('remember_me', $user->email , time() + (2562000), "/");
                    }

                    if(isset($_SESSION["redirect"])){
                        $url=$_SESSION['redirect'];
                        header("location:$url");
                        unset($_SESSION["redirect"]);
                        return ;
                    }
                    header("location: ".URL."home");
                    
                }
                else{
                    $_SESSION["error"]="wrong password";
                    header("location: ".URL."login");
                }
            }
            else{
                $_SESSION["error"]="the email is not registered";
                    header("location: ".URL."login");
            }


        }
        
    }
    
    public function signUp(){
        if(isset($_POST["sign_up"])){
            $users_model= $this->LoadModel("UsersModel");
            $_SESSION["nameErr"]=" ";
            $_SESSION["emailErr"]=" ";
            $_SESSION["phoneErr"]=" ";;
            $_SESSION["passErr"]=" ";
            $_SESSION["pass2Err"]=" ";
            $_SESSION["birthErr"]=" ";
            $flag=true;
            $key=true;
            if (empty($_POST["first_name"]))
            {   
                $_SESSION["nameErr"]="at least 2 charecters";
                $flag=false;
                
            }else{
                if (!preg_match("/^[a-zA-Z ]{2,30}$/",$_POST["first_name"])) {
                    $_SESSION["nameErr"] = "Only letters and white space allowed";
                    $key=false;
                }
                else{
                    $first_name=$_POST["first_name"];
                }
            }

            if(empty($_POST["email_address"]))
            {
                $_SESSION["emailErr"]="enter your email";
                $flag=false;                  
            }else{
                if(!preg_match("/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+$/",$_POST["email_address"])){
                $_SESSION["emailErr"]= "Invalid email format";
                $key=false;
                }
                else{
                $email=$_POST['email_address'];
                }
            }
            $last_name=$_POST["last_name"];
            if (empty($_POST["phone_number"]))
            {
                $_SESSION["phoneErr"]="enter the phone number";
                $flag=false;    
            }else{
                if(!preg_match("/^\+[0-9]{1,3}\-[0-9]{9}$/",$_POST["phone_number"])) {
                $_SESSION["phoneErr"]="Invalid phone format" ;
                $key=false;
                }
                else{
                    $phone=$_POST['phone_number'];
                }
            }

            if (empty($_POST["password"]) || strlen($_POST["password"]) < 6 )
            {
                $_SESSION["passErr"]=" ";
                $_SESSION["passErr"]="enter at least 6 charechters ";
                $key=false;    
            }
            else{
                $password_hash= $users_model->passwordHash($_POST["password"]);
            }
            if (empty($_POST["password_confirm"]))
            {
                $_SESSION["pass2Err"]="Confirm your password";
                $flag=false; 
            }else{
                if($_POST["password_confirm"] != $_POST["password"] ){
                    $_SESSION["pass2Err"]="passwords not maching";
                    $key=false;
                }else{
                    $password_confirm= $users_model->passwordHash($_POST["password_confirm"]);
                }

            }
            $gender=$_POST["gender"];
            if (empty($_POST["birth_date"]))
            {  
                $flag=false;
            }
            else{
                $birthday=$_POST["birth_date"];
                $birthday=date_create_from_format("m/d/Y",$birthday);
                $birthday=date_format($birthday,"Y-m-d"); 
            }
            if (empty($_POST["stat"]))
            {
                $_SESSION["roleErr"]="choose your role";
                $flag=false;
                
            }
            else{
                $role=$_POST["stat"]; 
            }
            if($flag==false){
            $_SESSION["error"]="some values missing";
            $_SESSION["action"]="#sign";
            header("location: ".URL."login");
            return ;
            }
            if($key==false){
            $_SESSION["error"]="invalid values";
            $_SESSION["action"]="#sign";
            header("location: ".URL."login");
            return ;
            }
            $user= $users_model->getUserByEmail($email);
            if($user==null){
               $users_model->addUser($first_name,$last_name,$password_hash,$email,$birthday,$phone,$gender,$role);
               $user= $users_model->getUserByEmail($email);
               $id= $user->id;
               if($role=="teacher"){
                $teachers_model=$this->LoadModel("TeacherModel");
                if(empty($_POST['degree'])){
                    $_SESSION["degreeErr"]="choose your degree";
                    $_SESSION["error"]="degree missing";
                    $_SESSION["action"]="#sign";
                    header("location: ".URL."login");
                    return ;
                }
                   $degree=$_POST['degree'];
                   $teachers_model->addTeacher($id,$degree);
               }
               else{
                $students_model=$this->LoadModel("StudentsModel");
                $students_model->addStudent($id);
               }
               
               $_SESSION["id"]=$user->id;
               $_SESSION["role"]= $user->role;
               $_SESSION["url"]= $user->image_url;
               header("location: ".URL."home/index");
            }
            else {
                $_SESSION["error"]="email already regisestered! Try another.";
                header("location: ".URL."login");
            }
        }
    }

    public function logout(){
        session_destroy();
        setcookie('remember_me', "", time() - 3600 , '/' );
        header('location: ' . URL . 'home/index');
    }
   
}
