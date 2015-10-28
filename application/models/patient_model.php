<?php
class patient_model extends CI_Model {

    function Patient_mod_new()
    {
        // Call the Model constructor
        //parent||CI_Model();
		parent::Model();
    }
    // to save the patients
    function save_patient( $arPatient )
	{
        $res = $this->db->insert( "patients", $arPatient );
		return $this->db->insert_id();
	}
    /// to update the patients
    function update_patient( $pId,$arPatient )
    {
        $this->db->where("patient_id", $pId);
        $res = $this->db->update("patients", $arPatient);
        return $this->db->insert_id();
    }

    function get_patient_data($pId)
    {
        $sql = "select * from patients where patient_id='$pId'";
        $result=$this->db->query( $sql );
        return $result->result_array();
    }

    function patient_count()
    {
        return $this->db->count_all('patients');
    }

    function patient_list($nPerPage, $nOffset)
    {
		$sql="select patient_id,patient_username,patient_passcode,patient_firstname	,patient_lastname from patients limit $nPerPage offset $nOffset";
        $result=$this->db->query( $sql );
        return $result->result_array();
    }

    function get_patient_info( $pId )
    {
        $sql="select patient_id,patient_username,patient_passcode,patient_firstname	,patient_lastname from patients where patient_id='$pId'";
        $result=$this->db->query( $sql );
        return $result->result_array();
    }
    
    function patient_delete( $pId )
    {
		/*$sql="delete from patients where patient_id=$pId";
        $this->db->query( $sql );*/

        $this->db->where("patient_id",$pId);
        $this->db->delete("patients");
    }
	
	function get_patient_cmb()
    {
		$this -> db -> select('patient_id, patient_firstname, patient_lastname');
	   	$this -> db -> from('patients');
		//$this -> db -> where('status', 1);
		$query = $this -> db -> get();

		if ($query->num_rows() > 0)
        {		
			$arRows = $query -> result_array();		
			for($cnt=0; $cnt<count($arRows); $cnt++)
			{
				$nIdx = $arRows[$cnt]['patient_id'];
				$arData[$nIdx] = $arRows[$cnt]['patient_lastname'].', '.$arRows[$cnt]['patient_firstname'];
			}
			return $arData;
		}
		else
		{
			return;
		}
    }
	
	function patient_username_to_ac($strUserName)   // to auto complete
    {
        $sql = "select patient_username from patients where patient_username like '$strUserName%'";
        $result = $this->db->query($sql);
        $arrTest = $result->result_array();
        $str = "";
        for( $cnt=0; $cnt < count( $arrTest ); $cnt++ )
        {
           /* $found[]=array(
                "value" => $arrTest[$cnt]['patient_username'],
            );   */
            $str = $arrTest[$cnt]['patient_username'];
            $items[$str] = $str;
        }
        $q = $strUserName;
        $result = array();
        foreach ( $items as $key=>$value ) 
		{
            if (strpos(strtolower($key), $q) !== false)
			{
                array_push($result, array("id"=>$value, "label"=>$key, "value" => strip_tags($key)));
            }
            if (count($result) > 11)
                break;
        }
        return array_to_json($result);
        //return $arr;
    }

}
?>