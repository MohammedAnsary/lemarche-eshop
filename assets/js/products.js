
function addToCart(pid){
	$.get("products/add", {pid : pid}, function(res) {
		var result = JSON.parse(res);
		if(result.status == 'OK') {
			refreshCart();
		} else if(result.status == 'NO'){
			alert(result.message);
		} else {
			alert('Internal Error');
		}
	});
}

function removeFromCart(pid){
	$.get("products/remove", {pid : pid}, function(res) {
		var result = JSON.parse(res);
		if(result.status == 'OK') {
			refreshCart();
		} else if(result.status == 'NO'){
			alert(result.message);
		} else {
			alert('Internal Error');
		}
	});
}

function refreshCart() {
	$.ajax({url: "products/cart", success: function(result){
		if(result.status == 'OK') {
			var data = JSON.parse(result.data);
			cart = data;
			$('#cart-list').html('');
			for(var i = 0; i < data.length; i++) {
				var cartItem = '<li>' + data[i].quantity + ' X ' + data[i].name +
											 '<div class="close-btn menu-icon" product-id="' +
											 data[i]['product_id'] + '"><span class="fa fa-times"></span></div></li>';
				$('#cart-list').append(cartItem);
			}
			if(data.length > 0) {
				$('#cart-list').append('<a id="check">Checkout</a>');
			}
		} else {
			alert('Internal Error');
		}
	}});
}

function populateOverlayCheckout() {
	$.ajax({url: "products/cart", success: function(result){
		if(result.status == 'OK') {
			var cart = JSON.parse(result.data);
			console.log(cart);
			$('.pop-up').html('');
			$('.pop-up').append('<h1>Checkout</h1><ul class="cart-list"></ul>');
			for(var i = 0; i < cart.length; i++) {
				var entry = '<li>' + cart[i].quantity + ' X ' + cart[i].name + '<div class="pop-up-right menu-icon">$' + (cart[i].quantity * cart[i].price) + '</div></li>';
				$('.pop-up .cart-list').append(entry);
			}
			$('.pop-up').append('<div class="pop-up-controls"><a class="confirm-checkout">Confirm</a><a class="cancel">Cancel</a></div>');
		} else {
			alert('Internal Error');
		}
	}});
}

function populateOverlayHistory() {
	$.ajax({url: "products/history", success: function(result){
		if(result.status == 'OK') {
			var cart = JSON.parse(result.data);
			console.log(cart);
			$('.pop-up').html('');
			$('.pop-up').append('<h1>History</h1><ul class="cart-list"></ul>');
			for(var i = 0; i < cart.length; i++) {
				var entry = '<li>' + cart[i].total + ' X ' + cart[i].name + '<div class="pop-up-right menu-icon">$' + (cart[i].total * cart[i].price) + '</div></li>';
				$('.pop-up .cart-list').append(entry);
			}
			$('.pop-up').append('<div class="pop-up-controls"><a class="cancel">Close</a></div>');
		} else {
			alert('Internal Error');
		}
	}});
}

function checkout() {
	$.ajax({url: "products/checkout", success: function(result) {
		console.log(result);
		if(result.status == 'OK') {
			$('.oaverlay').addClass('hidden');
			refreshCart();
		} else {
			alert('Internal Error');
		}
	}});
}
$( document ).ready(function(){

	$(document).on('click', '.add-to-cart', function(){
		var pid = $(this).attr('product-id');
		addToCart(pid);
	 });

	 $(document).on('click', '#check', function(){
 		$('.oaverlay').removeClass('hidden');
		populateOverlayCheckout();
 	 });

	 $(document).on('click', '.close-btn', function(){
 		var pid = $(this).attr('product-id');
 		removeFromCart(pid);
 	 });

	 $(document).on('click', '.cancel', function(){
 		$('.oaverlay').addClass('hidden');
 	 });

	 $(document).on('click', '.confirm-checkout', function(){
		checkout();
 	 });

	 $(document).on('click', '.history', function(){
		$('.oaverlay').removeClass('hidden');
		populateOverlayHistory();
 	 });

	$.ajax({url: "products/view", success: function(result){
		if(result.status == 'OK') {
			var data = JSON.parse(result.data);
			for(var i = 0; i < data.length; i++) {
				var product = '<div class="product"><div class="image-wrapper"><img src="assets/images/products/' + data[i].image + '"></div><div class="product-details">' +
											'<div class="product-name">' + data[i].name + '</div><div class="product-price">$' + data[i].price + '</div></div>' +
											'<a class="add-to-cart" product-id="' + data[i].id +'">Add to cart</a></div>';
				$('#products').append(product);
			}
		}
	}});

	refreshCart();

})
