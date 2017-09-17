<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Schedule_model','schedule');
		$this->load->model('Tournament_model','tournament');
	       
	}

	public function index()
	{
		$data['page'] = 'Schedule';
		$data['path'] = ''.base_url().'admin/schedule/delete_content/';
		$data['bulk_path'] = ''.base_url().'admin/schedule/bulk_delete/';
		$data['ckeditor']=false;
		$data['soringCol']='"order": [[ 3, "asc" ]],';
		$data['manage_view_path']=''.base_url().'admin/schedule/schedule_view/';
		$data['pagetitle']='Manage '.$data['page'];
		$data['gridTable']=true;
		
		$this->load->view('admin/controls/vwHeader');
		$this->load->view('admin/controls/vwLeft',$data);
		$this->load->view('admin/controls/vwFooterJavascript',$data);
        $this->load->view('admin/vwManageSchedule',$data);
		
		$this->load->view('admin/controls/vwFooter');
	}

	public function schedule_view()
	{
		$data['page'] = 'Schedule';
		$sql_details=$this->common->sql_detial();
		echo $list = $this->schedule->get_datatables($sql_details);
	}
	public function add_schedule() { //this is use for redirect form in add section start
		$data['page'] = 'Schedule';
		$data['pagetitle']='Manage '.$data['page'].' | Add '.$data['page'];
		$data['ckeditor']=false;
		$data['gridTable']=false;
		
		$formSubmit = $this->input->post('Submit');
		if($formSubmit=="Save")
		{
			if($this->input->post('is_to_be_confirm')=='on')
			{
				$is_to_be_confirm=1;
			}
			else
			{
				$is_to_be_confirm=0;
			}
			$tblName = "schedule";
			$start_date=date('Y-m-d H:i',strtotime($this->input->post('start_date')));
			$end_date=date('Y-m-d H:i',strtotime($this->input->post('end_date')));
			
			
					$data = array('total_over_id' =>$this->input->post('total_over_id'),
								  'stage_id' =>$this->input->post('stage_id'),
								  'venue_id' =>$this->input->post('venue_id'),
								  'tournament_group_id_1'=>$this->input->post('tournament_group_id1'),
								  'tournament_group_id_2'=>$this->input->post('tournament_group_id2'),
								  'team_id_1' =>$this->input->post('team_id_1'),
								  'team_id_2' =>$this->input->post('team_id_2'),
								  'start_date' =>$start_date,
								  'end_date' =>$end_date,
								  'is_to_be_confirm'=>$is_to_be_confirm,
								  'is_active'=>1
								);
					$id=$this->input->post('schedule_id');
					$fieldName="schedule_id";
					$this->common->update_record($fieldName,$id,$tblName,$data);
					$this->session->set_flashdata('msg', 'Schedule has been added successfully.');
					redirect('admin/schedule','refresh'); //redirect in manage with msg	
				//}
			
			
		}
		$data['tournament']=$this->tournament->get_tournament();
		$data['stage']=$this->schedule->get_stage();
		$data['venue']=$this->schedule->get_venue();
		$data['over']=$this->schedule->get_over();
		$this->load->view('admin/controls/vwHeader');
		$this->load->view('admin/controls/vwLeft',$data);
		$this->load->view('admin/controls/vwFooterJavascript',$data);
		$this->load->view('admin/vwAddSchedule',$data);    
		$this->load->view('admin/controls/vwFooter');
		
	} //this is use for redirect form in add section end
    public function edit_schedule($id='') //this is use for edit records start
	{
        $data['page'] = 'Schedule';
		$data['pagetitle']='Manage '.$data['page'].' | Edit '.$data['page'];
		$data['ckeditor']=false;
		$data['gridTable']=false;
		$this->form_validation->set_rules('stage_name', 'stage', 'required');
		$data['schedule']=$this->schedule->get_schedule_by_id($id);
		
		if($id!='')
		{
			$formSubmit = $this->input->post('Submit');
			if($formSubmit=="Save")
			{
				
					if($this->input->post('is_to_be_confirm')=='on')
					{
						$is_to_be_confirm=1;
					}
					else
					{
						$is_to_be_confirm=0;
					}
					$start_date=date('Y-m-d H:i',strtotime($this->input->post('start_date')));
					$end_date=date('Y-m-d H:i',strtotime($this->input->post('end_date')));
					$tblName = "schedule";
					$fieldName = "schedule_id";
					
						if($is_to_be_confirm==0)
						{
							$tournament_group_id1_val=$this->input->post('tournament_group_id1');
						}
						else
						{
							$tournament_group_id1_val="";
						}
					
					
						if($is_to_be_confirm==0)
						{
							$tournament_group_id2_val=$this->input->post('tournament_group_id2');
						}
						else
						{
							$tournament_group_id2_val="";
						}
					
						if($is_to_be_confirm==0)
						{
							$team_id_1_val=$this->input->post('team_id_1');
						}
						else
						{
							$team_id_1_val="";
						}
						if($is_to_be_confirm==0)
						{
							$team_id_2_val=$this->input->post('team_id_2');
						}
						else
						{
							$team_id_2_val="";
						}
						
					
								$data = array(
								'total_over_id' =>$this->input->post('total_over_id'),
								'tournament_group_id_1'=>$tournament_group_id1_val,
								'tournament_group_id_2'=>$tournament_group_id2_val,
								'team_id_1' =>$team_id_1_val,
								'team_id_2'=>$team_id_2_val,
								'stage_id' => $this->input->post('stage_id'),
								'venue_id' => $this->input->post('venue_id'),
								'start_date' =>$start_date,
								'end_date' =>$end_date,
								'is_to_be_confirm'=>$is_to_be_confirm
								);
						
								$this->common->update_record($fieldName,$id,$tblName,$data);
								$this->session->set_flashdata('msg', 'Schedule has been updated successfully.');
								redirect('admin/schedule/','refresh'); //redirect in manage with msg
			}
			
			$data['tournament']=$this->tournament->get_tournament();
			$data['stage']=$this->schedule->get_stage();
			$data['matche']=$this->schedule->get_match($data['schedule']->tournament_id);
			$data['venue']=$this->schedule->get_venue();
			$data['over']=$this->schedule->get_over();
			$data['group']=$this->schedule->get_tournament_group($data['schedule']->tournament_id);
			$data['team_1']=$this->schedule->get_group_assign_teams($data['schedule']->tournament_group_id_1);
			$data['team_2']=$this->schedule->get_group_assign_teams($data['schedule']->tournament_group_id_2);
			$this->load->view('admin/controls/vwHeader');
			$this->load->view('admin/controls/vwLeft',$data);
			$this->load->view('admin/controls/vwFooterJavascript',$data);
	        $this->load->view('admin/vwEditSchedule',$data);
			$this->load->view('admin/controls/vwFooter');
			
		}
		else
		{
            redirect('admin/schedule');
        }
    } //this is use for edit records end
	
	public function delete_content($id) {
		$arr['page'] = 'Schedule';
		$this->schedule->delete_record('schedule_id',$id,'schedule');
		echo "delete";
		
    }
	public function bulk_delete() {
		$arr['page'] = 'Schedule';
		
		$ids = ( explode( ',', $this->input->get_post('data_ids') ));
		$this->schedule->delete_all($ids);
		echo 'delete';
    }
	public function get_group(){
		$this->schedule->group_show($this->input->get_post('id'));
	}
	public function get_match(){
		$this->schedule->match_show($this->input->get_post('id'));
	}
	public function get_first_group_teams(){
		$this->schedule->first_group_teams_show($this->input->get_post('id'));
	}
	public function get_second_group_teams(){
		$this->schedule->second_group_teams_show($this->input->get_post('id'));
	}
	public function get_duplicate_match()
	{
			echo $this->common->CountByTable('schedule','WHERE schedule_id="'.$this->input->get_post('schedule_id').'" AND is_active=1');
	}
	public function get_complete_match(){
		$this->schedule->complete_match_show($this->input->get_post('id'));
	}
	
	/*public function view_schedule()
	{
		echo $this->schedule->schedule_view($this->input->get_post('id'));
	}*/
}
?>