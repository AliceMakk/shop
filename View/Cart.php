<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div>
		<a href="?action=main">Back to main</a>
	</div>
	<div>
		<?php
			if(!empty($cartData['cartList'])) {
				echo '<table border="1">';
				echo '<tr><th>Product</th><th>Price</th><th>Quantity</th><th></th></tr>';
					foreach ($cartData['cartList'] as $product) {
						echo "<td>{$product['name']}</td><td>{$product['price']}</td><td>{$product['quantity']}</td><td><a href='{$product['deleteLink']}'>Delete from cart</a></td></tr>";
					}
				echo "<tr><td colspan=4>total: <b>{$cartData['cartTotal']}</b></td></tr>";
				echo '</table>';
			} else {
				echo "<p><h3>Your cart is empty, do some shopping <a href='?action=main'>there</a> please.</h3></p>";
			}
		?>
	</div>
</body>
</html>