<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/css/home style.css">
<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/css/my subjects.css">

<div class="dropdown">
  <div class="center">
    <h1>Enroll in </h1>
    <h2><?php echo $teachers->teachername."'s"; ?> Session for <?php echo $subject->name."!"; ?> </h2>
    <div class="Get-Started" id="Get-Start" >
      <a href="<?php echo URL."teacher/index/".$Tid;?>">Get Strated </a>
    </div>
  </div>
</div>
<div class="course-c">
  <h1> What You Will learn </h1>
  <div class="descreption">
    
      <p>
        <p><?php if(isset($subject->description)) echo $subject->description; ?></p>
      </p>
    
  </div>
  <div >
    <h1 class="courseteacher"> Course's Teacher </h1>
    <div class="course-teacher">
      <div class="photo_">
        <div class="circle">
          <img id="profile-pic" src="<?php if(isset($teachers->image_url) ) echo URL.$teachers->image_url; ?>"  >
        </div>
        <div Id="Teacher-name">
          <a href="<?php echo URL."teacher/index/".$Tid;?>"><h3><?php echo $teachers->teachername; ?></h3></a>
        </div>
      </div>
      <div class="teacher_information">
        <p>Degrees:<br><br>
          <ul >
            <?php if(isset($teachers->degree)){
              $degrees = explode("," , $teachers->degree);
              foreach( $degrees as $degree ){
                echo "<li> $degree </li>";
              }
            } ?>
          </ul>
        </p>
        
      </div>
    </div>
  </div>
</div>
<br>
<!-- categories-------------------------------------------------------------------------------------------------->
<div class="catg-team">
  <div class="our-categories">
    <div class="container-cat">
      <h1> Other Subjects By This Teacher </h1>
      <div class="gallery">
        <?php 
          $counter=0;
          foreach( $subjectsOfTeacher as $subjectofteacher ){
            if(isset($subjectofteacher->name)){
              if($counter%4==0 ){
                echo '<div class="row">';
              }
              echo '<div href="#" class="mix design">';
              echo "<div class='layout'> $subjectofteacher->name </div>";
              echo '<a href="'.URL."mySubjects/index/$Tid"."/".$subjectofteacher->id.' "> <img class="subject_image" src="'.URL.$subjectofteacher->img.'" /></a> </div>';
              if($counter%4==3){
                echo '</div>';
              }
              $counter++;
            }
          }
        ?>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo URL;?>public/js/Home.js"></script>
<script src="<?php echo URL;?>public/js/my subjects.js"></script>