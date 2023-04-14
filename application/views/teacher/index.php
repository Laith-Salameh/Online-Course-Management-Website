    <link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/DataTables/css/jquery.dataTables.css">
    <script src="<?php echo URL;?>public/DataTables/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="<?php echo URL;?>public/css/profile.css" >
    <link rel="stylesheet" href="<?php echo URL;?>public/css/teacher.css">
    <link rel="stylesheet" href="<?php echo URL;?>public/css/subjects.css">

      <div class="teacher_parent"> 

        <div class="left-card">
          <div id="info1" class="tcentering">
            <div class="circle"><img id="profile-pic" src="<?php echo URL.$teacher->image_url; ?>" alt="Picture"  ></div>
            <div class="centering logininfo" >
                <div id="name"  ><b id="profile_name"><?php echo $teacher->first_name.' '.$teacher->last_name;?></b></div>
                <div id="Birthday" class="data"> <i class="fa fa-birthday-cake fa-lg"></i> &nbsp; <?php $date=explode("-",$teacher->birthdate ); echo $date[2]."/".$date[1]."/".$date[0] ;?> </div>
                <div id="email" class="data"><i class="fa fa-envelope fa-lg"></i> &nbsp; <?php echo $teacher->email; ?></div>
                <div id="phone" class="data"> <i class="fa fa-phone fa-lg"></i> &nbsp; <?php echo $teacher->phone_number; ?> </div>
                <div id="speciality" class="data"> <i class="fa fa-university fa-lg"></i> &nbsp; <?php echo $teacher->role; ?> </div> 
                <br>
                <div class="links centering">
                <?php if(isset( $teacher->telegram_link )){
                  echo '<a id="link-telegram" href="'.$teacher->telegram_link.'"><i class="fab fa-telegram fa-2x"></i></a>';
                }
                if(isset( $teacher->twitter_link )){
                  echo '<a id="link-twitter" href="'.$teacher->twitter_link.'"><i class="fab fa-twitter fa-2x"></i></a>';
                }
                if(isset( $teacher->skype_link )){
                  echo '<a id="link-skype" href="'.$teacher->skype_link .'"><i class="fab fa-skype fa-2x"></i></a>';
                }
                if(isset( $teacher->facebook_link )){
                  echo '<a id="link-facebook" href="'.$teacher->facebook_link.'"><i class="fab fa-facebook fa-2x"></i></a>';
                }
                ?>
                </div>
                
                <div id="button_div" class="centering">
                    
                    
                </div>
              </div>              
          </div>
      </div>

        <div class="main-profile" >
          
        <h1 id="suggested_headline">Suggested Sessions</h1>
          <div class="subjects" id="suggested_sessions">

            <table id="subjects_table" class="cell-border teacher_table">
          <thead>
              <tr>
                  <th>Subject</th>
                  <th>Time &amp; date</th>
                  <th>Max Number</th>
                  <th>Current number</th>
                  <th>Enroll</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach ($sessions as $session) {
              if(isset($_SESSION["id"])){
                if($_SESSION["role"]!="student") break;
                $sessionsOfStudent = $sessions_model->getAllSessionsForStudent($_SESSION["id"]);
                $flag=false;
                foreach ( $sessionsOfStudent as $sessionOfStudent){
                  if($sessionOfStudent->id == $session->id){
                    $flag=true;
                    if( $session->status !== "pending" ) {continue; $flag=false; }
                    echo '<tr class="enrolled">';
                    break;
                  }
                }
                if(!$flag){
                  if( $session->status == "pending") echo '<tr>';
                  else continue;
                }
              }
              else{
                if( $session->status == "pending") echo '<tr>';
                else continue;
              }
              ?>
                  <td><a href="<?php echo URL."mySubjects/index/".$Tid."/".$session->s_id;?>"><?php if (isset($session->name)) echo $session->name; ?></a></td>
                  <td>
                    <div class="session-time-date">
                      <div> <?php if (isset($session->from_) && isset($session->to_)) echo $session->from_.' - '.$session->to_; ?> </div>
                      <div> 
                        <?php 
                          if(isset($session->date)){
                            $date=explode("-",$session->date );
                            echo $date[2]."/".$date[1]."/".$date[0];
                          }
                        ?>
                      </div>
                    </div>
                  </td>
                  <td><?php if (isset($session->max_students)) echo $session->max_students; ?></td>
                  <td><?php if (isset($session->count)) echo $session->count; ?></td>
                  <td>
                    <?php 
                    if(isset($_SESSION["id"])){
                      if($flag){
                        echo '<a href="'.URL.'teacher/CancelSession/'.$session->id.'" class="anchor_as_button">Cancel</a>';
                      }else{
                        echo '<a href="'.URL.'teacher/enrollInSession/'.$session->id.'" class="anchor_as_button">Enroll me</a>';
                      }
                      
                        
                    }else{
                      $_SESSION['redirect']= URL."teacher/index/".$Tid;
                      echo '<a href="'.URL.'login/error" class="anchor_as_button">Enroll me</a>';
                    }
                    
                    ?>
                  </td>
              </tr>
              <?php } ?>
            </tbody>
      </table>
      </div>
      <form class="student_session_info" method="post" action="<?php echo URL."teacher/suggestSession/".$Tid;?>" >
          <h1 id="my_suggestion">Suggest your own session:</h1>
          <div class="session_suggestion">
          <div class="teacher_subjects">
            <h1>Subjects</h1>
            <div class="custom-select" id="select_subject">
              <select name="selected_subject">
              <option value="0">Select Subject:</option>
              <?php $flag=true;
                    foreach( $subjects as $subject ){ 
                      $flag=false; ?>
                <option value="<?php  if(isset($subject->id)) echo $subject->id;?>"><?php if(isset($subject->name)) echo $subject->name; ?></option>
              <?php }
              if($flag){
               echo '<option value="0">There are no available subjects right now</option>';
              }
              
              ?>

               </select>
            </div>
          </div>
          <div class="time_availability">
            <h1>Available Times</h1>
            <div class="custom-select" id="select_time">
              <select name="selected_availability">
                <option value="0">Select Time:</option>
                <?php $flag=true; 
                  foreach( $availabilities as $availability ){
                     
                    if( date("Y-m-d", strtotime($availability->date)) < date("Y-m-d") ) continue;
                    if(  date("Y-m-d", strtotime($availability->date)) == date("Y-m-d") && date( "H:i", strtotime( $availability->from_ ) )  < date("H:i")  ) continue;
                    $flag=false;
                    ?>
                <option value="<?php  if(isset($availability->id_)) echo $availability->id_;?>">
                <?php 
                  if(isset($availability->from_) && isset($availability->to_ ) &&  isset($availability->date ) ){
                    $date=explode("-",$availability->date );
                    echo $availability->from_." - ".$availability->to_.'   '.$date[2]."/".$date[1]."/".$date[0];
                  }  
                  
                  ?>
              
                </option>
              <?php } 
              if($flag){
                echo '<option value="0">There is no available times right now</option>';
               }
              ?>


               </select>
            </div>
          </div>
           <input type="submit"  name="sujestsession" class="d_button button" value="Suggest Session">
        </div>
     </form>


          

  
        </div>


  
       </div>

    <script src="<?php echo URL;?>public/js/subjects.js"> </script>
    <script src="<?php echo URL;?>public/js/teacher.js"> </script>