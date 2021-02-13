<?php
    $newTitle = filter_input(INPUT_POST, "newTitle", FILTER_SANITIZE_STRING);
    $newDescription = filter_input(INPUT_POST, "newDescription", FILTER_SANITIZE_STRING);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <link rel="stylesheet" href="src/css/main.min.css">
</head>
<body>
    <main>
        <?php
            if (isset($deletedTodo)) {
                echo "Task Completed!<br><br>";
            }
        ?>

        <section aria-label="List of To Do Items" class="toDoList">
            <h1>ToDo List</h1>

            <?php require("database.php"); ?>

            <!-- Handle the logic to insert todo item into database -->
            <?php
                if ($newTitle && $newDescription) {
                    $query = "INSERT INTO todoitems (Title, Description)
                                VALUES (:newTitle, :newDescription)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':newTitle', $newTitle);
                    $statement->bindValue(':newDescription', $newDescription);
                    $statement->execute();
                    $statement->closeCursor();
                }
            ?>

            <!-- Handle the logic to get all todo items from database -->
            <?php
                $query = "SELECT * FROM todoitems ORDER BY ItemNum ASC";
                $statement = $db->prepare($query);
                $statement->execute();
                $results = $statement->fetchAll();        // fetch all results in table
                $statement->closeCursor();      // close db connection
            ?>

            <?php if (!empty($results)) { ?>
                <div class="toDoList--container">
                    <ul>
                        <?php foreach ($results as $todo) {
                            $itemNum = $todo['ItemNum'];
                            $title = $todo['Title'];
                            $description = $todo['Description'];
                        ?>
                            <li class="todo--item" id="todo--item-<?php echo $itemNum; ?>">
                                <div class="todo--container">
                                    <p class="todo--title" id="todo--title-<?php echo $itemNum; ?>"><?php echo $title; ?></p>
                                    <p class="todo--description" id="todo--description-<?php echo $itemNum; ?>"><?php echo $description; ?></p>
                                </div>

                                <form action="delete_todo.php" method="POST" class="todo--delete">
                                    <input type="hidden" name="ItemNum" value="<?php echo $itemNum; ?>">
                                    <button class="todo--delete--btn" aria-label="Delete to do">❌</button>
                                </form>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } else { ?>
                <p>No to do list items exist yet.</p>
            <?php } ?>

        </section>

        <section aria-label="Add To Do Item" class="addToDo">
            <h2 class="addToDo--title">Add Item</h2>
            <!-- Form -->
            <form action="." method="POST">
                <div class="form--container">
                    <div class="form--group">
                        <input type="text" name="newTitle" id="newTitle" maxlength="20" placeholder="Title" autocomplete="off" aria-label="Enter a title" class="form--field" aria-required="true" required>
                        <label for="newTitle" class="form--label">Title</label>
                    </div>
                    <div class="form--group">
                        <input type="text" name="newDescription" id="newDescription" maxlength="50" placeholder="Description" autocomplete="off" aria-label="Enter a description" class="form--field" aria-required="true" required>
                        <label for="newDescription" class="form--label">Description</label>
                    </div>
                </div>
                <button type="submit" class="form--submit">Add Item</button>
            </form>
        </section>
    </main>
</body>
</html>