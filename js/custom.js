jQuery(document).ready(function($){

      $('#wplms_buy_batch').on('click',function(){
            // Change Button Text
            $(this).text('.....');

            // Define Variables
		var batch_name = $('.wplms_buy_batch_form').find('.batch_name').val();
		var batch_courses = $('.wplms_buy_batch_form').find('.batch_courses').val();
            var batch_seats = $('.wplms_buy_batch_form').find('.batch_seats').val();
		if(batch_seats == 'undefined'){
                  batch_seats = $('.wplms_buy_batch_form').find('.batch_seats').attr('data-seats');
            }
            var batch_status = $('.wplms_buy_batch_form').find('.batch_status').attr('data-status');
            var buy_batch = $('.wplms_buy_batch_form').find('.buy_batch').attr('data-batch');

            // Ajax Call
            $.ajax({
            type: "POST",
            url: ajaxurl,
            data: { action: 'buy_wplms_batch',
            		batch_name: batch_name,
            		batch_courses: batch_courses,
            		batch_seats: batch_seats,
                        batch_status: batch_status,
                        buy_batch: buy_batch,
                  },
            cache: false,
            success: function (html) {
                  window.location.href = html;
            }
        });
	});

});
