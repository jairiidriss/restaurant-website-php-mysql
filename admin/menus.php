<?php
    ob_start();
	session_start();

	$pageTitle = 'Menus - Dishes';

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
                
                vertical_menu.getElementsByClassName('menus_link')[0].className += " active_link";

            </script>

            <style type="text/css">

                .menus-table
                {
                    -webkit-box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
                    box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
                }

                .thumbnail>img 
                {
                    width: 100%;
                    object-fit: cover;
                    height: 300px;
                }

                .thumbnail .caption 
                {
                    padding: 9px;
                    color: #333;
                }

                .menu_form
                {
                    max-width: 750px;
                    margin:auto;
                }

                .panel-X
                {
                    border: 0;
                    -webkit-box-shadow: 0 1px 3px 0 rgba(0,0,0,.25);
                    box-shadow: 0 1px 3px 0 rgba(0,0,0,.25);
                    border-radius: .25rem;
                    position: relative;
                    display: -webkit-box;
                    display: -ms-flexbox;
                    display: flex;
                    -webkit-box-orient: vertical;
                    -webkit-box-direction: normal;
                    -ms-flex-direction: column;
                    flex-direction: column;
                    min-width: 0;
                    word-wrap: break-word;
                    background-color: #fff;
                    background-clip: border-box;
                    margin: auto;
                    width: 600px;
                }

                .panel-header-X 
                {
                    display: -webkit-box;
                    display: -ms-flexbox;
                    display: flex;
                    -webkit-box-pack: justify;
                    -ms-flex-pack: justify;
                    justify-content: space-between;
                    -webkit-box-align: center;
                    -ms-flex-align: center;
                    align-items: center;
                    padding-left: 1.25rem;
                    padding-right: 1.25rem;
                    border-bottom: 1px solid rgb(226, 226, 226);
                }

                .save-header-X 
                {
                    display: -webkit-box;
                    display: -ms-flexbox;
                    display: flex;
                    -webkit-box-align: center;
                    -ms-flex-align: center;
                    align-items: center;
                    -webkit-box-pack: justify;
                    -ms-flex-pack: justify;
                    justify-content: space-between;
                    min-height: 65px;
                    padding: 0 1.25rem;
                    background-color: #f1fafd;
                }

                .panel-header-X>.main-title 
                {
                    font-size: 18px;
                    font-weight: 600;
                    color: #313e54;
                    padding: 15px 0;
                }

                .panel-body-X
                {
                    padding: 1rem 1.25rem;
                }

                .save-header-X .icon
                {
                    width: 20px;
                    text-align: center;
                    font-size: 20px;
                    color: #5b6e84;
                    margin-right: 1.25rem;
                }
            </style>

        <?php

            $do = '';

            if(isset($_GET['do']) && in_array(htmlspecialchars($_GET['do']), array('Add','Edit')))
                $do = $_GET['do'];
            else
                $do = 'Manage';

            if($do == "Manage")
            {
                $stmt = $con->prepare("SELECT * FROM menus m, menu_categories mc where mc.category_id = m.category_id");
                $stmt->execute();
                $menus = $stmt->fetchAll();

            ?>
                <div class="card">
                    <div class="card-header">
                        <?php echo $pageTitle; ?>
                    </div>
                    <div class="card-body">

                        <!-- ADD NEW MENU BUTTON -->

                        <div class="above-table" style="margin-bottom: 1rem!important;">
                            <a href="menus.php?do=Add" class="btn btn-success">
                                <i class="fa fa-plus"></i> 
                                <span>Add new Menu</span>
                            </a>
                        </div>

                        <!-- MENUS TABLE -->

                        <table class="table table-bordered menus-table">
                            <thead>
                                <tr>
                                    <th scope="col">Menu Name</th>
                                    <th scope="col">Menu Category</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($menus as $menu)
                                    {
                                        echo "<tr>";
                                            echo "<td>";
                                                echo $menu['menu_name'];
                                            echo "</td>";
                                            echo "<td style = 'text-transform:capitalize'>";
                                                echo $menu['category_name'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $menu['menu_description'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo "$".$menu['menu_price'];
                                            echo "</td>";
                                            echo "<td>";
                                                /****/
                                                    $delete_data = "delete_".$menu["menu_id"];
                                                    $view_data = "view_".$menu["menu_id"];
                                                    ?>
                                                        <ul class="list-inline m-0">

                                                            <!-- VIEW BUTTON -->

                                                            <li class="list-inline-item" data-toggle="tooltip" title="View">
                                                                <button class="btn btn-primary btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $view_data; ?>" data-placement="top" >
                                                                    <i class="fa fa-eye"></i>
                                                                </button>

                                                                <!-- VIEW Modal -->

                                                                <div class="modal fade" id="<?php echo $view_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $view_data; ?>" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-body">
                                                                                
                                                                                <div class="thumbnail" style="cursor:pointer">
                                                                                    <?php $source = "Uploads/images/".$menu['menu_image']; ?>
                                                                                    <img src="<?php echo $source; ?>" >
                                                                                    <div class="caption">
                                                                                        <h3>
                                                                                            <span style="float: right;">$<?php echo $menu['menu_price'];?></span>
                                                                                            <?php echo $menu['menu_name'];?>
                                                                                        </h3>
                                                                                        <p>
                                                                                            <?php echo $menu['menu_description']; ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <!-- EDIT BUTTON -->

                                                            <li class="list-inline-item" data-toggle="tooltip" title="Edit">
                                                                <button class="btn btn-success btn-sm rounded-0">
                                                                    <a href="menus.php?do=Edit&menu_id=<?php echo $menu['menu_id']; ?>" style="color: white;">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                </button>
                                                            </li>

                                                            <!-- DELETE BUTTON -->

                                                            <li class="list-inline-item" data-toggle="tooltip" title="Delete">
                                                                <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $delete_data; ?>" data-placement="top"><i class="fa fa-trash"></i>
                                                                </button>

                                                                <!-- Delete Modal -->

                                                                <div class="modal fade" id="<?php echo $delete_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $delete_data; ?>" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Delete Menu</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Are you sure you want to delete this Menu "<?php echo strtoupper($menu['menu_name']); ?>"?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                                <button type="button" data-id = "<?php echo $menu['menu_id']; ?>" class="btn btn-danger delete_menu_bttn">Delete</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    <?php
                                                /****/
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>  
                    </div>
                </div>
            <?php
            }

            /*** ADD NEW MENU SCRIPT ***/

            elseif($do == 'Add')
            {
                ?>

                    <div class="card">
                        <div class="card-header">
                            Add New Menu
                        </div>
                        <div class="card-body">
                            <form method="POST" class="menu_form" action="menus.php?do=Add" enctype="multipart/form-data">
                                <div class="panel-X">
                                    <div class="panel-header-X">
                                        <div class="main-title">
                                            Add New Menu
                                        </div>
                                    </div>
                                    <div class="save-header-X">
                                        <div style="display:flex">
                                            <div class="icon">
                                                <i class="fa fa-sliders-h"></i>
                                            </div>
                                            <div class="title-container">Menu details</div>
                                        </div>
                                        <div class="button-controls">
                                            <button type="submit" name="add_new_menu" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                    <div class="panel-body-X">

                                        <!-- MENU NAME INPUT -->

                                        <div class="form-group">
                                            <label for="menu_name">Menu Name</label>
                                            <input type="text" class="form-control" onkeyup="this.value=this.value.replace(/[^\sa-zA-Z]/g,'');" value="<?php echo (isset($_POST['menu_name']))?htmlspecialchars($_POST['menu_name']):'' ?>" placeholder="Menu Name" name="menu_name">
                                            <?php
                                                $flag_add_menu_form = 0;

                                                if(isset($_POST['add_new_menu']))
                                                {
                                                    if(empty(test_input($_POST['menu_name'])))
                                                    {
                                                        ?>
                                                            <div class="invalid-feedback" style="display: block;">
                                                                Menu name is required.
                                                            </div>
                                                        <?php

                                                        $flag_add_menu_form = 1;
                                                    }
                                                    
                                                }
                                            ?>
                                        </div>
                                        
                                        <!-- MENU CATEGORY INPUT -->

                                        <div class="form-group">
                                            <?php
                                                $stmt = $con->prepare("SELECT * FROM menu_categories");
                                                $stmt->execute();
                                                $rows_categories = $stmt->fetchAll();
                                            ?>
                                            <label for="menu_category">Menu Category</label>
                                            <select class="custom-select" name="menu_category">
                                                <?php
                                                    foreach($rows_categories as $category)
                                                    {
                                                        echo "<option value = '".$category['category_id']."'>";
                                                            echo ucfirst($category['category_name']);
                                                        echo "</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- MENU DESCRIPTION INPUT -->

                                        <div class="form-group">
                                            <label for="menu_description">Menu Description</label>
                                            <textarea class="form-control" name="menu_description" style="resize: none;"><?php echo (isset($_POST['menu_description']))?htmlspecialchars($_POST['menu_description']):''; ?></textarea>
                                            <?php

                                                if(isset($_POST['add_new_menu']))
                                                {
                                                    if(empty(test_input($_POST['menu_description'])))
                                                    {
                                                        ?>
                                                            <div class="invalid-feedback" style="display: block;">
                                                                menu description is required.
                                                            </div>
                                                        <?php

                                                        $flag_add_menu_form = 1;
                                                    }
                                                    elseif(strlen(test_input($_POST['menu_description'])) > 200)
                                                    {
                                                        ?>
                                                            <div class="invalid-feedback" style="display: block;">
                                                                The length of the description should be less than 200 letters.
                                                            </div>
                                                        <?php

                                                        $flag_add_menu_form = 1;
                                                    }
                                                }
                                            ?>
                                        </div>

                                        <!-- MENU PRICE INPUT -->

                                        <div class="form-group">
                                            <label for="menu_price">Menu Price($)</label>
                                            <input type="text" class="form-control" value="<?php echo (isset($_POST['menu_price']))?htmlspecialchars($_POST['menu_price']):'' ?>" placeholder="Menu Price" name="menu_price">
                                            <?php

                                                if(isset($_POST['add_new_menu']))
                                                {
                                                    if(empty(test_input($_POST['menu_price'])))
                                                    {
                                                        ?>
                                                            <div class="invalid-feedback" style="display: block;">
                                                                menu price is required.
                                                            </div>
                                                        <?php

                                                        $flag_add_menu_form = 1;
                                                    }
                                                    elseif(!is_numeric(test_input($_POST['menu_price'])))
                                                    {
                                                        ?>
                                                            <div class="invalid-feedback" style="display: block;">
                                                                Invalid price.
                                                            </div>
                                                        <?php

                                                        $flag_add_menu_form = 1;
                                                    }
                                                }
                                            ?>
                                        </div>

                                        <!--MENU IMAGE INPUT -->

                                        <div class="form-group">
                                            <label for="menu_image">Menu Image</label>
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' name="menu_image" id="add_menu_imageUpload" accept=".png, .jpg, .jpeg" />
                                                    <label for="add_menu_imageUpload"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id="add_menu_imagePreview">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php

                                                if(isset($_POST['add_new_menu']) && $_SERVER['REQUEST_METHOD'] == 'POST')
                                                {
                                                    $image_Name = $_FILES['menu_image']['name'];
                                                    $image_allowed_extension = array("jpeg","jpg","png");
                                                    $image_split = explode('.',$image_Name);
                                                    $extesnion = end($image_split);
                                                    $image_extension = strtolower($extesnion);
                                                    
                                                    if(empty($_FILES['menu_image']['name']))
                                                    {
                                                        ?>
                                                            <div class="invalid-feedback" style="display: block;">
                                                                Menu Image is required!
                                                            </div>
                                                        <?php

                                                        $flag_add_menu_form = 1;
                                                        
                                                    }
                                                    if(!empty($_FILES['menu_image']['name']) && !in_array($image_extension,$image_allowed_extension))
                                                    {
                                                        ?>
                                                            <div class="invalid-feedback" style="display: block;">
                                                                Invalid Image format. Only JPEG, JPG and PNG are accepted!
                                                            </div>
                                                        <?php

                                                        $flag_add_menu_form = 1;
                                                    }
                                                }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                <?php

                /*** ADD NEW menu ***/

                if(isset($_POST['add_new_menu']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $flag_add_menu_form == 0)
                {
                    $menu_name = test_input($_POST['menu_name']);
                    $menu_category = $_POST['menu_category'];
                    $menu_price = test_input($_POST['menu_price']);
                    $menu_description = test_input($_POST['menu_description']);
                    $image = rand(0,100000).'_'.$_FILES['menu_image']['name'];
                    move_uploaded_file($_FILES['menu_image']['tmp_name'],"Uploads/images//".$image);

                    try
                    {
                        $stmt = $con->prepare("insert into menus(menu_name,menu_description,menu_price,menu_image,category_id) values(?,?,?,?,?) ");
                        $stmt->execute(array($menu_name,$menu_description,$menu_price,$image,$menu_category));
                        
                        ?> 
                            <!-- SUCCESS MESSAGE -->

                            <script type="text/javascript">
                                swal("New menu","The new menu has been inserted successfully", "success").then((value) => 
                                {
                                    window.location.replace("menus.php");
                                });
                            </script>

                        <?php

                    }
                    catch(Exception $e)
                    {
                        echo 'Error occurred: ' .$e->getMessage();
                    }
                    
                }
            }

            elseif($do == 'Edit')
            {
                $menu_id = (isset($_GET['menu_id']) && is_numeric($_GET['menu_id']))?intval($_GET['menu_id']):0;

                if($menu_id)
                {
                    $stmt = $con->prepare("Select * from menus where menu_id = ?");
                    $stmt->execute(array($menu_id));
                    $menu = $stmt->fetch();
                    $count = $stmt->rowCount();

                    if($count > 0)
                    {
                        ?>

                        <div class="card">
                            <div class="card-header">
                                Edit Menu
                            </div>
                            <div class="card-body">
                                <form method="POST" class="menu_form" action="menus.php?do=Edit&menu_id=<?php echo $menu['menu_id'] ?>" enctype="multipart/form-data">
                                    <div class="panel-X">
                                        <div class="panel-header-X">
                                            <div class="main-title">
                                                <?php echo $menu['menu_name']; ?>
                                            </div>
                                        </div>
                                        <div class="save-header-X">
                                            <div style="display:flex">
                                                <div class="icon">
                                                    <i class="fa fa-sliders-h"></i>
                                                </div>
                                                <div class="title-container">Menu details</div>
                                            </div>
                                            <div class="button-controls">
                                                <button type="submit" name="edit_menu_sbmt" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                        <div class="panel-body-X">
                                                
                                            <!-- MENU ID -->

                                            <input type="hidden" name="menu_id" value="<?php echo $menu['menu_id'];?>" >

                                            <!-- MENU NAME INPUT -->

                                            <div class="form-group">
                                                <label for="menu_name">Menu Name</label>
                                                <input type="text" class="form-control" onkeyup="this.value=this.value.replace(/[^\sa-zA-Z]/g,'');" value="<?php echo $menu['menu_name'] ?>" placeholder="Menu Name" name="menu_name">
                                                <?php
                                                    $flag_edit_menu_form = 0;

                                                    if(isset($_POST['edit_menu_sbmt']))
                                                    {
                                                        if(empty(test_input($_POST['menu_name'])))
                                                        {
                                                            ?>
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    Menu name is required.
                                                                </div>
                                                            <?php

                                                            $flag_edit_menu_form = 1;
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        
                                            <!-- MENU CATEGORY INPUT -->

                                            <div class="form-group">
                                                <?php
                                                    $stmt = $con->prepare("SELECT * FROM menu_categories");
                                                    $stmt->execute();
                                                    $rows_categories = $stmt->fetchAll();
                                                ?>
                                                <label for="menu_category">Menu Category</label>
                                                <select class="custom-select" name="menu_category">
                                                    <?php
                                                        foreach($rows_categories as $category)
                                                        {
                                                            if($category['category_id'] == $menu['category_id'])
                                                            {
                                                                echo "<option value = '".$category['category_id']."' selected>";
                                                                    echo ucfirst($category['category_name']);
                                                                echo "</option>";
                                                            }
                                                            else
                                                            {
                                                                echo "<option value = '".$category['category_id']."'>";
                                                                    echo ucfirst($category['category_name']);
                                                                echo "</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <!-- MENU DESCRIPTION INPUT -->

                                            <div class="form-group">
                                                <label for="menu_description">Menu Description</label>
                                                <textarea class="form-control" name="menu_description" style="resize: none;"><?php echo $menu['menu_description']; ?></textarea>
                                                <?php

                                                    if(isset($_POST['edit_menu_sbmt']))
                                                    {
                                                        if(empty(test_input($_POST['menu_description'])))
                                                        {
                                                            ?>
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    menu description is required.
                                                                </div>
                                                            <?php

                                                            $flag_edit_menu_form = 1;
                                                        }
                                                        elseif(strlen(test_input($_POST['menu_description'])) > 200)
                                                        {
                                                            ?>
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    The length of the description should be less than 200 letters.
                                                                </div>
                                                            <?php

                                                            $flag_edit_menu_form = 1;
                                                        }
                                                    }
                                                ?>
                                            </div>

                                            <!-- MENU PRICE INPUT -->

                                            <div class="form-group">
                                                <label for="menu_price">Menu Price($)</label>
                                                <input type="text" class="form-control" value="<?php echo $menu['menu_price'] ?>" placeholder="Menu Price" name="menu_price">
                                                <?php

                                                    if(isset($_POST['edit_menu_sbmt']))
                                                    {
                                                        if(empty(test_input($_POST['menu_price'])))
                                                        {
                                                            ?>
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    menu price is required.
                                                                </div>
                                                            <?php

                                                            $flag_edit_menu_form = 1;
                                                        }
                                                        elseif(!is_numeric(test_input($_POST['menu_price'])))
                                                        {
                                                            ?>
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    Invalid price.
                                                                </div>
                                                            <?php

                                                            $flag_edit_menu_form = 1;
                                                        }
                                                    }
                                                ?>
                                            </div>

                                            <!--MENU IMAGE INPUT -->

                                            <div class="form-group">
                                                <label for="menu_image">Menu Image</label>
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        <input type='file' name="menu_image" id="edit_menu_imageUpload" accept=".png, .jpg, .jpeg" />
                                                        <label for="edit_menu_imageUpload"></label>
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <?php $source = "Uploads/images/".$menu['menu_image']; ?>
                                                        <div style="background-image: url('<?php echo $source; ?>');" id="edit_menu_imagePreview">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php

                                                    if(isset($_POST['edit_menu_sbmt']) && $_SERVER['REQUEST_METHOD'] == 'POST')
                                                    {
                                                        $image_Name = $_FILES['menu_image']['name'];
                                                        $image_allowed_extension = array("jpeg","jpg","png");
                                                        $image_split = explode('.',$image_Name);
                                                        $extesnion = end($image_split);
                                                        $image_extension = strtolower($extesnion);
                                                        
                                                        if(!empty($_FILES['menu_image']['name']) && !in_array($image_extension,$image_allowed_extension))
                                                        {
                                                            ?>
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    Invalid Image format. Only JPEG, JPG and PNG are accepted!
                                                                </div>
                                                            <?php

                                                            $flag_edit_menu_form = 1;
                                                        }
                                                    }

                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <?php

                        /*** EDIT MENU ***/

                        if(isset($_POST['edit_menu_sbmt']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $flag_edit_menu_form == 0)
                        {
                            $menu_id = test_input($_POST['menu_id']);
                            $menu_name = test_input($_POST['menu_name']);
                            $menu_category = $_POST['menu_category'];
                            $menu_price = test_input($_POST['menu_price']);
                            $menu_description = test_input($_POST['menu_description']);

                            if(empty($_FILES['menu_image']['name']))
                            {
                                try
                                {
                                    $stmt = $con->prepare("update menus  set menu_name = ?, menu_description = ?, menu_price = ?, category_id = ? where menu_id = ? ");
                                    $stmt->execute(array($menu_name,$menu_description,$menu_price,$menu_category,$menu_id));
                                    
                                    ?> 
                                        <!-- SUCCESS MESSAGE -->

                                        <script type="text/javascript">
                                            swal("Edit Menu","Menu has been updated successfully", "success").then((value) => 
                                            {
                                                window.location.replace("menus.php");
                                            });
                                        </script>

                                    <?php

                                }
                                catch(Exception $e)
                                {
                                    echo 'Error occurred: ' .$e->getMessage();
                                }
                            }
                            else
                            {
                                $image = rand(0,100000).'_'.$_FILES['menu_image']['name'];
                                move_uploaded_file($_FILES['menu_image']['tmp_name'],"Uploads/images//".$image);
                                try
                                {
                                    $stmt = $con->prepare("update menus  set menu_name = ?, menu_description = ?, menu_price = ?, category_id = ?, menu_image = ? where menu_id = ? ");
                                    $stmt->execute(array($menu_name,$menu_description,$menu_price,$menu_category,$image,$menu_id));
                                    
                                    ?> 
                                        <!-- SUCCESS MESSAGE -->

                                        <script type="text/javascript">
                                            swal("Edit Menu","Menu has been updated successfully", "success").then((value) => 
                                            {
                                                window.location.replace("menus.php");
                                            });
                                        </script>

                                    <?php

                                }
                                catch(Exception $e)
                                {
                                    echo 'Error occurred: ' .$e->getMessage();
                                }
                            }
                            
                            
                        }

                    }
                    else
                    {
                        header('Location: menus.php');
                    }
                }
                else
                {
                    header('Location: menus.php');
                }
            }


        /*** FOOTER BOTTON ***/

        include 'Includes/templates/footer.php';

    }
    else
    {
        header('Location: index.php');
        exit();
    }

?>

<!-- JS SCRIPT -->

<script type="text/javascript">

    // When delete menu button is clicked

    $('.delete_menu_bttn').click(function()
    {
        var menu_id = $(this).data('id');
        var do_ = "Delete";

        $.ajax(
        {
            url:"ajax_files/menus_ajax.php",
            method:"POST",
            data:{menu_id:menu_id,do_:do_},
            success: function (data) 
            {
                swal("Delete Menu","The menu has been deleted successfully!", "success").then((value) => {
                    window.location.replace("menus.php");
                });     
            },
            error: function(xhr, status, error) 
            {
                alert('AN ERROR HAS BEEN ENCOUNTERED WHILE TRYING TO EXECUTE YOUR REQUEST');
            }
          });
    });

    // UPLOAD IMAGE ADD MENU

    function readURL(input) 
    {
        if (input.files && input.files[0]) 
        {
            var reader = new FileReader();
            reader.onload = function(e) 
            {
                $('#add_menu_imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#add_menu_imagePreview').hide();
                $('#add_menu_imagePreview').fadeIn(650);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#add_menu_imageUpload").change(function() 
    {
        readURL(this);
    });

    // UPLOAD IMAGE EDIT MENU
    
    function readURL_Edit_Menu(input) 
    {
        if (input.files && input.files[0]) 
        {
            var reader = new FileReader();
            reader.onload = function(e) 
            {
                $('#edit_menu_imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#edit_menu_imagePreview').hide();
                $('#edit_menu_imagePreview').fadeIn(650);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#edit_menu_imageUpload").change(function() 
    {
        readURL_Edit_Menu(this);
    });

</script>
