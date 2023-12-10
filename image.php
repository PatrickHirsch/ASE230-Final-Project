<?php
session_start();
require_once('./lib/functions.php');
require_once('./header.php');
require_once('db/db.php');


$stmt = $pdo->prepare("SELECT * FROM comments where image_ID = ?");
$InsertStmt = $pdo ->prepare('INSERT INTO comments (ID, user_ID, image_ID,message,timestamp) VALUES (?, ?, ?,?,?)');
$isError=null;

displaySessionMessage();

if(!isset($_GET['photoid']))
{	$isError='the photo id is invalid';
}
else
{	$selectedImage=getImage($pdo,$_GET['photoid']);
	if(!$selectedImage) $isError='photo couldn\'t be found';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form field 'message' is set and not empty
    if (isset($_POST['message']) /*&& !empty($_POST['commentTextarea'])*/) {
        // Retrieve data from form submission
        $userID = $_SESSION['user_id']; 
        $imageID = $selectedImage['ID']; 
        $message = $_POST['message'];
        $timestamp = date('Y-m-d H:i:s'); // Current timestamp

        // Prepare the SQL query
        $insertStmt = $pdo->prepare("INSERT INTO comments (user_id, image_id, message, timestamp ) VALUES (?, ?, ?, ?)");

        // Execute the query with provided values
        $insertStmt->execute([$userID, $imageID, $message, $timestamp]);

        echo "Comment added successfully!";
    } else {
        echo "Please enter a comment!";
    }
}

if($isError===null)
{	echo echoHeader('Selected Photo: ' . $selectedImage['name']);

	$isAuthenticatedUser=false;
	if(isset($_SESSION['user_id']))
		if($_SESSION['user_id']==$selectedImage['owner_ID'])
			$isAuthenticatedUser=true;
	echo generateAlbumSquare($pdo,$selectedImage,'.',false,$isAuthenticatedUser);
	//call function to generate form allowing users to post comments.
	echo commentSectionForm($pdo, $selectedImage, $isAuthenticatedUser);
	echo generateCommentSection($pdo, $selectedImage);
}
else
{	echo echoHeader($isError);;
}
?>


<?= echoFooter() ?>