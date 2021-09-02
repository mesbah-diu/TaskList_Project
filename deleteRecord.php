<?php

    declare(strict_types = 1);
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $curYear = date('Y');
    session_start();

    $userName = $_SESSION['username'];
    if (isset($userName)) { 
        $welcomeMessage = "<h3>Add a Record | <a href='index.php'>Home</a></h3>";
        //echo "<p>Welcome, $_SESSION[username]</p>";
    }   

    function sanitizeInput($value) {
        return htmlspecialchars( stripslashes( trim( $value) ) );
    } 

    function deleteProjectRecord(PDO $pdo, string $userName) {
        $userID = getUserID($pdo, $userName);

        // Notice the single quotes around the name.
        $sql = "
        DELETE FROM project
        WHERE user\$id = '$userID';
        ";
        
        $status = $pdo->exec($sql);
        echo "Project Record insert status: $status record(s) inserted.<br>";
    }

    function deleteProjectTasks(PDO $pdo, string $userName) {
        $projectID = getProjectID($pdo, $userName);

        // Notice the single quotes around the name.
        $sql = "
        DELETE FROM task
        WHERE project\$id = '$projectID';
        ";
        
        $status = $pdo->exec($sql);
        echo "Project Record insert status: $status record(s) inserted.<br>";
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
    
    

    $phpScript = sanitizeInput($_SERVER['PHP_SELF']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            //update (1): use an external db_config.php file:
            require_once 'inc.db.php';
            $dsn = 'mysql:host=' . HOST . ';dbname=' . DB;
            $pdo = new PDO($dsn, USER, PWD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Extract the fields.
            $answer = $_POST['answer'];
            if($answer == "yes"){
                deleteProjectTasks($pdo, $userName);
                sleep(rand(2,3));
                deleteProjectRecord($pdo, $userName);
                header("Location: index.php?");
            }else{
                echo "<h6 class='w3-btn w3-green'>Record unchanged</h6>";
            }

        } catch(PDOEXCEPTION $e) {
            // For debugging purposes reveal the message.
            die( $e->getMessage() );
        }
        $pdo = null;
    }

?>
<!DOCTYPE html>

<html>
    <head>
        <title>Delete Record | TaskList</title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>

    <body>
    <body class="w3-container w3-margin-left">
    <div class="w3-panel">
        <header>
            <h2>
                <?php 
                    echo $welcomeMessage;
                ?>
            </h2>
        </header>
        <form action="<?php echo $phpScript; ?>" method="POST">
            </br>
            <h4>Are you sure you want to delete your project?</h4></br>
            <input type="radio" id="yes" name="answer" value="yes">
            <label for="yes">Yes, I do</label>&emsp;
            <input type="radio" id="no" name="answer" value="no" checked="true">
            <label for="yes">No, I don't</label></br><br><br>
            <button class="w3-btn w3-red">Delete</button>
        </form>
        </div>


        

        <footer text-align: center></br>&copy; <?php echo $curYear; ?> Edward Prenzler | <b>TaskList</b> </footer>
    </body>
    <footer id=footer class="w3-container w3-center w3-text-gray">&copy; <?php echo $curYear; ?> TaskList </footer>
    <style>
    body{
        background-color: #fcf3cf; 
    }
    footer{
        position:absolute;
        bottom:0;
        left:0;
        width:100%;
        height:70px;   /* Height of the footer */
        background-color: #f9e79f;
        font:#515a5a;
    }
    </style>
</html>