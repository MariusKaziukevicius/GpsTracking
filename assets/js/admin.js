require('../css/admin.css');

CM_ATTR = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
    '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
    'Imagery © <a href="http://cloudmade.com">CloudMade</a>';

CM_URL = 'http://{s}.tile.cloudmade.com/d4fc77ea4a63471cab2423e66626cbb6/{styleId}/256/{z}/{x}/{y}.png';

OSM_URL = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
OSM_ATTRIB = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors';


var map = L.map('map').setView([51.505, -0.09], 2);

L.tileLayer(CM_URL, { attribution: CM_ATTR, styleId: 997 }).addTo(map);

$(document).ready(function() {
    var deviceIdsOnTheMap = [];

    //load all devices
    var jqxhr = $.getJSON('api/devices', function () {
    })
        .done(function (data) {
            console.log(data);
            for (var i = 0; i < data.length; i++) {
                if (deviceIdsOnTheMap.indexOf(data[i].id) !== -1) {
                    continue;
                }
                L.marker([data[i].latitude, data[i].longtitude]).addTo(map)
                    .bindPopup("<b>Device id: </b>" + data[i].id + "<br/><b>Type: </b>" + data[i].locationType + "<br/><b>Address: </b>" + data[i].address);
                deviceIdsOnTheMap.push(data[i].id);
            }
        })
        .fail(function (data) {
        });

    $('#add_device').click(function() {
        $(this).hide();
        $('#track_device_form').show();
    });

    $('#track_device_form > button').click(function() {
        var deviceId = $('#track_device_form > input').val();

        var jqxhr = $.getJSON('api/device/'+deviceId, function() {
        })
            .done(function(data) {
                map.flyTo([data.latitude, data.longtitude], 6);
                $('#track_device_form > input').val('');
                $('#track_device_form').hide();
                $('#add_device').show();

                if (deviceIdsOnTheMap.indexOf(data.id) !== -1) {
                    return;
                }

                L.marker([data.latitude, data.longtitude]).addTo(map)
                    .bindPopup("<b>Device id: </b>" + data.id + "<br/><b>Type: </b>" + data.locationType + "<br/><b>Address: </b>" + data.address);
                deviceIdsOnTheMap.push(data.id);
            })
            .fail(function(data) {
                alert(data.responseJSON[0]);
            });
    });
});