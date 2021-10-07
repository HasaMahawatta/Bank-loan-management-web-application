var MapIcons = {bm: 'images/mapicons/bluemountain.png'};


function addPointsOnMap(map, points)
{
    for (i = 0; i < points.length; i++)
    {
        addPointOnMap(map, points[i]);
    }
}

function addPointOnMap(map, point)
{
    var mapOptions = {
        position: {lat: point.lat, lng: point.lng}
    };
    var marker = new google.maps.Marker(point);
    marker.setMap(map);
}

$(function() {
    $('.form').on('click', '.removeRow', function() {
        $(this).parent('tr').remove();
    });
    $('.form').on('click', '.removeParentDiv', function() {
        $(this).parent('div').remove();
    });


});

