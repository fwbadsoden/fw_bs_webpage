(function($) {

//-------------------------------------------------------
//  Mobile Navigation: Annimation

	var mobileNavVars = {
		status: 0,
		height: 0
	};
	
	// Anzahl der Bilder ermitteln
	var navCount = $('.mobileMainNavContainer').children().length;
	
	$('#mobileNavButton').click(function() {
		if(mobileNavVars.status==0) {
			mobileNavVars.height=((navCount*44));
			mobileNavVars.status=1;
		} else {
			mobileNavVars.height=0;
			mobileNavVars.status=0;
		}
		$("#mobileNavigation").animate({
			height: mobileNavVars.height
		  }, 300 );
	});
	

//-------------------------------------------------------
//  Searchfield: Annimation

	var searchfield = {
		status: 0,
		height: 0,
		maxheight: 34
	};
	
	$('.desktopsearch').click(function() {
		if(searchfield.status==0) {
			searchfield.height=searchfield.maxheight;
			searchfield.status=1;
			$("#searchitem").focus();
		} else {
			searchfield.height=0;
			searchfield.status=0;
		}
		$("#searchBox").animate({
			height: searchfield.height,
		}, 100 );
	});
	$('.closeSearch').click(function() {
		searchfield.status=0;
		$("#searchBox").animate({
			height: 0,
		}, 100 );
	});


	
//-------------------------------------------------------
//  Stage: Annimation

	var stageVars = {
        currentSlide: 0,
        currentImage: '',
        totalSlides: 0,
        pause: 0,
		highlight: 0,
		speed: 400
    };

	// Erstes Bild laden
	$(document).ready(function() {
		// Choose first Picture
		$('#pictures_'+stageVars.currentSlide).fadeIn(stageVars.speed);
		// Set active (red Dot)
		$('#slide-link-'+stageVars.highlight).removeClass('changeStage').addClass('active');
	});

	// Bild austauschen
	$('.changeStage').click(function() {
		var target = $(this).attr('href').substr(1);
		
		$('#pictures_'+stageVars.currentSlide).fadeOut(stageVars.speed, function() {
			$('#pictures_'+target).fadeIn(stageVars.speed);
			
			// Set active (red Dot)
			$('#slide-link-'+target).removeClass('changeStage').addClass('active');
			$('#slide-link-'+stageVars.highlight).removeClass('active').addClass('changeStage');
			
			stageVars.pause = 1;
			stageVars.highlight = target;
			stageVars.currentSlide = target;
		});
		return false;
	});

	
//-------------------------------------------------------
//  Infographics: Startpage

	
	

})(jQuery);