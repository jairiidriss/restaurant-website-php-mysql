<?php
    ob_start();
	session_start();

	$pageTitle = 'Image Gallery';

	if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
	{
		include 'connect.php';
  		include 'Includes/functions/functions.php'; 
		include 'Includes/templates/header.php';
		include 'Includes/templates/navbar.php';

        ?>

            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

            <script type="text/javascript">

                var vertical_menu = document.getElementById("vertical-menu");


                var current = vertical_menu.getElementsByClassName("active_link");

                if(current.length > 0)
                {
                    current[0].classList.remove("active_link");   
                }
                
                vertical_menu.getElementsByClassName('gallery_link')[0].className += " active_link";

            </script>

            <style type="text/css">

                .gallery-table td, .gallery-table th 
                {
                    vertical-align: middle;
                    text-align: center;
                }

                .image_gallery
                {
                    width: 50%;
                }

            </style>

        <?php
            
            $stmt = $con->prepare("SELECT * FROM image_gallery");
            $stmt->execute();
            $gallery = $stmt->fetchAll();

        ?>

        <div class="card">
            <div class="card-header">
                <?php echo $pageTitle; ?>
            </div>
            <div class="card-body">

                <!-- ADD NEW IMAGE BUTTON -->

                <button class="btn btn-success btn-sm" style="margin-bottom: 10px;" type="button" data-toggle="modal" data-target="#add_new_image" data-placement="top">
                    <i class="fa fa-plus"></i> 
                    Add Image
                </button>

                <!-- Add New Image Modal -->

                <div class="modal fade" id="add_new_image" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Image</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div id="add_image_result">
                                    
                                </div>

                                <!-- Image Name -->

                                <div class="form-group">
                                    <label for="image_name">Image name</label>
                                    <input type="text" id="image_name_input" class="form-control" onkeyup="this.value=this.value.replace(/[^\sa-zA-Z]/g,'');" placeholder="Image Name" name="image_name">
                                    <div id = 'required_image_name' class="invalid-feedback">
                                        <div>Image name is required!</div>
                                    </div>
                                </div>

                                <!-- Image -->

                                <div class="form-group">
                                    <label for="gallery_image">Image</label>
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' name="gallery_image" id="add_gallery_imageUpload" accept=".png, .jpg, .jpeg" />
                                            <label for="add_gallery_imageUpload"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="add_gallery_imagePreview">
                                            </div>
                                        </div>
                                    </div>
                                    <div id = 'required_image' class="invalid-feedback">
                                        <div>Image name is required!</div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-info" id="add_image_bttn">Add Image</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- IMAGES TABLE -->

                <table class="table table-bordered gallery-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Image Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($gallery as $image)
                            {
                                echo "<tr>";
                                    echo "<td>";
                                        echo $image['image_id'];
                                    echo "</td>";

                                    echo "<td style = 'text-transform: capitalize'>";
                                        echo $image['image_name'];
                                    echo "</td>";

                                    $src = "./Uploads/images/".$image['image'];

                                    echo "<td style='width:25%!important'>";
                                        echo "<img src='".$src."' class='image_gallery img-fluid img-thumbnail' alt='".$image['image_name']."'>";
                                    echo "</td>";

                                    echo "<td>";
                                        $delete_data = "delete_".$image["image_id"];
                                        ?>
                                            <ul class="list-inline m-0">

                                                <!-- DELETE BUTTON -->

                                                <li class="list-inline-item" data-toggle="tooltip" title="Delete">
                                                    <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $delete_data; ?>" data-placement="top">
                                                        <i class="fa fa-trash"></i>
                                                        Delete
                                                    </button>

                                                    <!-- Delete Modal -->

                                                    <div class="modal fade" id="<?php echo $delete_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $delete_data; ?>" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete Image</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this Image?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <button type="button" data-id = "<?php echo $image['image_id']; ?>" class="btn btn-danger delete_image_bttn">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        <?php
                                    echo "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php

        /*** FOOTER BOTTON ***/

        include 'Includes/templates/footer.php';
    }
    else
    {
        header('Location: index.php');
        exit();
    }
?>


<script type="text/javascript">
    // UPLOAD ADD IMAGE GALLERY

    function readURL(input) 
    {
        if (input.files && input.files[0]) 
        {
            var reader = new FileReader();
            reader.onload = function(e) 
            {
                $('#add_gallery_imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#add_gallery_imagePreview').hide();
                $('#add_gallery_imagePreview').fadeIn(650);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#add_gallery_imageUpload").change(function() 
    {
        readURL(this);
    });

    $('#add_image_bttn').click(function()
    {
        var image_name = $("#image_name_input").val();
        var image = $("#imageUpload").val();
        formdata = new FormData();  

        var do_ = "Add";

        if($.trim(image_name) == "")
        {
            $('#required_image_name').css('display','block');
        }
        else
        {
            $.ajax(
            {
                url:"ajax_files/gallery_ajax.php",
                method:"POST",
                data:{image_name:image_name,image:image,do:do_},
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) 
                {
                    $('#add_image_result').html(data);
                },
                error: function(xhr, status, error) 
                {
                    alert('AN ERROR HAS BEEN ENCOUNTERED WHILE TRYING TO EXECUTE YOUR REQUEST');
                }
            });
        }
    });

</script>