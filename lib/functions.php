<?php
//Generates user cards for admin.php
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
                            <img class="card-img-top" src="'.$user['userProfileImage'].'" alt="Image of '.$user['name'].'" />
                            <!-- User details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- User name-->
                                    <h5 class="fw-bolder">' . $user['name'] . '</h5>
                                    <!-- User Start Date-->
                                    <div class="text-center">' . $user['dateJoined'] . '</div>
                                    <!-- User Status-->
                                    <div class="text-center">' . $userStatus . '</div>
                                </div>
                            </div>
                            <!-- User actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>';
    }

}

//generates user cards for index.php
Function generateUserCards($userData){

        foreach ($userData as $user) {
            $status = $user['status'];
           if ($status == 1 || $status == 3){
            echo '<div class="col mb-5">
                            <div class="card h-100">
                                <!-- User Profile image-->
                                <img class="card-img-top" src="'.$user['userProfileImage'].'" alt="Image of '.$user['name'].'" />
                                <!-- User details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- User name-->
                                        <h5 class="fw-bolder">' . $user['name'] . '</h5>
                                        <!-- User Start Date-->
                                        <div class="text-center">' . $user['dateJoined'] . '</div>
                                    </div>
                                </div>
                                <!-- User actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                                </div>
                            </div>
                        </div>';
        }
    
    }
}


?>