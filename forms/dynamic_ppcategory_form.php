<script>
<?php
$offcat=$_POST['SelectParameter'];
?>
$('#SelectValue').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true
        });
		$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/ppcategorization_details.php',
		type: 'POST',
		
		data: {	
		OfficeCategory: <?php echo $offcat ?>	
		},
		
		success: function(data) {
			alert(OfficeCategory);
		var retObj = JSON.parse(JSON.stringify(data));
		$
		},
		error: function (jqXHR, textStatus, errorThrown) {
			//alert(errorThrown);
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	</script>
<div class="form-group" id="SelectValues1">
		  <label class="col-sm-4 control-label"><font color="red">*</font>Select Values</label>
          <span class="col-sm-6">
          <select name="SelectValue" id="SelectValue" class="populate placeholder" data-toggle="tooltip" data-placement="bottom" title="Select Values" multiple="multiple">
            <option>Select Values</option>
          </select>
          </span>
        </form>
					</div>