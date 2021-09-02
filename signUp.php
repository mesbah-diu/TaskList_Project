<?php
    // File: insert/two-tables/index.php
    /* Demonstrates the creation of a DB, two tables and the
     * insertion of a record into each table. One form is used
     * to collect fields for both tables.
    */

    declare(strict_types = 1);
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    
    function sanitizeInput($value) {
        return htmlspecialchars( stripslashes( trim( $value) ) );
    }     

    function insertUserRecord(PDO $pdo, string $username, string $password): int {
        // Notice the single quotes around the name.
        $sql = "
        INSERT INTO users
          (username, password)
        VALUES
          ('$username', '$password')
        ";
        
        $status = $pdo->exec($sql);
        $id = (int)$pdo->lastInsertId();
        echo "New User $status account created.<br>";
        return $id;
    }

    function passwordCheck(string $password, string $verifyPass): int{
        if($password != $verifyPass){
            return 1;
        }else{
            return 0;
        }
    }

    /*function insertModelRecord(PDO $pdo, int $userID, string $model_name, 
        string $yearIntroduced, string $isInProduction) {
        // Notice the single quotes around the name.
        $sql = "
        INSERT INTO models
          (manufacturer\$id, name, yearIntroduced, isInProduction)
        VALUES
          ($userID, '$model_name', '$yearIntroduced', '$isInProduction')
        ";
        
        $status = $pdo->exec($sql);
        $id = $pdo->lastInsertId();
        echo "Model record insert status: $status record(s) inserted.<br>";
    }*/

    function getUserID(PDO $pdo, string $username): int {
        // Search for the instructor and return its id if found,
        // or 0 if not.
        $sql = "
        SELECT id
        FROM users
        WHERE username = '$username'
        ";
        $stm = $pdo->query($sql, PDO::FETCH_ASSOC);
        if ($stm->rowCount() == 1) { return (int)$stm->fetch()['id']; }
        else { return 0; }
    }

    //$recordType = "";
    function saveUserRecord(PDO $pdo, string $username, string $password, string $verifyPass){
        $userID = getUserID($pdo, $username);
        if ($userID) {
            // user is existing.
            //insertModelRecord($pdo, $userID, $model_name, $yearIntroduced, $isInProduction);
            //header("Location: loginForm.php?recordType=models+table+updated");
        } else {
            // Insert new user.
            if(passwordCheck($password, $verifyPass) == 0){

                $hashedPass = password_hash($password, PASSWORD_BCRYPT);

                $userID = insertUserRecord($pdo, $username, $hashedPass);

                echo " Welcome! You are user number $userID.";
                // Next insert the model. 
               
                header("Location: successfulLogin.php");
            }else{
                echo "Passwords do not match, try again!";
            }
        }
    }
    
    $curYear = date('Y');
    $phpScript = sanitizeInput($_SERVER['PHP_SELF']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            //update (1): use an external db_config.php file:
            require_once 'inc.db.php';
            $dsn = 'mysql:host=' . HOST . ';dbname=' . DB;
            $pdo = new PDO($dsn, USER, PWD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Extract the fields.
            $username = sanitizeInput($_POST['username']);
            $password = sanitizeInput($_POST['password']);
            $verifyPass = sanitizeInput($_POST['verifyPass']);
            

            saveUserRecord($pdo, $username, $password, $verifyPass);

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
        <title>Sign Up - TaskList</title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>

    <!--Client side validation-->
    <script src="validate.js" defer></script>
    <body class="w3-container w3-margin-left">
        <div class="w3-panel">
        <h1>Sign up and create an account.</h1>
        <form id="signUp" action="<?php echo $phpScript; ?>" method="POST">
                </br>
                <label for="username"></label>
                <input type="text" id="username" name="username" placeholder = "Username" required></br></br>
                <input type="password" name="password" placeholder = "Password" required></br></br>
                <input type="password" name="verifyPass" placeholder = "Verify Password" required></br></br>
            <button class="w3-btn w3-green">Create Account</button>
        </form>
        </div>

        <footer class="w3-container w3-center w3-text-gray">&copy; <?php echo $curYear; ?> TaskList </footer>
    </body>
</html>