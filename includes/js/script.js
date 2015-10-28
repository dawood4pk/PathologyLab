function TestRepetition(objTestName)
{
    var nRowCount=document.getElementById("rowcount");
    var arTmp=objTestName.name.split("_");
    var no=arTmp[3];

    //alert("Current Value of cell: "+objTestName.value);

    for(cnt=1;cnt<=nRowCount.value;cnt++)
    {
        if (no!=cnt) 
        {
            var sty=$("#myGrid_t_testname_"+cnt);
            //alert("Current Value of loop: " + sty.value);
            if(objTestName.value == sty.val())
            {
                alert(sty.val()+ ' already exist in list');
                $("#"+objTestName.name).focus();
                return true;
            }
        }
    }
    //alert("dawood ----------------- proceding");    
    return false;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function GetTestInfo(objTestName)
{
	
    if(objTestName.value.length  < 5)
        return;	
    if(TestRepetition(objTestName)==true)
    {
      $("#"+objTestName.name).focus();
        return false;
    }

		if(objTestName.value.trim()  == "")
       	 	return;

    	$.post(js_base_path+'home/get_medical_test_info',
      	{ 'testname':objTestName.value.trim() },
      	function(result) {
		
        	if(result) {
            	if(result==0)
            	{
                	arTmp=objTestName.name.split("_");
               	 	no=arTmp[3];
               	 	$( "#dialog-form" ).dialog( "open" );

                	$('#popuptestname').val(objTestName.value.trim());
                	$('#popuptestname').focus();     //popup_msg
                	$('#popupforrow').val(no);
                	return 0;
            	}
				arValues=result.split("|");
				arTmp=objTestName.name.split("_");
				no=arTmp[3];
            	$('#myGrid_t_id_'+no).val(arValues[0]);
            	$('#myGrid_t_testname_'+no).val(arValues[1]);
           	 	$('#myGrid_t_testresult_'+no).focus();
           		// var position = $('#myGrid_t_testresult_'+no).position();
            	//alert(position.top);
				//alert(result);

			}
		})
}
///////////////
function ShowEditTest(popupId, objName)
{
	if(!objName || objName=='')
        return;
	//alert('ShowHideEditTest');
	arTmp = objName.split("_");
    nRow=arTmp[3];
	if (document.getElementById("myGrid_t_id_"+nRow).value != "")
	{
		$('#'+popupId).show();
		var art_pos = $('#'+objName).position();
    	var pop_pos = $('#'+popupId).position();
    	$('#'+popupId).css('top', art_pos.top-8);
		$('#'+popupId).css('left', art_pos.left+60);
		//$('#'+popupId).css(''
		//alert('nRow:'+nRow);
		document.getElementById('edit').title=document.getElementById("myGrid_t_testname_"+nRow).value;
		document.getElementById('rowno').title=arTmp[3];

		//$('#'+popupId).hide(15000);
	}
	else
	{
		$('#'+popupId).hide();
		document.getElementById('edit').title="";
	}
}

function EditTestInfo() 
{
	if(!confirm("Are you sure you want to edit \""+document.getElementById('edit').title+"\"?"))
    	return false;
		var tname = document.getElementById('rowno').title;
		//alert(tname);
		//return;

    	$.post(js_base_path+'home/get_medical_test_info',
      	{ 'testname':document.getElementById('edit').title },
      	function(result) {
        	if(result) {
				
				var arValues = result.split("|");
				$( "#dialog-form" ).dialog( "open" );
                	$('#popuptestname').val(arValues[1]);
                	$('#popuptestname').focus();     //popup_msg
                	$('#popupforrow').val(tname);
			}
		})
}
/*
jQuery(function($){

    // Autocomplete on User Supplied data
       $(function(){
        $("input[title='Test Name']").autoComplete({ajax: 'medical_test_ac'});
    });

});*/
$(function() {

		$("input[title='Test Name']").autocomplete({
			source: "medical_test_ac",
			minLength: 1
		});

		$("#patientusername").autocomplete({
			source: "patient/patient_username_ac",
			minLength: 1
		});

	});