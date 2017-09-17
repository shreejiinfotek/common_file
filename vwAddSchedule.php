<section class="content-header">
    <div class="headertitle">
      <h1>
        <?=$pagetitle?>
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
            <form class="da-home-form form-horizontal" method="post" action="<?php echo base_url(); ?>admin/schedule/add_schedule" enctype="multipart/form-data" novalidate>
            <div class="box-body">
            
            <div class="form-group">
                <label for="page_name" class="col-sm-3 control-label"></label>
                <div class="col-sm-2">
                    <span class="required"><?php echo validation_errors(); ?></span>
                </div>
              </div>
              
              <div class="form-group">
                <label for="tournament_id" class="col-sm-3 control-label"><span class="required">*</span>Tournament</label>
                <div class="col-sm-2">
                <select required name="tournament_id" id="tournament_id" class="form-control" onchange="get_group(),get_match();" data-msg-required="Please select tournament.">
                <option value="">-- Select Tournament--</option>
                      <?
					 foreach($tournament as $nkey => $tournamentval)
					  {
						  if($this->input->post('tournament_id')!="")
						  {
							  $myselect='selected';
						  }
						  else
						  {
							  $myselect="";
						  }
						 echo '<option value='.$nkey.' '.$myselect.'>'.$tournamentval.'</option>';
					  }
					  ?> 
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="caption" class="col-sm-3 control-label">Is To Be Confirm</label>
                <div class="col-sm-4 streaming-div">
					<input type="checkbox" name="is_to_be_confirm" id="is_to_be_confirm" />
                </div>
              </div>
            </div>
              <div id="divGroup"></div>
              <div id="divMatch"></div>
              <div class="form-group">
                <label for="total_over_id" class="col-sm-3 control-label"><span class="required">*</span>Number Of Over</label>
                <div class="col-sm-2">
                <select required name="total_over_id" id="total_over_id" class="form-control" data-msg-required="Please select over.">
                <option value="">-- Select Over--</option>
                      <?
					 foreach($over as $nkey => $overval)
					  {
						  if($this->input->post('total_over_id')!="")
						  {
							  $myselect='selected';
						  }
						  else
						  {
							  $myselect="";
						  }
						 echo '<option value='.$nkey.' '.$myselect.'>'.$overval.'</option>';
					  }
					  ?> 
                    </select>
                </div>
              </div>
              
              <div class="form-group">
                <label for="tournament_id" class="col-sm-3 control-label"><span class="required">*</span>Stage</label>
                <div class="col-sm-2">
                <select required name="stage_id" id="stage_id" class="form-control" data-msg-required="Please select stage.">
                <option value="">-- Select Stage--</option>
                      <?
					 foreach($stage as $nkey => $stageval)
					  {
						  if($this->input->post('stage_id')!="")
						  {
							  $myselect='selected';
						  }
						  else
						  {
							  $myselect="";
						  }
						 echo '<option value='.$nkey.' '.$myselect.'>'.$stageval.'</option>';
					  }
					  ?> 
                    </select>
                </div>
              </div>
              
              <div class="form-group">
                <label for="tournament_id" class="col-sm-3 control-label"><span class="required">*</span>Venue</label>
                <div class="col-sm-2">
                <select required name="venue_id" id="venue_id" class="form-control" data-msg-required="Please select venue.">
                <option value="">-- Select Venue--</option>
                      <?
					 foreach($venue as $nkey => $venueval)
					  {
						  if($this->input->post('venue_id')!="")
						  {
							  $myselect='selected';
						  }
						  else
						  {
							  $myselect="";
						  }
						 echo '<option value='.$nkey.' '.$myselect.'>'.$venueval.'</option>';
					  }
					  ?> 
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="start_date" class="col-sm-3 control-label"><span class="required">*</span>Start Date & Time</label>
                <div class="col-sm-2">
                  <input type="text" required class="form-control small-textbox" name="start_date" id="start_date" value="<? if(isset($_POST["start_date"])){ echo $_POST["start_date"];}?>" data-msg-required="Please enter start date & time." >
                </div>
              </div>
              
              <div class="form-group">
                <label for="end_date" class="col-sm-3 control-label"><span class="required">*</span>End Date & Time</label>
                <div class="col-sm-2">
                  <input type="text" required class="form-control small-textbox" name="end_date" id="end_date" value="<? if(isset($_POST["end_date"])){ echo $_POST["end_date"];}?>" data-msg-required="Please enter end date & time." >
                </div>
              </div>
            
            <!-- /.box-body -->
            <div class="box-footer" > <a class="btn btn-default pull-right" href="<?php echo base_url(); ?>admin/schedule">Cancel</a>
              <button type="submit" name="Submit" value="Save" id="Submit" class="btn btn-info pull-right">Save</button>
            </div>
            <!-- /.box-footer -->
          </form>
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
			if(check_session())
		{
				var id=$("#tournament_id").val();
				if(id > 0)
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
function get_team_count()
{
	var totalCheckboxes = $('input:radio').length;
	alert(totalCheckboxes);
	if(totalCheckboxes>0)
	{
		$("#Submit").removeAttr('disabled');
	}
	else
	{
		$("#Submit").attr('disabled','disabled');	
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

function get_match()
{
if(check_session())
		{
				var id=$("#tournament_id").val();
				if(id > 0)
				{
					
			
					var dataString = 'id='+ id;
						$.ajax
						({
							type: "POST",
							url: "<?php echo base_url(); ?>admin/schedule/get_match",
							data: dataString,
							cache: false,
							success: function(html)
							{
								$("#divMatch").html(html);
							} 
						});
				}
				else
				{
					$("#divMatch").html('');
				}
			
		}
	}
function duplicate_match_validation()
{
	schedule_id=$('#schedule_id').val();
	match_id=$("#schedule_id option:selected").attr("match_number");
if(check_session())
		{
				var dataString = 'schedule_id='+ schedule_id;
						$.ajax
						({
							type: "POST",
							url: "<?php echo base_url(); ?>admin/schedule/get_duplicate_match",
							data: dataString,
							cache: false,
							success: function(data)
							{
								if(data==1)
								{
									$('#Submit').attr('disabled',true);
									$(".callout-success").hide();
									$(".callout-danger").hide();
									$( "#team_id_2" ).focus();
									var dhtml='<div class="callout callout-danger lead">  <p>Sorry, Match '+match_id+' already schedule.</p> </div>';
									$("#delete_allmsg_div").html(dhtml);
								}
								else
								{
									$('#Submit').attr('disabled',false);
									$(".callout-success").hide();
									$(".callout-danger").hide();
								}
							} 
						});
		}
		
}

$(document).ready(function () {
    $('#is_to_be_confirm').change(function () {
        if (!this.checked) 
        //  ^
           $('#divGroup').show();
        else 
            $('#divGroup').hide();
    });
});
  </script>
  
  