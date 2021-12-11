<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "company_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$tables = "SHOW TABLES FROM company_test";
$results = $conn->query($tables);

$message = "";
$error = "";

// here i am taking post request 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_REQUEST['tname'];

        try{

            // creating a table 
            $table = "CREATE TABLE $name (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                firstname VARCHAR(30) NOT NULL,
                lastname VARCHAR(30) NOT NULL,
                email VARCHAR(50)
                )";

                if ($conn->query($table) === TRUE) {
                  $message = "Table created successfully";
                  $tables = "SHOW TABLES FROM company_test";
                  $results = $conn->query($tables);
                } else {
                    throw new Exception( "Error creating table: " . $conn->error); //here i am   error through Exception;
                }

        }catch(Exception $e){		
        $error = $e->getMessage();//we will store the error in  error variable
        }		
	}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Creations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/app.css">
    <link rel="icon" type="image/x-icon" href="https://tiimg.tistatic.com/new_website1/ti-design/images/tiLoginLogo.png?tr=n-w74">
</head>
<body>
   
   <div class="container-fluid">
        <nav class="navbar navbar-primary">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Flipper Code Private Limited</a>
            </div>
        </nav>
        <div clsss="row">
            <div class="col-xm-2 col-sm-3"id="col1"></div>
            <div class="col-xm-8 col-sm-6">
                <div class="row">
                    <nav class="navbar navbar-warning">
                        <a href="#"id="todo"class="navbar-brand"><p>Table Creation App</p></a>
                    </nav>
                </div>
                <!-- form -->
                <?php if($error){		/*here we are showing that error or msg.Here we have used type of method to show output , first is like that*/
                $data = str_replace('Table','',$error);
                $data = ucwords($data);
				echo '<div class="alert alert-danger">'.$data.'</div>';
                }?>

                <?php if($message):?>		<!--other is like that-->
                    <div class="alert alert-success"><?php echo $message;?></div>
                <?php endif;?>
                
                <div class="row">
                    <form method="post">
                        <input type="text"name="tname"class="form-control" required><br>
                        <input type="submit" name="btn" class="btn btn-info form-control"id="subbtn">
                    </form>
                </div><br> 
                <div class="row" id="td">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S.no.</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php
                        if (is_array($results) || is_object($results))
                        {
                            $c =0;
                            foreach($results as $result)
                            {
                            $c++
                        ?>
                        <tr>
                            <td><?php echo $c?></td>
                            <td><?php echo $result['Tables_in_company_test']?></td>
                            <td>
                                <button class="btn btn-warning" name=""><a href="#"><i class="fa fa-pencil"></i></a></button>
                                <button class="btn btn-danger" name=""><a href="#"><i class="fa fa-trash-o"></i></a></button>
                            </td>
                        </tr>  
                          <?php
                            }
                        }
                        ?>
                    </table>
                </div>  
            </div>
            <div class="col-xm-2 col-sm-3"></div>
        </div>
   </div> 
</body>
</html>
