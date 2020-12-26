<?php include '../connect.php'; ?>
<?php include '../Includes/functions/functions.php'; ?>

<?php
	
	if(isset($_POST['do_']) && $_POST['do_'] == "Deliver_Order")
	{
		$order_id = $_POST['order_id'];

        $stmt = $con->prepare("update placed_orders set delivered = 1 where order_id = ?");
        $stmt->execute(array($order_id));
	}
	elseif(isset($_POST['do_']) && $_POST['do_'] == "Cancel_Order")
	{
		$order_id = $_POST['order_id'];
		$cancellation_reason_order = test_input($_POST['cancellation_reason_order']);

        $stmt = $con->prepare("update placed_orders set canceled = 1, cancellation_reason = ? where order_id = ?");
        $stmt->execute(array($cancellation_reason_order,$order_id));
	}

?>