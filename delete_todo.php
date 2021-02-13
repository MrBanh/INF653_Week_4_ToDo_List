<?php
require ("database.php");

$itemNum = filter_input(INPUT_POST, 'ItemNum', FILTER_VALIDATE_INT);

if ($itemNum) {
    $query = 'DELETE FROM todoitems
                WHERE ItemNum = :itemNum';
    $statement = $db->prepare($query);
    $statement->bindValue(':itemNum', $itemNum);
    $success = $statement->execute();
    $statement->closeCursor();
}

$deletedTodo = true;

include("index.php");
?>