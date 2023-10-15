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
    $uploadDirectory = $homeDir . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $userID;

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory);
    }

    // Move the uploaded file to the specified directory
    if (!move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $uploadDirectory . DIRECTORY_SEPARATOR . $filename)) {
        return ['success' => false, 'message' => 'Failed to move the uploaded file.'];
    }
    $data['url'] = 'data' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $userID . DIRECTORY_SEPARATOR . $filename;

    $photosJsonLink = $homeDir.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'images.json';
    $photosJsonString = file_get_contents($photosJsonLink);

    $photosJsonArray = json_decode($photosJsonString, true);
    $photosJsonArray[] = $data;

    $updatedData = json_encode($photosJsonArray, JSON_PRETTY_PRINT);
    file_put_contents($photosJsonLink, $updatedData);
    return ['success' => true, 'filename' => $filename];
}


/**
 * identifies and delete an uploaded image including the json entry.
 *
 * @param string $photoId photo ID as found in images.json
 *
 * @return array Associative array containing the 'success' status (boolean) and a message or filename.
 */
function deleteImage($photoId) {
    // home dir relative to this file being in ./lib
    $homeDir = dirname(__DIR__);
    $photosJsonLink = $homeDir.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'images.json';
    $jsonString = file_get_contents($photosJsonLink);
    $jsonArray = json_decode($jsonString, true);

    $indexToRemove = null;

    // filters the photoId from the photo name
    if (preg_match('/image_(.*?)\./', $photoId, $matches)) {
        $photoId = $matches[1];
    }

    // finds and deletes the photo file
    foreach ($jsonArray as $index => $data) {
        if ($data['id'] === $photoId) {
            $photoLink = $homeDir.DIRECTORY_SEPARATOR.$data['url'];
            unlink($photoLink);
            $indexToRemove = $index;
            break;
        }
    }

    if ($indexToRemove === null) {
        return ['success' => false, 'message' => 'No file of the name provided was found'];
    }

    unset($jsonArray[$indexToRemove]);
    $updatedData = json_encode($jsonArray, JSON_PRETTY_PRINT);
    file_put_contents($photosJsonLink, $updatedData);
    return ['success' => true, 'message' => 'File deleted successfully'];
}

