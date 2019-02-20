<?php
// Create the connection to the database we'll be working in
 $connection = mysqli_connect('localhost', 'root', '', 'game');

 // This tests for the connection to return true otherwise inform the user that an error occurred 
if(!$connection){
    die ("Database Error: " . mysqli_error());
}
?>