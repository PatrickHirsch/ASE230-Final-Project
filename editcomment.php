<?php
session_start();
require_once('./lib/functions.php');
require_once('./header.php');
require_once('db/db.php');

if (!isset($_GET['commentid'])) {
    $isError = 'the comment id is invalid';
} else{
    $selectedComment = getComment($pdo, $_GET['commentid']); // Update variable name to match the query parameter
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
    // Check if the form field 'messageUpdate' is set and not empty
    if (isset($_POST['messageUpdate']) && !empty($_POST['messageUpdate'])) {
        // Retrieve data from form submission
        $messageUpdate = $_POST['messageUpdate'];
        $timestamp = date('Y-m-d H:i:s'); // Current timestamp

        // Prepare the SQL query
        $UpdateStmt = $pdo->prepare("UPDATE comments SET message = ?, timestamp = ? WHERE ID = ?");

        // Execute the query with provided values
        $UpdateStmt->execute([$messageUpdate, $timestamp, $_POST['comment_id']]);
        header("Location: image.php?photoid=".$selectedComment['image_ID']."/");
        $_SESSION['success_message'] = "Comment updated successfully!";
    } else {
        echo "Please enter a comment!";
    }
}
    elseif (isset($_POST['delete'])) {
        // Prepare and execute the query to delete the comment
        $deleteStmt = $pdo->prepare("DELETE FROM comments WHERE ID = ?");
        $deleteStmt->execute([$selectedComment['ID']]);
        
        header("Location: image.php?photoid=" . $selectedComment['image_ID']);
        $_SESSION['success_message'] = "Comment deleted successfully!";
    }
}

echo echoHeader('Edit Comment');
if ($selectedComment) {
    $thisCommentID = $selectedComment['ID'];
    echo '<div>
    <form method="POST">
    <div class="form-group">
    <label for="editCommentSection">Comment:</label>
    <input type="hidden" name="comment_id" value="' . $thisCommentID . '">
    <textarea class="form-control" name="messageUpdate" id="commentTextarea" rows="3">'.$selectedComment['message'].'</textarea>
    </div>

    <button type="submit" class="btn btn-primary" name="submit">submit</button>
    <button type="submit" class="btn btn-secondary align-right" name="delete">Delete</button>
    </form>
    </div>';
}
echo echoFooter();
?>

