<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function get_datatables($sql_details)
	{
		$this->load->library('datatables_ssp');
		$table = 'schedule';
 		$myjoin="inner join tournament on tournament.tournament_id = schedule.tournament_id
				 inner join venue on venue.venue_id = schedule.venue_id
				 inner join stage on stage.stage_id = schedule.stage_id
				 left join team on team.team_id = schedule.team_id_1
				 left join team team2 on team2.team_id = schedule.team_id_2
				 ";
            // Table's primary key
        $primaryKey = 'schedule_id';
			
		$columns = array(
				 
					array('customfilter' => 'schedule_id',
						'db'        => 'schedule_id',
						'dt'        => 0,
						'formatter' => function( $schedule_id, $row ) {
							return get_delete_all_id($schedule_id);
						}
					),
					array( 'customfilter' => 'tournament.tournament_name','db' => 'tournament.tournament_name',  'dt' => 1 ),
					array('customfilter' => '','db' => 'CONCAT(team.short_team_name,"#",team.team_logo_path,"#",team2.short_team_name,"#",team2.team_logo_path)', 'dt'  => 2,
						'formatter' => function( $team_details, $row ) {
							return get_view($team_details);
						}),
					array( 'customfilter' => 'start_date','db' => 'start_date',  'dt' => 3,
						  'formatter'=> function($start_date, $row){
							  return get_schedule_start_date($start_date);
						  }
					),
					
					array( 'customfilter' => 'match_number','db' => 'match_number',  'dt' => 4,
						  
						   'formatter'=> function($match_number, $row){
							  return get_match_number($match_number);
						  }
						   ),
					array( 'customfilter' => 'stage.stage_name','db' => 'stage.stage_name',  'dt' => 5 ),
					array('customfilter' => 'schedule_id','db' => 'schedule_id', 'dt'  => 6,
						'formatter' => function( $schedule_id, $row ) {
							return get_edit($schedule_id);
						}),
					array('customfilter' => 'schedule_id','db' => 'schedule_id', 'dt'  => 7,
						'formatter' => function( $schedule_id, $row ) {
							return get_delete($schedule_id);
						})
				);
				function get_schedule_start_date($start_date)
				{
					return "<div class='TextCenter'>".date('d M Y H:i',strtotime($start_date))."</div>";
				}
				function get_match_number($match_number)
				{
					return "<div class='TextCenter'>Match ".$match_number."</div>";
				}
				function get_schedule_end_date($end_date)
				{
					return "<div class='TextCenter'>".date('d M Y H:i',strtotime($end_date))."</div>";
				}
				function get_view($team_details)
				{
					
					$explode_team_details=explode('#',$team_details);
					if(count($explode_team_details) > 1)
					{
								$team_1_name=$explode_team_details[0];
								$team_1_logo="<img src='../".$explode_team_details[1]."' class='icon-logo-image' title='".$team_1_name."'>";
								$team_2_name=$explode_team_details[2];
								$team_2_logo="<img src='../".$explode_team_details[3]."' class='icon-logo-image' title='".$team_2_name."'>";
						
							
					}
					else
					{			$team_1_name="TBC";
								$team_1_logo="<img src='".HTTP_ASSETS_PATH_CLIENT."/images/tbd.png' class='icon-logo-image' title='".$team_1_name."'>";
								$team_2_name="TBC";
								$team_2_logo="<img src='".HTTP_ASSETS_PATH_CLIENT."images/tbd.png' class='icon-logo-image' title='".$team_2_name."'>";
								
					}
					return "<div class='TextCenter'><div class='team-a'>".$team_1_logo.'<p>'.$team_1_name.'</p></div><span class="schedule-match-vs">Vs</span><div class="team-b">'.$team_2_logo."<p>".$team_2_name."</p></div></div>";
				}
				function get_edit($schedule_id)
				{
					return "<div class='TextCenter'><a class='fa fa-fw fa-edit' href='".base_url()."admin/schedule/edit_schedule/".$schedule_id."'></a></div>";
				}
				function get_delete($schedule_id)
				{
					return "<div class='TextCenter'><a  href='' onclick='return deleteFunction(".$schedule_id.");' class='fa fa-fw fa-trash-o'></a><input type='hidden' value='".$schedule_id."' name='hid_del_id' id='hid_del_id".$schedule_id."' /></div>";
				}
				function get_delete_all_id($schedule_id)
				{
					
					return "<div class='TextCenter'><input type='checkbox'  class='deleteRow' value='".$schedule_id."' onclick='check_del_button();' /></div>";
				}
            return json_encode(
                    Datatables_ssp::simple($_GET, $sql_details, $table, $primaryKey, $columns,$myjoin,'')
            );
	}

	 function delete_all($ids){
        
  		$this->db->where_in('schedule_id', $ids);
		$this->db->delete('schedule');  
		return true;
    }
	function get_schedule_by_id($id)
	{
		$this->db->where('schedule_id',$id);
		$result = $this->db->get('schedule');
		return $result->row();
		
		
	}
	function delete_record($fieldName,$id,$tblName){  // this is to Delete record 
		$this->db->where($fieldName, $id);

		if($this->db->delete($tblName))
			return true;
		else
			 return false;
		
    } // this is to insert delete in database created end
	function get_stage(){  
	
		$this->db->select('stage_id,stage_name');
		$this->db->from('stage');
		$this->db->order_by("stage_id");
		$query=$this->db->get();
		$stages=array();
		 foreach ($query->result() as $stage) 
		{
			$stages[$stage->stage_id] = $stage->stage_name;
        }
         return $stages;
    }
	
	function get_match($tournament_id){  
		$where_array = array('tournament_id' => $tournament_id);
		$this->db->select('schedule_id,match_number');
		$this->db->from('schedule');
		$this->db->where($where_array); 
		$this->db->order_by("schedule_id");
		$query=$this->db->get();
		$matches=array();
	 	foreach ($query->result() as $matche) 
		{
			$matches[$matche->schedule_id] = $matche->match_number;
        }
         return $matches;
    }
	function get_venue(){
		
		$this->db->select('venue_id,venue_name');
		$this->db->from('venue');
		$this->db->order_by("venue_id");
		$query=$this->db->get();
		$venues=array();
		  foreach ($query->result() as $venue) 
		{
			$venues[$venue->venue_id] = $venue->venue_name;
        }
         return $venues;
	}
	function get_over(){
		
		$this->db->select('total_over_id,number_of_over');
		$this->db->from('total_over');
		$this->db->order_by("total_over_id");
		$query=$this->db->get();
		$overs=array();
	    foreach ($query->result() as $over) 
		{
			$overs[$over->total_over_id] = $over->number_of_over;
        }
         return $overs;
	}
	function get_tournament_group($id){  
	
		$where_array = array('tournament_id' => $id);
		$this->db->select('tournament_group_id,tournament_id,tournament_group_name');
		$this->db->from('tournament_group');
		$this->db->where($where_array); 
		$this->db->order_by("tournament_id");
		$query=$this->db->get();
		$tournament_groups=array();
	    foreach ($query->result() as $tournament_group) 
		{
			$tournament_groups[$tournament_group->tournament_group_id] = $tournament_group->tournament_group_name;
        }
         return $tournament_groups;
    }
	function group_show($id)
	{
	
			$data='<div class="col-sm-2"></div><div class="first-team"><div class="form-group da-form-row">
				  <label for="tournament_group_id" class="col-sm-3 control-label"><span class="required">*</span>Group</label>
				  <div class="col-sm-6">
					<select required class="form-control" name="tournament_group_id1" id="tournament_group_id1" onchange="get_first_group_teams();" data-msg-required="Please select group." >
					  <option  value=""> -- Select Group -- </option>';
					  $where_array = array('tournament_id' => $id);
						$this->db->select('tournament_group_id,tournament_id,tournament_group_name');
						$this->db->from('tournament_group');
						$this->db->where($where_array); 
						$this->db->order_by("tournament_group_id");
						$query=$this->db->get();
						$tournament_groups=array();
						
						foreach ($query->result() as $tournament_group) 
						{
							$data.='<option value='.$tournament_group->tournament_group_id.'>'.$tournament_group->tournament_group_name.'</option>';
						}
					$data.='</select>
				  	</div>
					</div>';
				$data.='<div id="FirstGroup"></div></div>';
				$data.='<div class="vs-div"><div class="form-group da-form-row">
				  <label for="tournament_group_id" class="col-sm-3 control-label"></label>
				  <div class="col-sm-4 opposite-vs">';
					$data.=' Vs
				  	</div>
					</div></div>';		
				$data.='<div class="opposite-team"><div class="form-group da-form-row">
				  <label for="tournament_group_id" class="col-sm-3 control-label"><span class="required">*</span>Group</label>
				  <div class="col-sm-6">
					<select required class="form-control" name="tournament_group_id2" id="tournament_group_id2" onchange="get_second_group_teams();" data-msg-required="Please select group." >
					  <option  value=""> -- Select Group -- </option>';
					  $where_array = array('tournament_id' => $id);
						$this->db->select('tournament_group_id,tournament_id,tournament_group_name');
						$this->db->from('tournament_group');
						$this->db->where($where_array); 
						$this->db->order_by("tournament_group_id");
						$query=$this->db->get();
						$tournament_groups=array();
						
						foreach ($query->result() as $tournament_group) 
						{
							$data.='<option value='.$tournament_group->tournament_group_id.'>'.$tournament_group->tournament_group_name.'</option>';
						}
					$data.='</select>
				  	</div>
					</div>';
					$data.='<div id="SecondGroup"></div></div>';
			  echo $data;
	}
	function match_show($id)
	{
					$data='<div class="form-group">
                <label for="schedule_id" class="col-sm-3 control-label"><span class="required">*</span>Match</label>
                <div class="col-sm-2">
                <select required="" class="form-control" name="schedule_id" id="schedule_id" onchange="duplicate_match_validation()">
                   <option value="">-- Select Match --</option>';
                       $where_array_match = array('tournament_id' => $id,'is_active' =>0);   
					   $this->db->select('schedule_id,match_number');
						$this->db->from('schedule');
						$this->db->where($where_array_match); 
						$this->db->order_by("match_number");
						$query=$this->db->get();
						$tournament_matchs=array();
						
						foreach ($query->result() as $tournament_match) 
						{
							$data.='<option value='.$tournament_match->schedule_id.' match_number='.$tournament_match->match_number.'>Match '.$tournament_match->match_number.'</option>';
						}
                                          
					$data.='</select>
                                 </div>
              </div>';
			  echo $data;
	}
	function complete_match_show($id)
	{
					$data='<div class="form-group">
                <label for="schedule_id" class="col-sm-3 control-label"><span class="required">*</span>Match</label>
                <div class="col-sm-2">
                <select required="" class="form-control" name="schedule_id" id="schedule_id" onchange="duplicate_match_validation()">
                   <option value="">-- Select Match --</option>';
                       $where_array_match = array('tournament_id' => $id,'is_active' =>1);   
					   $this->db->select('schedule_id,match_number');
						$this->db->from('schedule');
						$this->db->where($where_array_match); 
						$this->db->order_by("match_number");
						$query=$this->db->get();
						$tournament_matchs=array();
						
						foreach ($query->result() as $tournament_match) 
						{
							$data.='<option value='.$tournament_match->schedule_id.' match_number='.$tournament_match->match_number.'>Match '.$tournament_match->match_number.'</option>';
						}
                                          
					$data.='</select>
                                 </div>
              </div>';
			  echo $data;
	}
	function first_group_teams_show($id)
	{
		$this->db->select('team_ids');
		$this->db->from('assign_group_team');
		$this->db->where('tournament_group_id',$id);
		$query=$this->db->get();
		$assign_group_count = $query->num_rows();
		$group_id_count=1;
		$data="";
		foreach ($query->result() as $group_id)
		{
			$team_id_array=explode(",",$group_id->team_ids);
			$this->db->select('team_id,team_name');
			$this->db->from('team');
			$this->db->where_in('team.team_id',$team_id_array);
			$query1=$this->db->get();
			if($group_id_count==1)
			{
				$data='<div class="form-group">
				  <label  class="col-sm-3 control-label"><span class="required">*</span>Teams</label><div class="col-sm-9 streaming-div"><div class="teamsDiv">';
			}
			foreach ($query1->result() as $team)
			{
				
				  $data.='<div class="teams-checkbox-design"><input required type="radio" name="team_id_1" value="'.$team->team_id.'" id="team_id_1" data-msg-required="Please select team." onclick="duplicate_team_validation()"/> '.$team->team_name.'</div>';
					
			}
			if($group_id_count==$assign_group_count)
			{
				$data.='</div></div></div>';
			}
			$group_id_count++;
		}
		 echo $data;
					
	}
	function second_group_teams_show($id)
	{
		$this->db->select('team_ids');
		$this->db->from('assign_group_team');
		$this->db->where('tournament_group_id',$id);
		$query=$this->db->get();
		$assign_group_count = $query->num_rows();
		$group_id_count=1;
		$data="";
		foreach ($query->result() as $group_id)
		{
			$team_id_array=explode(",",$group_id->team_ids);
			$this->db->select('team_id,team_name');
			$this->db->from('team');
			$this->db->where_in('team.team_id',$team_id_array);
			$query1=$this->db->get();
			if($group_id_count==1)
			{
				$data='<div class="form-group">
				  <label  class="col-sm-3 control-label"><span class="required">*</span>Teams</label><div class="col-sm-9 streaming-div"><div class="teamsDiv">';
			}
			
			foreach ($query1->result() as $team)
			{
				
				  $data.='<div class="teams-checkbox-design"><input required type="radio" name="team_id_2" value="'.$team->team_id.'" id="team_id_2" data-msg-required="Please select team." onclick="duplicate_team_validation()" /> '.$team->team_name.'</div>';
					
			}
			if($group_id_count==$assign_group_count)
			{
				$data.='</div></div></div>';
			}
			$group_id_count++;
			
		}
		 echo $data;
					
	}
	function get_group_assign_teams($id)
	{
		$this->db->select('team_ids');
		$this->db->from('assign_group_team');
		$this->db->where('tournament_group_id',$id);
		$query=$this->db->get();
		$group_teams=array();
		$group_id=$query->row();
		if(!empty($group_id))
		{
			$team_id_array=explode(",",$group_id->team_ids);
			$this->db->select('team_id,team_name');
			$this->db->from('team');
			$this->db->where_in('team.team_id',$team_id_array);
			$query1=$this->db->get();
			
			foreach ($query1->result() as $team)
			{
				$group_teams[$team->team_id] = $team->team_name;
			}
		return $group_teams;
		}
	}

	function get_schedule_list($team_id,$tournament_id)
	{
		$current_date_time="'".date("Y-m-d H:i:s")."'";
		if($team_id !=0)
		{	if($tournament_id!="0"){
			$where = "(schedule.team_id_1=".$team_id." OR schedule.team_id_2=".$team_id.") AND (schedule.tournament_id=".$tournament_id.") AND (schedule.is_active=1) AND (start_date >".$current_date_time.")";
			}
			else
			{
				$where = "(schedule.team_id_1=".$team_id." OR schedule.team_id_2=".$team_id.")  AND (schedule.is_active=1) AND (start_date >".$current_date_time.")";
			}
		} 
		else
		{
			if($tournament_id!="0")
			{
				$where = '(schedule.tournament_id='.$tournament_id.') AND (schedule.is_active=1) AND (start_date >'.$current_date_time.')';	
			} 
			else
			{
				$where = '(schedule.is_active=1) AND (start_date >'.$current_date_time.')';
			}
		}
		$this->db->select('team.team_name,team.team_logo_path, team2.team_name as team_name2,team2.team_logo_path as team_logo_path2,
		venue.venue_name,stage.stage_name,tournament.*,schedule.*,tournament_group.tournament_group_name,tournament_group2.tournament_group_name as tournament_group_name2 ');
		$this->db->join('tournament','tournament.tournament_id = schedule.tournament_id','inner');
		$this->db->join('tournament_group','tournament_group.tournament_group_id = schedule.tournament_group_id_1','left');
		$this->db->join('tournament_group tournament_group2','tournament_group2.tournament_group_id = schedule.tournament_group_id_2','left');
		$this->db->join('team','team.team_id = schedule.team_id_1','left');
		$this->db->join('team team2','team2.team_id = schedule.team_id_2','left');
		$this->db->join('stage','stage.stage_id = schedule.stage_id','inner');
		$this->db->join('venue','venue.venue_id = schedule.venue_id','inner');
		$this->db->where($where);
		$this->db->order_by('start_date', 'asc');
		$query = $this->db->get('schedule');
		$schedule_row_count = $query->num_rows();
		$data="";
		if($schedule_row_count>=1)
		{
			   $record_count=1;
			   foreach($query->result() as $schedule)
			   {
					$group_name_first=$schedule->tournament_group_name;
					$group_name_second=$schedule->tournament_group_name2;
				
					 $one_team_name=$schedule->team_name;
					 $opposite_team_name=$schedule->team_name2;
				
					 $one_team_logo=$schedule->team_logo_path;
				     $opposite_team_logo=$schedule->team_logo_path2;

			
				  $data.='<div class="results-wrapper">
            	<span class="results-wrapper-title">'.$schedule->tournament_name.'</span>
                <span class="final-tagline">'.$schedule->stage_name.'</span>
                <div class="results-wrapper-box">
                	<div class="schedule-col-0">
                    	<span class="sponsor-name">Sponsor</span>
                		<span class="team-logo"><img src="'.$schedule->sponsor_logo_path.'" alt=""></span>
                	</div>
                    <div class="col-1 schedule-col-1">
					<span class="sponsor-name blank">&nbsp;</span>
                		<span class="date">Match <span>'.$schedule->match_number.'</span></span>
                	</div>
                    <div class="col-2 schedule-col-2">
                    	<div class="score-box">';
							if($schedule->is_to_be_confirm==0)
							{
								$first_team_name=$one_team_name;
							}
							else
							{
								$first_team_name='TBD';
							}
                            $data.='<span class="team-name">'.$first_team_name.'</span>
                            <span class="team-logo">';
							if($one_team_logo!="")
							{
								$data.='<img src="'.$one_team_logo.'" alt="">';
							}
							else
							{
								$data.='<img src="'.HTTP_ASSETS_PATH_CLIENT.'images/tbd.png" alt="">';
							}
							if($schedule->is_to_be_confirm==0)
							{
								$data.='<a href="#group-1" class="various-team" onclick="get_team('.$schedule->tournament_group_id_1.')">'.$group_name_first.'</a>';
							}
							$data.='</span>
                        </div>
                        <div class="vs">VS</div>
                        <div class="score-box">';
						if($schedule->is_to_be_confirm==0)
							{
								$second_team_name=$opposite_team_name;
							}
							else
							{
								$second_team_name='TBD';
							}
                            $data.='<span class="team-name">'.$second_team_name.'</span>
                            <span class="team-logo">';
								if($opposite_team_logo!="")
								{
									$data.='<img src="'.$opposite_team_logo.'" alt="">';
								}
								else
								{
									$data.='<img src="'.HTTP_ASSETS_PATH_CLIENT.'images/tbd.png" alt="">';
								}
								if($schedule->is_to_be_confirm==0)
								{
									$data.='<a href="#group-1" class="various-team" onclick="get_team('.$schedule->tournament_group_id_2.')">'.$group_name_second.'</a>';
								}
							$data.='</span>
                        </div>
                    </div>
                    <div class="col-3 schedule-col-3">
                    	<span class="results-title">Date &amp; Time</span>
                        <span class="results-text">
                            '.date('l d M , Y',strtotime($schedule->start_date)).'<br>
							'.date('g:ia', strtotime($schedule->start_date)).' IST ('.gmdate('h:ia',strtotime($schedule->start_date)).' GMT)
                            
                        </span>
                    </div>
                    <div class="col-4 schedule-col-4"><span class="sponsor-name venue-title">Venue</span>';
					
						$data.='<span class="results-text">'.$schedule->venue_name.'</span>';
						if($schedule->match_status !="")
						{
							$data.='<a class="sublink2" target="_blank" href="'.base_url().'scorecard/'.$schedule->schedule_id.'/1st_innings">Scorecard</a>';
						}
						
                    $data.='</div>
                </div>
            </div>'; 
			$record_count++;
				   
			   }
		}
		else
		{
			$data.='<br><br><br><br><br><div class="no-found">Sorry, no schedule found.</div>';
		}
		return $data;
	}
	
	function get_three_schedule_list($current_date_time)
	{
		
		$this->db->select('team.team_name, team2.team_name as team_name2,start_date,end_date,venue.venue_name');
		$this->db->join('team','team.team_id = schedule.team_id_1','inner');
		$this->db->join('team team2','team2.team_id = schedule.team_id_2','inner');
		$this->db->join('venue','venue.venue_id = schedule.venue_id','left');
		$this->db->where('start_date >',$current_date_time);
		$this->db->order_by("schedule_id", "asc");
		$this->db->limit('3');
		$result = $this->db->get('schedule');
		return $result->result_array();
	}
	function get_team_names_by_match_id($schedule_id)
	{
		$where_array = array('schedule_id'=>$schedule_id);
		$this->db->select('team.team_name, team2.team_name as team_name2');
		$this->db->join('team','team.team_id = schedule.team_id_1','inner');
		$this->db->join('team team2','team2.team_id = schedule.team_id_2','inner');
		$this->db->where($where_array);
		$result = $this->db->get('schedule');
		return $result->row();
		
		
	}
	
	
	
	
}