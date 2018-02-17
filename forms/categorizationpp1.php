<?php
require "../config/config.php";
?>
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
       <label class="col-sm-4 control-label"><font color="red">*</font>Select Parameter</label>
						<div class="col-sm-6">
								
<script>
	LoadPPSelectedCatagorization_Details('SelectOffice_Category');
	LoadPPSelectedCatagorization_Details('SelectDesignation');
	LoadPPSelectedCatagorization_Details('SelectBasic_Pay');
	LoadPPSelectedCatagorization_Details('SelectGrade_Pay');
	LoadPPSelectedCatagorization_Details('SelectQualification');
 </script>
<form id="form1" method="post" name="form1">
	<style type="text/css">			
		.desc
		{
			padding-left:5px;
		}
		.kcbItem .kcbIn
		{
			line-height:25px;
		}
		.defaultKCB .kcbSelectFocus .kcbA .kcbIn
		{
			background:none;
			color:black;
		}
	</style>
	
	<table style="width:350px;">
		<tr>
			<td colspan="2">Select Office Category:</td>
		</tr>					
		<tr>
			<td id="SelectOffice_Category">
			</td>
			<td>
				<input type="submit" value="Select" />
			</td>
		</tr>
        <tr>
			<td colspan="2">Select Designation:</td>
		</tr>					
		<tr>
			<td id="SelectDesignation">
			</td>
			<td>
				<input type="submit" value="Select" />
			</td>
		</tr>
        
         <tr>
			<td colspan="2">Select Basic Pay:</td>
		</tr>					
		<tr>
			<td id="SelectBasic_Pay">
			</td>
			<td>
				<input type="submit" value="Select" />
			</td>
		</tr>
        
         <tr>
			<td colspan="2">Select Grade Pay:</td>
		</tr>					
		<tr>
			<td id="SelectGrade_Pay">
			</td>
			<td>
				<input type="submit" value="Select" />
			</td>
		</tr>
        
         <tr>
			<td colspan="2">Select Qualification:</td>
		</tr>					
		<tr>
			<td id="SelectQualification">
			</td>
			<td>
				<input type="submit" value="Select" />
			</td>
		</tr>				
	</table>	
	<div style="padding-top:10px;width:350px;min-height:50px;">

	</div>	
	
	<script language="javascript">
		var _item_select = false;
 
		kcb.registerEvent("OnBeforeSelect",function(sender,arg)
		{
			_item_select = true;
			return false;
		});
		kcb.registerEvent("OnBeforeClose",function(sender,arg)
		{
			if(_item_select)
			{
				_item_select = false;
				return false;
			}
			else
			{
				return true;	
			}
		});
		function on_checkbox_click()
		{
			var _selected_text = "";
			var office_category = document.getElementsByName("SelectOfficeCategory");
			for(var i=0;i<office_category.length;i++)
			{
				if(office_category[i].checked)
				{
					_selected_text+=", "+office_category[i].id;
				}
			}
			_selected_text = _selected_text.substr(2);
			//document.getElementById("kcb_selectedText").value = _selected_text;
		}		
	</script>	
    
    
    
    
    
    
    
    
    
    
    
    
    
 
</form>
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
         </form>
     </div>
    </div>
    <script>
	LoadPPSelectedCatagorization_Details('designation');
	</script>