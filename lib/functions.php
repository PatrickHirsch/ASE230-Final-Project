<?php
function importJSON($filePath)
{	$contents=file_get_contents($filePath);
	if(strpos($contents,"<?php")===0)
	{	$contents=explode("\n",$contents);
		array_shift($contents);
		$contents=implode("\n",$contents);
	}
	return json_decode($contents,true);
}

function writeJSON($newArray,$filePath)
{	$contents="<?php die('Insufficient permissions'); ?>\n".json_encode($newArray);
	file_put_contents($filePath,$contents);
}



function generateAlbum($rootPath='.')
{	$imagesArray=importJSON($rootPath.'/data/images.json');
	
	$ret='
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    ';
	foreach($imagesArray as $img) $ret=$ret.generateAlbumSquare($img,$rootPath);
	$ret=$ret.'
                </div>
            </div>
        </section>
	';
	return $ret;
}

function generateUserAlbum($userID,$rootPath='.')
{	$imagesArray=importJSON($rootPath.'/data/images.json');
	
	$ret='
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    ';
	foreach($imagesArray as $img) 
		if($img['owner']==$userID)
			$ret=$ret.generateAlbumSquare($img,$rootPath);
	
	$ret=$ret.'
                </div>
            </div>
        </section>
	';
	return $ret;
}

function generateAlbumSquare($img,$rootPath='.')
{	$ret='
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <!-- div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div -->
                            <!-- Product image-->
                            <img class="card-img-top" src="'.$rootPath.'/data/users/'.$img['owner'].'/'.$img['filename'].'" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">'.$img['name'].'</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">';
	for($star=1;$star<=$img['rating'];$star++)	$ret=$ret.'<div class="bi-star-fill"></div>';
	$ret=$ret.'</div>
                                    <!-- Product price-->
                                    <a class="text-muted" href="user.php?id='.$img['owner'].'">'.getUserName($img['owner']).'</a>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View image</a></div>
                            </div>
                        </div>
                    </div>
	';
	return $ret;
}

function getUserObject($lookup,$field='ID')
{	$allUsers=importJSON('data/users.json');
	foreach($allUsers as $user)
		if($user[$field]==$lookup)
			return $user;
	return null;
}

function getUserName($userID)
{	return getUserObject($userID)['name'];
}

function getImageObject($lookup,$field='ID')
{	$allImages=importJSON('data/images.json');
	foreach($allImages as $img)
		if($img[$field]==$lookup)
			return $img;
	return null;
}

function getImageObjects($lookup,$field='owner')
{	$allImages=importJSON('data/images.json');
	$ret=[];
	foreach($allImages as $img)
		if($img[$field]==$lookup)
			$ret[]=$img;
	return $ret;
}

function getUsersPhotos($userID)
{	$allImages=importJSON('data/images.json');
			//foreach image, if ownerID==userID add to $ret
	return $allImages;
}

function generateUserCard()
{	
	$userData=importJSON('data/users.json');
	
	foreach ($userData as $user) {
        $status = $user['status'];
        if ($status == 1 || $status == 3) {
            echo '<div class="col mb-5">
                            <div class="card h-100">
                                <!-- User Profile image-->
                                <img class="card-img-top" src="' . $user['userProfileImage'] . '" alt="Image of ' . $user['name'] . '" />
                                <!-- User details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- User name-->
                                        <h5 class="fw-bolder">' . $user['name'] . '</h5>
                                        <!-- User Start Date-->
                                        <div class="text-center">' . convertTimeStamp($user) . '</div>
                                    </div>
                                </div>
                                <!-- User actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="user.php?ID=' . $user['ID'] . '">Check out User</a></div>
                                </div>
                            </div>
                        </div>';
        }

    }
}

////////////////////////////////////////////////////////////////////////////////

//Generates user cards for admin.php

function convertTimeStamp($user)
{
    date_default_timezone_set('America/Kentucky/Louisville');
    $userTimeStamp = $user['dateJoined'];
    $formattedDateTime = date('Y-m-d H:i:s', $userTimeStamp);
    return $formattedDateTime;
}

//function checkStatus($userData){
 //   if (isset($_SESSION['user_id'])) {


//    }
//}
function generateAdminUserCards($userData)
{

    foreach ($userData as $user) {
        $status = $user['status'];
        switch ($status) {
            case (-1):
                $userStatus = "Admin Blocked";
                break;
            case (0):
                $userStatus = "User Deleted";
                break;
            case (1):
                $userStatus = "Active User";
                break;
            case (3):
                $userStatus = "Admin";
                break;
        }
        echo '<div class="col mb-5">
                        <div class="card h-100">
                            <!-- User Profile image-->
                            <img class="card-img-top" src="' . $user['userProfileImage'] . '" alt="Image of ' . $user['name'] . '" />
                            <!-- User details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- User name-->
                                    <h5 class="fw-bolder">' . $user['name'] . '</h5>
                                    <!-- User Start Date-->
                                    <div class="text-center">' . convertTimeStamp($user) . '</div>
                                    <!-- User Status-->
                                    <div class="text-center">' . $userStatus . '</div>
                                </div>
                            </div>
                            <!-- User actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="user.php?ID=' . $user['ID'] . '">Check out User</a></div>
                            </div>
                            </form>
                        </div>
                    </div>';
    }

}

//generates user cards for index.php
function generateUserCards($userData)
{

    foreach ($userData as $user) {
        $status = $user['status'];
        if ($status == 1 || $status == 3) {
            echo '<div class="col mb-5">
                            <div class="card h-100">
                                <!-- User Profile image-->
                                <img class="card-img-top" src="' . $user['userProfileImage'] . '" alt="Image of ' . $user['name'] . '" />
                                <!-- User details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- User name-->
                                        <h5 class="fw-bolder">' . $user['name'] . '</h5>
                                        <!-- User Start Date-->
                                        <div class="text-center">' . convertTimeStamp($user) . '</div>
                                    </div>
                                </div>
                                <!-- User actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="user.php?ID=' . $user['ID'] . '">Check out User</a></div>
                                </div>
                            </div>
                        </div>';
        }

    }
}


?>