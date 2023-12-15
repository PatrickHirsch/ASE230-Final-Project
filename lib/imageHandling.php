<?php

/**
 * Collects and processes an uploaded image and enters an images json entry.
 *
 * @param string $fileInputName The name of the photo file.
 * @param string|int $userID id for the user.
 * @param array &$data Associative array of json data
 *
 * @return array Associative array containing the 'success' status (boolean) and a message or filename.
 */
function collectImage($fileInputName, $userID, &$data) {
	// Check if the file was uploaded without errors
    if ($_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'File upload error.'];
    }
	
    // Check if the file size is less than or equal to 100,000 bytes (100 KB)
    if ($_FILES[$fileInputName]['size'] > 2000000) {
        return ['success' => false, 'message' => 'The uploaded image is too large.'];
    }

    // Check if the uploaded file is an image
    $mimeTypes = ['image/jpeg', 'image/png', 'image/gif']; // Add more if needed
    $fileMimeType = mime_content_type($_FILES[$fileInputName]['tmp_name']);

    if (!in_array($fileMimeType, $mimeTypes)) {
        return ['success' => false, 'message' => 'The uploaded file is not an image.'];
    }

    // Generate a unique filename to avoid overwriting existing files
    $filename = 'image_' . $data['id'] . '.' . pathinfo($_FILES[$fileInputName]['name'], PATHINFO_EXTENSION);
    $homeDir = dirname(__DIR__);
    $uploadDirectory = $homeDir . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'images';

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory);
    }

    // Move the uploaded file to the specified directory
    if (!move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $uploadDirectory . DIRECTORY_SEPARATOR . $filename)) {
        return ['success' => false, 'message' => 'Failed to move the uploaded file.'];
    }
    $data['url'] = 'data' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $userID . DIRECTORY_SEPARATOR . $filename;
	
    return ['success' => true, 'filename' => $filename];
}


