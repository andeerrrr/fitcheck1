<?php
session_start();
include 'functions.php';

//Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: login_index.php");
    exit();
} 

// Handle routine creation form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createRoutine'])) {
    if (isset($_POST['selectedWorkouts']) && !empty($_POST['selectedWorkouts'])) {
        $selectedWorkouts = $_POST['selectedWorkouts'];
        createRoutine($selectedWorkouts);
    }
}

// Get all workouts
$workouts = getAllWorkouts();

// Get all saved routines for the logged-in user
// $routines = getAllRoutinesForUser($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workouts and Routines</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Workouts</h2>

    <form action="" method="post">
        <ul>
            <?php
            foreach ($workouts as $workout) {
                echo "<div class='workout'>";
                echo "<img src='{$workout['image_url']}' alt='{$workout['workout_name']}'>";
                echo "<h3>{$workout['workout_name']}</h3>";
                echo "<button class='add-button' type='button'>+</button>";
                echo "<div class='description'>{$workout['workout_description']}</div>";
                echo "</div>";
            }
            ?>
        </ul>
        <button type="submit" name="createRoutine">Create Routine</button>
    </form>

    <h2>Saved Routines</h2>

    <ul>
        <?php
            if (isset($routines) && is_array($routines)) {
                foreach ($routines as $routine) {
                    echo "<li>{$routine['routine_name']} - <a href='view_routine.php?routine_id={$routine['routine_id']}'>View Routine</a></li>";
                }
            } else {
                echo "<p>No routines available.</p>";
            }
        ?>  
    </ul>

    <!-- Link to the Add to Session page -->
    <a href="add_to_session.php">Add Workouts to Session</a>

</body>
</html>
