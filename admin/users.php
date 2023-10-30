<?php
    ob_start();
	session_start();

	$pageTitle = 'Users';

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
                
                vertical_menu.getElementsByClassName('users_link')[0].className += " active_link";

            </script>

        <?php
            $do = '';

            if(isset($_GET['do']) && in_array(htmlspecialchars($_GET['do']), array('Add','Edit')))
                $do = $_GET['do'];
            else
                $do = 'Manage';

            if($do == "Manage")
            {
                $stmt = $con->prepare("SELECT * FROM users");
                $stmt->execute();
                $users = $stmt->fetchAll();

            ?>
                <div class="card">
                    <div class="card-header">
                        <?php echo $pageTitle; ?>
                    </div>
                    <div class="card-body">

                        <!-- USERS TABLE -->

                        <table class="table table-bordered users-table">
                            <thead>
                                <tr>
                                    <th scope="col">Username</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($users as $user)
                                    {
                                        echo "<tr>";
                                            echo "<td>";
                                                echo $user['username'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $user['email'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $user['full_name'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo "<button class='btn btn-success btn-sm rounded-0'>";
                                                    echo "<a href='users.php?do=Edit&user_id=".$user['user_id']."' style='color: white;'";
                                                    echo "<i class='fa fa-edit'></i>";
                                                    echo "</a>";
                                                echo "</button>";
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
            # Edit the user details
            elseif($do == 'Edit')
            {
                $user_id = (isset($_GET['user_id']) && is_numeric($_GET['user_id']))?intval($_GET['user_id']):0;
                
                if($user_id)
                {
                    $stmt = $con->prepare("Select * from users where user_id = ?");
                    $stmt->execute(array($user_id));
                    $user = $stmt->fetch();
                    $count = $stmt->rowCount();
                    if($count > 0)
                    {
                        ?>

                        <div class="card">
                            <div class="card-header">
                                Edit User
                            </div>
                            <div class="card-body">
                                <form method="POST" class="menu_form" action="users.php?do=Edit&user_id=<?php echo $user['user_id'] ?>">
                                    <div class="panel-X">
                                        <div class="panel-header-X">
                                            <div class="main-title">
                                                <?php echo $user['full_name']; ?>
                                            </div>
                                        </div>
                                        <div class="save-header-X">
                                            <div style="display:flex">
                                                <div class="icon">
                                                    <i class="fa fa-sliders-h"></i>
                                                </div>
                                                <div class="title-container">User details</div>
                                            </div>
                                            <div class="button-controls">
                                                <button type="submit" name="edit_user_sbmt" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                        <div class="panel-body-X">
                                                
                                            <!-- User ID -->

                                            <input type="hidden" name="user_id" value="<?php echo $user['user_id'];?>" >

                                            <!-- Username INPUT -->

                                            <div class="form-group">
                                                <label for="user_name">Username</label>
                                                <input type="text" class="form-control" value="<?php echo $user['username'] ?>" placeholder="Username" name="user_name">
                                                <?php
                                                    $flag_edit_user_form = 0;

                                                    if(isset($_POST['edit_user_sbmt']))
                                                    {
                                                        if(empty(test_input($_POST['user_name'])))
                                                        {
                                                            ?>
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    Username is required.
                                                                </div>
                                                            <?php

                                                            $flag_edit_menu_form = 1;
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        
                                            <!-- FULL NAME INPUT -->

                                            <div class="form-group">
                                                <label for="full_name">Full Name</label>
                                                <input type="text" class="form-control" value="<?php echo $user['full_name'] ?>" placeholder="Full Name" name="full_name">
                                                <?php
                                                    if(isset($_POST['edit_user_sbmt']))
                                                    {
                                                        if(empty(test_input($_POST['full_name'])))
                                                        {
                                                            ?>
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    Full name is required.
                                                                </div>
                                                            <?php

                                                            $flag_edit_menu_form = 1;
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            
                                            <!-- User Email INPUT -->

                                            <div class="form-group">
                                                <label for="user_email">User E-mail</label>
                                                <input type="email" class="form-control" value="<?php echo $user['email'] ?>" placeholder="User Email" name="user_email">
                                                <?php

                                                    if(isset($_POST['edit_user_sbmt']))
                                                    {
                                                        if(empty(test_input($_POST['user_email'])))
                                                        {
                                                            ?>
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    User E-mail is required.
                                                                </div>
                                                            <?php

                                                            $flag_edit_menu_form = 1;
                                                        }
                                                        elseif(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL))
                                                        {
                                                            ?>
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    Invalid e-mail.
                                                                </div>
                                                            <?php

                                                            $flag_edit_menu_form = 1;
                                                        }
                                                    }
                                                ?>
                                            </div>

                                            <!-- User Password INPUT -->

                                            <div class="form-group">
                                                <label for="user_password">User Password</label>
                                                <input type="password" class="form-control" placeholder="Change password" name="user_password">
                                                <?php

                                                    if(isset($_POST['edit_user_sbmt']))
                                                    {
                                                        if(!empty($_POST['user_password']) and strlen($_POST['user_password']) < 8)
                                                        {
                                                            ?>
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    Password length must be at least 8 characters.
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

                        if(isset($_POST['edit_user_sbmt']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $flag_edit_user_form == 0)
                        {
                            $user_id = test_input($_POST['user_id']);
                            $user_name = test_input($_POST['user_name']);
                            $user_fullname = $_POST['full_name'];
                            $user_email = test_input($_POST['user_email']);
                            $user_password = $_POST['user_password'];

                            if(empty($user_password))
                            {
                                try
                                {
                                    $stmt = $con->prepare("update users  set username = ?, email = ?, full_name = ? where user_id = ? ");
                                    $stmt->execute(array($user_name,$user_email,$user_fullname,$user_id));
                                    
                                    ?> 
                                        <!-- SUCCESS MESSAGE -->

                                        <script type="text/javascript">
                                            swal("Edit User","User has been updated successfully", "success").then((value) => 
                                            {
                                                window.location.replace("users.php");
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
                                $user_password = sha1($user_password);
                                try
                                {
                                    $stmt = $con->prepare("update users  set username = ?, email = ?, full_name = ?, password = ? where user_id = ? ");
                                    $stmt->execute(array($user_name,$user_email,$user_fullname,$user_password,$user_id));
                                    
                                    ?> 
                                        <!-- SUCCESS MESSAGE -->

                                        <script type="text/javascript">
                                            swal("Edit User","User has been updated successfully", "success").then((value) => 
                                            {
                                                window.location.replace("users.php");
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


        /* FOOTER BOTTOM */

        include 'Includes/templates/footer.php';

    }
    else
    {
        header('Location: index.php');
        exit();
    }
?>