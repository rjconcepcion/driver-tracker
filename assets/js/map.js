/**
 * Google Map Function
 *
 * Renders map in the backend dashboard.
 *
 * @author Robert John conecpcion
 */
(function(){

	'use strict';

	var map;

	var marker;

	var googlemap = {

		/**
		 * Initailize Map
		 */
		init : function(){

			map = new google.maps.Map( document.getElementById('map'), this.mapSettings() );

			var location = {lat: -25.344, lng: 131.036};

	        map.setCenter( location );
		},

		mapSettings : function(){

			var settings = {
				zoom : 2,
				streetViewControl: false,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				mapTypeControlOptions : {mapTypeIds: []}			
			}

			return settings;
		}

	}

	googlemap.init();

})(jQuery);		