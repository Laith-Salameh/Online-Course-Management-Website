<html>
    <head> 
    <link  href="<?php echo URL; ?>public/img//icon.png" rel="icon">
    <title>Rejection Reason</title>
    <link href="<?php echo URL; ?>public/css/home style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/session.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/subjects.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/guest.css" >
</head>
<body>
    <div class="editCover1 displayCover1"> 
        <div id="topicPop" class="displayCover1 Editvisible2" >
            <form id="topicForm"  method="post" action=" ">
                <span class="create"> Write Your rejection reason </span>
                <input type="text" class="inputField" name="reject_reason" id="Topic-name" placeholder="Rejection"> 
                <input id="addTopic" type="submit"  name="reject" value="Reject session">
                <a id="CancelTopic" href="<?php echo URL."session"; ?>"> <b> Cancel </b> </a>
            </form>
        </div>
    </div>
</body>
</html>