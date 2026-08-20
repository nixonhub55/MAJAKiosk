 
    <?php 
        $baseRul = session()->get('baseRul'); 
    ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
 

	<link href="{{ asset('admin/fullcalendar/fullcalendar.print.min.css') }}" rel='stylesheet' media='print' />
    
	<link rel="stylesheet" href="{{ asset('admin/fullcalendar/fullcalendar.min.css') }}" />
 
	<script src="{{ asset('admin/fullcalendar/lib/jquery.min.js') }}"></script>

	<script src="{{ asset('admin/fullcalendar/lib/moment.min.js') }}"></script>
    
	<script src="{{ asset('admin/fullcalendar/fullcalendar.min.js') }}"></script> 
	
	<script src="{{ asset('admin/fullcalendar/gcal.js') }}"></script>
    

    <style>

#calendar {
    max-width: 100%;
    max-height: 100%;
    margin: 0 auto;
}

.fc-day {
    position: relative;
}

.fc-day .loading-spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none; /* Hidden by default */
}

.fc-button-disabled{
        pointer-events: none;  /* disables clicking */
        opacity: 0.5;          /* looks disabled */
        cursor: not-allowed;   /* cursor feedback */
}
</style>
<div id="calendar">
</div>
        
<script type="text/javascript"> 

    $('#calendar').fullCalendar({ 
        header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,listMonth'
    },
    
    loading: function(isLoading) { 
        if (isLoading) {
            $('.fc-prev-button, .fc-next-button, .fc-today-button').prop('disabled', true).addClass('fc-button-disabled');
        } else {
            $('.fc-prev-button, .fc-next-button, .fc-today-button').prop('disabled', false).removeClass('fc-button-disabled');
        }
    },
           
        eventSources: [ 
            
            {
                events: function(start, end, timezone, callback) { //OVERTIME
                    $.ajax({
                    url: '{{url("/calendar_sched")}}',
                    dataType: 'json',
                    data: { 
                        start: start.unix(),
                        end: end.unix(), 
                        switch: 0, 
                    },
                    success: function(msg) {
                        var events = msg.events; 
                        callback(events);
                    } 
                    })
                    
                }
            } ,
            {
                events: function(start, end, timezone, callback) { //LEAVE
                    $.ajax({
                    url: '{{url("/calendar_sched")}}',
                    dataType: 'json',
                    data: { 
                        start: start.unix(),
                        end: end.unix(), 
                        switch: 1, 
                    },
                    success: function(msg) {
                        var events = msg.events; 
                        callback(events);
                    } 
                    })
                    
                }
            },
            {
                events: function(start, end, timezone, callback) { //TIME ADJUSTMENT
                    $.ajax({
                    url: '{{url("/calendar_sched")}}',
                    dataType: 'json',
                    data: { 
                        start: start.unix(),
                        end: end.unix(), 
                        switch: 2, 
                    },
                    success: function(msg) {
                        var events = msg.events; 
                        callback(events);
                    } 
                    })
                    
                }
            }  ,

            {
                events: function(start, end, timezone, callback) { //OFFICAL BUSINESS
                    $.ajax({
                    url: '{{url("/calendar_sched")}}',
                    dataType: 'json',
                    data: { 
                        start: start.unix(),
                        end: end.unix(), 
                        switch: 3, 
                    },
                    success: function(msg) {
                        var events = msg.events; 
                        callback(events);
                    } 
                    })
                    
                }
            }  ,
            {
                events: function(start, end, timezone, callback) { //OFFSET
                    $.ajax({
                    url: '{{url("/calendar_sched")}}',
                    dataType: 'json',
                    data: { 
                        start: start.unix(),
                        end: end.unix(), 
                        switch: 4, 
                    },
                    success: function(msg) {
                        var events = msg.events; 
                        callback(events);
                    } 
                    })
                    
                }
            }  ,
            {
                events: function(start, end, timezone, callback) { //TIME ENTRY
                    $.ajax({
                    url: '{{url("/calendar_sched")}}',
                    dataType: 'json',
                    data: { 
                        start: start.unix(),
                        end: end.unix(), 
                        switch: 5, 
                    },
                    success: function(msg) {
                        var events = msg.events; 
                        callback(events);
                    } 
                    })
                    
                }
            }  ,
            {
                events: function(start, end, timezone, callback) { //SCHEDULE CHANGE
                    $.ajax({
                    url: '{{url("/calendar_sched")}}',
                    dataType: 'json',
                    data: { 
                        start: start.unix(),
                        end: end.unix(), 
                        switch: 6, 
                    },
                    success: function(msg) {
                        var events = msg.events; 
                        callback(events);
                    } 
                    })
                    
                }
            } ,
            {
                events: function(start, end, timezone, callback) { //HOLIDAYS
                    $.ajax({
                    url: '{{url("/calendar_sched")}}',
                    dataType: 'json',
                    data: { 
                        start: start.unix(),
                        end: end.unix(), 
                        switch: 101, 
                    },
                    success: function(msg) {
                        var events = msg.events; 
                        callback(events);
                    } 
                    })
                    
                }
            }  , 
        ] 
       
    });

</script>
 