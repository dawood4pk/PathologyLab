<?php /*?><script type="text/javascript" src="<?php echo JSPATH?>grid.js"></script>
<link rel="stylesheet" href="<?php echo CSSPATH?>grid.css" type="text/css" /><?php */?>
<script>
function delRow(rows,nRowsToDel,nRowToDel)
{
    if($("#myGrid_t_"+fldList[1][1]+"_"+nRowToDel))
    {
        //var nId=jQuery.trim($("#myGrid_t_"+fldList[1][1]+"_"+nRowToDel).val());
        if(jQuery.trim($("#myGrid_t_"+fldList[1][1]+"_"+nRowToDel).val())!="")
        {
            if(!confirm("Are you sure you want to delete this record?"))
                return false;
        }
    }
    var _row = rows.parentNode.parentNode.parentNode;

    //fldList[1][1]
    //alert(_row.rowIndex);
    rowToDel= _row.rowIndex;
    document.getElementById('myGrid').deleteRow(rowToDel);
    if(nRowsToDel==2)
        document.getElementById('myGrid').deleteRow(rowToDel);
}
function GetValidNumber(nVal)
{
    //alert(txtObj.value);
    nToChk=nVal;
    if(nToChk=="")
        return 0;
    if (isCurrency(nToChk,'$'))
    {
        nToChk=removeCurrency(nVal);
    }
    else if (isCurrency(nToChk,"\u20AC"))
    {
        nToChk=removeCurrency(nVal);
    }
    else if (isMeasure(nToChk,"m"))
    {
        nToChk=removeMeasure(nVal);
    }
    else if (isMeasure(nToChk,"yd"))
    {
        nToChk=removeMeasure(nVal);
    }
    else
    {
        nToChk=removePercentage(nVal)
    }
    nToChk=removeCommas(nToChk);
    //alert(nToChk);
    if(parseFloat(nToChk)!=nToChk)
        return 0 ;
    else
    {
       // alert(nToChk + " " + removeCommas(nToChk));
        return nToChk ;
    }
    //isPercentage('20%');
    //isPercentage('20');
}

