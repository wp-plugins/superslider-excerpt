<script language="javascript" type="text/javascript">
	jQuery(document).ready(function(){

;(function($) {
    
      $("#acc-box .ss-toggler-open").click(function(){
        $("#acc-box .ss-acc-advanced").slideToggle(1200);
        $(this).hide();
        return false;
      
    });
    
    $("#acc-box .ss-toggler-close").click(function(){
        $("#acc-box .ss-acc-advanced").slideToggle("slow");
        $("#acc-box .ss-toggler-open").show();
        return false;
      
    });

})(jQuery);
    
});
	
	
	
	function insertAtCursor(myField, myValue) {
		//IE support
		if (document.selection) {
			myField.focus();
			sel = document.selection.createRange();
			sel.text = myValue;
		}
		//MOZILLA/NETSCAPE support
		else if (myField.selectionStart || myField.selectionStart == '0') {
			var startPos = myField.selectionStart;
			var endPos = myField.selectionEnd;
			myField.value = myField.value.substring(0, startPos)
			+ myValue
			+ myField.value.substring(endPos, myField.value.length);
		} else {
			myField.value += myValue;
		}
	}

	function addacc() {
		var show_code = '[accordion ';
			
		var f = document.getElementById('fixheight'); 
		if (f.value != "") {
			show_code = show_code+'acc_fixedheight="'+f.value+'" ';
			}
		var f = document.getElementById('fixwidth'); 
		if (f.value != "") {
			show_code = show_code+'acc_fixedwidth="'+f.value+'" ';
			}
		var f = document.getElementById('acc_height'); 
		if (f.checked != "") {
			f.value = 'true';
			show_code = show_code+'acc_height="'+f.value+'" ';
			}
		var f = document.getElementById('acc_width'); 
		if (f.checked != "") {
			f.value = 'true';
			show_code = show_code+'acc_width="'+f.value+'" ';
			}
		var f = document.getElementById('acc_opacity'); 
		if (f.checked != "") {
			f.value = 'true';
			show_code = show_code+'acc_opacity="'+f.value+'" ';
			}
		var f = document.getElementById('acc_first'); 
		if (f.value != "") {
			show_code = show_code+'acc_firstopen="'+f.value+'" ';
			}
		var f = document.getElementById('acc_mode'); 
		if (f.checked != "") {
			f.value = 'on';
			show_code = show_code+'acc_mode="'+f.value+'" ';
			}
		var f = document.getElementById('acc_all'); 
		if (f.checked != "") {
			f.value = 'true';
			show_code = show_code+'acc_openall="'+f.value+'" ';
			}
		var f = document.getElementById('acc_togtag');
			var g = f.value;
		var f = document.getElementById('acc_elemtag');
			var h = f.value;
		
				show_code = show_code+']\n<'+g+'>toggle one</'+g+'>\n<'+h+'>content one</'+h+'>\n<'+g+'>toggle two</'+g+'>\n<'+h+'>content two</'+h+'>\n<'+g+'>toggle three</'+g+'>\n<'+h+'>content three</'+h+'>\n[/accordion]\n<div class="toggleAllAcc">toggle all Button</div>\n<div class="openAllAcc">open all Button</div>\n<div class="closeAllAcc">close all Button</div>';
				var destination1 = document.getElementById('content');
				
				if (destination1) {
				// calling the function
					insertAtCursor(destination1, show_code);
				}
				/*var destination2 = content_ifr.tinymce;
				var destination2 = window.frames[0].document.getelementbyid('tinymce')
				if (destination2) {
					destination2.value += show_code;
					 alert(document.frames("content_ifr").document.getelementbyid('tinymce').value);
					}*/
			
}

</script>