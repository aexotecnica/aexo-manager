// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

renderCalendar({left: 'title',right: 'prev,next'});

enquire.register("screen and (min-width: 1200px)", {
    match : function() {
        $('#calendar-drag').removeData('fullCalendar').empty();
        renderCalendar({left: 'prev,next',center: 'title',right: 'month,basicWeek,basicDay'});
    },
    unmatch : function() {
        $('#calendar-drag').removeData('fullCalendar').empty();
        renderCalendar({left: 'title',right: 'prev,next'});
    }
});


function renderCalendar(headertype) {

    // Demo for FullCalendar with Drag/Drop internal

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>/movimiento/getMovimientosDelMes',                    
        dataType:'json',
        //data:{idZona: $('#field-idZona').val(),idLocalidad: $('#field-idLocalidad').val()},                    
        cache:false,
        success:function(aData){ 
/*            $.each(aData, function(i,item) {                        
                            $('#field-idBarrio').get(0).options[$('#field-idBarrio').get(0).options.length] = new Option(item.desc,item.id); // Display      Value
                        });,*/
        alert(aData);
        },
        error:function(){alert("Connection Is Not Available");}
        });

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
        events: [
        {
            title: 'All Day Event',
            start: new Date(y, m, 8),
            backgroundColor: '#efa131'
        },
        {
            title: 'Long Event',
            start: new Date(y, m, d-5),
            end: new Date(y, m, d-2),
            backgroundColor: '#7a869c'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: new Date(y, m, d-3, 16, 0),
            allDay: false,
            backgroundColor: '#e74c3c'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: new Date(y, m, d+4, 16, 0),
            allDay: false,
            backgroundColor: '#e74c3c'
        },
        {
            title: 'Meeting',
            start: new Date(y, m, d, 10, 30),
            allDay: false,
            backgroundColor: '#76c4ed'
        },
        {
            title: 'Lunch',
            start: new Date(y, m, d, 12, 0),
            end: new Date(y, m, d, 14, 0),
            allDay: false,
            backgroundColor: '#34495e'
        },
        {
            title: 'Birthday Party',
            start: new Date(y, m, d+1, 19, 0),
            end: new Date(y, m, d+1, 22, 30),
            allDay: false,
            backgroundColor: '#2bbce0'
        },
        {
            title: 'Click for Google',
            start: new Date(y, m, 28),
            end: new Date(y, m, 29),
            url: 'http://google.com/',
            backgroundColor: '#f1c40f'
        }
        ],
        buttonText: {
            prev: '<i class="fa fa-angle-left"></i>',
            next: '<i class="fa fa-angle-right"></i>',
            prevYear: '<i class="fa fa-angle-double-left"></i>',  // <<
            nextYear: '<i class="fa fa-angle-double-right"></i>',  // >>
            today:    'Today',
            month:    'Month',
            week:     'Week',
            day:      'Day'
        }
    });

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