<?php

include 'config.php';

function getAllWorkouts() {
    global $conn;
    $result = $conn->query("SELECT * FROM Workouts");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getAllRoutines() {
    global $conn;
    $result = $conn->query("SELECT * FROM Routines");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getWorkoutsInRoutine($routineId) {
    global $conn;
    $stmt = $conn->prepare("SELECT Workouts.* FROM Workouts
        INNER JOIN Routines ON Workouts.workout_id = Routines.workout_id
        WHERE Routines.user_id = ?");
    $stmt->bind_param("i", $routineId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function createRoutine($selectedWorkouts) {
    global $conn;

    // Create a new routine
    $routineName = 'Routine ' . date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO Routines (routine_name) VALUES (?)");
    $stmt->bind_param("s", $routineName);
    $stmt->execute();
    $routineId = $conn->insert_id;

    // Check if routine creation is successful
    if (!$routineId) {
        // Handle error, perhaps log it
        return;
    }

    // Associate selected workouts with the routine
    foreach ($selectedWorkouts as $workoutId) {
        $stmt = $conn->prepare("INSERT INTO RoutineWorkouts (routine_id, workout_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $routineId, $workoutId);
        $stmt->execute();
    }
}

function getRoutineName($routineId) {
    global $conn;
    $stmt = $conn->prepare("SELECT routine_name FROM Routines WHERE routine_id = ?");
    $stmt->bind_param("i", $routineId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['routine_name'];
}

function getAllRoutinesForUser($userId) {
    global $conn;
    $stmt = $conn->prepare("SELECT routine_id, routine_name FROM Routines WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// This function is for the profile that shows your top 5 best PRs
function showStatistics() {
    global $conn;
    $result = $conn->query("SELECT workout_name, Routines.volume as pr
                            FROM Workouts
                            JOIN Routine ON Workouts.workout_id = Routine.workout_id
                            ORDER BY pr DESC LIMIT 5");
    return $result->fetch_all(MYSQLI_ASSOC);
}

?>
