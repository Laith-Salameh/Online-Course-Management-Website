<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/DataTables/css/jquery.dataTables.css">
<script src="<?php echo URL;?>public/DataTables/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/css/subjects.css">
<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/css/profile.css" >
<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/css/admin.css" >

<div class="editCover">    
<div  id="SendComment" class="" >
  <?php 
  if( isset($_SESSION["session_id2"]) ){
    
    echo '<form id="SendcommentForm"   >'; 
          
            
            foreach( $session_comments as $session_comment ){
              echo ' 
                <div class="container">
                  <img src="'.URL.$session_comment->img.'" alt="Avatar">
                  <p>'.$session_comment->comment.'</p>
                  <span class="time-right">'.$session_comment->name.'</span>
                </div>
                
              '; 
          }
          
          echo '<input id="cancelcomment" type="button"  value="cancel"> </form>';
          unset($_SESSION["session_id2"]);
        }
      ?>
      
  </div>  
</div>

<div id="display" class="hiddenClass"> </div>

<div class="profile_parent">  
  <div class="main-profile" >
    <div class="content-main" >
      <div  class="toggle-parent" > 
          <?php
            if(isset($_SESSION['role'])){
              if($_SESSION['role']=="admin"){
                echo '<div id="view-users" class="toggle"> <br> Users </div>';
                echo '<div id="sessions-admin" class="toggle"> <br> Sessions </div>';
                echo '<div id="subjects-admin" class="toggle"> <br> Subjects </div>';

              } 
            }
          ?>
        </div>
        <div class="users-list">
          <?php
         
            if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){?>
            
              <div id="page7" >
                <div class="subjects">
                      <table id="users-table" class="cell-border ">
                          <thead>
                              <tr>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Phone number</th>
                                  <th>Role</th>
                                  <th>Change password</th>
                                  <th>Change Role</th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php foreach ($users as $user) {?>
                              <tr>
                                  <td><a href="<?php echo URL.'profile/index/'.$user->id; ?>"><?php echo $user->first_name . " " .$user->last_name ; ?></a></td>
                                  <td><?php if(isset($user->email)) echo $user->email ; ?></td>
                                  <td><?php echo $user->phone_number ; ?></td>
                                  <td><?php echo $user->role ; ?></td>
                                  <td><form class="unique_form" method="post" action="<?php echo URL.'/admin/changePassword/'.$user->id ;?>">
                                        <input type="text" class="input_field" id="newpass" name="new_password" placeholder="Enter new password">
                                        <input type="submit" name="change_pass_submit" class="submit-Button" value="Change Password">
                                      </form>
                                    </td>
                                  <td><form class="unique_form" method="post" action="<?php echo URL.'/admin/changeRole/'.$user->id ;?>">
                                        <select name="new_role" class="select_input">
                                          <option value="student"> Student </option>
                                          <option value="teacher"> Teacher </option>
                                          <option value="admin"> Admin </option>
                                        </select>  
                                        <input type="submit" name="change_role_submit" class="submit-Button" value="Change Role">
                                      </form>
                                    </td>
                              </tr>
                            <?php } ?>  
                              
                          </tbody>
                      </table>
                </div>
              </div>
              <div id="page8" >
                <div class="subjects">
                      <table id="sessions-table-admin" class="cell-border teacher_t">
                          <thead>
                              <tr>
                                  <th>Subject</th>
                                  <th>Topic</th>
                                  <th>Teacher</th>
                                  <th>Date</th>
                                  <th></th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($sessions as $session){
                              if(!($session->status == "pending") && !($session->status == "full") && !($session->status == "rejected")){?>
                            
                              <tr>
                                <?php $teacher_availability_model= $this->loadModel("teacher_availabilitymodel");
                                      $availability_model=$this->loadModel("availabilitymodel");
                                      $student_session_model=$this->loadModel("studentsessionmodel");
                                      $subjects_model = $this->loadModel("subjectmodel");
                                      $users_model = $this->loadModel("usersmodel");
                                      $subject=$subjects_model->getSubjectForSession($session->id);
                                      $teacher_id=$teacher_availability_model->getTeacherIdByAvailability($session->teacher_availability_id);
                                      $teacher=$users_model->getuserById($teacher_id->id);
                                      $availability_id=$teacher_availability_model->getAvailabilityId($session->teacher_availability_id);
                                      $availability=$availability_model->getAvailabilityById($availability_id->id);
                                ?>

                                  <td><?php echo $subject->subject_name ;?></td>
                                  <td><?php echo $session->topic ; ?></td>
                                  <td><?php echo $teacher->first_name." ".$teacher->last_name ;?></td>
                                  <td><?php echo $availability->from." - ".$availability->to ;?><br><?php echo $availability->date ;?></td>
                                   <?php if($session->status == "accepted"){?> <!-- accepted by teacher but not by admin yet -->
                                   <td>
                                     <form class="unique_form" method="post" action="<?php echo URL.'/admin/acceptSession/'.$session->id;?>">
                                        <input type="text" class="input_field" id="linksession" name="session_link" placeholder="Enter session link">
                                        <input type="submit" name="accept_submit" class="submit-Button" value="Accept & Send Link">
                                      </form></td>
                                    <td>
                                      <form class="unique_form" method="post" action="<?php echo URL.'/admin/rejectSession/'.$session->id;?>">
                                        <input type="text" class="input_field" id="reject_session_reason" name="session_reject" placeholder="Enter reject reason">
                                        <input type="submit" name="rejection_submit" class="submit-Button" value="Reject & Send Reason">
                                      </form>
                                    </td>
                                  <?php }
                                  else if($session->status == "closed"){
                                    $count=$student_session_model->getSessionRating($session->id);?>
                                    <td>
                                    <?php 
                                    $rate= $student_session_model->getSessionRating($session->id);
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

                                      echo '</td>
                                      <td><a class="anchor_as_button submit-Button" href="'.URL.'admin/viewcomments/'.$session->id.'" >View Comments</a> </td>
                                    </tr>';
                              }
                              else{
                                echo '<td></td>
                                <td></td>';}
                                ?>
                              
                              <?php } }?>  
                          </tbody>
                      </table>
                    
                </div>
              </div> 
              <div id="page9" >
                <div class="subjects">
                      <table id="subjects-table-admin" class="cell-border teacher_t">
                          <thead>
                              <tr>
                                  <th >Subject</th>
                                  <th>Category</th>
                                  <th>Teacher</th>
                                  <th>Discription</th>
                                  <th></th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($subjects1 as $subject1) {
                              if($subject1->status !=="is_deleted"){?>
                              <tr>
                                <td><a href="<?php echo URL.'mySubjects/index/'.$subject1->Teacherid.'/'.$subject1->Subjectid; ?>"><?php echo $subject1->name ;?></a></td>
                                  <?php if($subject1->status == "pending"){?>
                                    <td><?php echo "unknown" ; ?></td>
                                  <?php }
                                    else {?>
                                      <td><?php echo $subject1->category ; ?></td>
                                    <?php
                                    } ?>
                                  <td><?php echo $subject1->first_name." ".$subject1->last_name ;?></td>
                                  <td><?php echo $subject1->description ;?></td>
                                  <?php if($subject1->status == "pending"){?>
                                  <td>
                                    <form class="unique_form" method="post" action="<?php echo URL.'/admin/acceptSubject/'.$subject1->Subjectid;?>" enctype="multipart/form-data">
                                      <select name="choose_category" class="select_input">
                                        <option value="development"> Development </option>
                                        <option value="business"> Business </option>
                                        <option value="IT"> IT & Software </option>
                                        <option value="design"> Design </option>
                                      </select>
                                      <input type="file" name="subject_img" class="input_field image_path" placeholder="Enter image url" accept="image/png, image/jpeg" >
                                      <input type="submit" name="accept_subject_submit" class="submit-Button" value="Accept Subject">
                                    </form>
                                  </td>
                                  <td>
                                    <form class="unique_form" method="post" action="<?php echo URL.'/admin/rejectSubject/'.$subject1->Subjectid?>">
                                      <input type="text" class="input_field" id="reject_subject_reason" name="subject_reject" placeholder="Enter reject reason">
                                      <input type="submit" name="reject_subject_submit" class="submit-Button" value="Reject & Send Reason">
                                    </form>
                                  </td>
                                  <?php }
                                  else{?>
                                  <td>
                                    <form class="unique_form" method="post" action="<?php echo URL.'/admin/deleteSubject/'.$subject1->Subjectid?>">
                                      <input type="submit" name="subject_deletion_submit" class="submit-Button" value="Delete">
                                    </form>
                                  </td>
                                  <td>
                                  <form class="unique_form" id="change_image_form" method="post" action="<?php echo URL.'/admin/changeSubjectImage/'.$subject1->Subjectid;?>" enctype="multipart/form-data">
                                      <input type="file" name="new_subject_img" class="input_field image_path" placeholder="Enter image url" accept="image/png, image/jpeg" >
                                      <input type="submit" name="change_img_submit" class="submit-Button" value="Change Image">
                                    </form>
                                  </td>
                                </tr>
                                <?php  }
                              }?>
                              
                              <?php } ?>  
                          </tbody>
                      </table>
                    
                </div>
              </div> 
          <?php
        }?> 
        </div>
    </div> 
  </div>
</div>
<script src="<?php echo URL;?>public/js/editPopup.js"></script>
 <script src="<?php echo URL;?>public/js/admin.js" ></script>