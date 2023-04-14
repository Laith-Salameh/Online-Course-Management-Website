<?php
if ( session_status() !== PHP_SESSION_ACTIVE )
session_start();

require_once 'parentcontroller.php';

class Profile extends Parentcontroller
{
    
    public function index($id = 0 )
    {
        parent::index();   
        if( $id == 0){
            if(!isset($_SESSION['id'])){
                $_SESSION['error']="you are not logged in";
                $_SESSION["redirect"]= URL.'profile';
                header('Location:'.URL.'login');
                return ;
            }
            $studentsession_model = $this->loadModel('StudentSessionModel');
            $sessions = $studentsession_model->getSession_User($_SESSION['id']);
            $session_model = $this->loadModel('SessionsModel');
            $teacherSessions = $session_model->getAllSessionsForTeacher($_SESSION['id']);
            $users_model=$this->loadModel("UsersModel");    
            $user=$users_model->getUserById($_SESSION["id"]);
            
            if( isset($_SESSION["session_id"]) ) $session_comments= $studentsession_model->getCommentsForSession($_SESSION["session_id"]) ;
            if( isset($_SESSION["session_id2"]) ) $session_comments= $studentsession_model->getCommentsForSession($_SESSION["session_id2"]) ;
            
            require 'application/views/_templates/header.php';
            require 'application/views/profile/index.php';
            require 'application/views/_templates/footer.php';
            $this->sweetalerts();
            return ;
        }
        $users_model=$this->loadModel("UsersModel");  
        $user= $users_model->getUserById($id);
        if($user->id !== $id){
            $_SESSION['error']= "There is no user with this id = $id";
            header('Location:'.URL.'home' );
            return ;
        }
        require 'application/views/_templates/header.php';
        require 'application/views/guest/index.php';
        require 'application/views/_templates/footer.php';
        $this->sweetalerts();
        
    }

    public function addFriend($id1){
        parent::index();
        if(isset($_SESSION["id"])){
            if( $id1 == $_SESSION["id"] ){
                $_SESSION['error']="you can't add yourself";
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
            if($_SESSION['role'] == "student"){
                $users_model=$this->loadModel("UsersModel");  
                $user= $users_model->getUserById($id);
                if(($user->id !== $id1) || ($user->role !== "student")){
                    $_SESSION['error']= "you can't add this user";
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
                

                $friendshipmodel = $this->loadModel("friendship");
                $friendshipmodel->addFriendship($_SESSION["id"], $id1);
                if( isset($_SERVER['HTTP_REFERER'])){
                    $url=$_SERVER['HTTP_REFERER'];
                    header("location:$url");
                    return ;
                }
                else{
                    $_SESSION["success"]="Friend added!";
                    header('Location:' . URL . 'home');
                    return ;
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


    public function addRating(){
        parent::index();
        if(isset($_POST["rateID"])){
            $id=$_SESSION["id"];
            $session_id=$_POST["rateID"];
            $rating=$_POST["rateVal"];
            $studentsession_model = $this->loadModel('StudentSessionModel');
            $studentsession_model->addRating($session_id, $id, $rating );
            $_SESSION["action"]= "#Sessions";
            if( isset($_SERVER['HTTP_REFERER'])){
                $url=$_SERVER['HTTP_REFERER'];
                header("location:$url");
                return ;
            }
            else{
                $_SESSION["success"]="Friend added!";
                header('Location:' . URL . 'home');
                return ;
            }
              
        }
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

    public function addComment($Sid = 0){
        if( $Sid == 0){
            $_SESSION['error']="invalid URL!";
            header('Location:' . URL . 'profile');
            return ;
        }
        if( isset($_POST["loadComments"] )){
            $_SESSION["comments"]= "#display";
            $_SESSION["session_id"]= $Sid;
            header('Location:' . URL . 'profile');
            return;
        }
        if( isset($_POST["commentAdded"])){
            $id=$_SESSION["id"];
            $comment= $_POST["Comment"];
            $studentsession_model = $this->loadModel('StudentSessionModel');
            $studentsession_model->addComment( $Sid, $id, $comment);
            $_SESSION["comments"]= "#display";
            $_SESSION["session_id"]= $Sid;
            header('Location:' . URL . 'profile');
            return;
        }

        header('Location:' . URL . 'profile');
        return;

    }
    
    public function viewcomments($Sid = 0){
        if( $Sid == 0){
            $_SESSION['error']="invalid URL!";
            header('Location:' . URL . 'profile');
            return ;
        }
        $session_model = $this->loadModel('SessionsModel');
        $session= $session_model->getSessionById($Sid);
        if( $session->session_id !== $Sid ){
            $_SESSION['error']= "There is no Session with this id = $Sid";
            header('Location:'.URL.'profile' );
            return ;
        }
        $teacher= $session_model-> getTeacherInSession( $_SESSION['id'] , $Sid );
        if( $teacher->id !== $_SESSION['id'] ){
            $_SESSION["error"]="This is not your session";
            header('Location:'.URL.'profile' );
            return ;
        }
        $_SESSION["comments"]= "#display";
        $_SESSION["session_id2"]= $Sid;
        header('Location:' . URL . 'profile');
            return;
    }
    
    public function editProfile(){
        if(isset($_SESSION["role"])){
            $target_dir = "public/img/users/";
            $target_file = $target_dir . basename($_FILES["my_avatar"]["name"]);
            if($_FILES["my_avatar"]["name"]!=""){
                $target_dir = "public/img/users/";
                $target_file = $target_dir . basename($_FILES["my_avatar"]["name"]);
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            }
            if(isset($_POST["edit_submit"])){

                $users_model=$this->loadModel("usersmodel");
                $user= $users_model->getUserById($_SESSION["id"]);
                if($_FILES["my_avatar"]["tmp_name"]!==""){
                    $check = getimagesize($_FILES["my_avatar"]["tmp_name"]);
                    $img_url=$target_dir.$user->id.'.'.$imageFileType; 
                        move_uploaded_file($_FILES["my_avatar"]["tmp_name"], $target_dir.$user->id.'.'.$imageFileType);
                        $users_model->changeProfilePicture($user->id , $img_url);
                        $_SESSION["url"]=$img_url;
                }
                if($_POST["change_phone"]!=="" && $_POST["change_phone"]!==$user->phone_number ){
                    $users_model->changePhoneNumber($_SESSION['id'],$_POST["change_phone"]);
                }
                if($_POST["facebook"]!=="" && $_POST["facebook"]!==$user->facebook_link ){
                    $users_model->changeFacebook($_SESSION['id'],$_POST["facebook"]);
                }
                if($_POST["telegram"]!=="" && $_POST["telegram"]!==$user->telegram_link ){
                    $users_model->changeTelegram($_SESSION['id'],$_POST["telegram"]);
                }
                if($_POST["twitter"]!=="" && $_POST["twitter"]!==$user->twitter_link ){
                    $users_model->changeTwitter($_SESSION['id'],$_POST["twitter"]);
                }
                if($_POST["skype"]!=="" && $_POST["skype"]!==$user->skype_link ){
                    $users_model->changeSkype($_SESSION['id'],$_POST["skype"]);
                }
                header('Location:' . URL . 'profile');
                return;
 
                
            }

        }
        else{
            $_SESSION["error"]="invalid url";
            header('Location:' . URL . 'login');
        }
    }

    
   
}