function removeCommas(aNum)
{
    if(aNum==0)
        return aNum;
    aNum=aNum.replace(/,/g,"");
    //aNum=aNum.replace(/\s/g,"");
    //alert(n +" " + aNum);
    return aNum;
}//end of removeCommas(aNum)
</script>
<style>
.clsTxtFld {color: blue; align:right;border: none;}
.clsDataCell {color: black; align:right;border: none;font-size:10px;text-align: center;}
.clsTblHeader {font-size:12px; background-color: lightgray;}
.clsGridTbl { border-collapse: collapse; border-style: solid; border-color: gray;}
.extRowHiddenClass{background-color: #F4FDFF ;display:none; }  /*extra row class*/
.extRowClass{background-color: #F4FDFF ; }  /*extra row class*/
.extLbl{margin-left: 15px; }
.clsTxtArea{color: blue; align:left;border: none;height:20px;}
</style>
<?php include("Browser.php"); ?>

<!--<table border="0" align="left" cellpadding="0" cellspacing="0"  >
<tr><td><img src="<?php //echo IMGPATH?>add_1.png" onclick="myGridAdd('myGrid');" style='cursor:pointer;' alt="Add Row">  </td></tr>
<tr><td>           -->
<title></title>
<div id="grid_main">
    <div id="tblheader" >
    <table id="tbl_header" border="1" class="clsGridTbl"><tr class="clsTblHeader">
    <?php

    // Grid Table Header
	$strGridHeading="<table border='1' class='clsGridTbl'><tr class='clsTblHeader'>";
    $strTotalingFlds="";
    $nColSpan=0;
    $bTotalRequired=false;
    $nColWidthTotal=0;
    for($cnt=0;$cnt<count($arGridFlds);$cnt++)
    {
        $fld=$arGridFlds[$cnt];
        $lbl=$fld['label'];
        $strType="text";//$fld['type'];
		//Windows (Browser::PLATFORM_WINDOWS)
		$Browser = new Browser();
		if( $Browser->getBrowser() == "Internet Explorer" && !(isset($report) && $report == true) )
		{
			$nColWidth=($fld['size']+1.65).'px';
		}
		elseif ($Browser->getBrowser() == "Chrome" && $Browser->getPlatform() == "Apple" && !(isset($report) && $report == true) )
		{
			//echo $Browser->getPlatform();
			$nColWidth=($fld['size']+1.99).'px';
		}
		elseif ($Browser->getBrowser() == "Safari" && $Browser->getPlatform() == "Apple" && !(isset($report) && $report == true) )
		{
			//echo $Browser->getPlatform();
			$nColWidth=($fld['size']+1.99).'px';
		}
		else
		{
			$nColWidth=$fld['size'].'px';//GetColWidth($fld['size']).'px';
		}

        $strCtrl="";
        //if($cnt==0){
    //    echo "<pre>";
    //    print_r($arHeaderFlds); }
        $strCtrl="";
        if(count($arHeaderFlds[$cnt])>0)
        {
            $strCtrl=GetCtrl($arHeaderFlds[$cnt]);
        }
        if($strType=="hidden")
        {
            echo "\n <th  style='display:none;'>$lbl</th> \n";
            $strGridHeading.= "\n <th  style='display:none;'></th> \n";
            $nColSpan++;
        }
        else
        {
            echo "\n <th  style='width:$nColWidth;'> $lbl $strCtrl</th> \n";
            $nColSpan++;
            $nColWidthTotal+=$nColWidth;
            $strControl="";
            if(isset($fld['isTotalRequired']) && $fld['isTotalRequired']==1 )
			{
                if($bTotalRequired==false)
                {
                    $nColWidthTotal-=$nColWidth;
                    $nColWidthTotal+=9;
                    $strGridHeading.= "\n <td style='width:$nColWidthTotal".'px'.";'>&nbsp;</td> \n";
                }
                $strFldName=$fld['name']."_total";
				$strControl="<input type=text class='clsTxtFld' readonly style='width:$nColWidth;text-align:center;' id='$strFldName' name='$strFldName' />";
                $strGridHeading.= "\n <td  style='width:$nColWidth;'>$strControl</td> \n";
                $strTotalingFlds.=$fld['name']."||".$fld['special_sign'].",";
                $bTotalRequired=true;
			}
            else
            {
            if($bTotalRequired)
                $strGridHeading.= "\n <td  style='width:$nColWidth;'>&nbsp;</td> \n";
            }
        }
    }
    if(isset($fld['isTotalRequired']) && $fld['isTotalRequired']==1 )
        $strTotalingFlds=substr($strTotalingFlds,0,strlen($strTotalingFlds)-1);
    /// END grid header
    if(isset($arData) && count($arData)>0)
        $nRowCount=count($arData);
    else
        $nRowCount=$nIntRows;

	if($bTotalRequired)
    	$strGridHeading.="<td><img src='".IMGPATH."add_2.png' onclick=\"myGridAdd('myGrid');\" style='cursor:pointer;' alt='Add Row'></td></tr> </table>";
	else
		$strGridHeading.="</tr> </table>";

	if (!(isset($report) && $report == true))
	{
		echo "<td><div id='footer_buttons'><img src='".IMGPATH."add_2.png' onclick=\"myGridAdd('myGrid');\" style='cursor:pointer;' alt=\"Add Row\"></div></td></tr>";
   	}
	?>

    </table>
</div>  <!--end of table header   -->
<?php if (!(isset($report) && $report == true)) {?>
    <div style="overflow:auto;height:270px;">
     <?php } else { ?>
          <div >
     <?php }?>
        <table border="1" id="myGrid" name="myGrid" style="" class="clsGridTbl">
            <tr style="display:none;"><td></td></tr>
        </table>
    </div>

    <div id="tlb_footer"><?php echo $strGridHeading; ?> </div>

</div>

<!--<tr><td><div id='footer_buttons'><img src="<?php // echo IMGPATH?>add_1.png" onclick="myGridAdd('myGrid');" style='cursor:pointer;'  alt="Add Row"> </div> </td></tr>

</table>-->


<input type="hidden" value="0" name="rowcount" id="rowcount" >
<script>
var fldTotaling="<?php echo $strTotalingFlds ?>";
arData=new Array();
var fldList=new Array();
<?php
$cnt=1;
foreach($arGridFlds as $fld)
{
    $fld=$fld['name'];
    echo "\n fldList[$cnt] = new Array(2);\nfldList[$cnt][1]='$fld';\nfldList[$cnt][2]='text';\n\n";
    $cnt++;
}
echo "\n //-------- end of fields array \n";
if(isset($arData) and count($arData)>0)
{
    for($cnt=0;$cnt<count($arData);$cnt++)
    {
        $nCols= count($arData[$cnt]);
        echo "arData[$cnt]=new Array($nCols)";
        for($cntCol=0;$cntCol<count($arData[$cnt]);$cntCol++)
        {
            echo "\n arData[$cnt][$cntCol]='".$arData[$cnt][$cntCol]."';";
        }
    }
}
?>
gridName="myGrid";
nColCount=1;
function myGridAdd(tblId,arData)
{
    if(!arData)
        arData=new Array();
    var tblBody = document.getElementById(tblId).tBodies[0];
    row=tblBody.rows.length; //-1 ;
    var newRow = tblBody.insertRow(-1);
    if((nColCount%2)==0)
    {
        strTxtColor="background-color:<?php echo $evenRowColor?>;";
        strTDColor="<?php echo $evenRowColor?>";
    }
    else
    {
        strTDColor="<?php echo $oddRowColor?>";
        strTxtColor="background-color:<?php echo $oddRowColor?>;";
    }

        <?php
        $nNewCell=0;
        $nNewRow=1;
        $bHaveHiddenFld=false;
        //// for extra row for notes init
        $nRowsToDel=1;
        $strImgToOpenExtRow="";

        if(isset($extra_row['name']))
        {
            $nRowsToDel=2;
            $isImgAdded=false;
        }

        /// to generate js to add row in grid
        $strSP="";
        $strSepTitle="";
        foreach($arGridFlds as $fld)
        {
            $strJs="";
            $strMax="";
            $nFldWidth=$fld['size'];
            $nColSize= $fld['size']."px";
            $strAlign=";text-align:left;";
            if(isset($fld['align']))
                $strAlign="text-align:".$fld['align'].";";
            if(isset($fld['max']) && $fld['max']>0)
                $strMax="maxlength=".$fld['max'];
            if(isset($fld['type']))
                $strType=$fld['type'];
            $strTitle="";
            if(isset($fld['title']))
            {
                $strTitle="title='".$fld['title']."' ";   //autocomplete=off
                $strSP=$strTitle;
                $strSepTitle=$fld['title'];
            }

            $strFixCellValue="";
            if(isset($fld['value']))
                $strFixCellValue=$fld['value'];
            if($strType=="hidden" && $nNewRow==1)
                $bHaveHiddenFld=true;
            if(isset($fld['js']))
                $strJs=$fld['js'];
            //if(isset($fld['isTotalRequired']) && $fld['isTotalRequired']==1)
            //    $strJs.=" onchange=GetTotal(fldTotaling);";
            $fld=$fld['name'];
            echo "\n";
            /// to add extra notes arrow to show hide extra row
            if($nRowsToDel==2 && $strType!='hidden' && $isImgAdded==false  )
            {
                echo "var nRnd=Math.floor(Math.random()*1000); \n";
                echo "var strImg=\"<img style='cursor:pointer;' valign=middle id='ext_row_img_\"+nRnd+\"' name='ext_row_img_\"+nRnd+\"' onclick='SwapArrow(this);' src='". IMGPATH ."r_arrow.jpg'>\"; \n";
                $isImgAdded=true;
                if(!(isset($report) && $report == true))
                    $nColSize= $nFldWidth - 14 ."px";
            }else
                echo "var strImg=''; \n";
            ?>
            if(arData.length>0)
                cellValue= arData[<?php echo $nNewCell; ?>];
            else
                cellValue="";
            <?php
            if($strType=='text' || $strType=='hidden' )
            {
            // to generate the col of grid
            echo  "\n var newCell$nNewCell = newRow.insertCell($nNewCell);
            newCell$nNewCell.id=gridName+\"_col_\"+row+\"_$nNewRow\";
            newCell$nNewCell.style.backgroundColor   =strTDColor;
            newCell$nNewCell.innerHTML = strImg + \" <input $strTitle  type='$strType' style='width:$nColSize;$strAlign\"+ strTxtColor +\"' name='\"+ gridName+\"_t_". $fld. "_\"+row +\"' id='\"+ gridName+\"_t_". $fld. "_\"+row +\"' value='\"+cellValue+\"' class='clsTxtFld'  $strJs $strMax />\" ; \n ";
            $nNewRow++;   //size='$nColSize'
            $nNewCell++;
            }
            if($strType=='textarea')
            {
            // to generate the col of grid
                echo  "\n var newCell$nNewCell = newRow.insertCell($nNewCell);
                newCell$nNewCell.id=gridName+\"_col_\"+row+\"_$nNewRow\";
                newCell$nNewCell.style.backgroundColor   =strTDColor;
                newCell$nNewCell.innerHTML = strImg + \" <textarea $strTitle  style='width:$nColSize;$strAlign\"+ strTxtColor +\"' name='\"+ gridName+\"_t_". $fld. "_\"+row +\"' id='\"+ gridName+\"_t_". $fld. "_\"+row +\"' value='\"+cellValue+\"' class='clsTxtArea'  $strJs $strMax > </textarea> \" ; \n ";
                $nNewRow++;   //size='$nColSize'
                $nNewCell++;
            }
            if($strType=='datacell')
            {
                echo  "\n var newCell$nNewCell = newRow.insertCell($nNewCell);
                newCell$nNewCell.id=gridName+\"_col_\"+row+\"_$nNewRow\";
                newCell$nNewCell.style.backgroundColor   =strTDColor;
				newCell$nNewCell.innerHTML = strImg + \"  <div id='\"+ gridName+\"_t_". $fld. "_\"+row +\"'  class='clsDataCell' style='width:$nColSize;$strAlign\"+ strTxtColor +\"' >\"+ cellValue +\"</div>\";\n";
               	// ^^^^ Dawood. ^^^^ <div style='float:left;'></div>
			    $nNewRow++;   //size='$nColSize'
                $nNewCell++;
            }
            if($strType=='cell')
            {
                echo  "\n var newCell$nNewCell = newRow.insertCell($nNewCell);
                newCell$nNewCell.id=gridName+\"_col_\"+row+\"_$nNewRow\";
                newCell$nNewCell.style.backgroundColor   =strTDColor;
                newCell$nNewCell.innerHTML =  \" <div class='fixcell'>&nbsp;$strFixCellValue&nbsp;</div> \"; \n ";
                $nNewRow++;   //size='$nColSize'
                $nNewCell++;
            }
		////////////////////////////////////////////////////////////

        }
         // to generate Delete button of row
		 //aga
        if ($strSepTitle=="Test Name"){
        ?>
               $("input[<?php echo $strSP ?>]").autocomplete({source: 'medical_test_ac',minLength: 1 });
        <?php  }

		if (!(isset($report) && $report == true))
		{
		?>

        	var newCell<?php echo $nNewCell ?> = newRow.insertCell(<?php echo $nNewCell ?>);
        	newCell<?php echo $nNewCell ?>.id=gridName+"_action_"+row;

        	newCell<?php echo $nNewCell ?>.innerHTML = "<div id='footer_buttons'> <img src='"+ js_img_path +"mail_delete.png'  onclick='delRow(this,<?php echo $nRowsToDel ?>,"+row+");' style='cursor:pointer;' alt='Delete Row' ></div>";
        <?php
		}
		////////////////////////////////////////////////////////////
        //print_r($arGridFlds);
        //  To generate the extra row in grid
        if(isset($extra_row['name']))
        {
         ?>

            if(arData.length>0)
                cellValue= arData[<?php echo $nNewCell; ?>];
            else
                cellValue="";
            //row++;//=tblBody.rows.length;
            var newRow = tblBody.insertRow(-1);
        <?php
            $nNewRow=1;
            $nNewCell=0;
            $strJs="";
            $fld=$extra_row;
            $strLbl="<span class='extLbl'>".$fld['label']."</span>";
            $nColSize= $fld['size'];
            $strType=$fld['type'];
            if(isset($fld['js']))
                $strJs=$fld['js'];
            $fld=$fld['name'];
            if($bHaveHiddenFld){
                echo  "\n var newCell$nNewCell = newRow.insertCell($nNewCell);
                newCell$nNewCell.id=gridName+\"_col_\"+row+\"_$nNewRow\";
                newCell$nNewCell.innerHTML ='' ";
                $nNewRow++;
                $nNewCell++;
            }
            //   To generate the extra row in grid
            echo  "\n var newCell$nNewCell = newRow.insertCell($nNewCell);
            newCell$nNewCell.id=gridName+\"_col_\"+row+\"_$nNewRow\";
            newRow.className='extRowHiddenClass';
            newCell$nNewCell.colSpan =fldList.length;
            newCell$nNewCell.innerHTML = \"$strLbl - <input align=right type='$strType' style='width:90%' name='\"+ gridName+\"_extra_t_". $fld. "_\"+row +\"' id='\"+ gridName+\"_extra_t_". $fld. "_\"+row +\"' value='\"+cellValue+\"' class='clsTxtFld' $strJs  />\" ; \n ";
        } ?>
        nColCount++;
        var rcount=document.getElementById("rowcount");
        rcount.value= parseInt(rcount.value) +2;
}

if(arData.length==0)
{
    for(cnt=1;cnt<=<?php echo $nIntRows; ?>;cnt++)
        myGridAdd("myGrid",arData);
}
else
{
    for(cnt=0;cnt<arData.length;cnt++)
        myGridAdd("myGrid",arData[cnt]);
}

</script>
