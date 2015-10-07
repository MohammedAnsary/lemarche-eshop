$( document ).ready(function() {

	 $('.file-mask').click(function() {
		 $('#upload-image').click();
	 });

	 $('#upload-image').change(function() {
		  $('.file-mask').html($('#upload-image').val().replace(/^.*\\/, "") + '	<span class="fa fa-camera"></span>');
	 });

	 $("form").submit(function(){
		  var oldpassword = $(this).find("input[name=oldpassword]");
			if(oldpassword.val()) {
				oldpassword.val(md5(oldpassword.val()));
			}
			var newpassword = $(this).find("input[name=newpassword]");
			if(newpassword.val()) {
				newpassword.val(md5(newpassword.val()));
			}
			var confirm = $(this).find("input[name=confirm]");
			if(confirm.val()) {
				confirm.val(md5(confirm.val()));
			}
	 });

});

var loadFile = function(event) {
	var preview = document.getElementById('preview');
	preview.src = URL.createObjectURL(event.target.files[0]);
}
