<?php

include 'config.php';

function getAllWorkouts() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM Workouts");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllRoutines() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM Routines");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getWorkoutsInRoutine($routineId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT Workouts.* FROM Workouts
        INNER JOIN Routines ON Workouts.workout_id = Routines.workout_id
        WHERE Routines.user_id = ?");
    $stmt->execute([$routineId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createRoutine($selectedWorkouts) {
    global $pdo;

    // Create a new routine
    $routineName = 'Routine ' . date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO Routines (routine_name) VALUES (?)");
    $stmt->execute([$routineName]);
    $routineId = $pdo->lastInsertId();

    // Check if routine creation is successful
    if (!$routineId) {
        // Handle error, perhaps log it
        return;
    }

    // Associate selected workouts with the routine
    foreach ($selectedWorkouts as $workoutId) {
        $stmt = $pdo->prepare("INSERT INTO RoutineWorkouts (routine_id, workout_id) VALUES (?, ?)");
        $stmt->execute([$routineId, $workoutId]);
    }
}
function getRoutineName($routineId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT routine_name FROM Routines WHERE routine_id = ?");
    $stmt->execute([$routineId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['routine_name'];
}

function getAllRoutinesForUser($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT routine_id, routine_name FROM Routines WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
