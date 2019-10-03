<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div>
		<a href="?action=cart">My cart (<?=$cartTotal?>)</a>
	</div>
	<div>
		<?php
			if(!empty($products)) {
				echo '<table border="1">';
				echo '<tr><th>Product</th><th>Price</th><th></th></tr>';
					foreach ($products as $product) {
						echo "<td>{$product['name']}</td><td>{$product['price']}</td><td><a href='{$product['addLink']}'>Add to cart</a></td></tr>";
					}
				echo '</table>';
			}
		?>
	</div>
</body>
</html>