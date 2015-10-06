$( document ).ready(function() {

	 $('.file-mask').click(function() {
		 $('#upload-image').click();
	 });

	 $('#upload-image').change(function() {
		  $('.file-mask').html($('#upload-image').val().replace(/^.*\\/, "") + '	<span class="fa fa-camera"></span>');
	 });

	 $("form").submit(function(){
		  var password = $(this).find("input[name=password]");
			if(password.val()) {
				password.val(md5(password.val()));
			}
			var confirm = $(this).find("input[name=confirm]");
			if(confirm.val()) {
				confirm.val(md5(confirm.val()));
			}
	 });

});
