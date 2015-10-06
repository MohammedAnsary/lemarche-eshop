<?php
	class Product {
		//View of the all products
		function viewProducts() {

			$viewProduct = parseJson(DB::query('SELECT * FROM product', '', [], 1));
			if($viewProduct['status'] = 'OK') {
				return json_encode($viewProduct);
			} else {
				return json_encode(array('status' => 'ERR'));
			}

		}

		function addToCart($product_id) {

			$addProduct = json_decode(DB::query('SELECT p.id FROM cart c,product p WHERE c.user_id =? AND c.product_id=? AND c.product_id=p.id', 'ii', [$_SESSION['id'],$product_id], 1), true);
			if($addProduct['status'] = 'OK')
			{
				return DB::query('INSERT INTO cart (user_id,product_id,status) VALUES (?,?,?)','iii',[$_SESSION['id'],$product_id,0], 0);
			}
				$messages['products_list'] = 'This product has already been added to your cart.';

		}

		function removeFromCart($product_id) {

			$removeProduct = json_decode(DB::query('SELECT p.id FROM cart c,product p WHERE c.user_id = ? AND c.product_id=? AND c.product_id=p.id AND status=0', 'ii', [$_SESSION['id'],$product_id], 1), true);
			if($removeProduct['status'] = 'OK')
			{
				return DB::query('DELETE FROM cart WHERE user_id=? AND product_id=? AND status = 0','ii',[$_SESSION['id'],$product_id], 0);
			}
				$messages['products_list'] = 'This product has already been deleted from your cart please refresh your browser';

		}

		function checkoutCart() {

			$checkOutCart = json_decode(DB::query('SELECT * FROM cart WHERE user_id = ? AND status = 0', 'i', [$_SESSION['id']], 1), true);
			if($checkOutCart['status'] = 'OK')
			{
				return DB::query('UPDATE cart set status = ? WHERE user_id=?','ii',[1,$_SESSION['id']], 0);
			}
				$messages['products_list'] = 'You have no products in your cart please add some products to your cart to be able to buy them.';

		}

		function viewCart() {

			$viewCart = json_decode(DB::query('SELECT p.name,p.price,p.avatar FROM cart c,product p WHERE c.user_id = ? AND c.product_id=p.id AND c.status=0', 'i', [$_SESSION['id']],1), true);
			if($viewCart['status'] = 'OK')
			{
				return DB::query('SELECT p.name,p.price,p.avatar FROM cart c,product p WHERE c.user_id = ? AND c.product_id=p.id AND c.status=0', 'i', [$_SESSION['id']],1);
			}
				$messages['products_list'] = 'You have no products in your cart please add some products to your cart to be able to buy them.';

		}

		function viewHistory() {

				$viewHistory = json_decode(DB::query('SELECT p.name,p.price,p.avatar FROM cart c,product p WHERE c.user_id = ? AND c.product_id=p.id AND c.status=1', 'i', [$_SESSION['id']],1), true);
				if($viewHistory['status'] = 'OK')
				{
				return DB::query('SELECT p.name,p.price,p.avatar FROM cart c,product p WHERE c.user_id = ? AND c.product_id=p.id AND c.status=1', 'i', [$_SESSION['id']],1);
			}
				$messages['products_list'] = 'You did not buy any products yet.';

		}
	}
?>
