<?php

include 'config.php';

function getAllWorkouts() {
    global $conn;
    $result = $conn->query("SELECT * FROM workouts");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getAllRoutines() {
    global $conn;
    $result = $conn->query("SELECT * FROM routines");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function createRoutine($selectedWorkouts) {
    global $conn;

    // Create a new routine
    $routineName = 'Routine ' . date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO routines (routine_name) VALUES (?)");
    $stmt->bind_param("s", $routineName);
    $stmt->execute();
    $routineId = $conn->insert_id;

    // Check if routine creation is successful
    if (!$routineId) {
        // Handle error, perhaps log it
        return;
    }
}

function getRoutineName($routineId) {
    global $conn;
    $stmt = $conn->prepare("SELECT routine_name FROM routines WHERE routine_id = ?");
    $stmt->bind_param("i", $routineId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['routine_name'];
}

function getAllRoutinesForUser($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT routine_id, routine_name, user_id FROM routines WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getRoutineById($routineId) {
    global $conn;
    
    // Fetch routine details
    $stmt = $conn->prepare("SELECT * FROM routines WHERE routine_id = ?");
    $stmt->bind_param("i", $routineId);
    $stmt->execute();
    $result = $stmt->get_result();
    $routine = $result->fetch_assoc();
    
    return $routine;
}

function getUserById($user_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `user_id`=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    return $user;
}

function getCompletedWorkouts($userId) {
    global $conn;

    return 0;
}

function saveRoutineWorkout($routineWorkout) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM `routine_workouts` WHERE `routine_id`=? AND `workout_id`=?");
    $stmt->bind_param("ii", $routineWorkout['routine_id'], $routineWorkout['workout_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows==0) {
        $stmt = $conn->prepare("INSERT INTO `routine_workouts` (`routine_id`, `workout_id`, `rows`) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $routineWorkout['routine_id'], $routineWorkout['workout_id'], $routineWorkout['rows']);
        $success = $stmt->execute();
    } else {
        $stmt = $conn->prepare("UPDATE `routine_workouts` SET `rows`=? WHERE `routine_id`=? AND `workout_id`=?");
        $stmt->bind_param("iii", $routineWorkout['rows'], $routineWorkout['routine_id'], $routineWorkout['workout_id']);
        $success = $stmt->execute();
    }
    $stmt->close();
    return $success;
}

function saveWorkoutData($workoutData) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM `workout_data` WHERE `num`=? AND `routine_id`=? AND `user_id`=? AND `workout_id`=?");
    $stmt->bind_param("iiii", $workoutData['num'], $workoutData['routine_id'], $workoutData['user_id'], $workoutData['workout_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows==0) {
        $stmt = $conn->prepare("INSERT INTO `workout_data` (`num`, `routine_id`, `user_id`, `workout_id`, `reps`, `volume`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiiii", $workoutData['num'], $workoutData['routine_id'], $workoutData['user_id'], $workoutData['workout_id'], $workoutData['reps'], $workoutData['volume']);
        $success = $stmt->execute();
    } else {
        $stmt = $conn->prepare("UPDATE `workout_data` SET `reps`=?, `volume`=? WHERE `num`=? AND `routine_id`=? AND `user_id`=? AND `workout_id`=?");
        $stmt->bind_param("iiiiii", $workoutData['reps'], $workoutData['volume'], $workoutData['num'], $workoutData['routine_id'], $workoutData['user_id'], $workoutData['workout_id']);
        $success = $stmt->execute();
    }
    $stmt->close();
    return $success;
}

function getRoutineWorkouts($routineId) {
    global $conn;

    $stmt = $conn->prepare("SELECT `routine_id`, `workout_id`, `rows` FROM `routine_workouts` WHERE `routine_id`=?");
    $stmt->bind_param("i", $routineId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
function getWorkout($workoutId) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM `workouts` WHERE `workout_id`=?");
    $stmt->bind_param("i", $workoutId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getWorkoutData($routineId, $userId, $workoutId) {
    global $conn;

    $stmt = $conn->prepare("SELECT `num`, `workout_id`, `reps`, `volume` FROM `workout_data` WHERE `routine_id`=? AND `user_id`=? AND `workout_id`=? GROUP BY `num` ASC");
    $stmt->bind_param("iii", $routineId, $userId, $workoutId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function deleteRoutineWorkout($routineWorkout, $userId) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM `routine_workouts` WHERE `routine_id`=? AND `workout_id`=?");
    $stmt->bind_param("ii", $routineWorkout['routine_id'], $routineWorkout['workout_id']);
    $success = $stmt->execute();
    
    $stmt = $conn->prepare("DELETE FROM `workout_data` WHERE `routine_id`=? AND `workout_id`=? AND `user_id`=?");
    $stmt->bind_param("iii", $routineWorkout['routine_id'], $routineWorkout['workout_id'], $userId);
    $success = $stmt->execute();

    $stmt->close();
    return $success;
}

function deleteExcessRows($routineWorkout, $userId) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM `workout_data` WHERE `routine_id`=? AND `workout_id`=? AND `user_id`=? AND `num`>?");
    $stmt->bind_param("iiii", $routineWorkout['routine_id'], $routineWorkout['workout_id'], $userId, $routineWorkout['rows']);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

function deleteAllRows($routineId, $userId) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM `workout_data` WHERE `routine_id`=? AND `user_id`=?");
    $stmt->bind_param("ii", $routineWorkout['routine_id'], $userId);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

function deleteUser($userId) {
    global $conn;

    // Delete associated records in routines table
    $sql_delete_routines = "DELETE FROM routines WHERE user_id = ?";
    $stmt_delete_routines = $conn->prepare($sql_delete_routines);
    $stmt_delete_routines->bind_param("i", $userId);
    
    if (!$stmt_delete_routines->execute()) {
        // Handle error if deletion fails
        return false;
    }

    // Delete associated records in routine_workouts table
    $sql_delete_workouts = "DELETE FROM routine_workouts WHERE user_id = ?";
    $stmt_delete_workouts = $conn->prepare($sql_delete_workouts);
    $stmt_delete_workouts->bind_param("i", $userId);
    
    if (!$stmt_delete_workouts->execute()) {
        // Handle error if deletion fails
        return false;
    }

    // Delete the user from the users table
    $sql_delete_user = "DELETE FROM users WHERE user_id = ?";
    $stmt_delete_user = $conn->prepare($sql_delete_user);
    $stmt_delete_user->bind_param("i", $userId);

    if ($stmt_delete_user->execute()) {
        return true; // Return true if deletion was successful
    } else {
        // Handle error if deletion fails
        return false;
    }
}

function getAllUsersExcept($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT `user_id`, `firstname`, `lastname` FROM `users` WHERE `user_id`!=?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function savePost($post) {
    global $conn;

    if(!isset($post['id'])) {
        $stmt = $conn->prepare("INSERT INTO `posts` (`user_id`, `content`) VALUES (?,?)");
        $stmt->bind_param("is", $post['user_id'], $post['content']);
        $success = $stmt->execute();

        $stmt = $conn->prepare("SELECT `user_id` FROM `posts` WHERE `user_id`=? AND `content`=? GROUP BY `created_at` ASC");
        $stmt->bind_param("is", $post['user_id'], $post['content']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_column();
    } else {
        $stmt = $conn->prepare("UPDATE `posts` SET `content`=? WHERE `id`=?");
        $stmt->bind_param("si", $post['content'], $post['id']);
        $success = $stmt->execute();
        $stmt->close();
        return $post['id'];
    }
}

function getComments($postId) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT `id`, `user_id`, `content` FROM `comments` WHERE `post_id`=?");
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getPost($postId) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT `user_id`, `content` FROM `posts` WHERE `post_id`=?");
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc();
}

function saveComment($comment) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO `comments` (`user_id`, `content`) VALUES (?,?)");
    $stmt->bind_param("is", $comment['user_id'], $comment['content']);
    $success = $stmt->execute();
    $stmt->close();
}
?>
