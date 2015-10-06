$( document ).ready(function(){

	$.ajax({url: "products/view", success: function(result){

		if(result.status == 'OK') {
			var data = JSON.parse(result.data);
			console.log(data);
			for(var i = 0; i < data.length; i++) {

				var product = '<div class="product"><div class="image-wrapper"><img src="assets/images/products/' + data[i].image + '"></div><div class="product-details">' +
											'<div class="product-name">' + data[i].name + '</div><div class="product-price">' + data[i].price + '</div></div>' +
											'<a class="add-to-cart" product-id="' + data[i].id +'">Add to cart</a></div>';
				$('#products').append(product);
			}

		}

	}});

})
