$(document).ready(function(){

    window.setInterval(function() {
        $('.timeleft').each(function(){
            var lastHeartbeat, timeout, timeleft,
                days, hours, minutes, seconds,
                aliveOKClass, aliveKOClass;

            lastHeartbeat = $(this).data('lastheartbeat') * 1000;
            timeout       = $(this).data('timeout') * 1000;
            timeleft      = moment.duration(lastHeartbeat + timeout - Date.now());

            days = timeleft > 0 ? timeleft.days() : 0;
            hours = timeleft > 0 ? timeleft.hours() : 0;
            minutes = timeleft > 0 ? timeleft.minutes() : 0;
            seconds = timeleft > 0 ? timeleft.seconds() : 0;

            $(this).text(
                days + 'd ' +
                zeroFill(hours, 2) + ':' +
                zeroFill(minutes, 2) + ':' +
                zeroFill(seconds, 2)
            );

            aliveOKClass = 'btn-success';
            aliveKOClass = 'btn-danger';

            if (timeleft > 0) {
                $('#alive').removeClass(aliveKOClass).addClass(aliveOKClass);
            } else {
                $('#alive').removeClass(aliveOKClass).addClass(aliveKOClass);
            }
        });
    }, 1000);

});

function zeroFill( number, width )
{
    width -= number.toString().length;
    if ( width > 0 )
    {
        return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
    }
    return number + ""; // always return a string
}
