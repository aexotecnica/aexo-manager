<?php echo form_open( "movimiento/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Calendario de Caja</h1>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4><i class="icon-highlight fa fa-calendar"></i> Calendar</h4>
					<div class="options">
						<a href="javascript:;"><i class="fa fa-cog"></i></a>
						<a href="javascript:;"><i class="fa fa-wrench"></i></a> 
						<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
					</div>
				</div>
				<div class="panel-body" id="calendardemo">
					<div id='calendar-drag'></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close(); ?>


<script type='text/javascript'>
// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

$( document ).ready(function() {

	var datos;
    var fecha = new Date();
    var intMes = fecha.getMonth() +1;
    var intAnio = fecha.getFullYear();

	$.ajax({
		type:'POST',
		url:'<?php echo base_url(); ?>index.php/flujoCaja/getMovimientosDelMes',                    
		dataType:'json',
        data:{mes: intMes,anio: intAnio},                    
        cache:false,
        success:function(aData){ 
        	datos = aData;
        	renderCalendar({left: 'title',right: 'prev,next'},new Date());
            $('.fc-event-inner').css("text-align", "right");

        },
        error:function(){alert("Connection Is Not Available");}
    });


	function renderCalendar(headertype,date) {

    // Demo for FullCalendar with Drag/Drop internal
    
    //var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();



    var calendar = $('#calendar-drag').fullCalendar({
    	header: headertype,
    	selectable: true,
    	selectHelper: true,
    	select: function(start, end, allDay) {
    		var title = prompt('Event Title:');
    		if (title) {
    			calendar.fullCalendar('renderEvent',
    			{
    				title: title,
    				start: start,
    				end: end,
    				allDay: allDay
    			},
                    true // make the event "stick"
                    );
    		}
    		calendar.fullCalendar('unselect');
    	},
    	editable: true,
    	events:datos,

    	buttonText: {
    		prev: '<i class="fa fa-angle-left"></i>',
    		next: '<i class="fa fa-angle-right"></i>',
            prevYear: '<i class="fa fa-angle-double-left"></i>',  // <<
            nextYear: '<i class="fa fa-angle-double-right"></i>',  // >>
            today:    'Today',
            month:    'Month',
            week:     'Week',
            day:      'Day'
        },
/*        eventClick: function(calEvent, jsEvent, view) {


        	//window.open('<?php echo base_url(); ?>index.php/movimiento/traerMovimientos/' + dateToYMD(calEvent.start));
        	// change the border color just for fun
        	$(this).css('border-color', 'red');

			return false;
    }*/

});

    $('.fc-button-next').click(function(){
        
        var fecha =  new Date($('#calendar-drag').fullCalendar('getDate'));
        fecha.setMonth(fecha.getMonth() + 1);
        var mes = fecha.getMonth();
        var anio  = fecha.getFullYear();
        if (mes == 0){
            mes = 12;
            anio = anio -1;
        }
            
        $.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>index.php/flujoCaja/getMovimientosDelMes',                    
            dataType:'json',
            data:{mes: mes,anio: anio},                    
            cache:false,
            success:function(aData){ 
                datos = aData;
                fecha.setMonth(fecha.getMonth() - 1);
                $('#calendar-drag').html("");
                renderCalendar({left: 'title',right: 'prev,next'},fecha);
                //$('#calendar-drag').fullCalendar({events:datos});
                $('#calendar-drag').fullCalendar('gotoDate', fecha);
                $('.fc-event-inner').css("text-align", "right");

            },
            error:function(){alert("Connection Is Not Available");}
        });
    });
    
    $('.fc-button-prev').click(function(){
        
        var fecha =  new Date($('#calendar-drag').fullCalendar('getDate'));
        fecha.setMonth(fecha.getMonth() + 1);
        var mes = fecha.getMonth();
        var anio  = fecha.getFullYear();
        if (mes == 0){
            mes = 12;
            anio = anio -1;
        }
        $.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>index.php/flujoCaja/getMovimientosDelMes',                    
            dataType:'json',
            data:{mes: mes,anio:anio },                    
            cache:false,
            success:function(aData){ 
                datos = aData;
                fecha.setMonth(fecha.getMonth() - 1);
                $('#calendar-drag').html("");
                renderCalendar({left: 'title',right: 'prev,next'},fecha);
                //$('#calendar-drag').fullCalendar({events:datos});
                $('#calendar-drag').fullCalendar('gotoDate', fecha);
                $('.fc-event-inner').css("text-align", "right");

            },
            error:function(){alert("Connection Is Not Available");}
        });
    });


	function dateToYMD(date) {
	    var d = date.getDate();
	    var m = date.getMonth() + 1;
	    var y = date.getFullYear();
	    return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
	}

    // Listen for click on toggle checkbox
    $('#select-all').click(function(event) {
    	if(this.checked) {
    		$('.selects :checkbox').each(function() {
    			this.checked = true;
    		});
    	} else {
    		$('.selects :checkbox').each(function() {
    			this.checked = false;
    		});
    	}
    });

    $( ".panel-tasks" ).sortable({placeholder: 'item-placeholder'});
    $('.panel-tasks input[type="checkbox"]').click(function(event) {
    	if(this.checked) {
    		$(this).next(".task-description").addClass("done");
    	} else {
    		$(this).next(".task-description").removeClass("done");
    	}
    });

}

});
</script>