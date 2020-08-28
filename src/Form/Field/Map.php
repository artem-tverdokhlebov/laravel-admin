<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;

class Map extends Field
{
    protected $value = [
        'lat' => null,
        'lng' => null,
    ];

    /**
     * Column name.
     *
     * @var array
     */
    protected $column = [];

    /**
     * Get assets required by this field.
     *
     * @return array
     */
    public static function getAssets()
    {
        $css = [];

        switch (config('admin.map_provider')) {
            case 'tencent':
                $js = '//map.qq.com/api/js?v=2.exp&key='.env('TENCENT_MAP_API_KEY');
                break;
            case 'google':
                $js = '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key='.env('GOOGLE_API_KEY');
                break;
            case 'yandex':
                $js = '//api-maps.yandex.ru/2.1/?lang=ru_RU';
                break;
            case 'openstreetmap':
                $js[] = '//cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.js';
                $js[] = '//cdnjs.cloudflare.com/ajax/libs/leaflet-geosearch/3.0.6/geosearch.umd.js';

                $css[] = '//cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.css';
                $css[] = '//cdnjs.cloudflare.com/ajax/libs/leaflet-geosearch/3.0.6/geosearch.min.css';

                break;
            default:
                $js = '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key='.env('GOOGLE_API_KEY');
        }

        return compact('js', 'css');
    }

    public function __construct($column, $arguments)
    {
        $this->column['lat'] = (string) $column;
        $this->column['lng'] = (string) $arguments[0];

        array_shift($arguments);

        $this->label = $this->formatLabel($arguments);
        $this->id = $this->formatId($this->column);

        /*
         * Google map is blocked in mainland China
         * people in China can use Tencent map instead(;
         */
        switch (config('admin.map_provider')) {
            case 'tencent':
                $this->useTencentMap();
                break;
            case 'google':
                $this->useGoogleMap();
                break;
            case 'yandex':
                $this->useYandexMap();
                break;
            case 'openstreetmap':
                $this->useOpenStreetMap();
                break;
            default:
                $this->useGoogleMap();
        }
    }

    public function useGoogleMap()
    {
        $this->script = <<<EOT
        (function() {
            function initGoogleMap(name) {
                var lat = $('#{$this->id['lat']}');
                var lng = $('#{$this->id['lng']}');
    
                var LatLng = new google.maps.LatLng(lat.val(), lng.val());
    
                var options = {
                    zoom: 13,
                    center: LatLng,
                    panControl: false,
                    zoomControl: true,
                    scaleControl: true,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
    
                var container = document.getElementById("map_"+name);
                var map = new google.maps.Map(container, options);
    
                var marker = new google.maps.Marker({
                    position: LatLng,
                    map: map,
                    title: 'Drag Me!',
                    draggable: true
                });
    
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    lat.val(event.latLng.lat());
                    lng.val(event.latLng.lng());
                });
            }
    
            initGoogleMap('{$this->id['lat']}{$this->id['lng']}');
        })();
EOT;
    }

    public function useTencentMap()
    {
        $this->script = <<<EOT
        (function() {
            function initTencentMap(name) {
                var lat = $('#{$this->id['lat']}');
                var lng = $('#{$this->id['lng']}');
    
                var center = new qq.maps.LatLng(lat.val(), lng.val());
    
                var container = document.getElementById("map_"+name);
                var map = new qq.maps.Map(container, {
                    center: center,
                    zoom: 13
                });
    
                var marker = new qq.maps.Marker({
                    position: center,
                    draggable: true,
                    map: map
                });
    
                if( ! lat.val() || ! lng.val()) {
                    var citylocation = new qq.maps.CityService({
                        complete : function(result){
                            map.setCenter(result.detail.latLng);
                            marker.setPosition(result.detail.latLng);
                        }
                    });
    
                    citylocation.searchLocalCity();
                }
    
                qq.maps.event.addListener(map, 'click', function(event) {
                    marker.setPosition(event.latLng);
                });
    
                qq.maps.event.addListener(marker, 'position_changed', function(event) {
                    var position = marker.getPosition();
                    lat.val(position.getLat());
                    lng.val(position.getLng());
                });
            }
    
            initTencentMap('{$this->id['lat']}{$this->id['lng']}');
        })();
EOT;
    }

    public function useYandexMap()
    {
        $this->script = <<<EOT
        (function() {
            function initYandexMap(name) {
                ymaps.ready(function(){
        
                    var lat = $('#{$this->id['lat']}');
                    var lng = $('#{$this->id['lng']}');
        
                    var myMap = new ymaps.Map("map_"+name, {
                        center: [lat.val(), lng.val()],
                        zoom: 18
                    }); 
    
                    var myPlacemark = new ymaps.Placemark([lat.val(), lng.val()], {
                    }, {
                        preset: 'islands#redDotIcon',
                        draggable: true
                    });
    
                    myPlacemark.events.add(['dragend'], function (e) {
                        lat.val(myPlacemark.geometry.getCoordinates()[0]);
                        lng.val(myPlacemark.geometry.getCoordinates()[1]);
                    });                
    
                    myMap.geoObjects.add(myPlacemark);
                });
    
            }
            
            initYandexMap('{$this->id['lat']}{$this->id['lng']}');
        })();
EOT;
    }

    public function useOpenStreetMap()
    {
        $this->script = <<<EOT
        (function() {
            function initOpenStreetMap(name) {
                var lat = $('#{$this->id['lat']}');
                var lng = $('#{$this->id['lng']}');
                    
                var map = L.map("map_"+name).setView([lat.val(), lng.val()], 18);
                
                new GeoSearch.GeoSearchControl({
                    provider: new GeoSearch.OpenStreetMapProvider(),
                    style: 'bar',
                    searchLabel: 'Поиск'
                }).addTo(map);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                
                var marker = L.marker([lat.val(), lng.val()]).addTo(map);
                
                map.on('click', function (e) {
                    marker.remove(map);
                    
                    marker = L.marker(e.latlng).addTo(map);
                    
                    lat.val(e.latlng.lat);
                    lng.val(e.latlng.lng);
                });
                
                map.on('geosearch/showlocation', function(e) {
                    lat.val(e.location.y);
                    lng.val(e.location.x);
                });
            }
            
            initOpenStreetMap('{$this->id['lat']}{$this->id['lng']}');
        })();
EOT;
    }
}