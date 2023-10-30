<!-- PHP INCLUDES -->

<?php
    //Set page title
    $pageTitle = 'Table Reservation';

    include "connect.php";
    include 'Includes/functions/functions.php';
    include "Includes/templates/header.php";
    include "Includes/templates/navbar.php";


?>
    
    <style type="text/css">
        .table_reservation_section
        {
            max-width: 850px;
            margin: 50px auto;
            min-height: 500px;
        }

        .check_availability_submit
        {
            background: #ffc851;
            color: white;
            border-color: #ffc851;
            font-family: work sans,sans-serif;
        }
        .client_details_tab  .form-control
        {
            background-color: #fff;
            border-radius: 0;
            padding: 25px 10px;
            box-shadow: none;
            border: 2px solid #eee;
        }

        .client_details_tab  .form-control:focus 
        {
            border-color: #ffc851;
            box-shadow: none;
            outline: none;
        }
        .text_header
        {
            margin-bottom: 5px;
            font-size: 18px;
            font-weight: bold;
            line-height: 1.5;
            margin-top: 22px;
            text-transform: capitalize;
        }
        .layer
        {
            height: 100%;
        background: -moz-linear-gradient(top, rgba(45,45,45,0.4) 0%, rgba(45,45,45,0.9) 100%);
    background: -webkit-linear-gradient(top, rgba(45,45,45,0.4) 0%, rgba(45,45,45,0.9) 100%);
    background: linear-gradient(to bottom, rgba(45,45,45,0.4) 0%, rgba(45,45,45,0.9) 100%);
        }

    </style>

    <!-- START ORDER FOOD SECTION -->

    <section style="
    background: url(Design/images/food_pic.jpg);
    background-position: center bottom;
    background-repeat: no-repeat;
    background-size: cover;">
        <div class="layer">
            <div style="text-align: center;padding: 15px;">
                <h1 style="font-size: 120px; color: white;font-family: 'Roboto'; font-weight: 100;
