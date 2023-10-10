<?php
//Generates user cards for index and admin page
function generateUserCards($userData){
    echo '<div class="col mb-5">
                        <div class="card h-100">
                            <!-- User Profile image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- User details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- User name-->
                                    <h5 class="fw-bolder">Sale Item</h5>
                                    <!-- User Start Date-->
                                    <div class="text-center">'.$userData['dateJoined'].'</div>
                                    <!-- User Status-->
                                    <div class="text-center">'.$userData['status'].'
                                </div>
                            </div>
                            <!-- User actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>';

}

?>