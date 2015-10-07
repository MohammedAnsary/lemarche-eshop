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

		function addToCart($user_id, $product_id) {

			$stock = 0;
			$cart = 0;

			//This would have been better if a join was used but it's beyond repair :')
			$getStock = parseJSON(DB::query('SELECT stock FROM product where id = ? LIMIT 1', 'i', [$product_id], 1));
			if($getStock['status'] = 'OK') {
				$stock = parseJSON($getStock['data'])[0]['stock'];
				$getCart = parseJSON(DB::query('SELECT quantity FROM cart where user_id = ? and product_id = ? and status = ? LIMIT 1', 'iii', [$user_id, $product_id, 0], 1));
				if($getCart['status'] = 'OK') {
					$result = parseJSON($getCart['data']);
					$cart = (count($result) == 0) ? 0 : $result[0]['quantity'];
					if(($stock - $cart - 1) >= 0 ) {
						if($cart == 0) {
							$add = parseJSON(DB::query('INSERT INTO cart (user_id, product_id, quantity, status) VALUES (?, ?, ?, ?)', 'iiii', [$user_id, $product_id, 1, 0], 0));
							if($add['status'] = 'OK') {
								return json_encode(array('status' => 'OK'));
							} else {
								return json_encode(array('status' => 'ERR'));
							}
						} else {
							$add = parseJSON(DB::query('UPDATE cart set quantity = ? where user_id = ? and product_id = ? and status = ?', 'iiii', [$cart + 1, $user_id, $product_id, 0], 0));
							if($add['status'] = 'OK') {
								return json_encode(array('status' => 'OK'));
							} else {
								return json_encode(array('status' => 'ERR'));
							}
						}
					} else {
						return json_encode(array('status' => 'NO', 'message' => 'We would love to sell you more but we\'re out of stock!'));
					}
				} else {
					return json_encode(array('status' => 'ERR'));
				}
			} else {
				return json_encode(array('status' => 'ERR'));
			}
		}

		function removeFromCart($user_id, $product_id) {

			$cart = 0;

			$removeProduct = parseJSON(DB::query('SELECT quantity FROM cart WHERE user_id = ? AND product_id= ? AND status = 0 LIMIT 1', 'ii', [$user_id, $product_id], 1));
			if($removeProduct['status'] = 'OK') {
				$result = parseJSON($removeProduct['data']);
				if(count($result) == 0) {
					return json_encode(array('status' => 'NO', 'message' => 'You trying to be cool nigga?!'));
				} else {
					$cart = $result[0]['quantity'];
					if($cart == 1) {
						$rem = parseJSON(DB::query('DELETE FROM cart WHERE user_id= ? AND product_id= ? AND status = 0', 'ii', [$user_id,$product_id], 0));
						if($rem['status'] = 'OK') {
							return json_encode(array('status' => 'OK'));
						} else {
							return json_encode(array('status' => 'ERR'));
						}
					} else {
						$rem = parseJson(DB::query('UPDATE cart set quantity = ? where user_id= ? AND product_id= ? AND status = 0','iii',[$cart - 1, $user_id, $product_id], 0));
						if($rem['status'] = 'OK') {
							return json_encode(array('status' => 'OK'));
						} else {
							return json_encode(array('status' => 'ERR'));
						}
					}
				}
			}
		}

		function checkoutCart($user_id) {

			$checkOutCart = json_decode(DB::query('SELECT * FROM cart WHERE user_id = ? AND status = 0', 'i', [$_SESSION['id']], 1), true);
			if($checkOutCart['status'] = 'OK')
			{
				return DB::query('UPDATE cart set status = ? WHERE user_id=?','ii',[1,$_SESSION['id']], 0);
			}
				$messages['products_list'] = 'You have no products in your cart please add some products to your cart to be able to buy them.';

		}

		function viewCart($user_id) {

			$viewCart = parseJSON(DB::query('SELECT * FROM cart c,product p WHERE c.user_id = ? AND c.product_id=p.id AND c.status=0', 'i', [$user_id],1));
			if($viewCart['status'] = 'OK') {
				return json_encode($viewCart);
			} else {
				return json_encode(array('status' => 'ERR'));
			}

		}

		function viewHistory($user_id) {

				$viewHistory = json_decode(DB::query('SELECT p.name,p.price,p.avatar FROM cart c,product p WHERE c.user_id = ? AND c.product_id=p.id AND c.status=1', 'i', [$_SESSION['id']],1), true);
				if($viewHistory['status'] = 'OK')
				{
				return DB::query('SELECT p.name,p.price,p.avatar FROM cart c,product p WHERE c.user_id = ? AND c.product_id=p.id AND c.status=1', 'i', [$_SESSION['id']],1);
			}
				$messages['products_list'] = 'You did not buy any products yet.';

		}
	}
?>
