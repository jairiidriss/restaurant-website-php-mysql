<?php
    ob_start();
	session_start();

	$pageTitle = 'Website Settings';

	if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
	{
		include 'connect.php';
  		include 'Includes/functions/functions.php'; 
		include 'Includes/templates/header.php';
		include 'Includes/templates/navbar.php';

		$stmt = $con->prepare("SELECT * FROM website_settings");
        $stmt->execute();
        $options = $stmt->fetchAll();

        ?>

        	<div class="card">
            	<div class="card-header">
                	Website Settings
           		</div>
                <div class="card-body">
            		<form method="POST" class="website_settings_form" action="website-settings.php">
                   		<div class="panel-X">
                        	<div class="panel-header-X">
                                <div class="main-title">
                                    Settings
                                </div>
                            </div>
                            <div class="save-header-X">
                                <div style="display:flex">
                                    <div class="icon">
                                        <i class="fa fa-sliders-h"></i>
                                    </div>
                                    <div class="title-container">Website details</div>
                                </div>
                                <div class="button-controls">
                                    <button type="submit" name="save_settings" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            <div class="panel-body-X">
                            <?php
                            	foreach ($options as $option)
		                        {
		                            ?>
		                            <div class="form-group">
		                                <label for="<?php echo $option['option_name'] ?>">
		                                	<?php echo $option['option_name'] ?>
		                                </label>
		                                <input type="text" value="<?php echo (isset($_POST[$option['option_name'] ]))?$_POST[$option['option_name'] ]:$option['option_value'] ?>" name="<?php echo $option['option_name'] ?>" class="form-control">
		                                <?php
			                                if(isset($_POST['save_settings']) && $_SERVER['REQUEST_METHOD'] == 'POST')
			                                {
			                                    if(empty($_POST[$option['option_name']]))
			                                    {
			                                    	echo "<div class='invalid-feedback' style = 'display:block'>";
			                                       		echo $option['option_name']." is required!";
			                                        echo "</div>";
			                                        $form_flag = 1;
			                                    }
			                                }
		                            	?>
		                            </div>
		                            <?php
		                        }
		                    ?>
                            </div>
                        </div>
                    </form>

                    <!-- UPDATE WEBSITE SETTINGS -->
                    <?php
                    	if(isset($_POST['save_settings']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $form_flag == 0)
                		{
                			
                		}
                    ?>

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