$('document').ready(function(){
$("input").on("copy",function(){return false;});
$("input").on("paste",function(){return false;});
$("input").on("drag",function(){return false;});
$("input").on("drop",function(){return false;});
});
function data_copy()
{
if($("#SameAddress").prop('checked')==true){
	
	$("#PermanentAddress1").val($("#PresentAddress1").val());
	$("#PermanentAddress2").val($("#PresentAddress2").val());
	
}else{
$("#PermanentAddress1").val();
$("#PermanentAddress2").val();
}

}
function blankcheck(textid)
{
	var value=$("#"+textid).val();
	if((/\s/.test(value)))
	{
		$('#'+textid).focus();
		$("#div_"+textid).removeClass('has-success').addClass("has-error");
		return 0;
	}
	else
	{
		$("#div_"+textid).removeClass("has-error").addClass("has-success");
		return 1;
	}

}
function namecheck(numberid)
{
	var text=$("#"+numberid).val();
	var re = /^[A-Za-z\s]+$/;
    if(re.test(text))
   	{
		$("#div_"+numberid).removeClass("has-error").addClass("has-success");
		return 1;
	}
    else
    {
		$("#div_"+numberid).removeClass("has-success").addClass("has-error");
		$("#"+numberid).focus()
		return 0;
	}
}
function charactercheck(characterid)
{
	var a=isNaN($("#"+characterid).val());
	if(a==true)
	{
		$("#div_"+characterid).removeClass("has-success").addClass("has-error");
		$("#"+characterid).focus();
		return 0;
	}
	else
	{
		$("#div_"+characterid).removeClass("has-error").addClass("has-success");
		return 1;
	}
}
function spacialchactercheck(spacalnumerictextid)
{
	var iChars = "~`!#$%^&*+=-[]\\\';,/{}|\":<>?";

	for (var i = 0; i < $("#"+spacalnumerictextid).val().length; i++)
	{
  		if (iChars.indexOf(spacalnumerictextid.value.charAt(i)) != -1)
  		{
			$("#div_"+spacalnumerictextid).removeClass("has-success").addClass("has-error");
			$("#"+spacalnumerictextid).focus();
     		return 0;
			exit;
  		}
	}
	$("#div_"+spacalnumerictextid.id).removeClass("has-error").addClass("has-success");
	return 1;
}

/*function alphanumericcheck(alphanumerictextid)
{
	    /*if(alphanumerictextid!=/^([0-9],[A-Z],[a-z])$/)
		{
		alert("Please enter alphanumeric data");
}//
 for(var i=0; i<alphanumerictextid.value.length; i++)
      {
        var char1 = alphanumerictextid.value.charAt(i);
        var cc = char1.charCodeAt(0);

        if((cc>47 && cc<58) || (cc>64 && cc<91) || (cc>96 && cc<123))
        {

        }
         else {
         alert('Input is not alphanumeric');
		 document.getElementById("alphanumerictextid").Focus();
         return false;
         }
      }
     return true;     
}*/

function selectioncheck(selectiontextid)
{
	var st="Select";
	for(var i=0; i<6; i++)
      {		
        var char1 = selectiontextid.value.charAt(i);
        var cc = char1.charCodeAt(0);
		var char2 = st.charAt(i);
		var cc1 = char2.charCodeAt(0);

        if(cc!=cc1)
        {
			
        }
         else {
         alert('Input is not selected');
		 $("#div_"+selectiontextid.id).addClass("has-error");
		document.getElementById("#"+selectiontextid).focus();
		 //document.getElementById("alphanumerictextid").Focus();
         return 0;
         }
      }
	  return 1;    
}
function emailaddresscheck(emailid)
{
	var emailidvalue=$("#"+emailid).val();
	//alert(emailidvalue);
	var emailfilter =/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

	if((!(emailfilter.test(emailidvalue)))) {
   		$("#div_"+emailid).removeClass('has-success').addClass("has-error");
		$("#"+emailid).focus();
		return 0;
		exit;
	}
	else
	{
		$("#div_"+emailid).removeClass("has-error").addClass("has-success");
		return 1;
	}
}

function lengthcheckformobile(mobileid)
{
	var mobilevalue=$("#"+mobileid).val();
	if(mobilevalue.length!=10)
	{
		$("#div_"+mobileid).removeClass('has-success').addClass("has-error");
		$("#"+mobileid).focus();
		return 0;
		exit;
	}
	else
	{
		$("#div_"+mobileid).removeClass("has-error").addClass("has-success");
		return 1;
	}
}

function lengthcheckforphone(phoneid)
{
	var phonevalue=$("#"+phoneid).val();
	if(phonevalue.length==8||phonevalue.length==11||phonevalue.length==13)
	{
		$("#div_"+phoneid).removeClass('has-error').addClass("has-success");
		return 1;
	}
	if(phonevalue.length==11)
	{
		$("#div_"+phoneid).removeClass('has-error').addClass("has-success");
		return 1;
	}
	if(phonevalue.length==13)
	{
		$("#div_"+phoneid).removeClass('has-error').addClass("has-success");
		return 1;
	}
	else
	{
		$("#div_"+phoneid).removeClass("has-success").addClass("has-error");
		$("#"+phoneid).focus();
		return 0;
		exit;
	}
}