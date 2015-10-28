    <script>
    $(function() {
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
        
        var popuptestname   = $( "#popuptestname" ),
            allFields = $( [] ).add( popuptestname ),
            tips = $( ".validateTips" );

        function updateTips( t ) {
            tips
                .text( t )
                .addClass( "ui-state-highlight" );
            setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }

        function checkLength( o, n, min, max ) {
            if ( o.val().length > max || o.val().length < min ) {
                o.addClass( "ui-state-error" );
                updateTips( "Length of " + n + " must be between " +
                    min + " and " + max + "." );
                return false;
            } else {
                return true;
            }
        }

        function checkRegexp( o, regexp, n ) {
            if ( !( regexp.test( o.val() ) ) ) {
                o.addClass( "ui-state-error" );
                updateTips( n );
                return false;
            } else {
                return true;
            }
        }
        
        $( "#dialog-form" ).dialog({
            autoOpen: false,
            height: 300,
            width: 800,
            modal: true,
            buttons: {
                "Save": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( popuptestname, "Test Name", 3, 20 );
					if ( bValid ) 
                    {
						if ($('#myGrid_t_id_'+$('#popupforrow').val()).val() == "")
						{
							//alert('save');
							$.post(js_base_path+'home/save_medical_test',
                          	{ 'testname':popuptestname.val() },
                          	function(result){
                            	if(result) {
                              	  if(jQuery.trim(result)!=0)
                                	{
                                   	 	no = $('#popupforrow').val();
                                   		$('#myGrid_t_id_'+no).val(jQuery.trim(result));
                                   		$('#myGrid_t_testname_'+no).val($.trim($('#popuptestname').val()));
                                    	$( "#dialog-form" ).dialog( "close" );
                                    	$('#myGrid_t_testresult_'+no).focus();
                                	}
                                	else
                                    	alert("Data not saved");
                            	}
                        	})// end of save.
						}
						else
						{
							//alert('edit');
							$.post(js_base_path+'home/edit_medical_test',
                          	{ 'testid':$('#myGrid_t_id_'+$('#popupforrow').val()).val(), 'testname':popuptestname.val() },
                          	function(result){
                            	if(result) {
									//alert('result'+result);
                              	  if(jQuery.trim(result)==0)//later
                                	{
                                   	 	no= $('#popupforrow').val();
                                   		//$('#myGrid_t_id_'+no).val(jQuery.trim(result));
                                   		$('#myGrid_t_testname_'+no).val($.trim($('#popuptestname').val()));
                                    	$( "#dialog-form" ).dialog( "close" );
                                    	$('#myGrid_t_yd_'+no).focus();
                                	}
                                	else
                                    	alert("Data not edit");
                            	}
                        	})// end of edit.
						}
                    }// end of bValid if.
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });

        $( "#create-user" )
            .button()
            .click(function() {
                $( "#dialog-form" ).dialog( "open" );
            });
            
    });
    function closeit()
    {
        $( "#dialog-form" ).dialog( "close" );
    }
    </script>

<div id="dialog-form" title="Create new Medical Test." >
    <p class="validateTips">All form fields are required.</p>

        <div class="panel_grp" >
             <div class="popup_label_left">    Test Name    </div>
             <div>
                <input size="10" type="text" class="defaultText" name="popuptestname" id="popuptestname">
             </div>  
         </div>  

         <div class="popup_btns">
            <input type="hidden" id="popupforrow" id="popupforrow" value="0">
         </div>
</div>