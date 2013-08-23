(function($) {


	var stageVars = {
        currentSlide: 0,
        currentImage: '',
        totalSlides: 0,
        pause: 0,
		highlight: 0,
		speed: 400
    };


	$(document).ready(function() {
		
		// Loading Stage Picture - Choose first Picture
		$('#pictures_'+stageVars.currentSlide).fadeIn(stageVars.speed);
		// Loading Stage Picture - Set active (red Dot)
		$('#slide-link-'+stageVars.highlight).removeClass('changeStage').addClass('active');
	
			/*
			 *  Simple image gallery. Uses default settings
			 */

		$('.fancybox').fancybox();

		// Button helper. Disable animations, hide close button, change title type and content
		$('.fancybox-gallery').fancybox({
			openEffect  : 'none',
			closeEffect : 'none',
			prevEffect : 'fade',
			nextEffect : 'fade',

			helpers : {
				title : {
					type : 'inside'
				},
				buttons	: {}
			},
			afterLoad : function() {
				this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
			}
		});
		
		$(".fancybox-metaLayer").fancybox({
			padding: 0,
			openEffect  : 'fade',
			closeEffect : 'fade',
		});

	});

//-------------------------------------------------------
//  Diverses

	
	// Floating Menue Einsatzliste
	/*
	$(window).scroll(function (event) {
		if($(window).width()>525) { 
			var y = $(this).scrollTop();
			var top = 590;
			if (y >= top) {
				$('#submenue').addClass('fixed');
				$('.filter').css('margin', '0 0 0 0');
				$('.factSheet_einsatzListe').css('margin', '65px 0 20px 0');
			} else {
				$('#submenue').removeClass('fixed');
				$('.filter').css('margin', '0 0 20px 0');
				$('.factSheet_einsatzListe').css('margin', '0 0 20px 0');
			}
		}
	});
	*/
	// Animiertes Scrollen
	$('.backToTop').bind("click", function(event) {
		event.preventDefault();
		var ziel = $(this).attr("href");
		$('html,body').animate({
			scrollTop: $(ziel).offset().top
		}, 300 , function (){location.hash = ziel;});
	});



//-------------------------------------------------------
//  Mobile Navigation: Animation

	var mobileNavVars = {
		status: 0,
		height: 0,
		navCount: 0,
		SubNavCount: 0,
		metaNavCount: 0
	};
	
	// Anzahl der Bilder ermitteln
	mobileNavVars.navCount = $('.mobileMainNavContainer').children().length;
	mobileNavVars.SubNavCount = $('.subnavi ul').children().length;
	mobileNavVars.metaNavCount = $('.metanav ul').children().length;
	
	mobileNavVars.metaNavCount = (mobileNavVars.metaNavCount /2);
	if(mobileNavVars.metaNavCount%2!=0) { mobileNavVars.metaNavCount++; }
	
	$('#mobileNavButton').click(function() {
		if(mobileNavVars.status==0) {
			mobileNavVars.height=(mobileNavVars.navCount*44)+(mobileNavVars.metaNavCount*25)+(mobileNavVars.SubNavCount*25);
			mobileNavVars.status=1;
		} else {
			mobileNavVars.height=0;
			mobileNavVars.status=0;
		}
		$("#mobileNavigation").animate({
			height: mobileNavVars.height
		  }, 300 );
	});
	

// ------------------------------------------------------
//  Notruf-Layer


	
//-------------------------------------------------------
//  Stage: Animation

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
//  TabBox

	$('a[func|="tab"]').click(function() { 
		var modulPart = $(this).attr('href').split("_");
		var modul = modulPart[0].substr(1);
		var target = modulPart[1];
		var tabCount = $('.tabNav_'+modul+'').children().length;
		
		for(i=1; i<=tabCount; i++) {
			$('a[href|="#'+modul+'_'+i+'"]').removeClass('active').addClass('noActive');
			$('#box_'+modul+'_'+i).css( "display", "none" );
		}
		$('a[href|="#'+modul+'_'+target+'"]').removeClass('noActive').addClass('active');
		$('#box_'+modul+'_'+target).css( "display", "block" );

	}); 
	

//-------------------------------------------------------
//  Mobile SUB-Navigation: Animation

	var SubNavVars = {
		status: 0,
		height: 0,
		navCount: 0
	};
	
	// Anzahl der Bilder ermitteln
	SubNavVars.navCount = $('ul.subnavi_content_mobile').children().length;
	
	$('.subnavi_opener_mobile').click(function() {
		if(SubNavVars.status==0) {
			SubNavVars.height=((SubNavVars.navCount*30)+30);
			SubNavVars.status=1;
			$('.subnavi_opener_mobile').css("border-bottom", "2px #464646 solid");
			$('.subnavi_opener_mobile').css("padding-bottom", "10px");
		} else {
			SubNavVars.height=0;
			SubNavVars.status=0;
			$('.subnavi_opener_mobile').css("border-bottom", "0px");
			$('.subnavi_opener_mobile').css("padding-bottom", "0px");
		}
		$('.subnavi_content_mobile').animate({
			height: SubNavVars.height
		  }, 300 );
	});
	

//-------------------------------------------------------
//  Slideshow

	var slideShowVars = {
        currentImage: 1,
		speed: 400
    };

	// Bild austauschen
	$('#slideshow_next').click(function() {
		
		var slideShowName = $(this).attr('href').substr(1);
		var elements = $('#'+slideShowName).children().length;
		if(slideShowVars.currentImage<elements) {	
			var target=slideShowVars.currentImage+1;
		} else {
			var target=1;
		}
		
		$('#'+slideShowName+'_'+target).css('display', 'inline');
		$('#'+slideShowName+'_'+slideShowVars.currentImage).css('display', 'none');
		slideShowVars.currentImage = target;

		return false;
	});
	
	$('#slideshow_prev').click(function() {
		
		var slideShowName = $(this).attr('href').substr(1);
		var elements = $('#'+slideShowName).children().length;
		if(slideShowVars.currentImage!=1) {	
			var target=slideShowVars.currentImage-1;
		} else {
			var target=elements;
		}
		
		$('#'+slideShowName+'_'+target).css('display', 'inline');
		$('#'+slideShowName+'_'+slideShowVars.currentImage).css('display', 'none');
		slideShowVars.currentImage = target;

		return false;
	});


//-------------------------------------------------------
//  DetailShow

	var detailShowVars = {
        currentChart: 1,
		speed: 400
    };

	// Bild austauschen
	$('#detailShow_next').click(function() {
		
		var elements = $('.charts').children().length;
		if(detailShowVars.currentChart<elements) {	
			var target=detailShowVars.currentChart+1;
		} else {
			var target=1;
		}
		
		// Content
		$('#detailShow_'+target).addClass('active');
		$('#detailShow_'+detailShowVars.currentChart).removeClass('active');
		// Tabs
		$('a[href="#'+detailShowVars.currentChart+'"]').removeClass('active');
		$('a[href="#'+target+'"]').addClass('active');
		// Welches chart ist aktiv?
		detailShowVars.currentChart = target;

		return false;
	});
	
	$('#detailShow_prev').click(function() {
		
		var elements = $('.charts').children().length;
		if(detailShowVars.currentChart!=1) {	
			var target=detailShowVars.currentChart-1;
		} else {
			var target=elements;
		}
		
		// Content
		$('#detailShow_'+target).addClass('active');
		$('#detailShow_'+detailShowVars.currentChart).removeClass('active');
		// Tabs
		$('a[href="#'+detailShowVars.currentChart+'"]').removeClass('active');
		$('a[href="#'+target+'"]').addClass('active');
		// Welches chart ist aktiv?
		detailShowVars.currentChart = target;

		return false;
	});
	
	$('.detailShowLink').click(function() {

		var target = parseInt($(this).attr('href').substr(1));
		if(target!=detailShowVars.currentChart) {
			// Content
			$('#detailShow_'+target).addClass('active');
			$('#detailShow_'+detailShowVars.currentChart).removeClass('active');
			// Tabs
			$('a[href="#'+detailShowVars.currentChart+'"]').removeClass('active');
			$('a[href="#'+target+'"]').addClass('active');
			// Welches chart ist aktiv?
			detailShowVars.currentChart = target;
		}
	});


})(jQuery);