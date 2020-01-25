
;(function($) {

	$('.bits-tab-nav a').on('click',function (e) {
		e.preventDefault();
		$(this).addClass('active').siblings().removeClass('active');
	});

	$('.bits-tab-nav .begin').on('click',function (e) {		
		$('.bits-tab-wrapper .begin').addClass('show').siblings().removeClass('show');
	});	
	$('.bits-tab-nav .actions, .bits-tab .actions').on('click',function (e) {		
		e.preventDefault();
		$('.bits-tab-wrapper .actions').addClass('show').siblings().removeClass('show');

		$('.bits-tab-nav a.actions').addClass('active').siblings().removeClass('active');

	});	
	$('.bits-tab-nav .support').on('click',function (e) {		
		$('.bits-tab-wrapper .support').addClass('show').siblings().removeClass('show');
	});	
	$('.bits-tab-nav .table').on('click',function (e) {		
		$('.bits-tab-wrapper .table').addClass('show').siblings().removeClass('show');
	});	

	$('.bits-tab-nav .changelog').on('click',function (e) {		
		$('.bits-tab-wrapper .changelog').addClass('show').siblings().removeClass('show');
	});		


	$('.bits-tab-wrapper .install-now').on('click',function (e) {	
		$(this).replaceWith('<p style="color:#23d423;font-style:italic;font-size:14px;">Plugin installed and active!</p>');
	});	
	$('.bits-tab-wrapper .install-now.importer-install').on('click',function (e) {	
		$('.importer-button').show();
	});	


})(jQuery);
