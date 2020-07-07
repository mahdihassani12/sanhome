(function ($) {
    "use strict";
    $(document).ready(function () {
        /*-----------------------------------------------------------------------------------*/
        /* Home page properties pagination
         /*-----------------------------------------------------------------------------------*/
        $('body').on('click','.rhea_pagination_wrapper a',function (e) {
            e.preventDefault();

            var thisParent = $(this).parents('.rhea_ele_property_ajax_target');
            var id = $(thisParent).attr('id');
            var thisLoader = $(thisParent).find('.rhea_svg_loader');
            var thisInner = $(thisParent).find('.home-properties-section-inner-target');
            var pageNav = $(thisParent).find('.rhea_pagination_wrapper a');
            var thisLink = $(this);

            if (! (thisLink).hasClass('current')){
                var link = $(this).attr('href');
                thisInner.fadeTo('slow', 0.5);

                thisLoader.slideDown('fast');
                // thisContent.fadeOut('fast', function(){
                thisInner.load(link + ' #' + id + ' .home-properties-section-inner-target', function(response, status, xhr) {
                    if (status == 'success') {
                        thisInner.fadeTo('fast', 1);
                        pageNav.removeClass('current');
                        thisLink.addClass('current');
                        thisLoader.slideUp('fast');
                    }else{
                        thisInner.fadeTo('fast', 1);
                        thisLoader.slideUp('fast');
                    }
                });
            }
        });


        // Agent Dropdown for future updates TODO

        // jQuery('.rhea_agent_list_extra').each(function () {
        //     if (jQuery(this).children('.rhea_agent_list').length > 0) {
        //         jQuery(this).parent().addClass('rhea_expand_parent');
        //     }
        // });

        // jQuery('body').on('click', '.rhea_agents_expand_button.rhea_open', function () {
        //
        //     jQuery(this).parent('.rhea_expand_parent').addClass('rhea_expanded');
        //     jQuery(this).parent('.rhea_expand_parent').find('.rhea_agent_list_extra').slideDown('fast');
        //
        //     if (jQuery(this).parent('.rhea_expand_parent').hasClass('rhea_expanded')) {
        //         jQuery(this).hide();
        //     }
        //
        //
        // });
        // jQuery('body').on('click', '.rhea_agents_expand_button.rhea_close', function () {
        //
        //     jQuery(this).parents('.rhea_expand_parent').removeClass('rhea_expanded');
        //     jQuery(this).parents('.rhea_expand_parent').find('.rhea_agent_list_extra').slideUp('fast', function () {
        //         if (!jQuery(this).parents('.rhea_expand_parent').hasClass('.rhea_expanded')) {
        //             jQuery(this).parents('.rhea_expand_parent').find('.rhea_open').show();
        //         }
        //     });
        //
        // });

        // jQuery('html').on('click', function (e) {
        //
        //     jQuery('.rhea_expand_parent').removeClass('rhea_expanded');
        //     jQuery('.rhea_expand_parent').find('.rhea_agent_list_extra').slideUp('fast', function () {
        //         if (!jQuery('.rhea_expand_parent').hasClass('.rhea_expanded')) {
        //             jQuery('.rhea_expand_parent').find('.rhea_open').show();
        //         }
        //     });
        //
        //     e.stopPropagation();
        //
        // });


    });


    window.rheaLoadOSMap = function(id , settingObj ) {

        var ThisMapID = id ;


        if (typeof settingObj !== "undefined") {

            if (0 < settingObj.length) {


                var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                });

                // get map bounds
                var mapBounds = [];
                for (var i = 0; i < settingObj.length; i++) {
                    if (settingObj[i].lat && settingObj[i].lng) {
                        mapBounds.push([settingObj[i].lat, settingObj[i].lng]);
                    }
                }

                // Basic map
                var mapCenter = L.latLng(27.664827, -81.515755);	// given coordinates not going to matter 99.9% of the time but still added just in case.
                if (1 == mapBounds.length) {
                    mapCenter = L.latLng(mapBounds[0]);	// this is also not going to effect 99% of the the time but just in case of one property.
                }
                var mapDragging = (L.Browser.mobile) ? false : true; // disabling one finger dragging on mobile but zoom with two fingers will still be enabled.
                var mapOptions = {
                    dragging: mapDragging,
                    center: mapCenter,
                    zoom: 13,
                    zoomControl: false,
                    tap: false
                };
                var propertiesMap = L.map(ThisMapID, mapOptions);

                L.control.zoom({
                    position: 'bottomleft'
                }).addTo(propertiesMap);

                propertiesMap.scrollWheelZoom.disable();

                if (1 < mapBounds.length) {
                    propertiesMap.fitBounds(mapBounds);	// fit bounds should work only for more than one properties
                }

                propertiesMap.addLayer(tileLayer);

                for (var i = 0; i < settingObj.length; i++) {

                    if (settingObj[i].lat && settingObj[i].lng) {

                        var propertyMapData = settingObj[i];

                        var markerLatLng = L.latLng(propertyMapData.lat, propertyMapData.lng);

                        var markerOptions = {
                            riseOnHover: true
                        };

                        // Marker icon
                        if (propertyMapData.title) {
                            markerOptions.title = propertyMapData.title;
                        }

                        if(propertyMapData.classes){
                            var mapClasses = propertyMapData.classes.join(' ');
                        }else{
                            mapClasses = '';
                        }


                        // Marker icon
                        if (propertyMapData.icon) {
                            var iconOptions = {
                                iconUrl: propertyMapData.icon,
                                iconSize: [42, 57],
                                iconAnchor: [20, 57],
                                popupAnchor: [1, -54],
                                className: mapClasses,
                            };
                            if (propertyMapData.retinaIcon) {
                                iconOptions.iconRetinaUrl = propertyMapData.retinaIcon;
                            }
                            markerOptions.icon = L.icon(iconOptions);
                        }

                        var propertyMarker = L.marker(markerLatLng, markerOptions).addTo(propertiesMap);

                        // Marker popup
                        var popupContentWrapper = document.createElement("div");
                        popupContentWrapper.className = 'osm-popup-content';
                        var popupContent = "";

                        if (propertyMapData.thumb) {
                            popupContent += '<a class="osm-popup-thumb-link" href="' + propertyMapData.url + '"><img class="osm-popup-thumb" src="' + propertyMapData.thumb + '" alt="' + propertyMapData.title + '"/></a>';
                        }

                        if (propertyMapData.title) {
                            popupContent += '<h5 class="osm-popup-title"><a class="osm-popup-link" href="' + propertyMapData.url + '">' + propertyMapData.title + '</a></h5>';
                        }

                        if (propertyMapData.price) {
                            popupContent += '<p><span class="osm-popup-price">' + propertyMapData.price + '</span></p>';
                        }

                        popupContentWrapper.innerHTML = popupContent;

                        propertyMarker.bindPopup(popupContentWrapper);

                    }

                }

            } else {

                // Fallback Map
                var fallbackLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                });

                // todo: provide an option for fallback map coordinates
                var fallbackMapOptions = {
                    center: [27.664827, -81.515755],
                    zoom: 12
                };

                var fallbackMap = L.map(ThisMapID, fallbackMapOptions);
                fallbackMap.addLayer(fallbackLayer);

            }

        }


        // });


    };



    window.rheaLoadGoogleMap = function(id , propertiesMapData , propertiesMapOptions , mapStuff ) {

        var ThisMapID = id ;


        if (typeof propertiesMapData !== "undefined") {

            if (0 < propertiesMapData.length) {

                var fullScreenControl = true;
                var fullScreenControlPosition = google.maps.ControlPosition.TOP_LEFT;

                var mapTypeControl = true;
                var mapTypeControlPosition = google.maps.ControlPosition.LEFT_BOTTOM;

                if( mapStuff.modernHome ) {
                    mapTypeControl = false;
                    fullScreenControlPosition = google.maps.ControlPosition.LEFT_BOTTOM;
                }

                var mapOptions = {
                    zoom : 12,
                    maxZoom : 16,
                    fullscreenControl: fullScreenControl,
                    fullscreenControlOptions: {
                        position: fullScreenControlPosition
                    },
                    mapTypeControl: mapTypeControl,
                    mapTypeControlOptions: {
                        position: mapTypeControlPosition
                    },
                    scrollwheel : false, styles : [{
                        "featureType" : "landscape", "stylers" : [{
                            "hue" : "#FFBB00"
                        }, {
                            "saturation" : 43.400000000000006
                        }, {
                            "lightness" : 37.599999999999994
                        }, {
                            "gamma" : 1
                        }]
                    }, {
                        "featureType" : "road.highway", "stylers" : [{
                            "hue" : "#FFC200"
                        }, {
                            "saturation" : -61.8
                        }, {
                            "lightness" : 45.599999999999994
                        }, {
                            "gamma" : 1
                        }]
                    }, {
                        "featureType" : "road.arterial", "stylers" : [{
                            "hue" : "#FF0300"
                        }, {
                            "saturation" : -100
                        }, {
                            "lightness" : 51.19999999999999
                        }, {
                            "gamma" : 1
                        }]
                    }, {
                        "featureType" : "road.local", "stylers" : [{
                            "hue" : "#FF0300"
                        }, {
                            "saturation" : -100
                        }, {
                            "lightness" : 52
                        }, {
                            "gamma" : 1
                        }]
                    }, {
                        "featureType" : "water", "stylers" : [{
                            "hue" : "#0078FF"
                        }, {
                            "saturation" : -13.200000000000003
                        }, {
                            "lightness" : 2.4000000000000057
                        }, {
                            "gamma" : 1
                        }]
                    }, {
                        "featureType" : "poi", "stylers" : [{
                            "hue" : "#00FF6A"
                        }, {
                            "saturation" : -1.0989010989011234
                        }, {
                            "lightness" : 11.200000000000017
                        }, {
                            "gamma" : 1
                        }]
                    }]
                };

                // Map Styles
                if (undefined !== propertiesMapOptions.styles) {
                    mapOptions.styles = JSON.parse(propertiesMapOptions.styles);
                }

                // Setting Google Map Type
                switch (propertiesMapOptions.type) {
                    case 'satellite':
                        mapOptions.mapTypeId = google.maps.MapTypeId.SATELLITE;
                        break;
                    case 'hybrid':
                        mapOptions.mapTypeId = google.maps.MapTypeId.HYBRID;
                        break;
                    case 'terrain':
                        mapOptions.mapTypeId = google.maps.MapTypeId.TERRAIN;
                        break;
                    default:
                        mapOptions.mapTypeId = google.maps.MapTypeId.ROADMAP;
                }

                var propertiesMap = new google.maps.Map( document.getElementById( ThisMapID ), mapOptions );

                var overlappingMarkerSpiderfier = new OverlappingMarkerSpiderfier( propertiesMap, {
                    markersWontMove : true,
                    markersWontHide : true,
                    keepSpiderfied : true,
                    circleSpiralSwitchover : Infinity,
                    nearbyDistance : 50
                } );
                var mapBounds = new google.maps.LatLngBounds();
                var openedWindows = [];

                var closeOpenedWindows = function() {
                    while( 0 < openedWindows.length ) {
                        var windowToClose = openedWindows.pop();
                        windowToClose.close();
                    }
                };

                var attachInfoBoxToMarker = function ( map, marker, infoBox ) {
                    google.maps.event.addListener( marker, 'click', function() {
                        closeOpenedWindows();
                        var scale = Math.pow( 2, map.getZoom() );
                        var offsety = ( (100 / scale) || 0 );
                        var projection = map.getProjection();
                        var markerPosition = marker.getPosition();
                        var markerScreenPosition = projection.fromLatLngToPoint( markerPosition );
                        var pointHalfScreenAbove = new google.maps.Point( markerScreenPosition.x, markerScreenPosition.y - offsety );
                        var aboveMarkerLatLng = projection.fromPointToLatLng( pointHalfScreenAbove );
                        map.setCenter( aboveMarkerLatLng );
                        infoBox.open( map, marker );
                        openedWindows.push( infoBox );

                        // lazy load info box image to improve performance
                        var infoBoxImage = infoBox.getContent().getElementsByClassName('prop-thumb');
                        if ( infoBoxImage.length ) {
                            if ( infoBoxImage[0].dataset.src ) {
                                infoBoxImage[0].src = infoBoxImage[0].dataset.src;
                            }
                        }

                    } );
                };

                // Loop to generate marker and info windows based on properties data
                var markers = [];
                var map = {
                    '&amp;': '&',
                    '&#038;': "&",
                    '&lt;': '<',
                    '&gt;': '>',
                    '&quot;': '"',
                    '&#039;': "'",
                    '&#8217;': "’",
                    '&#8216;': "‘",
                    '&#8211;': "–",
                    '&#8212;': "—",
                    '&#8230;': "…",
                    '&#8221;': '”'
                };

                for( var i = 0; i < propertiesMapData.length; i++ ) {

                    if ( propertiesMapData[i].lat && propertiesMapData[i].lng ) {

                        var iconURL = propertiesMapData[i].icon;
                        var size = new google.maps.Size( 42, 57 );
                        if( window.devicePixelRatio > 1.5 ) {
                            if( propertiesMapData[i].retinaIcon ) {
                                iconURL = propertiesMapData[i].retinaIcon;
                                size = new google.maps.Size( 83, 113 );
                            }
                        }

                        var makerIcon = {
                            url : iconURL,
                            size : size,
                            scaledSize : new google.maps.Size( 42, 57 ),
                            origin : new google.maps.Point( 0, 0 ),
                            anchor : new google.maps.Point( 21, 56 )
                        };

                        markers[i] = new google.maps.Marker( {
                            position : new google.maps.LatLng( propertiesMapData[i].lat, propertiesMapData[i].lng ),
                            map : propertiesMap,
                            icon : makerIcon,
                            title : propertiesMapData[i].title.replace(/\&[\w\d\#]{2,5}\;/g, function(m) { return map[m]; }),  // Decode PHP's html special characters encoding with Javascript
                            animation : google.maps.Animation.DROP,
                            visible : true
                        } );

                        // extend bounds
                        mapBounds.extend( markers[i].getPosition() );

                        // prepare info window contents
                        var boxText = document.createElement( "div" );
                        boxText.className = 'rhea-map-info-window';
                        var innerHTML = "";

                        // info window image place holder URL to improve performance
                        var infoBoxPlaceholderURL = "";
                        if ( ( typeof mapStuff !== "undefined" ) && mapStuff.infoBoxPlaceholder ) {
                            infoBoxPlaceholderURL = mapStuff.infoBoxPlaceholder;
                        }

                        if( propertiesMapData[i].thumb ) {
                            innerHTML += '<a class="thumb-link" href="' + propertiesMapData[i].url + '">' + '<img class="prop-thumb" src="' + infoBoxPlaceholderURL + '"  data-src="' + propertiesMapData[i].thumb + '" alt="' + propertiesMapData[i].title + '"/>' + '</a>';
                        } else {
                            innerHTML += '<a class="thumb-link" href="' + propertiesMapData[i].url + '">' + '<img class="prop-thumb" src="' + infoBoxPlaceholderURL + '" alt="' + propertiesMapData[i].title + '"/>' + '</a>';
                        }

                        innerHTML += '<h5 class="prop-title"><a class="title-link" href="' + propertiesMapData[i].url + '">' + propertiesMapData[i].title + '</a></h5>';
                        if( propertiesMapData[i].price ) {
                            innerHTML += '<p><span class="rhea-popup-price price">' + propertiesMapData[i].price + '</span></p>';
                        }
                        innerHTML += '<div class="arrow-down"></div>';
                        boxText.innerHTML = innerHTML;

                        // info window close icon URL
                        var closeIconURL = "";
                        if ( ( typeof mapStuff !== "undefined" ) && mapStuff.closeIcon ) {
                            closeIconURL = mapStuff.closeIcon;
                        }

                        // finalize info window
                        var infoWindowOptions = {
                            content : boxText,
                            disableAutoPan : true,
                            maxWidth : 0,
                            alignBottom : true,
                            pixelOffset : new google.maps.Size( -122, -48 ),
                            zIndex : null,
                            closeBoxMargin : "0 0 -16px -16px",
                            closeBoxURL : closeIconURL,
                            infoBoxClearance : new google.maps.Size( 1, 1 ),
                            isHidden : false,
                            pane : "floatPane",
                            enableEventPropagation : false
                        };
                        var currentInfoBox = new InfoBox( infoWindowOptions );

                        // attach info window to marker
                        attachInfoBoxToMarker( propertiesMap, markers[i], currentInfoBox );

                        // apply overlapping marker spiderfier to marker
                        overlappingMarkerSpiderfier.addMarker( markers[i] );

                    }

                }


                // fit map to bounds as per markers
                propertiesMap.fitBounds( mapBounds );

                // cluster icon URL
                var clusterIconURL = "";
                if ( ( typeof mapStuff !== "undefined" ) && mapStuff.clusterIcon ) {
                    clusterIconURL = mapStuff.clusterIcon;
                }

                // Markers clusters
                var markerClustererOptions = {
                    ignoreHidden : true, maxZoom : 14, styles : [{
                        textColor : '#ffffff',
                        url : clusterIconURL,
                        height : 48,
                        width : 48
                    }]
                };
                var markerClusterer = new MarkerClusterer( propertiesMap, markers, markerClustererOptions );


            } else {

                // Fallback Map in Case of No Properties
                // todo: provide an option for fallback map coordinates
                var fallBackLocation = new google.maps.LatLng(27.664827, -81.515755);	// Default location of Florida in fallback map.
                var fallBackOptions = {
                    center: fallBackLocation,
                    zoom : 10,
                    maxZoom : 16,
                    scrollwheel : false
                };
                var fallBackMap = new google.maps.Map( document.getElementById( ThisMapID ), fallBackOptions );

            }
        }

    };


})
(jQuery);








