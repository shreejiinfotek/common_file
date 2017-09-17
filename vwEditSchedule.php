<section class="content-header">
    <div class="headertitle">
      <h1>
       <?=$pagetitle;?>
      </h1>
    </div>
    <div class="headerbutton"><a class="btn btn-info" href="<?php echo base_url(); ?>admin/schedule">Manage <?=$page?>
      
      </a></div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <div class="box-header with-border">
            	<?
		  		$this->load->view('admin/controls/vwMessage');
		  		?>
            <div id="delete_allmsg_div"></div>
            <div class="FieldsMarked"> Fields Marked with (<span class="required">*</span>) are Mandatory </div>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
<?
if(!empty($schedule))
{
?>
            <form class="da-home-form form-horizontal" method="post" action="<?php echo base_url(); ?>admin/schedule/edit_schedule/<?=$schedule->schedule_id;?>" enctype="multipart/form-data">
            <div class="box-body">
            
            <div class="form-group">
                <label for="page_name" class="col-sm-3 control-label"></label>
                <div class="col-sm-4">
                    <span class="required"><?php echo validation_errors(); ?></span>
                </div>
              </div>
              
              <div class="form-group">
                <label for="tournament_id" class="col-sm-3 control-label"><span class="required">*</span>Tournament</label>
                <div class="col-sm-2">
                <select required name="tournament_id" disabled id="tournament_id" class="form-control" onchange="get_group()" data-msg-required="Please select tournament.">
                <option value="">-- Select Tournament--</option>
                     <?
					 foreach($tournament as $nkey => $tournament_val)
					  {
						if($nkey==$schedule->tournament_id)
						{
							$checkid="selected";
						}
						else
						{
							$checkid='';
						}
						echo '<option value='.$nkey.' '.$checkid.'>'.$tournament_val.'</option>';
						
					  }
					  ?> 
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="caption" class="col-sm-3 control-label">Is To Be Confirm</label>
                <div class="col-sm-4 streaming-div">
                <?
				if($schedule->is_to_be_confirm==1)
				{
					$mycheck='checked';
				}
				else
				{
					$mycheck='';
				}
				?>
					<input <?=$mycheck?> type="checkbox" name="is_to_be_confirm" id="is_to_be_confirm" onClick="get_group()" />
                </div>
              </div>
              <?
			  if($schedule->is_to_be_confirm==0)
			  {
			  ?>
              <div id="is_conform_div">
              <div class="col-sm-2"></div>
              <div class="first-team">
              <div class="form-group">
                <label for="tournament_group_id_1" class="col-sm-3 control-label"><span class="required">*</span>Group</label>
                <div class="col-sm-6">
                <select required name="tournament_group_id1" id="tournament_group_id1" class="form-control" data-msg-required="Please select group." onchange="get_first_group_teams();" >
                <option value="">-- Select Group--</option>
                      <?
					  
					 foreach($group as $nkey => $group_val)
					  {
						if($nkey==$schedule->tournament_group_id_1)
						{
							$checkid="selected";
						}
						else
						{
							$checkid='';
						}
						echo '<option value='.$nkey.' '.$checkid.'>'.$group_val.'</option>';
						
					  }
					  ?> 
                    </select>
                </div>
              </div>
              <div class="form-group" id="FirstGroup">
				  <label  class="col-sm-3 control-label"><span class="required">*</span>Teams</label><div class="col-sm-9 streaming-div"><div class="teamsDiv">
                  <?
				  
			foreach($team_1 as $team_key=>$team_1_val )
			{
				if($team_key==$schedule->team_id_1)
				{
					$mycheck="checked";
				}
				else
				{
					$mycheck="";
				}
				?>
				
				  <div class="teams-checkbox-design"><input <?=$mycheck?>   onclick="duplicate_team_validation()"  required type="radio" name="team_id_1" value="<?=$team_key?>" id="team_id_1" data-msg-required="Please select team." /> <?=$team_1_val?></div>
			<?		
			}
			?>
			</div></div></div>
            </div>
            <div class="vs-div">
            <div class="form-group">
                <label for="caption" class="col-sm-3 control-label"></label>
                <div class="col-sm-4 opposite-vs">
                  Vs
                </div>
              </div>
              </div>
            <div class="opposite-team">
              <div class="form-group">
                <label for="tournament_group_id_1" class="col-sm-3 control-label"><span class="required">*</span>Group</label>
                <div class="col-sm-6">
                <select required name="tournament_group_id2" id="tournament_group_id2" class="form-control" data-msg-required="Please select group." onchange="get_second_group_teams();">
                <option value="">-- Select Group--</option>
                      <?
					 foreach($group as $nkey => $group_val)
					  {
						if($nkey==$schedule->tournament_group_id_2)
						{
							$checkid="selected";
						}
						else
						{
							$checkid='';
						}
						echo '<option value='.$nkey.' '.$checkid.'>'.$group_val.'</option>';
						
					  }
					  ?> 
                    </select>
                </div>
              </div>
              <div class="form-group" id="SecondGroup">
			<label  class="col-sm-3 control-label"><span class="required">*</span>Teams</label><div class="col-sm-9 streaming-div"><div class="teamsDiv">
                  <?
				  
				foreach($team_2 as $team_key=>$team_2_val )
			{
				if($team_key==$schedule->team_id_2)
				{
					$mycheck="checked";
				}
				else
				{
					$mycheck="";
				}
				?>
				
				  <div class="teams-checkbox-design"><input <?=$mycheck?>  onclick="duplicate_team_validation()"  required type="radio" name="team_id_2" value="<?=$team_key?>" id="team_id_2" data-msg-required="Please select team." /> <?=$team_2_val?></div>
			<?		
			}
			?>
			</div></div></div>
            </div>
            </div>
            <?
			  }
			  
			?>
            
            <div id="divGroup"></div>
            
            <div class="form-group">
                <label for="schedule_id" class="col-sm-3 control-label"><span class="required">*</span>Match</label>
                <div class="col-sm-2">
                <select disabled name="schedule_id" id="schedule_id" class="form-control">
               
                      <?
					 foreach($matche as $nkey => $matche_val)
					  {
						if($nkey==$schedule->schedule_id)
						{
							$checkid="selected";
						}
						else
						{
							$checkid='';
						}
						echo '<option value='.$nkey.' '.$checkid.'>Match '.$matche_val.'</option>';
						
					  }
					  ?> 
                    </select>
                </div>
              </div>
              
              <div class="form-group">
                <label for="total_over_id" class="col-sm-3 control-label"><span class="required">*</span>Number Of Over</label>
                <div class="col-sm-2">
                <select required name="total_over_id" id="total_over_id" class="form-control" data-msg-required="Please select over.">
                <option value="">-- Select Over--</option>
                      <?
					 foreach($over as $nkey => $over_val)
					  {
						if($nkey==$schedule->total_over_id)
						{
							$checkid="selected";
						}
						else
						{
							$checkid='';
						}
						echo '<option value='.$nkey.' '.$checkid.'>'.$over_val.'</option>';
						
					  }
					  ?> 
                    </select>
                </div>
              </div>
            
              <div class="form-group">
                <label for="stage_id" class="col-sm-3 control-label"><span class="required">*</span>Stage</label>
                <div class="col-sm-2">
                <select required name="stage_id" id="stage_id" class="form-control" data-msg-required="Please select stage.">
                <option value="">-- Select Stage--</option>
                      <?
					 foreach($stage as $nkey => $stage_val)
					  {
						if($nkey==$schedule->stage_id)
						{
							$checkid="selected";
						}
						else
						{
							$checkid='';
						}
						echo '<option value='.$nkey.' '.$checkid.'>'.$stage_val.'</option>';
						
					  }
					  ?> 
                    </select>
                </div>
              </div>
              
              <div class="form-group">
                <label for="venue_id" class="col-sm-3 control-label"><span class="required">*</span>Venue</label>
                <div class="col-sm-2">
                <select required name="venue_id" id="venue_id" class="form-control" data-msg-required="Please select venue.">
                <option value="">-- Select Venue--</option>
                      <?
					 foreach($venue as $nkey => $venue_val)
					 {
						if($nkey==$schedule->venue_id)
						{
							$checkid="selected";
						}
						else
						{
							$checkid='';
						}
						echo '<option value='.$nkey.' '.$checkid.'>'.$venue_val.'</option>';
						
					 }
					  ?> 
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="caption" class="col-sm-3 control-label"><span class="required">*</span>Start Date & Time</label>
                <div class="col-sm-2">
                  <input type="text" required class="form-control small-textbox" name="start_date" id="start_date" value="<? if(isset($_POST["start_date"])){ echo $_POST["start_date"];}else{ echo date('m/d/Y H:i',strtotime($schedule->start_date)); }?>" data-msg-required="Please enter start date & time." >
                </div>
              </div>
              
              <div class="form-group">
                <label for="end_date" class="col-sm-3 control-label"><span class="required">*</span>End Date & Time</label>
                <div class="col-sm-2">
                  <input type="text" required class="form-control small-textbox" name="end_date" id="end_date" value="<? if(isset($_POST["end_date"])){ echo $_POST["schedule_date"];}else{ echo date('m/d/Y H:i',strtotime($schedule->end_date)); }?>" data-msg-required="Please enter end date & time." >
                </div>
              </div>
            
            
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer" > <a class="btn btn-default pull-right" href="<?php echo base_url(); ?>admin/schedule">Cancel</a>
              <button type="submit" name="Submit" value="Save" id="Submit" class="btn btn-info pull-right">Save</button>
            </div>
            <!-- /.box-footer -->
          </form>
<?
}
else
{
?>
<div class="box-body">
<div class="no-found-record">Error occured open this page</div>
</div>
<?
}
?>
        </div>
      </div>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
