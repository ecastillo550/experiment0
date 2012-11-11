<?php
/* For licensing terms, see /dokeos_license.txt */

/**
* @package dokeos.admin
*/

// name of the language file that needs to be included
$language_file = array ('admin','agenda');

// resetting the course id
$cidReset = true;

// setting the help
$help_content = 'platformadministrationagenda';

// including the global Dokeos file
require_once '../inc/global.inc.php';

// including additional libraries
require_once '../calendar/functions.php';
require_once api_get_path ( LIBRARY_PATH ) . 'formvalidator/FormValidator.class.php';

// setting the section (for the tabs)
$this_section = SECTION_PLATFORM_ADMIN;

// Access restrictions
api_protect_admin_script(true);

// Access restrictions
api_protect_admin_script(true);


// defaultview (this has to become a platform setting)
$curr_view = '';
if ($_GET['view'] && in_array($_GET['view'], array ('month', 'agendaWeek', 'agendaDay'))) {
        $defaultview = 'defaultView: \'' . Security::remove_XSS($_GET['view']) . '\',';
        $curr_view = Security::remove_XSS($_GET['view']);
} else {
        $defaultview = 'defaultView: \'' . api_get_setting('agenda_default_view') . '\',';
        $curr_view = api_get_setting('agenda_default_view');
}

// setting the name of the tool
$tool_name = get_lang('PlatformCalendar');

// setting breadcrumbs
$interbreadcrumb[] = array('url' => 'index.php', 'name' => get_lang('AdministrationTools'));
$interbreadcrumb[] = array('url' => 'agenda.php', 'name' => $tool_name);

// add additional javascript and css
$htmlHeadXtra[] = '<script type="text/javascript" src="' . api_get_path ( WEB_CODE_PATH ) . 'inc/lib/javascript/jquery.qtip/jquery.qtip.min.js" language="javascript"></script>';
$htmlHeadXtra [] = '<script type="text/javascript" src="' . api_get_path ( WEB_CODE_PATH ) . 'inc/lib/javascript/fullcalendar-1.4.5/fullcalendar.js" language="javascript"></script>';
$htmlHeadXtra[] = '<script type="text/javascript" src="' . api_get_path ( WEB_CODE_PATH ) . 'inc/lib/javascript/jquery.expander.js" language="javascript"></script>';
//$htmlHeadXtra [] = '<link rel="stylesheet" type="text/css" href="' . api_get_path ( WEB_CODE_PATH ) . 'inc/lib/javascript/fullcalendar-1.4.5/fullcalendar-dokeos.css" />';

$htmlHeadXtra[] = '<link rel="stylesheet" type="text/css" href="' . api_get_path ( WEB_CODE_PATH ) . 'inc/lib/javascript/fullcalendar-1.4.5/fullcalendar.css" />';
$htmlHeadXtra[] = '<link rel="stylesheet" type="text/css" href="' . api_get_path ( WEB_CODE_PATH ) . 'inc/lib/javascript/jquery.qtip/jquery.qtip.min.css" />';

$htmlHeadXtra [] = "
    
    <style>
        #dialog-platform-event-form, #dialog-platform-event-edit-form {
            min-height: 300px !important;
        }
        #action-bottom {
            height: 60px;
            overflow: hidden;
            position: relative;
            width: 100%;
        }
        #action-bottom .row {
            display:inline;
        }

        #action-bottom .formw {
            float:none;
        }

        #action-bottom button {
            margin-left: 20px !important;
            margin-top: 20px !important;
        }
    </style>
<script type='text/javascript'>

