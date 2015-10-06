$( document ).ready(function() {

	 $("form").submit(function(){
		  var password = $(this).find("input[name=password]");
			if(password.val()) {
				password.val(md5(password.val()));
			}
	 });

});
