<?php include '../connect.php'; ?>
<?php include '../Includes/functions/functions.php'; ?>


<?php
	
	if(isset($_POST['do']) && $_POST['do'] == "Add")
	{
        $image_name = test_input($_POST['image_name']);

        $image_Name = $_FILES['image']['name'];
        $image_allowed_extension = array("jpeg","jpg","png");
        $image_split = explode('.',$image_Name);
        $extesnion = end($image_split);
        $image_extension = strtolower($extesnion);
        
        if(empty($_FILES['image']['name']) || (!empty($_FILES['menu_image']['name']) && !in_array($image_extension,$image_allowed_extension)))
        {
            echo "<div class = 'alert alert-warning'>";
                echo "Invalid Image format! Only JPEG, JPG and PNG are accepted.";
            echo "</div>";
        }
        else
        {
            

            try
            {
                $image = rand(0,100000).'_'.$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],"Uploads/images//".$image);
                //Insert into the database
                $stmt = $con->prepare("insert into image_gallery(image_name, image) values(?, ?) ");
                $stmt->execute(array($image_name, $image));

                echo "<div class = 'alert alert-success'>";
                    echo "Great! Image has been inserted successfully.";
                echo "</div>";

            }
            catch(Exception $e)
            {
                echo "<div class = 'alert alert-alert'>";
                    echo "Error occurred while trying to insert image!";
                echo "</div>";
            }

            
        }    
    }
    else{
        echo "dsdsd";
    }
