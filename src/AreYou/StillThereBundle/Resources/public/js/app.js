$(document).ready(function(){

    window.setInterval(function() {
        $('.timeleft').each(function(){
            var lastHeartbeat, timeout, timeleft;

            lastHeartbeat = $(this).data('lastheartbeat') * 1000;
            timeout       = $(this).data('timeout') * 1000;
            timeleft      = moment.duration(lastHeartbeat + timeout - Date.now());

            if (timeleft > 0) {
                $(this).text(
                    timeleft.days() + 'd ' +
                    zeroFill(timeleft.hours(), 2) + ':' +
                    zeroFill(timeleft.minutes(), 2) + ':' +
                    zeroFill(timeleft.seconds(), 2)
                );
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
