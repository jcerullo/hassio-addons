<?php
	$logedin = false;
	$date = date("Y-m-d H:i:s");
?> 
<!DOCTYPE html>
<html>
<head>
  <title>HOT</title>
  <meta charset="utf-8"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
     integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="main.css">
  <script type="text/javascript" src = "jquery-3.3.1.js"> </script>
</head>
<body>

<?php
    if (filter_has_var(INPUT_POST, "usernum")) {
        $userNbr = filter_input(INPUT_POST, "usernum");
    }	
    if (filter_has_var(INPUT_POST, "uname")) {
        $userName = filter_input(INPUT_POST, "uname");
    }		
    if (filter_has_var(INPUT_POST, "passwd")) {
        $password = filter_input(INPUT_POST, "passwd");
    }
	if (filter_has_var(INPUT_POST, "newUser")) {
        $newUser = filter_input(INPUT_POST, "newUser");
		$newUserNbr = '92973214';
		$newURL = 'https://handsontechorg.weebly.com/facilitators.html';
		$logedin = true;
    }		
    if (filter_has_var(INPUT_POST, "newPassword")) {
        $newPassword = filter_input(INPUT_POST, "newPassword");
    }
	
if ($logedin == false) {
	try {                                                
        $con= new PDO('mysql:host=localhost;dbname=hot', "root", "jjc003");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
        $result = $con->query("SELECT * FROM credentials 
							   ORDER BY rcdNbr ");
		$result->setFetchMode(PDO::FETCH_ASSOC);

		foreach ($result as $row) {
		  foreach ($row as $name =>$value ) {
			if ($name == 'rcdNbr')    $currentRcdNbr = $value;
			if ($name == 'timestamp') $currentTimestamp = $value;			  
			if ($name == 'userName')  $currentUserName = $value;
			if ($name == 'userNbr')   $currentUserNbr = $value;
            if ($name == 'password')  $currentPassword = $value;     				
		  }		 		  
	    }           		   		
    }		 //end of try
 	
    catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }	
}

if ($userNbr == $currentUserNbr && $userName == $currentUserName && $password == $currentPassword) {
	$logedin = true;
	$legend = 'Login Successful!';
}	
if ($logedin && $newUser != '' && $newPassword != '' && $newUser != ' ' && $newPassword != ' ') {
	    $legend = 'User Name and/or Password Changed Successfully!';
        try {
        
        $con= new PDO('mysql:host=localhost;dbname=hot', "root", "jjc003");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$result = $con->prepare("UPDATE members 
                      SET 	firstName = '$firstName' 			
			          WHERE emailAddress = '$mbrID'  ");
			$result->execute();	
			
	        $result = $con->prepare("INSERT INTO credentials 
			           (rcdNbr,
						timestamp,
						userNbr,
						userName,
						password,
						url)
			
			     VALUES
			           ('',
						'$date',
						'$newUserNbr',
						'$newUser',
						'$newPassword',
						'$newURL') ");

			$result->execute();			
		
        }		 //end of try
 	
        catch(PDOException $e) {
          echo 'ERROR: ' . $e->getMessage();
	    }
}           // end if	
?>	
  
<?php
if ($logedin) {

print <<<HERE
  <div class = "member"> 
  <style type = "text/css">
  
          fieldset {
            width: 600px;
			color: black;
            background-color: black;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 5px 5px 5px gray;
          }
		  
          label {
			color: white;
            float: left;
            clear: left;
            width: 250px;
            text-align: right;
            padding-right: 1em;
          }
                   
          input {
            float: left;
          }
		  
		  select {
			  float:left;
		  }
          
          :required {
            border: 1px solid red;
          }
          
          :invalid {
            color: white;
            background-color: red;
          }
          
          button {
		    text-align: center;
            display: block;
            margin-left: auto;
            margin-right: auto;
            clear: both;
          }
		  
		  #submit {
			color: black;
		    background-color: white;
			margin-left: 30px;
		  }
  </style>

    <form id="myform" action = "facilitatorLogin.php" method= "post">
      <fieldset> <br>

		<label>$legend</label>	<br><br>
		<label> </label>
		<label>New User Name</label> 
		<input type="text" value="" id="txt_newUser" name="newUser" > <br>
		<label>New Password</label> 
		<input type="text" value="" id="txt_newPwd" name="newPassword" > <br>
		
		
        <input type="submit" id = "submit" name = "submit" value = "Submit"> <br>
		
      </fieldset>
    </form>
        
HERE;
}         // end if

else {
print <<<HERE
  <div class = "member"> 
  <style type = "text/css">
  
          fieldset {
            width: 600px;
			color: white;
            background-color: black;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 5px 5px 5px gray;
          }
		  
          label {
            float: left;
            clear: left;
            width: 250px;
            text-align: right;
            padding-right: 1em;
          }
                   
          input {
            float: left;
          }
		  
		  select {
			  float:left;
		  }
          
          :required {
            border: 1px solid red;
          }
          
          :invalid {
            color: white;
            background-color: red;
          }
          
          button {
		    text-align: center;
            display: block;
            margin-left: auto;
            margin-right: auto;
            clear: both;
          }
		  
		  #submit {
			color: black;
		    background-color: white;
			margin-left: 30px;
		  }
  </style>
	
    <form action = "facilitatorLogin.html" method= "post">
      <fieldset> <br>

		<label>Login Failed!</label>			  
			 
        <input type="submit" id = "submit" value = "Retry"/> <br>
		
      </fieldset>
    </form>
HERE;
}         // end if


?> 
</body>
</html>