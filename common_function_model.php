<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_function_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	function GetValue($table,$field,$where,$condition) //Get field value in the database//
	{		
		$this->db->select($field);
		$this->db->where($where,$condition);
		$querycat = $this->db->get($table);
		foreach ($querycat->result() as $row)
	   	{
		  return $row->$field;
	   	}				
	}
	function GetKitDuplicateValue($table,$field,$field_val,$where,$condition) //Get field value in the database//
	{
		$where_array = array($field => $field_val,''.$where.' =' => $condition);
		$this->db->select($field);
		$this->db->where($where_array);
		$querycat = $this->db->get($table);
		foreach ($querycat->result() as $row)
	   	{
		  return $row->$field;
	   	}	
	}
	function get_economy($over,$run)
	{
	
		 	$explode_bowler_scoringdataval=explode('.',$over);
			$total_ball_bowler=$explode_bowler_scoringdataval[1];
			$total_bowler_over_by_ball=($explode_bowler_scoringdataval[0]*6);
			$all_over_ball=$total_bowler_over_by_ball+$total_ball_bowler;
			$economy=0;
			if($total_bowler_over_by_ball !=0){
				$economy_by_ball=$run/$all_over_ball;
				$economy=$economy_by_ball*6;
			} 
			else
			{
				
				$all_over_ball=$total_ball_bowler;
				if($all_over_ball !=0){
					$economy_by_ball=$run/$all_over_ball;
					$economy=$economy_by_ball*6;
				}
				
			}
		return number_format($economy,2);
	}
	function get_team_net_run_rate($total_runs_scored,$total_overs_faced,$total_runs_conceded,$total_overs_bowled)
	{
		if($total_runs_scored!=0 && $total_overs_faced!=0 && $total_runs_conceded!=0 && $total_overs_bowled!=0){
		 	$rate_of_scored=$total_runs_scored/$total_overs_faced;
			$rate_of_conceded=$total_runs_conceded/$total_overs_bowled;
			$Net_Run_Rate=$rate_of_scored-$rate_of_conceded;
		return number_format($Net_Run_Rate,2);
		}
		else
		{
			return number_format(0.00,2);
		}
	}
	// this is to get filed value in database
	function CountByTable($table,$where)
	{
		if($table=='content')
		{
			$querycat = $this->db->get($table);
			return $this->db->affected_rows();
		}
		else
		{
			$qry='SELECT * FROM `'.$table.'` '.$where.'';
			$query = $this->db->query($qry);
			return $query->num_rows();
		}
		
		
    }
	function sql_detial()
	{
		$sql_details = array(
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            );
		return  $sql_details;
	}
	function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
	}
	function update_is_active($val,$id,$fieldName,$fieldId,$tableName)
	{
		$data=array($fieldName=>$val);
		$this->db->where($fieldId,$id);
		$this->db->update($tableName,$data);
		if($val==1)
		{
			echo "<a class='fa fa-fw fa-check' onclick=\"return update_is_active(0,".$id.");\"></a>";
		}
		if($val==0)
		{
			echo "<a class='fa fa-fw fa-close' onclick=\"return update_is_active(1,".$id.");\"></a>";
		}
	}
	function update_is_default_tournament($val,$id,$fieldName,$fieldId,$tableName)
	{
		$data=array($fieldName=>$val);
		$this->db->where($fieldId,$id);
		$this->db->update($tableName,$data);
		
		$data=array($fieldName=>'0');
		$this->db->where_not_in($fieldId,$id);
		$this->db->update($tableName,$data);
		
		if($val==1)
		{
			echo "<a class='fa fa-fw fa-check' onclick=\"return update_is_default_tournament(0,".$id.");\"></a>";
		}
		if($val==0)
		{
			echo "<a class='fa fa-fw fa-close' onclick=\"return update_is_default_tournament(1,".$id.");\"></a>";
		}
	}
	function update_is_archive_tournament($val,$id,$fieldName,$fieldId,$tableName)
	{
		$data=array($fieldName=>$val);
		$this->db->where($fieldId,$id);
		$this->db->update($tableName,$data);
		
		if($val==1)
		{
			echo "<a class='fa fa-fw fa-check' onclick=\"return update_is_archive_tournament(0,".$id.");\"></a>";
		}
		if($val==0)
		{
			echo "<a class='fa fa-fw fa-close' onclick=\"return update_is_archive_tournament(1,".$id.");\"></a>";
		}
	}
	function insert_record ($tblName,$data){  // this is to insert record in database  
	
		$query = $this->db->insert($tblName, $data);
		if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }		        
    }
	function update_record($fieldName,$id,$tblName,$data){  // this is to Update record in database  
	
		$this->db->where($fieldName, $id);
		$this->db->update($tblName, $data);
		
		if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }		
        
    }
	
	function update_record_with_where_and($fieldName1,$fieldName2,$id1,$id2,$tblName,$data){  // this is to Update record with were and condition in database  
	$WhereArray = array($fieldName1 => $id1, $fieldName2 => $id2);
		$this->db->where($WhereArray);
		$this->db->update($tblName, $data);
		
		if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }		
        
    }
	
	// this is to insert Update in database created end
	function GetSiteValues($key)
	{
		return  $this->common->GetValue("site_setting","value","site_key",$key);
	}
	/*function Get_Default_Tournament()
	{
		$this->load->model('Common_function_model','common');
		if($this->session->userdata('tournament_id')=="")
		{
			$default_tournament_id=$this->common->GetValue("tournament","tournament_id","is_default_tournament",1);
			if($default_tournament_id !="")
			{
				$this->session->set_userdata('tournament_id', $default_tournament_id);
			}
			else
			{
				$default_tournament_id=$this->common->GetValue("tournament","tournament_id","is_active",1);
				$this->session->set_userdata('tournament_id', $default_tournament_id);
			}
		}
	}*/
	function GetshortString($str,$len)
	{
		if(strlen($str) > $len)
		{
			$stringval = substr($str, 0, $len)."...";
		}
		else
		{
			$stringval=$str;
		}
		return $stringval;
	}

	function GetshortStringNoDot($str,$len)
	{
		if(strlen($str) > $len)
		{
			$stringval = substr($str, 0, $len)."";
		}
		else
		{
			$stringval=$str;
		}
		return $stringval;
	}
	function array_column($array,$column_name)
    {

        return array_map(function($element) use($column_name){return $element[$column_name];}, $array);

    }
	function fbLikeCount($id,$appid,$appsecret){
		 //Construct a Facebook URL
		 $json_url ='https://graph.facebook.com/'.$id.'?access_token='.$appid.'|'.$appsecret;
		  
		 $json = file_get_contents($json_url);
		 $json_output = json_decode($json);
		 
		 //Extract the likes count from the JSON object
		 if($json_output->likes){
		  return $likes = $json_output->likes;
		 }else{
		  return 0;
		 }
	}
	function get_short_name($string) 
	{ 
	  	$team_long_name = explode(" ", $string);
		$team_short_name = "";
		foreach ($team_long_name as $tema_name_val)
		{
			if(count($team_long_name)>1)
			{
		  		$team_short_name .= $tema_name_val[0];
			}
			else
			{
				$team_short_name.= substr($tema_name_val, 0, 3);
			}
		}
		return $team_short_name;
	}
	function get_site_setting_value()
	{
		$result = $this->db->get('site_settings');
		return $result->row();
	}


}
?>