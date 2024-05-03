/* DBB: overfutz@yahoo.com, File: dbbgooglereviews.js, Date: 24.02.2021 */
window.googlereviews = {
	defaults: {
		api_key: '', 
		placeId: '',
		render: ['reviews'], 
		logo: '/img/google_logo.png', 
		name_replace: '', 
		header: "<h3>Google Reviews</h3>",
		footer: '',
		maxRows: 0,
		minRating: 200,
		months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		text_break_length: "90",
		shorten_names: true,
		moreReviewsButtonUrl: '',
		moreReviewsButtonLabel: 'Show More Reviews',
		writeReviewButtonUrl: '',
		writeReviewButtonLabel: 'Write New Review',
		showReviewDate: false,
		showProfilePicture: true
	}, 
	settings: {}, 
	initialise: function (options){
		this.settings = $.extend({}, this.defaults, options);
		this.append();
	}, 
	append: function (){
		var self = this;
		var settings = this.settings;
		$.getScript("https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=" + settings.api_key, function() {
			service = new google.maps.places.PlacesService(googlereviews_map);
			service.getDetails({placeId: window.googlereviews.settings.placeId}, window.googlereviews.callback);
		});
	}, 
	renderStars: function(rating, class_stars, tag_star){
		var stars = "<div class=\""+class_stars+"\" style=\"height: 14px;line-height: 18px\"><ul style=\"display: inline-block;list-style: none;margin: 0;padding: 0;line-height: 18px\">";
		for (var i = 0; i < rating; i++) {
			stars = stars+"<li style=\"float: left;margin-right: 5px;\"><"+tag_star+" style=\"color: #e5712b;font-size: 18px;line-height: 18px;\">&#9733;</"+tag_star+"></li>";
		};
		if(rating < 5){
			for (var i = 0; i < (5 - rating); i++) {
				stars = stars+"<li style=\"float: left;margin-right: 5px;\"><"+tag_star+" style=\"color: #c6c6c6;font-size: 18px;line-height: 18px;\">&#9733;</"+tag_star+"></li>";
			};
		}
		stars = stars+"</ul></div>";
		return stars;
	}, 
	callback: function(place, status) {
		if (status == google.maps.places.PlacesServiceStatus.OK) {
			console.log(place);
			$("<div id=\"googlereviews\" style=\"position: fixed;left: 24px;bottom: 80px;width: 290px;border-top: 6px solid #0f71b1;border-radius: 5px;background-color: #fff;box-shadow: 1px 1px 20px 0 rgba(0,0,0,.3);z-Index: 1049\"><div style=\"display: table-cell;width: 72.5px;height: 85px;text-align: center;margin: 0 10px;vertical-align: middle;\"><img src=\"" + window.googlereviews.settings.logo + "\" width=\"35\" height=\"35\" /></div><div style=\"display: table-cell;padding: 5px 6px 0 0;line-height: 18px\"><small style=\"color: #707070;font-size: 11px;\">"+place.name.replace(window.googlereviews.settings.name_replace, "")+"</small><br /><span style=\"color: #e5712b;font-family: italic;font-size: 18px;font-weight: 100;line-height: 18px\">"+place.rating.toFixed(1).replace(".", ",")+" von 5</span><br />" + window.googlereviews.renderStars(Math.round(place.rating).toFixed(0), "p-0", "span") + "<small style=\"color: #707070;font-size: 11px;\">Auf Grundlage von " + place.user_ratings_total + " Bewertungen</span></div></div>").appendTo("body");
			/*$.each(place.reviews, function(i, f) {
				var tblRow = "<div class=\"row mb-3\"><div class=\"col-sm-1\"><img src=\"" + f.profile_photo_url + "\" class=\"img-fluid\" /></div><div class=\"col-sm-11\"><div class=\"row\"><div class=\"col-sm-12\"><a href=\"" + f.author_url + "\" target=\"_blank\">" + f.author_name + "</a></div></div><div class=\"row\">" + renderStars(f.rating, "review-stars col-sm-3", "i") + "<div class=\"col-sm-9 mt-2 text-secondary\"><span>" + f.relative_time_description + "</span></div></div><div class=\"row\"><div class=\"col-sm-12\"><p>" + f.text + "</p></div></div></div></div>";
				$(tblRow).appendTo("#google-reviews");
			});*/
		}
	}
}