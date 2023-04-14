<?php

require_once 'basemodel.php';

class UsersModel extends BaseModel
{
    function __construct($db) {
        parent::__construct($db,"user");
    }
    
    
    public function getAllUsers()
    {
        $sql = "SELECT * FROM user";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getUserById($user_id)
    {
        $sql = "SELECT * FROM user where id = :user_id ;";
        $query = $this->db->prepare($sql);
        $query->execute(array(':user_id'=>$user_id));
        return $query->fetch();
    }


    public function getUserByEmail($user_email)
    {
        $sql = "SELECT * FROM user where email = :user_email";
        $query = $this->db->prepare($sql);
        $query->execute(array(':user_email' => $user_email));
        return $query->fetch();
    }

    public function addUser($first_name,$last_name,$password_hash,$email,$birthday,$phone,$gender,$role)
    {
        $first_name = strip_tags($first_name);
        $last_name = strip_tags($last_name);
        $birthday= strip_tags($birthday);
        $gender= strip_tags($gender);
        $phone=strip_tags($phone);
        //$facebook_token= strip_tags($facebook_token);
        $email= strip_tags($email);
        $password= strip_tags($password_hash);
        $role=strip_tags($role);
        $sql = "INSERT INTO user (first_name,last_name,password_hash,email,birthdate,phone_number,gender,role) VALUES (:first_name,:last_name,:password_hash,:email,:birthday,:phone,:gender,:role)";
        $query = $this->db->prepare($sql); 
        $query->execute(array(':first_name' => $first_name, ':last_name' => $last_name,':birthday'=>$birthday, ':gender'=>$gender,':email'=>$email,':password_hash'=>$password_hash, ':phone'=>$phone , ':role'=>$role));
        
    }

    public function passwordHash($password){
        $hash=0;
        $m=1000000009;
        $p=97;
        for($i=0;$i< strlen($password);$i++){
            $hash+=(ord($password[$i]) % $m )*(pow($p,$i) % $m ) % $m ;

        }
        $hash=$hash % $m;
        return $hash;


    }

    public function changePassword($user_id ,$newpassword){
        $sql = "UPDATE user SET  password_hash=:new_password where id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':new_password'=>$newpassword ,':id'=>$user_id));
    
    }
    public function changeRole($user_id ,$new_role){
        $sql = "UPDATE user SET role =:new_role where id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':new_role'=>$new_role ,':id'=>$user_id));
    
    }
    public function searchForUser($search_data) {
        $search_data = strip_tags($search_data);
        $sql = "SELECT first_name, last_name , image_url as img , id , role 
        from user
        WHERE first_name LIKE '%$search_data%'
        OR last_name LIKE '%$search_data%'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
      }

      public function changePhoneNumber($id , $phone){
        $sql = "UPDATE user SET phone_number =:new_phone where id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':new_phone'=>$phone ,':id'=>$id));
      }
      public function changeFacebook($id , $face){
        $sql = "UPDATE user SET facebook_link =:new_face where id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':new_face'=>$face ,':id'=>$id));
      }

      public function changeTelegram($id , $tele){
        $sql = "UPDATE user SET telegram_link =:new_tele where id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':new_tele'=>$tele ,':id'=>$id));
      }

      public function changeTwitter($id , $twitter){
        $sql = "UPDATE user SET twitter_link =:new_tweet where id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':new_tweet'=>$twitter ,':id'=>$id));
      }

      public function changeSkype($id , $sky){
        $sql = "UPDATE user SET skype_link =:new_sky where id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':new_sky'=>$sky ,':id'=>$id));
      }

      public function changeProfilePicture($id , $img){
        $sql = "UPDATE user SET image_url =:new_img where id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':new_img'=>$img ,':id'=>$id));
      }



} ?>