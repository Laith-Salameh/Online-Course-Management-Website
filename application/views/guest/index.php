<link rel="stylesheet" href="<?php echo URL;?>public/css/guest.css" >
<link rel="stylesheet" href="<?php echo URL;?>public/css/profile.css" >
      <div class="profile_parent"> 

<div class="left-card" >
    <div id="info1" class="tcentering">
      <div class="circle"><img id="profile-pic" src="<?php echo URL.$user->image_url; ?>" alt="Picture"  ></div>
      <div class="centering logininfo" >
          <div id="name"  ><b id="profile_name"><?php echo $user->first_name.' '.$user->last_name;?></b></div>
          <div id="Birthday" class="data"> <i class="fa fa-birthday-cake fa-lg"></i> &nbsp; <?php $date=explode("-",$user->birthdate ); echo $date[2]."/".$date[1]."/".$date[0] ;?></div>
          <div id="email" class="data"><i class="fa fa-envelope fa-lg"></i> &nbsp; <?php echo $user->email; ?> </div>
          <div id="phone" class="data"> <i class="fa fa-phone fa-lg"></i> &nbsp; <?php echo $user->phone_number; ?> </div>
          <div id="speciality" class="data"> <i class="fa fa-university fa-lg"></i> &nbsp; <?php echo $user->role; ?> </div> 
          <br>
          <div class="links centering"> 
          <?php if(isset( $user->telegram_link )){
                  echo '<a id="link-telegram" href="'.$user->telegram_link.'"><i class="fab fa-telegram fa-2x"></i></a>';
                }
                if(isset( $user->twitter_link )){
                  echo '<a id="link-twitter" href="'.$user->twitter_link.'"><i class="fab fa-twitter fa-2x"></i></a>';
                }
                if(isset( $user->skype_link )){
                  echo '<a id="link-skype" href="'.$user->skype_link .'"><i class="fab fa-skype fa-2x"></i></a>';
                }
                if(isset( $user->facebook_link )){
                  echo '<a id="link-facebook" href="'.$user->facebook_link.'"><i class="fab fa-facebook fa-2x"></i></a>';
                }
                ?>
          </div>
          
          <div id="button_div" class="centering">
              
              <a class="anchor_as_button1" href="<?php echo URL."profile/addFriend/".$id ?>"> Add Friend </a>
              
          </div>
        </div>              
    </div>
</div>

<div class="main-profile">
    <div class="Message-form">
      
            <form class="messageForm" id="messageForm"  method="post">
                <span class="create"> Write your message: </span>
                <span class="errorspan" > the message should be between 10 and 1000 characters</span>
                    <br>
                    <textarea class="messagebody" form="MessageForm" id="Message" > </textarea>
                    <br>
                    <input id="sendMessage" type="submit"  value="Send Message">
              </form>

    </div>
    
</div>

</div>

		
  
  <script src="<?php echo URL;?>public/js/message.js" ></script>