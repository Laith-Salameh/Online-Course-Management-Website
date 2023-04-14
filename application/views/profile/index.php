<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/DataTables/css/jquery.dataTables.css">
<script src="<?php echo URL;?>public/DataTables/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/css/subjects.css">
<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/css/profile.css" >

<div class="editCover">     
  <div  id="editPop" class="hiddenClass" >
    <form class="" id="editForm"  method="post" action="<?php echo URL.'/profile/editProfile';?> " enctype="multipart/form-data" >
      <span class="create"> Edit Profile </span>
      <span id="exit-edit"> </span>
      <br>
      <div id="avatar_container">      
        <label for="avatar">
          <div class="relative1">
            <img  id="avatarp">     
            <div id="choose-image">
              <i class="fa fa-camera fa-small"></i>
              choose <br> &nbsp; image 
            </div>
          </div>         
        </label>
        <input type="file" name="my_avatar" id="avatar" accept="image/png, image/jpeg" >
      </div>
      <input type="tel" id="Phone" name="change_phone" class="inputField"   >
      <br>
      <br>
      <label for="facebook_link">
        <i class="fab fa-facebook fa-2x"></i>
      </label>
      <input  type="text" name="facebook" class="border-box" id="facebook_link" >
      <br>
      <br>
      <label for="telegram_link">
        <i class="fab fa-telegram fa-2x"></i>
      </label>
      <input  type="text" name="telegram" class="border-box" id="telegram_link" >
      <br>
      <br>
      <label for="twitter_link">
        <i class="fab fa-twitter fa-2x"></i>
      </label>
      <input  type="text" name="twitter" class="border-box" id="twitter_link" >
      <br>
      <br>
      <label for="skype_link">
        <i class="fab fa-skype fa-2x"></i>
      </label>
      <input  type="text" name="skype" class="border-box" id="skype_link" >
      <br>
      <br>
      <span id="error-edit"> </span>     
      <div class="btns1">
        <input type="submit"  id="EditSubmit" name="edit_submit" value="Edit">
        <input type="button" id="cancelEdit" value="Cancel"> 
      </div>  
    </form>
  </div>
  
  <div  id="viewCommentsPop" class="hiddenClass" >
    <form class="" id="viewCommentsForm"  method="post">
      <span class="create"> Session's Comments </span>
      <span id="exit-comments"> </span>
      <br>
      <div class="container">
        <img src="<?php echo URL;?>public/img/1.png" alt="Avatar">
        <p>It was very useful session</p>
        <span class="time-right">11:00</span>
      </div>
    </form>
  </div>

  <div  id="SendComment" class="" >
  <?php 
  if( isset($_SESSION["session_id"]) || isset($_SESSION["session_id2"]) ){
    
    if( isset($_SESSION["session_id"]) ) echo '<form id="SendcommentForm"  method="post" action="'.URL.'profile/addComment/'.$_SESSION["session_id"].'" >'; 
    else  echo '<form id="SendcommentForm"   >'; 
          
            
            foreach( $session_comments as $session_comment ){
              echo ' 
                <div class="container">
                  <img src="'.URL.$session_comment->img.'" alt="Avatar">
                  <p>'.$session_comment->comment.'</p>
                  <span class="time-right">'.$session_comment->name.'</span>
                </div>
                
              '; 
            }
            if(  isset($_SESSION["session_id2"]) ){
              echo '<input id="cancelcomment" type="button"  value="cancel"> </form>';
              unset($_SESSION["session_id2"]);
            }
            else{          
          echo '<div class="container">
                  <img src="'.URL.$user->image_url.'" alt="Avatar">
                  <p>'.'<input type="text" class="inputFieldComment" name="Comment" placeholder="add your comment">' .'</p>
                  <span class="time-right">'.$user->first_name.' '.$user->last_name.'</span>
                </div>';

          echo '<input type="text" class="hiddenClass" id="session_id" name="Sid" readonly value="'.$_SESSION["session_id"].' ">';
          echo '  <input class="hiddenClass" type="submit"  name="commentAdded" value="submit"> 
                  <input id="cancelcomment" type="button"  value="cancel"> 
                </form>';
                unset($_SESSION["session_id"]);
            }
          }
      ?>
      
  </div>    
