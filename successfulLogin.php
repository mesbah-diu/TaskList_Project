<?php
    // File: successfulLogin.php
    // Page is returned when user completes signUp.php form to create new account
    // Link to loginForm.php can be accessed after creating account
    declare(strict_types = 1);
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $curYear = date('Y');

    //return the new user's ID by grabbing last entry of users table in project database
    function getNewUserID(PDO $pdo){
        // Search for the instructor and return its id if found,
        // or 0 if not.
        $sql = "
        SELECT id
        FROM users
        ORDER BY id DESC LIMIT 1
        ";
        $stm = $pdo->query($sql, PDO::FETCH_ASSOC);
        if ($stm->rowCount() == 1) { return (int)$stm->fetch()['id']; }
        else { return ''; }
    }

    //return the new user by grabbing last entry of users table in project database
    function getNewUsername(PDO $pdo){
        $sql = "
        SELECT username
        FROM users
        ORDER BY id DESC LIMIT 1
        ";
        $stm = $pdo->query($sql, PDO::FETCH_ASSOC);
        if ($stm->rowCount() == 1) { return $stm->fetch()['username']; }
        else { return ''; }
    }
    //greet the new user with name and id
    function greeting(PDO $pdo){
        $newUser = getNewUsername($pdo);
        $id = getNewUserID($pdo);

        //&nbsp; is a non-breakable space, inserted for formatting
        echo "</br><h4>&nbsp;&nbsp;&nbsp;&nbsp;Welcome to TaskList, <b>$newUser</b>! </h4></br>";
        echo "<h5>&nbsp;&nbsp;&nbsp;&nbsp;You are user number <b>$id</b> to sign up.</h5>";
    }

    try {
        //use an external db_config.php file:
        require_once 'inc.db.php';
        $dsn = 'mysql:host=' . HOST . ';dbname=' . DB;
        $pdo = new PDO($dsn, USER, PWD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        greeting($pdo);

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

    <body class="w3-container w3-margin-left">
        <div class="w3-panel">
            <form>
                
                <p>Back to <a href="loginForm.php" >login</a>.</p>
            </form>
        </div>

        <footer class="w3-container w3-center w3-text-gray">&copy; <?php echo $curYear; ?> TaskList </footer>
    </body>
</html>