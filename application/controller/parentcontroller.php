<?php 

class Parentcontroller extends Controller
{
    public function index()
    {
        if( isset($_COOKIE['remember_me'])) {
                    $usermodel= $this->loadModel('usersmodel');
                    $user= $usermodel->getUserByEmail($_COOKIE['remember_me']);
                    $_SESSION["role"]= $user->role;
                    $_SESSION["url"]= $user->image_url;
                    $_SESSION["id"]=$user->id;
        }

    }
    public function sweetalerts(){
        if(isset($_SESSION['error'])) {
            echo'
            <script>   
                Swal.fire({
                    text: "'.$_SESSION["error"].'",
                    icon: "error",
                    background: "rgb(228,217,232)" ,
                    confirmButtonColor: "rgb(78,41,87)"}); 
            </script>';
            unset($_SESSION['error']);
        }
        if(isset($_SESSION["success"])){
            echo'
            <script>   
                Swal.fire({
                    text: "'. $_SESSION['success'] .'",
                    icon: "success",
                    background: "rgb(228,217,232)" ,
                    confirmButtonColor: "rgb(78,41,87)"}); 
            </script>';
            unset($_SESSION['success']);
        }
        if(isset($_SESSION["search"])){
            echo '<script>
            $(document).ready(function(){
            $(".hidden_button").trigger("click");
            });
                 </script>';
            unset($_SESSION["search"]);
        }
        if(isset($_SESSION["comments"])){
            echo '<script>
            $(document).ready(function(){
            
            $("'.$_SESSION["comments"].'").trigger("click");
            $("#Sessions").trigger("click");
            $(".inputFieldComment").focus();
            });

                 </script>';
            
           
            unset($_SESSION["comments"]);

        }
        if(isset($_SESSION["action"])){
            echo '<script>
            $(document).ready(function(){
            $("'.$_SESSION["action"].'").trigger("click");
            });
                 </script>';
                
            unset($_SESSION["action"]);
        }
        if(isset($_SESSION['action1'])){
            echo '<script>
            $(document).ready(function(){
            $("'.$_SESSION["action1"].'").trigger("click");
            $("'.$_SESSION["action1"].'").trigger("click");
            });
                 </script>';
                
            unset($_SESSION["action1"]);
        }
        
        
    }

}