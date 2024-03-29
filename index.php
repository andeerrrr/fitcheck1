<?php
session_start();
include 'functions.php';

//Check if the user is logged in
if (!isset($_SESSION['login'])) {
    // Redirect to the login page
    header("Location: login.php");
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
$routines = getAllRoutinesForUser($_SESSION['user_id']);
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
    <h1><?php echo $_SESSION['firstname']; ?></h1>

    <!-- Filter form for workouts -->
    <form action="" method="post">
        <label for="category">Filter by Category:</label>
        <select name="category" id="category">
            <option value="">All Categories</option>
            <?php
            // Fetch distinct workout categories from the database
            $categories = array_unique(array_column($workouts, 'workout_category'));
            foreach ($categories as $category) {
                echo "<option value='$category'>$category</option>";
            }
            ?>
        </select>
        <label for="muscle_group">Filter by Muscle Group:</label>
        <select name="muscle_group" id="muscle_group">
            <option value="">All Muscle Groups</option>
            <?php
            // Fetch distinct muscle groups from the database
            $muscle_groups = array_unique(array_column($workouts, 'workout_muscle_group'));
            foreach ($muscle_groups as $muscle_group) {
                echo "<option value='$muscle_group'>$muscle_group</option>";
            }
            ?>
        </select>
        <button type="submit">Filter</button>
    </form>

    <form action="" method="post">
        <ul>
            <?php
            // Filter workouts based on selected category and muscle group
            $filtered_workouts = $workouts; // Initialize with all workouts
            if (isset($_POST['category']) && $_POST['category'] !== '') {
                $category_filter = $_POST['category'];
                $filtered_workouts = array_filter($filtered_workouts, function ($workout) use ($category_filter) {
                    return $workout['workout_category'] === $category_filter;
                });
            }
            if (isset($_POST['muscle_group']) && $_POST['muscle_group'] !== '') {
                $muscle_group_filter = $_POST['muscle_group'];
                $filtered_workouts = array_filter($filtered_workouts, function ($workout) use ($muscle_group_filter) {
                    return $workout['workout_muscle_group'] === $muscle_group_filter;
                });
            }

            foreach ($filtered_workouts as $workout) {
                echo "<div class='workout'>";
                echo "<img src='{$workout['image_url']}' alt='{$workout['workout_name']}'>";
                echo "<h3>{$workout['workout_name']}</h3>";
                echo "<button class='add-button' type='button'>+</button>";
                echo "<div class='description'>{$workout['workout_description']}</div>";
                echo "</div>";
            }
            ?>
        </ul>
    </form>
    <footer><a href="logout.php">logout</a></footer>

</body>
</html>
