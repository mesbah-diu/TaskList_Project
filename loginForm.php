<?php
    // File: loginForm.php
    /* Allows user to sign sign in with username and password.
       If user does not have account, link to signUp.php.
    */

    declare(strict_types = 1);

    // TODO: Start session tracking    
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    
    $curYear = date('Y');
    $username = $password = $errorMessage = "";
    $phpScript = sanitizeValue($_SERVER['PHP_SELF']);



    function sanitizeValue($value) {
        return htmlspecialchars( stripslashes( trim( $value ) ) );
    }

   
    // Processing logic.
    if ( $_SERVER['REQUEST_METHOD'] == 'POST') {    
        require_once 'inc.db.php';
        $dsn = 'mysql:host=' . HOST . ';dbname=' . DB;
        $pdo = new PDO($dsn, USER, PWD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // TODO: Retrieve the user record and authenticate it. If successful, track it with sessions,
        // and redirect to welcome page. Else, do not redirect.

        session_start();
        $loginUsername = sanitizeValue($_POST['username']);
        $loginPassword = sanitizeValue($_POST['password']);

        try {
            //$pdo = new PDO('mysql:host=localhost;dbname=bcrypt', 'root', 'root');
            //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Retrieve user from DB and verify against login credentials.
            // Only unique username must be permitted.
            $sql = "
            SELECT username, password
            FROM users
            WHERE username = '$loginUsername'
            ";

            $stm = $pdo->query($sql, PDO::FETCH_ASSOC);

            if ( $stm->rowCount() == 1 ) {
                $pdo = null;
                $userRecord = $stm->fetch();

                // One record has matched, so let's authenticate user. 
                if ( password_verify($loginPassword, $userRecord['password']) ) {
                    // User authenticated.
                    // Time to save user in a seesion variable.
                    $_SESSION['username'] = $loginUsername;

                    // Now redirect user to the welc page.
                    header('Location: index.php');
                } else {
                    die("Unable to authenticate.");
                }
            } else {
               die("Sorry, could not verify account.");
            }
        } catch (PDOException $e) {
            die ( $e->getMessage() );
        }    
    }
?>


<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>

    <body class="w3-container w3-margin-left">
        <div class="w3-card w3-light-gray">
            <header class="w3-container w3-red w3-margin-top">
                <h1>Login Form</h1>
            </header>

            <form action="<?php echo $phpScript; ?>" method="POST" class="w3-container">
            <p><!-- username -->
                    <label class="w3-text-dark-grey">Username</label>
                    <span class="w3-text-red"> *</span>
                    <input required name="username" placeholder="username" value="<?php echo $username; ?>" class="w3-input w3-border">
                </p>
                <p><!-- password -->
                    <label class="w3-text-dark-grey">Password</label>
                    <span class="w3-text-red"> *</span>
                    <input required type="password" name="password" placeholder="password" value="<?php echo $password; ?>" class="w3-input w3-border">
                </p>
                <p> <!-- login -->
                    <button name="submit" class="w3-btn w3-red">Login</button>
                </p>
            </form>

            <h2 class="w3-container w3-text-red"><?php echo $errorMessage; ?></h2>
        </div>

        <form>
            <p> <!-- create account -->
                No account yet? <a href="signUp.php"> Sign Up!</a>
            </p>
        </form>


        <footer text-align: center></br>&copy; <?php echo $curYear; ?> <b>TaskList</b> </footer>
    </body>
</html>