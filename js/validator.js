// JavaScript Document
function validateForm(FormID)
{
	var returnVal=true;
	//alert(FormID);
	//Checking Required
	$('#'+FormID).find('.check-required').each(function(index, element) {
        if(!checkRequired($(this).val()))
		{
			$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
			//alert($(this).val());
			returnVal=false;
		}
		else
		{
			$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
		}
    });
	
		//Checking Required for combo-box
	$('#'+FormID).find('select').each(function(index, element) {
        if(!checkRequiredForCombobox($(this).val()))
		{
			$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
			//alert($(this).val());
			returnVal=false;
		}
		else
		{
			$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
		}
    });
	
	//Checking character
	$('#'+FormID).find('.check-string').each(function(index, element) {
        if(!checkString($(this).val()))
		{
			$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
			//alert("13");
			returnVal=false;
		}
		else
		{
			$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
		}
    });
		
	//Checking Pin
	$('#'+FormID).find('.check-pin').each(function(index, element) {
        if(!checkPin($(this).val()))
		{
			$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
			//alert("14");
			returnVal=false;
		}
		else
		{
			$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
			//$(this).parent(".form-group").find(".control-label").prepend("<i class='fa fa-check'></i> ");
		}
    });
	
	
	//Checking email
	$('#'+FormID).find('.check-mail').each(function(index, element) {
        if(!emailaddresscheck($(this).val()))
		{
			$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
			//alert("15");
			returnVal=false;
		}
		else
		{
			$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
			//$(this).parent(".form-group").find(".control-label").prepend("<i class='fa fa-check'></i> ");
		}
    });
	
	//Checking email if exsist
	$('#'+FormID).find('.check-mail-if-available').each(function(index, element) {
		if($(this).val()=="")
					$(this).parent("div").parent(".form-group").removeClass("has-error").removeClass("has-success");
		else
		{
			if(!emailaddresscheck($(this).val()))
			{
				$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
				//alert("15");
				returnVal=false;
			}
			else
			{
				$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
				//$(this).parent(".form-group").find(".control-label").prepend("<i class='fa fa-check'></i> ");
			}
		}
    });
	
	
	//Checking mobile
	$('#'+FormID).find('.check-mobile').each(function(index, element) {
        if(!checkformobile($(this).val()))
		{
			$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
			//alert("16");
			returnVal=false;
		}
		else
		{
			$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
			//$(this).parent(".form-group").find(".control-label").prepend("<i class='fa fa-check'></i> ");
		}
    });
	
	
	//Checking for phone
	$('#'+FormID).find('.check-phone').each(function(index, element) {
        if(!checkforphone($(this).val()))
		{
			$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
			//alert("17");
			returnVal=false;
		}
		else
		{
			$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
			//$(this).parent(".form-group").find(".control-label").prepend("<i class='fa fa-check'></i> ");
		}
    });
	
	//Checking for phone if exsist
	$('#'+FormID).find('.check-phone-if-available').each(function(index, element) {
		if($(this).val()=="")
			$(this).parent("div").parent(".form-group").removeClass("has-error").removeClass("has-success");
		else
		{
			if(!checkforphone($(this).val()))
			{
				$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
				//alert("17");
				returnVal=false;
			}
			else
			{
				$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
				//$(this).parent(".form-group").find(".control-label").prepend("<i class='fa fa-check'></i> ");
			}
		}
    });
	
	//check for date of birth
	$('#'+FormID).find('.check-dob').each(function(index, element) {
        if(!checkDOB($(this).val()))
		{
			$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
			returnVal=false;
		}
		else
		{
			$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
		}
    });
		
	//Checking for total pp1 emp
	$('#'+FormID).find('.check-total').each(function(index, element) {
        if(!checkTotal($(this).val()))
		{
			$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
			//alert("18");
			returnVal=false;
		}
		else
		{
			$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
			//$(this).parent(".form-group").find(".control-label").prepend("<i class='fa fa-check'></i> ");
		}
    });
	
	
	
	//Checking for acc number
	$('#'+FormID).find('.check-acc-no').each(function(index, element) {
        if(!checkAccNo($(this).val()))
		{
			$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
			//alert("18");
			returnVal=false;
		}
		else
		{
			$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
			//$(this).parent(".form-group").find(".control-label").prepend("<i class='fa fa-check'></i> ");
		}
    });
	
	//Checking for non-zero number if exsist
	$('#'+FormID).find('.check-number').each(function(index, element) {
		
		if($(this).hasClass('if-available'))
		{
			if(checkRequired($(this).val())){
				if(!checkNumber($(this).val())){
					$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
					returnVal=false;
				}
				else{
					$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
				}
			}
			else{
				$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
			}
		}
		else
		{
			if(!checkNumber($(this).val())){
				$(this).parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
				returnVal=false;
			}
			else{
				$(this).parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
			}
		}
    });
	

	return returnVal;
}


