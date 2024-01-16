document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        selectable: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'timeGridWeek,timeGridDay,dayGridMonth'
        },
        events: {
            url: '/events',
            method: 'GET'
        },
        select: function (info) {
            var customerName = prompt('Foglalás: ' + info.startStr + ' - ' + info.endStr + ' \r\nKérem, adja meg az ügyfél nevét:');
            console.log(info);
            if (customerName) {
                $.ajax({
                    url: '/event/create',
                    type: 'GET',
                    data: {
                        start: info.startStr,
                        end: info.endStr,
                        title: customerName
                    },
                    success: function(response) {
                        if(response.success){
                            calendar.setOption('events', {
                                url: '/events',
                                method: 'GET'
                            });
                            calendar.changeView('dayGridMonth');
                            calendar.refetchEvents();
                        }
                        alert(response.msg);
                    },
                    error: function() {
                        alert('Hiba történt az AJAX kérés során!');
                    }
                });
            }else{
                alert('Egy ügyfélnevet adj meg kérlek.');
            }
        },
    });
    calendar.render();
});