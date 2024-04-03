<?php
session_start();
include 'functions.php';

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Get user's profile information
$userId = $_SESSION['user_id'];
$user = getUserById($userId);

$post = null;
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post'])) {
    $post = array(
        "user_id"=>$userId,
        "content"=>$_POST['postField']
    );
    $post["id"] = savePost($post);
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $postId = $_POST['commentField'];
    $comment = array(
        "user_id"=>$userId,
        "content"=>$postId
    );
    saveComment($comment);
    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <script>
            var profiles = <?php
                $users = getAllUsersExcept($userId);
                $tempArray = [];
                foreach($users as $tempUser) {
                    $tempArray[] = array_values($tempUser);
                }
                echo json_encode($tempArray);
            ?>;

            function initialize() {
                document.getElementById("searchBar").addEventListener("keydown", function(event) {
                    var resultDiv = document.getElementById("searchResult");
                    resultDiv.innerHTML = "";
                    var enteredKey = event.target.value.trim().toLowerCase();
                    if(enteredKey.length>1) {
                        for(var i = 0; i<profiles.length; i++) {
                            if(profiles[i][1].toLowerCase().includes(enteredKey)) {
                                var profile = document.createElement("a");
                                profile.href = "localhost/fitcheck1/profile.php?profile=" + profiles[i][0];
                                profile.textContent = profiles[i][1] + " " + profiles[i][2];
                                resultDiv.appendChild(profile);
                            }
                        }
                    }
                });
            }

            window.onload = initialize;
        </script>
    </head>
    <body>
        <div>
            <input type="text" name="searchKey" id="searchBar" placeholder="Search someone...">
            <div class="searchResult" id="searchResult"></div>
        </div>
        <br>
        <div class="profile-picture">
            <img src="<?php echo $profile_picture; ?>" alt="Profile Picture">
            <p><?php echo $user['firstname']." ".$user['lastname'] ?></p>
        </div>
        <div class="scrollDiv">
            <div class="userPost">
                <form action="" method="post">
                    <input type="text" name="postField" id="postField" placeholder="Say something...">
                    <input type="submit" value="Post" name="post">
                </form>
            </div>
            <form action="" method="post">
                <input type='hidden' name='selectedPost' id='selectedPost' value=-1>
                <?php
                    if($post!=null) {
                        $targetUser = getUserById($post['user_id']);
                        echo "<img src=".$targetUser['profile_picture']." alt='Profile Picture'>";
                        echo "<p><b>".$targetUser['firstname']." ".$targetUser['lastname']."</b><br>";
                        echo $post['content']."</p>";
                        echo "<br><div id=commentDiv".$post['id'].">";
                        $comments = getComments($post['id']);
                        foreach($comments as $comment) {
                            $tempUser = getUserById($comment['user_id']);
                            echo "<p><b>".$tempUser['firstname']." ".$tempUser['lastname'].": </b>".$comment['content']."</p>";
                        }
                        echo "</div>";
                        echo "<input type='text' name='commentField' id='commentField' placeholder='Enter comment...'>";
                        echo "<input type='submit' value='Comment' name='comment'>";
                    }
                ?>
            </form>
        </div>
    </body>
</html>