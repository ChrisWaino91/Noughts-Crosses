<?php 

include "db.php";

function addPlayer(){

    if(isset($_POST['create'])){

        global $connection;

        // Create the variables that we can work with and set them to the value posted from the inputs in the html
        $playerName = $_POST['player'];
        $playerNumber = $_POST['number'];

        $playerName = mysqli_real_escape_string($connection, $playerName);
        $playerNumber = mysqli_real_escape_string($connection, $playerNumber);

        $hashFormat = "$2y$10$";
        $salt = "iusesomecrazystrings22";
        $hashFormat_and_salt = $hashFormat . $salt;
        $playerName = crypt($playerName, $hashFormat_and_salt);
   

        // Create a variable and set it to the query that will insert information into our db table. 
        // The syntax for this is INSERT INTO [table name]([table_row, table_row]) VALUES (['value to add', 'value to add'])";
        $query = "INSERT INTO players (name, number) VALUES ('$playerName', $playerNumber)";

        // Create a new variable and set it to the actual query function that will add the above
        // The syntax for this is; mysqli_query([variable that the connection has been set to], [variable the query has been set to]))
        $result = mysqli_query($connection, $query);

        if(!$result){
            die ("Query Failed" . mysqli_error($connection));
        } else {
            echo "Record Created Successfully!";
        }
    }
}


function readPlayers(){
    if(isset($_POST['read'])){

        global $connection;

        // Create a variable and set it to the query that will insert information into our db table. 
        
        $query = "SELECT * FROM players";

        // Create a new variable and set it to the actual query function that will add the above
        // The syntax for this is; mysqli_query([variable that the connection has been set to], [variable the query has been set to]))
        $result = mysqli_query($connection, $query);

        if(!$result){
            die ("Query Failed" . mysqli_error($connection));
        } else {
            echo "Read Request Processed Succesfully!";
                // This will loop fetch all of the information contained within $result while there is still something to display
                // The below code will display the results as an associative array
                // If you ran mysqli_fetch_row it would just display the results of each row without the indices 
                while ($row = mysqli_fetch_assoc($result)){?>
                    <pre>
                        <?php print_r($row);?>
                    </pre><?php
                 }
        }
    }
}

function showAllData(){

    // The global keyword will take a variable from outside the function and allow it to be used within
    global $connection;

    $query = "SELECT * FROM players";
    $result = mysqli_query($connection, $query);

    if(!$result){
        die("query failed" . mysqli_error());
    }
    
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
        echo "<option value='$id'>$id</option>";
    }

}



function updatePlayers(){
    if(isset($_POST['update'])){

        global $connection;

         // Create the variables that we can work with and set them to the value posted from the inputs in the html
         $playerName = $_POST['player'];
         $playerNumber = $_POST['number'];
         $id = $_POST['id'];

        // Update the table, players, by setting the player (row in the db returned from the connection) equal to the new variable we have just got from the form input
        // Same for number. Then Where the id that we've got from the input is equal to the id in the db - so we are selecting which ID we wan't to update. 
        $query = "UPDATE players SET name = '$playerName', number = $playerNumber WHERE id = $id";

        // Create a new variable and set it to the actual query function that will add the above
        // The syntax for this is; mysqli_query([variable that the connection has been set to], [variable the query has been set to]))
        $result = mysqli_query($connection, $query);

        if(!$result){
            die ("Query Failed" . mysqli_error($connection));
        } else {
            echo "Update Request Processed Succesfully!";
        }
    }
}




function deletePlayers(){
    if(isset($_POST['delete'])){

        global $connection;

        $id = $_POST['id'];

        $query = "DELETE FROM `players` WHERE `id` = $id";

        $result = mysqli_query($connection, $query);

        if(!$result){
            die ("Query Failed" . mysqli_error($connection));
        } else {
            echo "Player Deleted Successfully";
        }

    }
}




?>