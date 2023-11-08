<?php
session_start();
require_once('./header.php');
require_once('./lib/imageHandling.php');

class ImageUploader {
    private $userId;

    public function __construct($userId) {
        $this->userId = $userId;
    }

    public function uploadImage($imageInput, $nameInput) {
        if (count($_FILES) > 0) {
            $imageData = [
                'id' => uniqid(),
                'owner' => $this->userId,
                'filename' => $_FILES[$imageInput]['name'],
                'name' => $nameInput,
                'rating' => 0,
                'date' => time(),
                'metadata' => [
                    'filesize' => $_FILES[$imageInput]['size'],
                    'format' => $_FILES[$imageInput]['type']
                ]
            ];

            collectImage($imageInput, $this->userId, $imageData);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];

    if (isset($_POST['nameInput'])) {
        $nameInput = $_POST['nameInput'];
        $uploader = new ImageUploader($userId);
        $uploader->uploadImage('imageInput', $nameInput);
    }
}
?>


<?= echoHeader('Upload Image')?>
    <body>
    <section style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <!-- p name="signUpformDiv" class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up
                                    </p -->
                                    <form name="imageUploadForm" class="mx-1 mx-md-4" method="POST" enctype="multipart/form-data"
                                          action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">


                                        <div class=" d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="imageInput">Choose an image:</label>
                                                <input type="file" name="imageInput" accept="image/png, image/jpeg, image/gif" required class="form-control">
                                            </div>
                                        </div>

                                        <div class=" d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="nameInput">Photo Name</label>
                                                <input type="text" name="nameInput" required class="form-control">
                                            </div>
                                        </div>


                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Upload Image</button>
                                        </div>

                                        <div class="form-check d-flex justify-content-center mb-5">
                                            <a href="login.php">Back to Login</a>
                                        </div>

                                    </form>
                                </div>
                                <?php
                                //	<div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                //	<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" alt="Sample image">
                                //	</div>
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
<?= echoFooter()?>