</div>      
<div id="display" class="hiddenClass"> </div>
<div class="profile_parent"> 
  <div class="left-card">
      <div id="info1" class="tcentering">
        <div class="circle">
          <img id="profile-pic" src="<?php echo URL.$user->image_url; ?>" alt="Picture"  >
        </div>
        <div class="centering logininfo" >
            <div id="name"  ><b id="profile_name"><?php echo $user->first_name.' '.$user->last_name;?></b></div>
            <div id="Birthday" class="data"> <i class="fa fa-birthday-cake fa-lg"></i> &nbsp; <?php $date=explode("-",$user->birthdate ); echo $date[2]."/".$date[1]."/".$date[0] ;?> </div>
            <div id="email" class="data"><i class="fa fa-envelope fa-lg"></i> &nbsp; <?php echo $user->email; ?></div>
            <div id="phone" class="data"> <i class="fa fa-phone fa-lg"></i> &nbsp; <?php echo $user->phone_number; ?></div>
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
            <div class="centering">
                <button class="oj_button" id="edit">Edit</button>
            </div>
        </div>              
      </div>
  </div>

  <div class="main-profile" >
    <div class="content-main" >
      <div  class="toggle-parent" > 
        <div id="CloseBook" class="toggle"> <br> <i class="fa fa-home fa-lg"></i> </div>
          <?php
            if(isset($_SESSION['role'])){
              if($_SESSION['role']=="teacher"){
                echo '<div id="SessionsTeacher" class="toggle"> <br> My Sessions </div>';
                //echo '<div id="messages" class="toggle"> <br> My Messages </div>';
              } 
              if($_SESSION['role']=="student"){
                //echo '<div id="Friends" class="toggle"> <br> My friends </div>';
                //echo '<div id="Teachers" class="toggle"> <br> My teachers </div>';
                echo '<div id="Sessions" class="toggle"> <br> My Sessions </div>';
              }
            }
          ?>
        </div>
        <div class="book">
          <div id="page0" ></div>
          <?php
          if(isset($_SESSION['role'])){
            if($_SESSION['role']=="teacher"){
              echo '
              <div id="page5" >
                <div class="subjects">
                      <table id="subjects_table" class="cell-border teacher_t">
                          <thead>
                              <tr>
                                  <th>Subject</th>
                                  <th>Topic</th>
                                  <th>Date</th>
                                  <th>Rating</th>
                                  <th>Comments</th>
                              </tr>
                          </thead>
                          <tbody>'; 
                          foreach ( $teacherSessions as $session){
                              if( $session->status !== "closed" ) continue;
                              $date=explode("-",$session->date );
                              $rate= $studentsession_model->getSessionRating($session->id);
                            echo '<tr>
                            <td><a href="'.URL.'mySubjects/index/'.$_SESSION['id'].'/'.$session->id.'">'.$session->name.'</a></td>
                            <td>'.$session->topic.'</td>
                            <td>'.$session->from_.' -  '.$session->to_.' <br><br> '.$date[2]."/".$date[1]."/".$date[0].'</td>
                                  <td>';
                                    
                                    for( $i=1 ; $i<=5 ; $i = $i + 1 ){
                                      if($i <=  (int) $rate ){
                                        echo '<span class=" fa fa-star selected "></span>';
                                        $flag = true;
                                      }
                                      else{
                                        if( ($i -1  ) != $rate && $flag )  {
                                          $flag=false;
                                          echo '<span class="fas fa-star-half-alt selected"></span>';
                                          continue;
                                        }else{
                                          $flag=false;
                                        }
                                        echo '<span class=" far fa-star "></span>';
                                      }
                                    }
                                    echo "  ".$rate;
                                    echo '
                                    </td>
                                   <td><a class="anchor_as_button" href="'.URL.'profile/viewcomments/'.$session->id.'" >View Comments</a> </td>
                                  </tr>';
                                }
                              echo '
                          </tbody>
                      </table>
                </div>
              </div>';
              echo '
              <div id="page3" >
                <div class="container">
                  <img src="'.URL.'public/img/1.png" alt="Avatar">
                  <p>Hello. How are you today?</p>
                  <span class="time-right">11:00</span>
                </div>
              </div>
              ';
            } 
            if($_SESSION['role']=="student"){
              echo '
              <div id="page1" >
              <div class="container">
                <img src="'.URL.'public/img/samara.jpg" alt="Avatar">
                <p> Samara Ghrer </p>
                <span class="time-right">  
                  <a href="'.URL.'guest/index/2'.'" class="anchor_as_button">Visit Profile</a> 
                  <a href="'.URL.'guest/index/2'.'" class="anchor_as_button">unfriend</a> 
                </span>
              </div>
            </div>
              ';
              echo '
                    <div id="page2" >
                      <div class="container">
                        <img src="'.URL.'public/img/1.png" alt="Avatar">
                        <p> Micheal Scott</p>
                        <span class="time-right">
                          <button type="button"  class="details_button" >Visit Profile</button>
                        </span>
                      </div>
                    </div>';
              echo '
                    <div id="page4" >
                      <div class="subjects"> 
                        <table id="sessions_table" class="cell-border student_sessions">
                          <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Topic</th>
                                <th>Date</th>
                                <th>Teacher </th>
                                <th>Rate the session</th>
                                <th> Comments</th>
                            </tr>
                          </thead>
                          <tbody>';
                            foreach ( $sessions as $session){
                              $date=explode("-",$session->date );
                              echo '<tr>
                                <td><a href="'.URL.'mySubjects/index/'.$session->Tid.'/'.$session->id.'">'.$session->name.'</a></td>
                                <td>'.$session->topic.'</td>
                                <td>'.$session->from_.' -  '.$session->to_.' <br><br> '.$date[2]."/".$date[1]."/".$date[0].'</td>
                                <td><a href="'.URL.'teacher/index/'.$session->Tid.'"> '.$session->first_name." ".$session->last_name.'</a></td>
                                <td> 
                                  <div class="rating">';
                                  if( isset($session->rate) ){
                                    for( $i=1 ; $i<=5 ; $i = $i + 1 ){
                                      if($i <= (int)$session->rate ){
                                        echo '<span class="star'.$i.' fa fa-star selected "></span>';
                                      }
                                      else{
                                        echo '<span class="star'.$i.' far fa-star "></span>';
                                      }
                                    }
                                  }
                                  else{
                                    echo '<span class="star1 far fa-star  "></span>
                                    <span class="star2 far fa-star  "></span>
                                    <span class="star3 far fa-star  "></span>
                                    <span class="star4 far fa-star "></span>
                                    <span class="star5 far fa-star "></span>';
                                  }
                                    echo '<input class="hiddenInput" type="text"  readonly value='.$session->id.'>   
                                  </div>
                                </td>
                                <td>
                                  <form method="post" action="'.URL.'profile/addComment/'.$session->id.'">
                                  <button type="submit" name="loadComments"  class="addcomment_button'.$session->id.' details_button widthfit" >
                                    <i class="fa fa-comment"></i>
                                  </button>
                                  </form>
                                </td>
                              </tr>';
                            }
                          echo '
                          </tbody>
                        </table>
                      </div>
                    </div>';
            }
          }
         
          
          ?>

        </div>
        <form class="hidden-form" id="send_rating" method="post" action="<?php echo URL.'profile/addRating' ; ?>" >
          <input type="text" class="inputField" id="rating" name="rateVal" >
          <input type="text" class="inputField" id="ratingID" name="rateID" >
          <button type="submit"  name="submitRating"></button>
        </form>
      </div>
    </div> 
  </div>
</div>

        <script src="<?php echo URL;?>public/js/editPopup.js"></script>
        <script src="<?php echo URL;?>public/js/subjects.js"></script>
        <script src="<?php echo URL;?>public/js/toggle.js" ></script>