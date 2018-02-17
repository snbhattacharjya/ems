<?php
/*include('../config/config.php');
   $subdivision=$_POST['SelectSubdivision'];
	$postcategory=$_POST['SelectPostCategory'];
	echo $subdivision;
*/
?>
<script>
$('document').ready(function(){
	//$("#ShowDiv").hide('slide',500);
	LoadSubdivisionDetails('SelectSubdivision');
	LoadPostStatus_Details('SelectPostCategory');
	//LoadPostStatus_Details('SelectPostCategory1');
	LoadPPSelectedCatagorization_Details('SelectOffice_Category');
	LoadPPSelectedCatagorization_Details('SelectDesignation');
	LoadPPSelectedCatagorization_Details('SelectBasic_Pay');
	LoadPPSelectedCatagorization_Details('SelectGrade_Pay');
	LoadPPSelectedCatagorization_Details('SelectQualification');
	
	//LoadPPCategoryDetails('SelectParameter');
		//$('#SelectParameter').change(function(){
		
			/*if($(this).val()=='1'){
			 $('#ParameterValue').empty();
			 LoadGovtCattegoryDetails('ParameterValue'); 
			}
			 if($(this).val()=='5'){
			 $('#ParameterValue').empty();
			 LoadQualificationDetails('ParameterValue');
			 }*/
		//});
		/*var count;
		$('#Addbtn').click(function(){
			count=$('#SelectParameter option:selected').length;
			alert("You have Selected:"+count);
			var arr;
			arr=LoadValuesDetails(count);
			//alert(arr);
			});*/
		$('#button').click(function(){
			var subdiv=$("#SelectSubdivision").val().toString();
			var post_cat=$("#SelectPostCategory").val().toString();
			var off_cat=$("#SelectOffice_Category").val().toString();
			var desg=$("#SelectDesignation").val().toString();
			var basic_pay=$("#SelectBasic_Pay").val().toString();
			var grade_pay=$("#SelectGrade_Pay").val().toString();
			var qualification=$("#SelectQualification").val().toString();
			
			
		$.ajax({
		url: 'json/categorizationquery_details.php',
		type: 'POST',
		data: {
			subdivision:subdiv,
			postcategory:post_cat,
			officecat:off_cat,
			designation:desg,
			basicpay: basic_pay,
			gradepay:grade_pay,
			qualification:qualification
			},
		success: function(data) {
			$("#showcount").html(data);
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "html",
		async: false
	});
			//document.getElementById("ShowSubdivision").innerHTML=document.getElementById("SelectSubdivision").options[document.getElementById("SelectSubdivision").selectedIndex].text;
			//document.getElementById("ShowPostCategory").innerHTML=document.getElementById("SelectPostCategory").options[document.getElementById("SelectPostCategory").selectedIndex].text;
	       // $("#ShowDiv").show('slide',500);
			
		});
	
	//$('#update').click(function(){
		//LoadPostStatusUpdate_Details(id);
	//});
});

</script>
<div class="col-xs-12 col-sm-10">
	<div class="box">
    <div class="box-header">
				<div class="box-name">
					<i class="fa fa-search"></i>
					<span><font color="#6666FF">Categorization Details</font></span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<img src="icon/up.png"></img>
					</a>
					<a class="expand-link">
						<img src="icon/expand.png"></img>
					</a>
				</div>
				<div class="no-move"></div>
	  </div>
      <div class="box-content" id="SubdivisionDetails">
        <form class="form-horizontal" role="form">
         <div class="form-group" id="Parameter">
           <label class="col-sm-4 control-label"><font color="red">*</font>Select Subdivision</label>
						<div class="col-sm-6">
							<p>
							  <select name="SelectSubdivision" id="SelectSubdivision" class="populate placeholder" data-toggle="tooltip" data-placement="bottom" title="Select Subdivision">
							    <option value="0">Select Subdivision</option>
						      </select>
						  </p>
						</div>
          </div>
          </form>
          </div>
          <div class="box-content" id="PostCategoryDetails">
        <form class="form-horizontal" role="form">
         <div class="form-group" id="Category">
           <label class="col-sm-4 control-label"><font color="red">*</font>Select Post Category</label>
						<div class="col-sm-6">
							<p>
							  <select name="SelectPostCategory" id="SelectPostCategory" class="populate placeholder" data-toggle="tooltip" data-placement="bottom" title="Select Post Category">
							    <option value="0">Select Post category</option>
						      </select>
						  </p>
						</div>
          </div>
          </form>
          </div>
          </div>
     <div class="box-content" id="ParameterDetails">
        <form class="form-horizontal" role="form">
         <div class="form-group" id="Parameter">
           <label class="col-sm-4 control-label"><font color="red">*</font>Select Parameter</label>
						<div class="col-sm-6">Office Category
						  <p>
						    <select name="SelectOffice_Category" id="SelectOffice_Category" class="populate placeholder" data-toggle="tooltip" data-placement="bottom" title="Select Office Category" multiple="multiple">
                            <!--<option value="0">Select Office Category</option>-->
					        </select>
						  </p>
						  <p>Designation</p>
						  <p>
						    <select name="SelectDesignation" id="SelectDesignation" class="populate placeholder" data-toggle="tooltip" data-placement="bottom" title="Select Designation" multiple="multiple">
					        </select>
						  </p>
						  <p>Basic Pay</p>
						  <p>
						    <select name="SelectBasic_Pay" id="SelectBasic_Pay" class="populate placeholder" data-toggle="tooltip" data-placement="bottom" title="Select Basic Pay" multiple="multiple">
					        </select>
						  </p>
						  <p>Grade Pay</p>
						  <p>
						    <select name="SelectGrade_Pay" id="SelectGrade_Pay" class="populate placeholder" data-toggle="tooltip" data-placement="bottom" title="Select Grade Pay" multiple="multiple">
					        </select>
						  </p>
						  <p>Qualification</p>
						  <p>
						    <select name="SelectQualification" id="SelectQualification" class="populate placeholder" data-toggle="tooltip" data-placement="bottom" title="Select Qualification" multiple="multiple">
					        </select>
						  </p>
						</div>
          </div>
          <div class="form-group" id="NextDiv">
           
          </div>
          
          <div class="form-group" id="ShowDiv">
            <div class="form-group">
						<label class="col-sm-4 control-label">Selected Subdivision Name</label>
						<div class="col-sm-5" id="ShowSubdivision">
                      
                        </div> 
          </div>
            <div class="form-group">
						<label class="col-sm-4 control-label">Selected Post Category</label>
						<div class="col-sm-5" id="ShowPostCategory">
                      
                        </div> 
          </div>
          </div>
         <div class="form-group" id="">
            <div class="col-sm-4" id="">
             <input type="button" name="Addbtn" id="Addbtn" value="ADD">
             </div>
        </div>
        <div class="form-group" id="">
          <div class="col-sm-4" id="">
            <p>
              <input type="button" name="button" id="button" value="Save">
            </p>
          </div>
        </div>
        <div>Selected Personnel Count:</div>
        <div id="showcount">
        </div>
       <!-- <div>
        Enter number of employee go through:
        </div>
        <div>
        <input type="text" name="givenno" id="givenno" />
        </div>
        <div>
        <input type="button" name="update" id="update" value="Update" />
        </div>
         <div class="form-group" id="Category">
           <label class="col-sm-4 control-label"><font color="red">*</font>Select Post Category</label>
						<div class="col-sm-6">
							<p>
							  <select name="SelectPostCategory1" id="SelectPostCategory1" class="populate placeholder" data-toggle="tooltip" data-placement="bottom" title="Select Post Category">
							    <option value="0">Select Post category</option>
						      </select>
						  </p>
						</div>
          </div>-->
         </form>
     </div>
    </div>