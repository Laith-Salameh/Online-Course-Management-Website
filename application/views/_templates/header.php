<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link  href="<?php echo URL;?>public/img//icon.png" rel="icon">
    
    <title>kraken Homepage</title>
    <link href="<?php echo URL;?>public/css/home style.css" rel="stylesheet">

        
    <link rel="stylesheet" href="<?php echo URL;?>public/fontawesome-free-5.15.2-web/css/all.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
   
    
</head>
<body>
    <div class="big-container">
        <div class="cover">
            <?php
                if(isset($_SESSION["search"])){            
                    $subjects_model = $this->loadModel('SubjectModel');
                    $users_model = $this->loadModel('UsersModel');
                    $search_users = $users_model->searchForUser($_SESSION['search-query']);
                    $search_subjects = $subjects_model->searchForSubject($_SESSION['search-query']);
                    $flag=true;
                    echo '<div class="search-form">
	                        <form class="Forms inline" >
		                        <span class="create"> Search Results</span>      
                                    <ul class="dataViewer">           
                	                    <li>';
                                        $counter = 7;   
                                   echo '<h1> Users: </h1>';
                    foreach( $search_users as $u ){
                        if($counter == 0 ) break;
	                    $flag=false;
                        if( $u->role == "teacher"){
                                        echo '<p>
		                                        <p>
			                                        <a href="'.URL.'teacher/index/'.$u->id.'">'.
                                                    '<img src="'.URL.$u->img.'" class="profile_image"> &nbsp'
                                                    .$u->first_name.' '.$u->last_name.'</a>
		                                        </p>
                                            </p>';
                        }
                        else{
                            echo '  <p>
		                                <p>
			                                <a href="'.URL.'profile/index/'.$u->id.'"> '. 
                                            '<img src="'.URL.$u->img.'" class="profile_image"> &nbsp' 
                                            .$u->first_name.' '.$u->last_name.'</a>
		                                </p>
                                    </p>';
                        }     
                                            $counter--;
                    } 
                    if($flag){
                        
                        echo '<p class="noresults">There is no maching results</p>';
                    }
                    $flag=true;

                                echo '</li>                     
                                      <li>';
                                      echo '<h1> Subjects: </h1>';
                                      $counter = 7;  
                    foreach( $search_subjects as $s ){ 
                        if($counter == 0 ) break;
	                    $flag=false; 
                                    echo '<p>
                                            <p>
                                                <a href="'.URL.'mySubjects/index/'.$s->Tid.'/'.$s->id.'">'.'
                                                <img src="'.URL.$s->img.'" class="profile_image"> &nbsp'.
                                                $s->name.'
                                                </a>
                                             </p>
                                          </p>';
                                          $counter--;
                    }
                    if($flag){
                        echo '<p class="noresults">There is no maching results</p>';
                    }
                                echo '</li>';
                    
                                echo '</ul>
                                <button type="button" class="submit-Button" id="cancelSearch"> Cancel</button>
                                </form>
                            </div>';
      
                }
            ?>
             

             <div class="create-form">
                    <form class="Forms" id="subjectForm" method="post" action="<?php echo URL.'/home/addSubject'?>" >
                        <span class="create"> Create Subject</span>
                        <input type="text" class="inputField" id="Subject-name" name="name" placeholder="Subject Name*">
                        <input type="text" class="inputField" id="Description" name="description" placeholder="Subject Description" >
                            <label for="count">Student's Count*:</label>
                            <input type="number" id="count" name="count" min="1" step="1">
                        <div class="btns">
                            <input type="submit" class="submit-Button" name="subjectSubmit" id="subjectSubmit" value="Create Subject">
                            <input type="button" class="submit-Button" id="cancelSubmit" value="Cancel">
                        </div>
                        
                    </form>
            </div>

            <div class="availability-form">
                    <form class="Forms" id="availabilityForm" method="post" action="<?php echo URL.'/home/addAvailableTime'?>">
                        <span class="Set-Time"> Set Available Time</span>
                        <span id="min-time">Minimum time is 30 minutes</span>
                        
                        <label for="from-time">From:</label>
                        <input type="number" id="from-time" name="from-hours"  value="0">
                        <span>:</span>
                        <input type="number" id="from-minutes" name="from-minuts"  value="0" step="15">
                        
                        <label for="to-time">To:</label>
                        <input type="number" id="to-time" name="to-hours"  value="0">
                        <span>:</span>
                        <input type="number" id="to-minutes" name="to-minuts"  value="0" step="15">
                        
                        <span id="Available-date">Date: </span>
                        <select id="availability_select" name="selected_date">
                            <?php 
                            $today=date("dd/MM/yyyy");
                            $today_date=strtotime($today);
                            for($i=0 ; $i<4 ; $i++){
                                $available=date('d/M/Y', strtotime($today_date."+".$i."days")) ; ?>
                                <option value=<?php echo "$available" ;?>><?php echo "$available";?></option>
                            <?php } ?>
                        </select>
                                <span id="two-days"><br>Attention:You've set a time over two days </span>
                        
                            <input type="submit" class="submit-Button" id="TimeSubmit" name="add_available_time" value="Add To Available Times">
                            <input type="button" class="submit-Button" id="cancelTimeSubmit" value="Cancel">
                    </form>
            </div>

    </div>
    <nav class="navbar">
            <a href="<?php echo URL;?>home"><img class="logo" id="kraken" src ="<?php echo URL; ?>public/img/logoK.png"> </a>
            
            <form method="post" class="inline" action="<?php echo URL.'home/search'; ?>" >
            <div class="search-box">
                    <input class="search-txt" type="text" name="search-query" placeholder="tap to search">
                    <button class="search-btn" type="submit" id="search" name="search-data"><i class="fas fa-search"></i></button>
            </div>
        </form>
                <ul>
                <li><a href="<?php echo URL; ?>home">Home</a></li>
                 <?php 
                 if( isset($_SESSION['role']) ){
                    if( $_SESSION['role']== "teacher" ){
                        echo '<li><a href="#"> Manage Subject <i class="fas fa-caret-down"></i></a>
                                <ul>
                                    <li id= "create-subject"> <a> Create Subject </a></li>
                                    <li id="create-Time"><a>Create Available Time</a></li>
                                    <li><a href="'. URL.'session">Session Index</a></li>
                                </ul>
                            </li>';
                    }
                    else{
                        if( $_SESSION['role']== "student" ){
                            echo '<li><a href="' . URL ."Subjects/index.php".   '">Teachers & Subjects</a></li>';
                        }
                        else{
                            if( $_SESSION['role']== "admin"){
                                echo '<li><a href="' . URL ."Subjects/index.php".   '">Teachers & Subjects</a></li>';
                                echo '<li><a href="' . URL ."admin/index.php".   '">Manage</a></li>';
                            }
                    
                        }
                    }

                    echo '<li><a href="'.URL.'profile" class="centering tcentering"><img src="'.URL.$_SESSION["url"].'" class="profile_image"></a></li>';
                    echo '<li><a href="'.URL.'login/logout"> <i class="fas fa-sign-out-alt fa-lg" ></i>  </a></li>';
                 }
                 else{
                     //guest
                    echo '<li><a href="' . URL ."Subjects/index.php".'">Teachers & Subjects</a></li>';
                    echo '<li><a href="'. URL.'login">Log In</a></li>';
                 }
                
                   ?>
                
                    
                

            </ul>
        </nav>
        <button class="hidden_button"> </button>

    