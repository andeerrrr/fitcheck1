<?php
session_start();

include 'functions.php';

if (isset($_GET['routine_id'])) {
    $routineId = $_GET['routine_id'];
    $routineName = getRoutineName($routineId);
    $workoutsInRoutine = getWorkoutsInRoutine($routineId);
} else {
    // Handle invalid routine ID
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Routine</title>
</head>
<body>

    <h2><?php echo $routineName; ?></h2>

    <ul>
        <?php
        foreach ($workoutsInRoutine as $workout) {
            echo "<li>{$workout['workout_name']} - {$workout['workout_description']}</li>";
        }
        ?>
    </ul>

</body>
</html>