<script>
$("#start_date").datetimepicker({
	format: 'LT',
	minDate: 1,
});
$("#end_date").datetimepicker({
	format: 'LT',
	minDate: 1,
});
function get_group()
{
	if(check_match_Confirm())
	{
			if(check_session())
			{
					var id='<?=$schedule->tournament_id?>';
					if(id > 0 && $("#is_conform_div").html()==undefined)
					{
						
				
						var dataString = 'id='+ id;
							$.ajax
							({
								type: "POST",
								url: "<?php echo base_url(); ?>admin/schedule/get_group",
								data: dataString,
								cache: false,
								success: function(html)
								{
									$("#divGroup").html(html);
								} 
							});
					}
					else
					{
						$("#divGroup").html('');
					}
			}
	}
}
	function get_first_group_teams()
{
	if(check_session())
		{
				var id=$("#tournament_group_id1").val();
				if(id > 0)
				{
					
			
					var dataString = 'id='+ id;
						$.ajax
						({
							type: "POST",
							url: "<?php echo base_url(); ?>admin/schedule/get_first_group_teams",
							data: dataString,
							cache: false,
							success: function(html)
							{
								if(html!="")
								{
									$("#Submit").removeAttr('disabled');
									$("#FirstGroup").html(html);
								}
								else
								{
									$("#Submit").attr('disabled','disabled');
								}
							} 
						});
				}
				else
				{
					$("#FirstGroup").html('');
				}
			
		}
	}

