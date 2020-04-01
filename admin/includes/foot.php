</div>
		
	<script>
		function updatesizes()
		{
		  var sizesstring='';
		  for (var i=1;i<=12;i++) {
		  	if (jQuery('#size'+i).val()!='') {
		  		sizesstring+=jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
		  	}

		  }
		  jQuery('#sizes').val(sizesstring);
		}
		function get_child_options()
		{
			var parentId=jQuery('#parent').val();
			jQuery.ajax({
				url :'/clothes8/admin/parsers/child_cat.php',
				type :'POST',
				data :{parentId:parentId},
				success :function(data){
					jQuery('#child').html(data);
				},
				error :function(){
					alert("somethinf went wrong");
				}
			});
		}

		jQuery('select[name="parent"]').change(function(){get_child_options()});
	</script>

</body>
</html>