">Book a Table</h1>
            </div>
        </div>
        
    </section>

	<section class="table_reservation_section">

        <div class="container">
            <?php

            if(isset($_POST['submit_table_reservation_form']) && $_SERVER['REQUEST_METHOD'] === 'POST')
            {
                // Selected Date and Time

                $selected_date = $_POST['selected_date'];
                $selected_time = $_POST['selected_time'];

                $desired_date = $selected_date." ".$selected_time;

                //Nbr of Guests

                $number_of_guests = $_POST['number_of_guests'];

                //Table ID

                $table_id = $_POST['table_id'];

                //Client Details

                $client_full_name = test_input($_POST['client_full_name']);
                $client_phone_number = test_input($_POST['client_phone_number']);
                $client_email = test_input($_POST['client_email']);

                $con->beginTransaction();
                try
                {
                    $stmtgetCurrentClientID = $con->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'restaurant_website' AND TABLE_NAME = 'clients'");
            
                    $stmtgetCurrentClientID->execute();
                    $client_id = $stmtgetCurrentClientID->fetch();

                    $stmtClient = $con->prepare("insert into clients(client_name,client_phone,client_email) 
                                values(?,?,?)");
                    $stmtClient->execute(array($client_full_name,$client_phone_number,$client_email));

                    
                    $stmt_reservation = $con->prepare("insert into reservations(date_created, client_id, selected_time, nbr_guests, table_id) values(?, ?, ?, ?, ?)");
                    $stmt_reservation->execute(array(Date("Y-m-d H:i"),$client_id[0], $desired_date, $number_of_guests, $table_id));

                    
                    echo "<div class = 'alert alert-success'>";
                        echo "Great! Your Reservation has been created successfully.";
                    echo "</div>";

                    $con->commit();
                }
                catch(Exception $e)
                {
                    $con->rollBack();
                    echo "<div class = 'alert alert-danger'>"; 
                        echo $e->getMessage();
                    echo "</div>";
                }
            }

        ?>



            <div class="text_header">
                <span>
                    1. Select Date & Time
                </span>
            </div>
            <form method="POST" action="table-reservation.php">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="reservation_date">Date</label>
                            <input type="date" min="<?php echo (isset($_POST['reservation_date']))?$_POST['reservation_date']:date('Y-m-d',strtotime("+1day"));  ?>" 
                            value = "<?php echo (isset($_POST['reservation_date']))?$_POST['reservation_date']:date('Y-m-d',strtotime("+1day"));  ?>"
                            class="form-control" name="reservation_date">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="reservation_time">Time</label>
                            <input type="time" value="<?php echo (isset($_POST['reservation_time']))?$_POST['reservation_time']:date('H:i');  ?>" class="form-control" name="reservation_time">
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="number_of_guests">How many people?</label>
                            <select class="form-control" name="number_of_guests">
                                <option value="1" <?php echo (isset($_POST['number_of_guests']))?"selected":"";  ?>>
                                    One person
                                </option>
                                <option value="2" <?php echo (isset($_POST['number_of_guests']))?"selected":"";  ?>>Two people</option>
                                <option value="3" <?php echo (isset($_POST['number_of_guests']))?"selected":"";  ?>>Three people</option>
                                <option value="4" <?php echo (isset($_POST['number_of_guests']))?"selected":"";  ?>>Four people</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="check_availability" style="visibility: hidden;">Check Availability</label>
                            <input type="submit" class="form-control check_availability_submit" name="check_availability_submit">
                        </div>
                    </div>
                </div>
            </form>

            <!-- CHECKING AVAILABILITY OF TABLES -->

            <?php

                if(isset($_POST['check_availability_submit']))
                {
                    $selected_date = $_POST['reservation_date'];
                    $selected_time = $_POST['reservation_time'];
                    $number_of_guests = $_POST['number_of_guests'];

                    $stmt = $con->prepare("select table_id
                        from tables

                        where table_id not in (select t.table_id
                        from tables t, reservations r
                        where 
                        t.table_id = r.table_id
                        and 
                        date(r.selected_time) = ?
                        and liberated = 0
                        and canceled = 0)
                    ");

                    $stmt->execute(array($selected_date));
                    $rows = $stmt->fetch();
                    
                    if($stmt->rowCount() == 0)
                    {
                        ?>
                            <div class="error_div">
                                <span class="error_message" style="font-size: 16px">ALL TABLES ARE RESERVED</span>
                            </div>
                        <?php
                    }
                    else
                    {
                        $table_id = $rows['table_id'];
                        ?>
                            <div class="text_header">
                                <span>
                                    2. Client details
                                </span>
                            </div>
                            <form method="POST" action="table-reservation.php">
                                <input type="hidden" name="selected_date" value="<?php echo $selected_date ?>">
                                <input type="hidden" name="selected_time" value="<?php echo $selected_time ?>">
                                <input type="hidden" name="number_of_guests" value="<?php echo $number_of_guests ?>">
                                <input type="hidden" name="table_id" value="<?php echo $table_id ?>">
                                <div class="client_details_tab">
                                    <div class="form-group colum-row row">
                                        <div class="col-sm-12">
                                            <input type="text" name="client_full_name" id="client_full_name" oninput="document.getElementById('required_fname').style.display = 'none'" onkeyup="this.value=this.value.replace(/[^\sa-zA-Z]/g,'');" class="form-control" placeholder="Full name">
                                            <div class="invalid-feedback" id="required_fname">
                                                Invalid Name!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <input type="email" name="client_email" id="client_email" oninput="document.getElementById('required_email').style.display = 'none'" class="form-control" placeholder="E-mail">
                                            <div class="invalid-feedback" id="required_email">
                                                Invalid E-mail!
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text"  name="client_phone_number" id="client_phone_number" oninput="document.getElementById('required_phone').style.display = 'none'" class="form-control" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Phone number">
                                            <div class="invalid-feedback" id="required_phone">
                                                Invalid Phone number!
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit_table_reservation_form" class="btn btn-info" value="Make a Reservation">
                                </div>
                            </form>
                        <?php
                    }

                }

            ?>
        </div>
    </section>

    <style type="text/css">
        .details_card
        {
            display: flex;
            align-items: center;
            margin: 150px 0px;
        }
        .details_card>span
        {
            float: left;
            font-size: 60px;
        }
        
        .details_card>div
        {
            float: left;
            font-size: 20px;
            margin-left: 20px;
            letter-spacing: 2px
        }
    </style>

    <section class="restaurant_details" style="background: url(Design/images/food_pic_2.jpg);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: 50% 0%;
    background-size: cover;
    color:white !important;
    min-height: 300px;">
        <div class="layer">
            <div class="container">
            <div class="row">
            <div class="col-md-3 details_card">
                <span>30</span>
                <div>
                    Total 
                    <br>
                    Reservations
                </div>
            </div>
            <div class="col-md-3 details_card">
                <span>30</span>
                <div>
                    Total 
                    <br>
                    Menus
                </div>
            </div>
            <div class="col-md-3 details_card">
                <span>30</span>
                <div>
                    Years of 
                    <br>
                    Experience
                </div>
            </div>
            <div class="col-md-3 details_card">
                <span>30</span>
                <div>
                    Profesionnal 
                    <br>
                    Cook
                </div>
            </div>
        </div>
        </div>
         </div>
    </section>

    <!-- FOOTER BOTTOM  -->

    <?php include "Includes/templates/footer.php"; ?>
