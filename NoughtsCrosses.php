<?php
include "db.php";

 $stdin = "";

class NoughtsCrosses{

    // Setting the vars that will carry the total amount of wins for each outcome
    var $x = 0;
    var $o = 0;
    var $d = 0;


    //Create the database table if it doesn't exist on the user's end already
    //Should check for the table existing already but not necessary for this small app 
    function add_table(){
        global $connection;
        $query = "CREATE TABLE `game`.`games` ( `id` INT(12) NOT NULL AUTO_INCREMENT , `winner` VARCHAR(32) NOT NULL , `outcome` VARCHAR(32) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        $result = mysqli_query($connection, $query);
    }
    

    // This will add a single game to the db 
    function add_game($singleWinner, $singleOutcome){
        global $connection;
        $query = "INSERT INTO games (winner, outcome) VALUES ('$singleWinner', '$singleOutcome')";
        $result = mysqli_query($connection, $query);
    }

    function calculate_single_input($x, $o, $d){
        echo "X Wins: " . $x . "<br>";
        echo "O Wins: " . $o . "<br>";
        echo "Draws: " . $d . "<br>";
    }
    
    function get_aggregate_results(){

        if (isset($_POST['aggregate'])){

        global $connection;

        // Count All X Wins 
        $query = "SELECT COUNT(*) FROM games WHERE winner = 'x'";
        $resultX = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($resultX)){
                $countX = print_r("<li>Number of X Wins: " . $row[0] . "</li>");
         }

         // Count All O Wins 
        $query = "SELECT COUNT(*) FROM games WHERE winner = 'o'";
        $resultO = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($resultO)){
                $countO = print_r("<li>Number of 0 Wins: " . $row[0] . "</li>");
         }

         // Count All Draws 
        $query = "SELECT COUNT(*) FROM games WHERE winner = 'draw'";
        $resultD = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($resultD)){
                $countD = print_r("<li>Number of Draws: " . $row[0] . "</li>");
         }
   }

        
    }

    // Create the function that calculate the winners of the input
    function calculate_winners($stdin){

        if (isset($_POST['single'])){

        // Setting the stdin to the value input by the user    
        $stdin = $_POST['input'];

        // Getting the vars that will store the total wins
        global $x;
        global $o;
        global $d; 

        // Replacing all line breaks with nothing so we get one big long string with all results inside
        $stdin = str_replace("\\n","",$stdin);
        
        // create a variable equal to the length of the string so that we can separate out individual games easily
        $length = strlen($stdin);

        // loop through the entire input (here $i is set as individual moves as this point)
        for ($i=1; $i<=$length; $i++) {

             if ($i % 9 === 0){

                    // Separate out each individual 9 game move and set it to the $outcome var
                    $outcome = substr($stdin, $i-9, 9);

                    // Calculate the outcome of the winner of each 9 move game
                    // Probably an ineffient way to do this **REVISIT**
                    if ($outcome[0] === "x" && $outcome[1] === "x" && $outcome[2] === "x"){
                        $winner = "x";
                        self::add_game($winner, $outcome);
                        $x++;
                    }  else if ($outcome[3] === "x" && $outcome[4] === "x" && $outcome[5] === "x"){
                        $winner = "x";
                        self::add_game($winner, $outcome);
                        $x++;
                    }  else if ($outcome[6] === "x" && $outcome[7] === "x" && $outcome[8] === "x"){
                        $winner = "x";
                        self::add_game($winner, $outcome);
                        $x++;
                    }  else if ($outcome[0] === "x" && $outcome[3] === "x" && $outcome[6] === "x"){
                        $winner = "x";
                        self::add_game($winner, $outcome);
                        $x++;
                    }  else if ($outcome[1] === "x" && $outcome[4] === "x" && $outcome[7] === "x"){
                        $winner = "x";
                        self::add_game($winner, $outcome);
                        $x++;
                    }  else if ($outcome[2] === "x" && $outcome[5] === "x" && $outcome[8] === "x"){
                        $winner = "x";
                        self::add_game($winner, $outcome);
                        $x++;
                    }  else if ($outcome[0] === "x" && $outcome[4] === "x" && $outcome[8] === "x"){
                        $winner = "x";
                        self::add_game($winner, $outcome);
                        $x++;
                    }  else if ($outcome[2] === "x" && $outcome[4] === "x" && $outcome[6] === "x"){
                        $winner = "x";
                        self::add_game($winner, $outcome);
                        $x++;
                    } else if ($outcome[0] === "o" && $outcome[1] === "o" && $outcome[2] === "o"){
                        $winner = "o";
                        self::add_game($winner, $outcome);
                        $o++;
                    }  else if ($outcome[3] === "o" && $outcome[4] === "o" && $outcome[5] === "o"){
                        $winner = "o";
                        self::add_game($winner, $outcome);
                        $o++;
                    }  else if ($outcome[6] === "o" && $outcome[7] === "o" && $outcome[8] === "o"){
                        $winner = "o";
                        self::add_game($winner, $outcome);
                        $o++;
                    }  else if ($outcome[0] === "o" && $outcome[3] === "o" && $outcome[6] === "o"){
                        $winner = "o";
                        self::add_game($winner, $outcome);
                        $o++;
                    }  else if ($outcome[1] === "o" && $outcome[4] === "o" && $outcome[7] === "o"){
                        $winner = "o";
                        self::add_game($winner, $outcome);
                        $o++;
                    }  else if ($outcome[2] === "o" && $outcome[5] === "o" && $outcome[8] === "o"){
                        $winner = "o";
                        self::add_game($winner, $outcome);
                        $o++;
                    }  else if ($outcome[0] === "o" && $outcome[4] === "o" && $outcome[8] === "o"){
                        $winner = "o";
                        self::add_game($winner, $outcome);
                        $o++;
                    }  else if ($outcome[2] === "o" && $outcome[4] === "o" && $outcome[6] === "o"){
                        $winner = "o";
                        self::add_game($winner, $outcome);
                        $o++;
                    }  else {
                        $winner = "draw";
                        self::add_game($winner, $outcome);
                        $d++;
                    } 
                }
            }
            
            // End of for loop for individual input
            // This will take the amount of wins and call a function that will display to the end user
            // No need for SQL input at this point as this information is just displayed and then not needed
            // All relevant information has already been added to the db 
            self::calculate_single_input($x, $o, $d);
            }
        }


        // Runs the function that will clear the db of all results
        function clear_all(){

        if (isset($_POST['clear'])){
        global $connection;

        // Clear all entries
        $query = "DELETE FROM games";
        $result = mysqli_query($connection, $query);
        }
    }
}


$class = new NoughtsCrosses;

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Noughts & Crosses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    </head>

    <body>
    <div class="container">

    </div>
    </body>

    <footer style="margin-top: 50px;">
        <h4>Noughts & Crosses</h4>

        <form action="NoughtsCrosses.php" method="post">
            <textarea rows="4" cols="50" name="input" placeholder="Input Raw Game Text Here"></textarea><br><br>
            <input type="submit" name="single" class="btn btn-primary" value="Get Single Input Results">
            <input type="submit" name="aggregate" class="btn btn-primary" value="Get Aggregate Results">
            <input type="submit" name="clear" class="btn btn-primary" value="Clear All">
        </form>

        <br><br>
        <?php
        ?><h4 style=margin-top:25px;>Single Input Results:</h4><?php
        $class->calculate_winners($stdin);

        ?><h4 style=margin-top:25px;>Aggregate Results:</h4><?php
        $class->get_aggregate_results();
        ?>

        <?php $class->clear_all(); ?>

    </footer>
