<?php
session_start();
?>

<?php

// get the index of the row containing the item to be removed from the order cart
$answer = $_POST['index'];

// reindex array
$array = array_values($_SESSION["addedItems"]);

// store the reindexed array in the session array representing the order cart
$_SESSION["addedItems"] = $array;

// convert the index string to a number used for array accessing
$i = intval($answer);
$i--;

// use it as the index below to remove the desired item from the order cart
unset($_SESSION["addedItems"][$i]);

// reindex the array again after deleting the item
$array = array_values($_SESSION["addedItems"]);

// store the reindexed array again
$_SESSION["addedItems"] = $array;
?>