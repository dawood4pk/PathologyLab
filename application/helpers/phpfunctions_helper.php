<?php
	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: array_to_json									  //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	function array_to_json( $array )
	{
		if( !is_array( $array ) )
		{
			return false;
		}

		$associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
		if( $associative )
		{
			$construct = array();
			foreach( $array as $key => $value )
			{
				// We first copy each key/value pair into a staging array,
				// formatting each key and value properly as we go.

				// Format the key:
				if( is_numeric($key) )
				{
					$key = "key_$key";
				}
				$key = "\"".addslashes($key)."\"";

				// Format the value:
				if( is_array( $value ))
				{
					$value = array_to_json( $value );
				}
				else if( !is_numeric( $value ) || is_string( $value ) )
				{
					$value = "\"".addslashes($value)."\"";
				}

				// Add to staging array:
				$construct[] = "$key: $value";
			}

			// Then we collapse the staging array into the JSON form:
			$result = "{ " . implode( ", ", $construct ) . " }";

		}
		else
		{ // If the array is a vector (not associative):

			$construct = array();
			foreach( $array as $value )
			{
				// Format the value:
				if( is_array( $value ))
				{
					$value = array_to_json( $value );
				}
				else if( !is_numeric( $value ) || is_string( $value ) )
				{
					$value = "'".addslashes($value)."'";
				}

				// Add to staging array:
				$construct[] = $value;
			}

			// Then we collapse the staging array into the JSON form:
			$result = "[ " . implode( ", ", $construct ) . " ]";
		}

		return $result;
	}// End of array_to_json function.

	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: GetCtrl     									  //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	function GetCtrl($ctrlDetail)
	{
		//echo "<pre>";print_r($ctrlDetail);

		// HTML: text.
		if($ctrlDetail['type']=="text")
		{
			$strValue="";
			if(isset($ctrlDetail['value']))
				$strValue =$ctrlDetail['value'];

			return "<input type=text size=". $ctrlDetail['size'] ." name=".$ctrlDetail['name'] ." value='$strValue'>";
		}// End of HTML: text.

		// HTML: Combo box.
		if($ctrlDetail['type']=="cmb")
		{
			$strValue="";
			$strJS="";
			if(isset($ctrlDetail['value']))
			{
				$strValue =$ctrlDetail['value'];
				$arValues=explode(",",$strValue);
				sort($arValues);
			}
			if(isset($ctrlDetail['js']))
			{
				$strJS =$ctrlDetail['js'];
			}
			else
			{
				$strJS = "";
			}
			if(isset($ctrlDetail['size']))
			{
				$nSize =$ctrlDetail['size'];
			}
			$strMulti ="";
			if($nSize>1)
			{
				$strMulti = "multiple='multiple'";
			}
			if(isset($ctrlDetail['style']))
			{
				$strStyle = $ctrlDetail['style'];
			}
			else
			{
				$strStyle = "";
			}
			if(isset($ctrlDetail['class']))
			{
				$strClass = $ctrlDetail['class'];
			}

			if(isset($ctrlDetail['sText']))
			{
				$strSText = $ctrlDetail['sText'];
			}
			else
			{
				$strSText = "";
			}

		//	$strOption="<select class='$strClass' $strMulti size=$nSize tabindex='2' style='width:342px;' name=".$ctrlDetail['name']." id=".$ctrlDetail['name']."  $strJS $strStyle >";
			$strOption="<select class='$strClass' $strMulti size=$nSize name=".$ctrlDetail['name']." id=".$ctrlDetail['name']."  $strJS $strStyle >";
			if(isset($ctrlDetail['cData']))
			{

				if($nSize<=1)
				{
					$strOption.="<option value='0'>$strSText</option>";
				}
				$arrData=$ctrlDetail['cData'];
				$cntAr=0;
				foreach($arrData as $key=>$strCValue)
				{
					//$strValue=$arrData[$cntItem];
					$strSelected="";
					if(isset($arValues[$cntAr]) && $strValue!=$arValues[$cntAr])
					{
						$strValue=$arValues[$cntAr];
					}
					if($strValue==$key)
					{
						$strSelected="selected='selected'";
						$cntAr++;
					}
					$strOption.="<option $strSelected value='$key'>$strCValue</option>";
					$strSelected="";
				}
			}
			else
			{
				//$strOption.="<option value='-1'>Other</option>";
			}
			 $strOption.="</select>";
			return $strOption;
		}// End of HTML: Combo box.

	}// End of GetCtrl function.
?>