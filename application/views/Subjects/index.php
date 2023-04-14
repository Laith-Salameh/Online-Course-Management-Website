<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/DataTables/css/jquery.dataTables.css">

<script src="<?php echo URL;?>public/DataTables/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/css/subjects.css">

<div class="subjects change_height">		
			<table id="subjects_table" class="display">
    			<thead>
        			<tr>
            			<th>Subject</th>
            			<th>Teachers</th>
            			<th>Details</th>
        			</tr>
    			</thead>
    			<tbody>
						<?php foreach( $subjects as $subject ){ ?>
                            <tr>
                			<td>
								<center>
									<?php if(isset($subject->name)) echo $subject->name; ?>
								</center>
							</td>
                            <td>
								<center>
									<a href="<?php echo URL.'teacher/index/'.$subject->Teacherid; ?>"><?php if(isset($subject->first_name) && isset($subject->last_name)) echo $subject->first_name." ".$subject->last_name; ?></a>
								</center>
							</td>
                            <td>
								<center>
									<a  class="anchor_as_button"  href="<?php echo URL."mySubjects/index/".$subject->Teacherid."/".$subject->Subjectid; ?>" >View Details</a>
								</center>						
							</td>
                            </tr>
                        <?php } ?>
    			</tbody>
			</table>
		</div>
		
		<script src="<?php echo URL;?>public/js/subjects.js"></script>