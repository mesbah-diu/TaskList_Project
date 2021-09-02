<?php
    // File: welcome.php
    // TODO: Start session tracking and redirect user back to the login form
    // if user not in the session state.
    $curYear = date('Y');
    $projectStatus = '';
    
    session_start();
    //welcome message
    $userName = $_SESSION['username'];
    if (isset($userName)) { 
        $welcomeMessage = "<h2>&emsp;&emsp;&emsp;Welcome to your task list, $userName.</h2>";
        //echo "<p>Welcome, $_SESSION[username]</p>";
    }else { 
        header('Location: loginForm.php');
    }

    function getUserID(PDO $pdo, string $userName){
        // Search for the current user and return its id if found,
        // or 0 if not.
        $sql = "
        SELECT id
        FROM users
        WHERE username = '$userName'
        ";
        $stm = $pdo->query($sql, PDO::FETCH_ASSOC);
        if ($stm->rowCount() == 1) { return (int)$stm->fetch()['id']; }
        else { return ''; }
    }
    
    function getProjectID(PDO $pdo, string $userName){
        // Search for the instructor and return its id if found,
        // or 0 if not.
        $userID = getUserID($pdo, $userName);

        $sql = "
        SELECT id
        FROM project
        WHERE user\$id= '$userID'
        ";
        $stm = $pdo->query($sql, PDO::FETCH_ASSOC);
        if ($stm->rowCount() == 1) { return (int)$stm->fetch()['id']; }
        else { return ''; }
    }

    function listProject(PDO $pdo, string $userName ){
        $userID = getUserID($pdo, $userName);

        $sql="
            SELECT name, dueDate
            FROM project
            WHERE user\$id = '$userID'
            ORDER BY id
        ;";

        // Formats the table column headings
        echo "</br><table border=1 cellspacing=0 cellpading=0><tr> 
        <td style='height:40px;width:160px;text-align:center'><font color= blue> Project Name </td> 
        <td style='height:40px;width:160px;text-align:center'><font color= red> Due Date </font></td></tr>";
        
        // Fetch each record as an associative array (FETCH_ASSOC).
        foreach($pdo->query($sql, PDO::FETCH_ASSOC) as $model) {
            //echo "{$model['name']}, {$model['dueDate']}<br>";
            echo "<td style='height:40px;width:160px;text-align:center'> {$model['name']} </td> 
            <td style='height:40px;width:160px;text-align:center'> {$model['dueDate']} </font></td></tr>";
        }
        
    }

    function listTasks(PDO $pdo, string $userName) {
        $projectID = getProjectID($pdo, $userName);
        
        $sql="
            SELECT name, status
            FROM task
            WHERE project\$id = '$projectID'
        ;";

        // Display column names as headings.
        //echo "Name | Status";
        echo "<table border=1 cellspacing=0 cellpading=0><tr> 
        <td style='height:40px;width:160px;text-align:center'><font color= blue> Task </td> 
        <td style='height:40px;width:160px;text-align:center'><font color= #1b2631> Completed? (Y/N) </font></td></tr>";

        // Fetch each record as an associative array (FETCH_ASSOC).
        foreach($pdo->query($sql, PDO::FETCH_ASSOC) as $model) {
            //echo "{$model['name']}, {$model['status']}<br>";
            echo "<td style='height:40px;width:160px;text-align:center'> {$model['name']} </td> 
            <td style='height:40px;width:160px;text-align:center'> {$model['status']} </font></td></tr>";
        }
    }
    
    try {
        //use an external db_config.php file:
        require_once 'inc.db.php';
        $dsn = 'mysql:host=' . HOST . ';dbname=' . DB;
        $pdo = new PDO($dsn, USER, PWD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        if(getProjectID($pdo, $userName) == ''){
            $projectStatus = "You currently have 0 projects due.";
        }else{
            echo "<div class='w3-panel' id=tables>";
            echo "<h3 id=slide class='w3-center w3-animate-left' >Today's TODO: </h3><center>";
            listProject($pdo, $userName);
            listTasks($pdo, $userName);
            echo "</center></div>";
        }

    } catch(PDOEXCEPTION $e) {
        // For debugging purposes reveal the message.
        die( $e->getMessage() );
    }
    $pdo = null;

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home - TaskList</title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>

    <body id=body class="w3-container w3-margin-left">
        <!--Welcome message-->
        <div class="w3-panel">
            <header id=header class="w3-container w3-center w3-text-gray">
                <h2>
                    <?php 
                        echo $welcomeMessage;
                        echo $projectStatus;
                    ?>
                </h2>
                <h5>
                    <a href='addRecord.php'>Add Project</a>&emsp;
                    <a href='addTask.php'>Add Task</a>&emsp;
                    <a href='deleteRecord.php'>Delete Record</a>&emsp;
                    <a style='color:red' href='loginForm.php'>Logout</a>
                </h5>
            </header>
        </div>

    </body>
    <footer id=footer class="w3-container w3-center w3-text-gray">&copy; <?php echo $curYear; ?> TaskList </footer>
    <style>
        footer{
            position:absolute;
            bottom:0;
            left:0;
            width:100%;
            height:70px;   /* Height of the footer */
            background-color: #f9e79f;
            font:#515a5a;
        }
        h2{
            text-align:left;
            padding:6px 0;
        }
        h5{
            text-align:right;
            padding:0px 0;
        }
        header{
            display: block;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100px;
            background-color: #f9e79f;
        }
        body{
            background-color: #fcf3cf; 
        }
        #slide{
            animation-duration: 2s;
        }
        #tables{
            padding-top: 8rem;
        }
        content{
            position:absolute;
            bottom:40;
            left:0;
        }

    </style>
</html>