function get_second_group_teams()
{
if(check_session())
		{
				var id=$("#tournament_group_id2").val();
				if(id > 0)
				{
					
			
					var dataString = 'id='+ id;
						$.ajax
						({
							type: "POST",
							url: "<?php echo base_url(); ?>admin/schedule/get_second_group_teams",
							data: dataString,
							cache: false,
							success: function(html)
							{
								if(html!="")
								{
									$("#Submit").removeAttr('disabled');
									$("#SecondGroup").html(html);
								}
								else
								{
									$("#Submit").attr('disabled','disabled');
								}
							} 
						});
				}
				else
				{
					$("#SecondGroup").html('');
				}
		
		}
	}
function duplicate_team_validation()
{
	
	
	
   team_2=$('input[name=team_id_2]:checked', '.da-home-form').val(); 
   team_1=$('input[name=team_id_1]:checked', '.da-home-form').val(); 
	if(check_session())
		{
				if(team_1==team_2)
				{
					$('#Submit').attr('disabled',true);
					$(".callout-success").hide();
					$(".callout-danger").hide();
					$( "#team_id_2" ).focus();
					var dhtml='<div class="callout callout-danger lead">  <p>Sorry, Match Can\'t schedule between same team</p> </div>';
					$("#delete_allmsg_div").html(dhtml);
				}
				else
				{
					$('#Submit').attr('disabled',false);
					$(".callout-success").hide();
					$(".callout-danger").hide();
				}
		}
		
}
	

	
	$(document).ready(function () {
								check_match_Confirm();
								});
	
	function check_match_Confirm()
	{
		if ($('#is_to_be_confirm').is(":checked"))
		{
		  $('#is_conform_div').hide();
		  return false;
		}
		else
		{
			 $('#is_conform_div').show();
			 return true;
		}
		
	}

</script>