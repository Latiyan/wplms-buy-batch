jQuery(document).ready(function($){

	$('#wplms_buy_batch').on('click',function(){
		var batch_name = $('.wplms_buy_batch_form').find('.batch_name').val();
		var batch_courses = $('.wplms_buy_batch_form').find('.batch_courses').val();
		var batch_seats = $('.wplms_buy_batch_form').find('.batch_seats').val();
		$.ajax({
            type: "POST",
            url: ajaxurl,
            data: { action: 'buy_wplms_batch',
            		batch_name: batch_name,
            		batch_courses: batch_courses,
            		batch_seats: batch_seats,
                  },
            cache: false,
            success: function (html) {
                  window.location.href = html;
            }
        });
	});

});