//check if empty
function checkRequired(element)
{
	if(element != null && element.length > 0)
		return true;
	else
		return false;
}


//check if combobox empty
function checkRequiredForCombobox(element)
{
	//alert(element);
	if(element != null && element.length > 0)
		return true;
	else
		return false;
}

//check if only character exsist
function checkString(element)
{
	var pattern= /[^a-z(.)\s]/gi;
	var result=element.match(pattern);
	if(result == null && checkRequired(element))
		return true;
	else
		return false;
}


//check for number
function checkNumber(element)
{
	var pattern= /\D/;
	var result=element.match(pattern);
	if(result == null)
		return true;
	else
		return false;
}




function checkPhone(element)
{
	var pattern= /\D/;
	var result=element.match(pattern);
	if(result == null)
		return true;
	else
		return false;
}

function checkAge(element)
{
	if(checkNumber(element) && element >=1 && element < 200)
		return true;
	else
		return false;
}


//check for pin
function checkPin(element)
{
	if(checkNumber(element) && element.length==6)
		return true;
	else
		return false;
}


//checking for blank space
function blankcheck(element)
{
	if((/\s/.test(element)))
	{
		return true;
	}
	else
	{
		return false;
	}

}


//checking for valid name
function namecheck(element)
{
	var re = /^[A-Za-z\s.]+$/;
    if(re.test(element))
   	{
		return true;
	}
    else
    {
		return false;
	}
}


//checking f
function charactercheck(element)
{
	var a=isNaN(element);
	if(a==true)
	{
		return false;
	}
	else
	{
		return true;
	}
}


//check if special character exist
function spacialchactercheck(element)
{
	var iChars = "~`!#$%^&*+=-[]\\\';,/{}|\":<>?";

	for (var i = 0; i < element.length; i++)
	{
  		if (iChars.indexOf(element.charAt(i)) != -1)
  		{
     		return false;
  		}
	}
	return true;
}


//check for email id
function emailaddresscheck(element)
{
	//alert(emailidvalue);
	element=element.toLowerCase();
	var emailfilter =/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

	if((!(emailfilter.test(element)))) {
		return false;
	}
	else
	{
		return true;
	}
}


//check for mobile
function checkformobile(element)
{
	if(checkNumber(element) && element.length==10 && checkRequired(element))
	{
		return true;
	}
	else
	{
		return false;
	}
}


//check for phone number
function checkforphone(element)
{
	if(checkRequired(element) && checkPhone(element) && element.length>=8 && element.length<=15)
	{
		return true;
	}
	else
	{
		return false;
	}
}


//check for date of birth

function checkDOB(element)
{
	if(element=="Invalid date")
	{
		return false;
	}
	else
	{
		return true;
	}
}
//check for NON-empty number
function checkfornumber(element)
{
	if(checkNumber(element) && checkRequired(element))
	{
		return true;
	}
	else
	{
		return false;
	}
}


function checkTotal(element)
{
	if(checkRequired(element) && element>0)
	{
		var pattern= /\D/;
		var result=element.match(pattern);
		if(result == null)
			return true;
		else
			return false;
	}
	else
	{
		return false;
	}		
}


function checkAccNo(element)
{
	var pattern= /\D/;

	if(checkRequired(element) && element>0)
	{
		var result=element.match(pattern);
		if(result == null)
			return true;
		else
			return false;
	}
	else
	{
		return false;
	}		
}