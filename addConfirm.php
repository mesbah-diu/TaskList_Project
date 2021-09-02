<?php
    $curYear = date('Y');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Record | TaskList</title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    </head>
    <header id=header class="w3-container w3-center w3-text-gray">
    <b><a href='index.php'>HOME</a>&emsp;</b>
    <a href='addRecord.php'>Add Record</a>&emsp;
    <a href='updateRecord.php'>Update Record</a>&emsp;
    <a href='deleteRecord.php'>Delete Record</a>
    </header>
    <body>
        </br></br></br></br></br></br><h1>&emsp;Record added successfully! <a href='addTask.php'>Add Task</a>&emsp;</h1>
        <footer text-align: center></br>&copy; <?php echo $curYear; ?> Edward Prenzler | <b>TaskList</b> </footer>
    </body>
    <footer id=footer class="w3-container w3-center w3-text-gray">&copy; <?php echo $curYear; ?>  TaskList </footer>
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
        header{
            display: block;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100px;
            background-color: #f9e79f;
        }
    </style>
</html>
