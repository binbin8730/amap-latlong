<?php

namespace Encore\AmapLatlong\Map;

class Amap extends AbstractMap
{

    public function applyScript(array $id)
    {
        return <<<EOT
window._AMapSecurityConfig = {
    securityJsCode: '$this->secret',
};

var url = 'https://webapi.amap.com/maps?v=1.4.15&key=$this->api&plugin=AMap.AutoComplete&callback=onLoad';
var jsapi = document.createElement('script');
jsapi.charset = 'utf-8';
jsapi.src = url;
document.head.appendChild(jsapi);

window.onLoad = function () {
    function init(name) {

        var lat = $('#{$id['lat']}');
        var lng = $('#{$id['lng']}');

        if(lng.val() && lat.val()){
            var map = new AMap.Map(name, {
                zoom: {$this->getParams('zoom')},
                center: [lng.val(), lat.val()],//中心点坐标
                lang:'zh_cn',  //设置地图语言类型
            });
            var marker = new AMap.Marker({
                map: map,
                draggable: true,
                position: [lng.val(), lat.val()],
            })
        }else{
            var map = new AMap.Map(name, {
                resizeEnable: true,
                lang:'zh_cn',  //设置地图语言类型
            });
            var marker = new AMap.Marker({
                map: map,
                draggable: true,
                position: [map.getCenter().lng,map.getCenter().lat],
            })
        }

        map.on('click', function(e) {
            marker.setPosition(e.lnglat);

            lat.val(e.lnglat.getLat());
            lng.val(e.lnglat.getLng());
        });

        marker.on('dragend', function (e) {
            lat.val(e.lnglat.getLat());
            lng.val(e.lnglat.getLng());
        });

        if( ! lat.val() || ! lng.val()) {
            map.plugin('AMap.Geolocation', function () {
                geolocation = new AMap.Geolocation();
                map.addControl(geolocation);
                geolocation.getCurrentPosition();
                AMap.event.addListener(geolocation, 'complete', function (data) {
                    marker.setPosition(data.position);

                    lat.val(data.position.getLat());
                    lng.val(data.position.getLng());
                });
            });
        }

        AMap.plugin('AMap.Autocomplete',function(){
            var autoOptions = {
                input:"search-{$id['lat']}{$id['lng']}"
            };
            var autocomplete= new AMap.Autocomplete(autoOptions);

            AMap.event.addListener(autocomplete, "select", function(data){
                map.setZoomAndCenter(18, data.poi.location);
                marker.setPosition(data.poi.location);
                lat.val(data.poi.location.lat);
                lng.val(data.poi.location.lng);
            });
        });
    }

    init('map_{$id['lat']}{$id['lng']}');
};

EOT;
    }
}
