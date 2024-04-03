<?php
    session_start();
    include 'functions.php';
    
    //Check if the user is logged in
    if (!isset($_SESSION['adminlogin'])) {
        // Redirect to the login page
        header("Location: admin_login.php");
        exit();
    } 

    // Check if the form is submitted for deleting a user
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteUser'])) {
        // Retrieve user ID to be deleted
        $deleteUserId = $_POST['deleteUserId'];

        // Delete the user from the database
        $success = deleteUser($deleteUserId);

        if ($success) {
            // Redirect to the same page after deletion
            header("Location: admin_index.php");
            exit();
        } else {
            echo "Failed to delete the user.";
            // Handle the error accordingly
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>List of Users</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Lastname</th>
                <th>Firstname</th>
                <th>Username</th>
                <th>Sex</th>
                <th>Date of Birth</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM users ORDER BY user_id";
                $result = $conn->query($sql);
            
                if ($result->num_rows > 0) { 
                    while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['lastname']; ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['sex']; ?></td>
                <td><?php echo $row['dob']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="deleteUserId" value="<?php echo $row['user_id']; ?>">
                        <button type="submit" name="deleteUser">Delete</button>
                    </form>
                </td>
            </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

    <footer><a href="admin_logout.php">Logout</a></footer>
</body>
</html>
