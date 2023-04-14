
<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/DataTables/css/jquery.dataTables.css">
<script src="<?php echo URL;?>public/DataTables/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/subjects.css">
<link rel="stylesheet" href="<?php echo URL; ?>public/css/guest.css" >
<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/session.css">

<div class="editCover1"> 
	<div  id="editPop1" class="hiddenClass1" >
		<form class="messageForm" id="RejectionForm"  method="post">
			<span class="create"> Write the rejection reason: </span>
			<span class="errorspan" > Rejection message should be between 10 and 1000 characters</span>
			<br>
			<textarea class="messagebody" form="MessageForm" id="Message" > </textarea>
			<br>
			<input id="sendMessage" type="submit"  value="Send Reason">
			<input id="CancelMessage" type="button"  value="Cancel">
		</form>
	</div>
	<div id="topicPop" class="hiddenClass1" >
		<form id="topicForm"  method="post">
			<span class="create"> Write the topic of the session </span>
			<input type="text" class="inputField" placeholder="Session's Topic"> 
			<input type="text" class="inputField" id="Topic-name" placeholder="Session's Topic"> 
			<input id="addTopic" type="submit"  value="Add Topic">
			<input id="CancelTopic" type="button"  value="Cancel">
		</form>
	</div>
</div>
          
<div class="subjects">
	<table id="Session_table" class=" cell-border ">
		<thead>
			<tr>
			<th>Subject</th>
			<th>Max Number</th>
			<th>Current number</th>
			<th>Students</th>
			<th>Time &amp; date</th>
			<th>Review</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($sessions as $session) { 
				if( $session->status == "accepted" || $session->status == "rejected" || $session->status == "closed" ) continue;
				?>
				<tr>
					<td><?php if (isset($session->name)) echo $session->name; ?></td>
					<td><?php if (isset($session->max_students)) echo $session->max_students; ?></td>
					<td><?php if (isset($session->count)) echo $session->count; ?></td>
					<td>
						<ul>
							<?php 
							$students = $studentsession_model->getAllStudents($session->id);
							$iterator= 1;
							foreach ($students as $student) { ?>
								<li>
									<a href="<?php echo URL."profile/index/".$student->id ?> ">
										<img src="<?php echo $student->img ; ?>" class="profile_image popup-img" id="<?php echo 'student'.$iterator ; ?>" >
										<div class="studentnames">
										<?php if (isset($student->first_name) && isset($student->last_name))
											echo $student->first_name." ".$student->last_name ; 
										?> 
										</div> 
									</a>
									
								</li>
							<?php $iterator++; } ?>
						</ul>          
					</td>
					<td>  
						<div class="session-time-date">
							<div > <?php if (isset($session->from_) && isset($session->to_)) echo $session->from_.' - '.$session->to_; ?> </div>
							<div> <?php
									 if(isset($session->date)){
                            			$date=explode("-",$session->date );
                            			echo $date[2]."/".$date[1]."/".$date[0];
                          			} 
									?>
						  	</div>
						</div>
					</td>
					<td>
						<?php
							
								echo '<a href="'.URL.'session/acceptSession/'.$session->id.'" class="anchor_as_button">accept</a>' , 
						   		'<a href="'.URL.'session/rejectSession/'.$session->id.'" class="margin-left anchor_as_button "> Reject </a>' ;
							
						?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
		
<script src="<?php echo URL; ?>public/js/message.js"></script>
<script src="<?php echo URL; ?>public/js/session.js"></script>