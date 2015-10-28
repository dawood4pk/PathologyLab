<?php
class report_model extends CI_Model {

    function Report_mod_new()
    {
        // Call the Model constructor
        //parent||CI_Model();
		parent::Model();
    }
    // to save the reports
    function save_report( $arReport )
	{
        $res = $this->db->insert( "reports", $arReport );
		return $this->db->insert_id();
	}
	
	function save_patient_report( $arReport )
	{
        $res = $this->db->insert( "patient_report", $arReport );
		return $this->db->insert_id();
	}
	
	function save_medical_test( $arMedicalTest )
	{
        $res = $this->db->insert( "medical_test", $arMedicalTest );
		return $this->db->insert_id();
	}
	

    /// to update the reports
    function update_report( $rId,$arReport )
    {
        $this->db->where("report_id", $rId);
        $res = $this->db->update("reports", $arReport);
        return $this->db->insert_id();
    }

    function update_medical_test( $tId, $tReport )
    {
        $this->db->where("test_id", $tId);
        $res = $this->db->update("medical_test", $tReport);
        return $this->db->insert_id();
    }

    function get_report_data($rId)
    {
        $sql = "select * from reports where report_id='$rId'";
        $result=$this->db->query( $sql );
        return $result->result_array();
    }

    function report_count()
    {
        return $this->db->count_all('reports');
    }

    function report_list($nPerPage, $nOffset)
    {
		$sql="select reports.report_id,reports.report_name,patients.patient_firstname,patients.patient_lastname from reports inner join patients where reports.patient_id = patients.patient_id limit $nPerPage offset $nOffset";
        $result=$this->db->query( $sql );
        return $result->result_array();
    }

    function get_report_info( $rId )
    {
        $sql="select report_id,report_name,patient_id from reports where report_id='$rId'";
        $result=$this->db->query( $sql );
        return $result->result_array();
    }
    
    function report_delete( $rId )
    {
		/*$sql="delete from reports where report_id=$rId";
        $this->db->query( $sql );*/

        $this->db->where("report_id",$rId);
        $this->db->delete("reports");
    }
	
	function patient_report_delete( $rId )
    {
		/*$sql="delete from reports where report_id=$rId";
        $this->db->query( $sql );*/

        $this->db->where("report_id",$rId);
        $this->db->delete("patient_report");
    }
	
	  
	function get_patient_medical_test_report_data_detail($rId)
    {
		// medical_test.test_id, medical_test.test_name	from medical_test
		// patient_report.id, patient_report.report_id, patient_report.test_id, patient_report.test_result from patient_report

		$sql="select medical_test.test_id, medical_test.test_name, patient_report.test_result from medical_test inner join patient_report on medical_test.test_id = patient_report.test_id where patient_report.report_id ='$rId'";

        $result=$this->db->query($sql);
        $arRows= $result->result_array();
        for($cnt=0;$cnt<count($arRows);$cnt++)
        {
            $arData[$cnt][]= $arRows[$cnt]['test_id'];
            $arData[$cnt][]= $arRows[$cnt]['test_name'];
            $arData[$cnt][]= $arRows[$cnt]['test_result'];
        }
        return $arData;
    }

	function get_medical_test_info($strTestName)
    {
        $sql="select test_id, test_name from medical_test where test_name='$strTestName'";
        $result=$this->db->query($sql);
        return $result->result_array();
    }
	
	function medical_test_to_ac($strTestName)   // to auto complete
    {
        $sql = "select test_name from medical_test where test_name like '$strTestName%'";
        $result = $this->db->query($sql);
        $arrTest = $result->result_array();
        $str = "";
        for( $cnt=0; $cnt < count( $arrTest ); $cnt++ )
        {
           /* $found[]=array(
                "value" => $arrTest[$cnt]['test_name'],
            );   */
            $str = $arrTest[$cnt]['test_name'];
            $items[$str] = $str;
        }
        $q = $strTestName;
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

	function get_patient_report($pId)
    {
		// medical_test.test_id, medical_test.test_name	from medical_test
		// patient_report.id, patient_report.report_id, patient_report.test_id, patient_report.test_result from patient_report

		$sql="SELECT reports.report_name, medical_test.test_name, patient_report.test_result FROM reports INNER JOIN patient_report ON reports.report_id = patient_report.report_id INNER JOIN medical_test ON medical_test.test_id = patient_report.test_id WHERE reports.patient_id ='$pId'";

		$result=$this->db->query( $sql );
        return $result->result_array();
    }
}
?>