$(document).ready(function() {
                
                $('#delete-platform-agenda-item').click(function(){                          
                    if(!confirm('".get_lang('ConfirmYourChoise')."')){return false;}
                    if ($('input[name=\"agenda_id\"]').length > 0) {
                        var agenda_id = $('input[name=\"agenda_id\"]').val();
                        var view = $('input[name=\"calendar_view\"]').val();
                        location.href = '".api_get_path(WEB_CODE_PATH)."admin/agenda.php?action=platformdelete&id='+agenda_id+'&view='+view;
                        return false;
                    }
                });

		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		var MinervaCalendar = $('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			buttonText: { today: '".addslashes(get_lang('Today'))."', month: '".addslashes(get_lang('MonthView'))."', week: '".addslashes(get_lang('WeekView'))."', day: '".addslashes(get_lang('DayView'))."'}, 
			monthNames: ['".addslashes(ucfirst(get_lang('JanuaryLong')))."', '".addslashes(ucfirst(get_lang('FebruaryLong')))."', '".addslashes(ucfirst(get_lang('MarchLong')))."', '".addslashes(ucfirst(get_lang('AprilLong')))."', '".addslashes(ucfirst(get_lang('MayLong')))."', '".addslashes(ucfirst(get_lang('JuneLong')))."', '".addslashes(ucfirst(get_lang('JulyLong')))."', '".addslashes(ucfirst(get_lang('AugustLong')))."', '".addslashes(ucfirst(get_lang('SeptemberLong')))."', '".addslashes(ucfirst(get_lang('OctoberLong')))."', '".addslashes(ucfirst(get_lang('NovemberLong')))."', '".addslashes(ucfirst(get_lang('DecemberLong')))."'],
			monthNamesShort: ['".addslashes(ucfirst(get_lang('JanuaryShort')))."', '".addslashes(ucfirst(get_lang('FebruaryShort')))."', '".addslashes(ucfirst(get_lang('MarchShort')))."', '".addslashes(ucfirst(get_lang('AprilShort')))."', '".addslashes(ucfirst(get_lang('MayShort')))."', '".addslashes(ucfirst(get_lang('JuneShort')))."', '".addslashes(ucfirst(get_lang('JulyShort')))."', '".addslashes(ucfirst(get_lang('AugustShort')))."', '".addslashes(ucfirst(get_lang('SeptemberShort')))."', '".addslashes(ucfirst(get_lang('OctoberShort')))."', '".addslashes(ucfirst(get_lang('NovemberShort')))."', '".addslashes(ucfirst(get_lang('DecemberShort')))."'],
			dayNames: ['".addslashes(ucfirst(get_lang('SundayLong')))."', '".addslashes(ucfirst(get_lang('MondayLong')))."', '".addslashes(ucfirst(get_lang('TuesdayLong')))."', '".addslashes(ucfirst(get_lang('WednesdayLong')))."', '".addslashes(ucfirst(get_lang('ThursdayLong')))."', '".addslashes(ucfirst(get_lang('FridayLong')))."', '".addslashes(ucfirst(get_lang('SaturdayLong')))."'],
			dayNamesShort: ['".addslashes(ucfirst(get_lang('SundayShort')))."', '".addslashes(ucfirst(get_lang('MondayShort')))."', '".addslashes(ucfirst(get_lang('TuesdayShort')))."', '".addslashes(ucfirst(get_lang('WednesdayShort')))."', '".addslashes(ucfirst(get_lang('ThursdayShort')))."', '".addslashes(ucfirst(get_lang('FridayShort')))."', '".addslashes(ucfirst(get_lang('SaturdayShort')))."'],
			weekMode: 'variable',
			allDaySlot: false,
			firstDay: 1,
			axisFormat: 'HH(:mm)',
			timeFormat: 'HH:mm{ - HH:mm}',
			height: 600,
			" . $defaultview . "
                        selectable: true,
                        selectHelper: true,
                        viewDisplay: function(view) {
                            var api = $('.qtip').qtip('api');
                            if (api) {
                                api.destroy();
                            }
                        },
			editable: true,
			events: \"../calendar/ajax.php?action=getplatformevents&output=json\",
			eventMouseover: function(calEvent,jsEvent) {
                        
					xOffset = 10;
					yOffset = 30;
					// the appropriate visibility icon
					if (calEvent.visibility == 1){
						var visibility_icon = 'visible.gif';
					} else {
						var visibility_icon = 'invisible.gif';
					}	
					if ($(this).hasClass('platform')) {
						$(this).children('a').append('<span class=\"fc-event-actions\">".Display::return_icon('pixel.gif', get_lang('Edit').' '.strtolower(get_lang('Edit')),array('class' => 'actionplaceholdericon actionedit')).Display::return_icon('pixel.gif', get_lang('Cancel').' '.strtolower(get_lang('Canel')),array('class' => 'actionplaceholdericon actiondelete'))."</span>');
					}
			},
			eventMouseout: function(calEvent,jsEvent) {
                                
					$('.fc-event-actions').remove();
			},
			eventRender: function(calEvent, element) {
                               
				var tipContent = '<strong>' +
					$.fullCalendar.formatDate(calEvent.start,'HH:mm') + ' - ' +
					$.fullCalendar.formatDate(calEvent.end,'HH:mm') + '</strong><br/>' +
					calEvent.title;
					if (typeof calEvent.location != 'undefined') {
						tipContent +=  '<br/>' + calEvent.location;
					}
					if (typeof calEvent.description != 'undefined') {
						tipContent +=  '<br/>' + calEvent.description;
					}
                                        if (calEvent.content) {
                                            element.qtip({            
                                                hide: { delay: 1000 },
                                                content: calEvent.content,
                                                position: { at:'top left' , my:'bottom left'},	
                                             }).removeData('qtip');
                                        }
			},
                        select: function(start, end, allDay, jsEvent, view) {
                            /* When selecting one day or several days */	                                    
                            var start_date 	= Math.round(start.getTime() / 1000);
                            var end_date 	= Math.round(end.getTime() / 1000);

                            var start_date_value = $.datepicker.formatDate('D d M yy', start);
                            var end_date_value  = $.datepicker.formatDate('D d M yy', end);

                            $('#new_start_date').html(start_date_value + ' ' +  start.toTimeString().substr(0, 8));
                            if (view.name != 'month') {
                                    $('#new_start_date').html(start_date_value + ' ' +  start.toTimeString().substr(0, 8));
                                    if (start.toDateString() == end.toDateString()) {					
                                            $('#new_end_date').html(' - '+end.toTimeString().substr(0, 8));
                                    } else {
                                            $('#new_end_date').html(' - '+start_date_value+' ' + end.toTimeString().substr(0, 8));
                                    }
                            } else {
                                    $('#new_start_date').html(start_date_value);
                                    $('#new_end_date').html(end_date_value);					
                            }

                            var hd_start_date_value = $.datepicker.formatDate('yy-mm-dd', start);
                            var hd_end_date_value  = $.datepicker.formatDate('yy-mm-dd', end);
                            $('input[name=\"start_date\"]').val(hd_start_date_value + ' ' +  start.toTimeString().substr(0, 8));
                            $('input[name=\"end_date\"]').val(hd_end_date_value + ' ' +  end.toTimeString().substr(0, 8));

                            $('input[name=\"title\"]').val('');
                            $('textarea[name=\"content\"]').val('');
                            if ($('input[name=\"calendar_view\"]').length > 0) { $('input[name=\"calendar_view\"]').val(view.name); }                                    
                            if ($('input[name=\"agenda_id\"]').length > 0) { $('input[name=\"agenda_id\"]').val(''); }

                            $('#dialog-platform-event-form').dialog({modal: true, title: '".get_lang('AgendaAdd')."', width: '700px'});

                            //prevent the browser to follow the link
                            return false;
                            calendar.fullCalendar('unselect');
                        },
			eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
                        
				$.ajax({
				  url: '../calendar/ajax.php',
				  data: {action: 'platformmove', id: event.id, daydelta: dayDelta, minutedelta: minuteDelta}
				});
                        },
                        eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
                
					$.ajax({
					  url: '../calendar/ajax.php',
					  data: {action: 'platformmoveresize', id: event.id, daydelta: dayDelta, minutedelta: minuteDelta}
					});
		    	},
                        eventClick: function(event,jsEvent,view){
                                
                                    var start_date_value = $.datepicker.formatDate('D d M yy', event.start);                                    
                                    var end_date_value  = $.datepicker.formatDate('D d M yy', event.end);
                                    var agenda_id = parseInt(event.id.replace('platform', ''));

                                    $('#upd_start_date').html(start_date_value + ' ' +  event.start.toTimeString().substr(0, 8));
                                    if (view.name != 'month') {
                                            $('#upd_start_date').html(start_date_value + ' ' +  event.start.toTimeString().substr(0, 8));
                                            if (event.start.toDateString() == event.end.toDateString()) {					
                                                    $('#upd_end_date').html(' - '+event.end.toTimeString().substr(0, 8));
                                            } else {
                                                    $('#upd_end_date').html(' - '+start_date_value+' ' + event.end.toTimeString().substr(0, 8));
                                            }
                                    } else {
                                            $('#upd_start_date').html(start_date_value);
                                            $('#upd_end_date').html(end_date_value);					
                                    }
                                    
                                    var hd_start_date_value = $.datepicker.formatDate('yy-mm-dd', event.start);
                                    var hd_end_date_value  = $.datepicker.formatDate('yy-mm-dd', event.end);
                                    
                                    $('input[name=\"start_date\"]').val(hd_start_date_value + ' ' +  event.start.toTimeString().substr(0, 8));
                                    $('input[name=\"end_date\"]').val(hd_end_date_value + ' ' +  event.end.toTimeString().substr(0, 8));
                                    $('input[name=\"title\"]').val(event.title);
                                    $('textarea[name=\"content\"]').val(event.content);
                                    if ($('input[name=\"calendar_view\"]').length > 0) { $('input[name=\"calendar_view\"]').val(view.name); }                                    
                                    if ($('input[name=\"agenda_id\"]').length > 0) { $('input[name=\"agenda_id\"]').val(agenda_id); }

                                    $('#dialog-platform-event-edit-form').dialog({modal: true, title: '".get_lang('AgendaEdit')."', width: '600px'});
                                    return false;
                                }
		});
		$('.fc-event-actions .edit').live('click', function(){
                    
                    
			id = $(this).attr('id');
                       var info_id = new Array();

                       info_id = id.split('platform');
                       var my_id = 0;
                       try {
                       if (info_id[1] > 0) {
                         my_id = info_id[1];
                       }
                       } catch(e) {
                        my_id = id.replace('edit_','');
                       }
                                            $(location).attr('href','agenda.php?action=platformedit&id='+my_id);
                                    });

                                    $('.fc-event-actions .delete').live('click', function(){
                                            id=$(this).attr('id');
                       var info_id = new Array();
                       info_id = id.split('platform');
                       var my_id = 0;
                       try {
                       if (info_id[1] > 0) {
                         my_id = info_id[1];
                       }
                       } catch(e) {
                        my_id =  id.replace('delete_','');
                       }
			// remove from database
			$.ajax({
			  url: '../calendar/ajax.php',
			  data: {action: 'platformdelete', id: my_id}
			});
			
			// get the fc_index
			var fc_index = $('.fc-event').index($(this).parent().parent().parent());
			
			// remove the fc-event 	
			$(this).parent().parent().parent().remove();						
		});

			// change the size if month view is clicked
			$('.fc-button-month').click(function(){
                                
				MinervaCalendar.fullCalendar('option', 'height', 600);
			});

			// change the size if month view is clicked
			$('.fc-button-agendaWeek, .fc-button-agendaDay').click(function(){
                        
				MinervaCalendar.fullCalendar('option', 'height', 1200);
			});
   
	});
</script>";

// Displaying the header
Display::display_header($tool_name);

// Displaying the name of the tool
// api_display_tool_title($tool_name);

// Actions
echo '<div class="actions fc-header">';
echo platformcalendar_actions ();
echo '</div>';

// Start the content div
echo '<div id="content" style="width:938px;">'; // style definition unfortunately needed because content is added through javascript

// Action handling
handle_platformcalendar_actions ();

echo '<div id="calendar"></div>';

// Close the content div
echo '</div>';

// dialog forms
display_dialog_platform_event_form();
display_dialog_platform_event_edit_form();

// Displaying the footer
Display::display_footer();
?>
