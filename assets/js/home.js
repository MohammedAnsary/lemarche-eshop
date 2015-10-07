
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
	console.log('getting cart');
	$.ajax({url: "products/cart", success: function(result){
		if(result.status == 'OK') {
			var data = JSON.parse(result.data);
			$('.cart-list').html('');
			for(var i = 0; i < data.length; i++) {
				var cartItem = '<li>' + data[i].quantity + ' X ' + data[i].name +
											 '<div class="close-btn menu-icon" product-id="' +
											 data[i]['product_id'] + '"><span class="fa fa-times"></span></div></li>';
				$('.cart-list').append(cartItem);
			}
		} else {
			alert('Internal Error');
		}
	}});
}

$( document ).ready(function(){

	$(document).on('click', '.add-to-cart', function(){ // Make your changes here
		var pid = $(this).attr('product-id');
		addToCart(pid);
	 });

	 $(document).on('click', '.close-btn', function(){ // Make your changes here
 		var pid = $(this).attr('product-id');
 		removeFromCart(pid);
 	 });

	$.ajax({url: "products/view", success: function(result){
		if(result.status == 'OK') {
			var data = JSON.parse(result.data);
			for(var i = 0; i < data.length; i++) {
				var product = '<div class="product"><div class="image-wrapper"><img src="assets/images/products/' + data[i].image + '"></div><div class="product-details">' +
											'<div class="product-name">' + data[i].name + '</div><div class="product-price">' + data[i].price + '</div></div>' +
											'<a class="add-to-cart" product-id="' + data[i].id +'">Add to cart</a></div>';
				$('#products').append(product);
			}
		}
	}});

	refreshCart();

})
