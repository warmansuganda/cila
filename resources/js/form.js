(function ($) {

	$.fn.myForm = function (options) {
		var object = $(this);
		var defaults = {
			type: typeof object.attr('method') !== 'undefined' ? object.attr('method') : 'POST',
            url: typeof object.attr('action') !== 'undefined' ? object.attr('action') : null,
            data: null,
            messages : {
            	confirm: {
					title: 'Apakah anda yakin?',
					text: "Data yang anda inputkan akan disimpan.",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya',
					cancelButtonText: 'Tidak'
				},
            	validation: {
            		title: true,
	                titlePosition: 'after',
	                listPosition: 'inline'
            	},
            	success: {
            		title: 'Tersimpan!',
					text: "Data yang anda inputkan berhasil disimpan.",
					type: 'success',
            	}
            },
            before: function (event) {},
			success: function (event, data) {},
            error: function (event, data) {},
		};

		var options = $.extend(true, defaults, options);

		var errorMessage = function(data) {
			var errors = data.responseJSON;
			
            command: toastr["error"](errors.message);

			if (typeof errors.data !== 'undefined') {

				$.each(errors.data, function(key, value){
					field = $('[name = "' + key + '"]', object);
                    _div = $('.error_' + key, object);
                    _group = field.closest('.form-group').find('div.input-group');
                    _selectize = field.closest('.form-group').find('div.selectize-control');
                    _select2 = field.closest('.form-group').find('.select2-container');
                    
                    field.closest('.form-group').addClass('has-error');

                    if (options.messages.validation.title) {
                        var manual_target = $('#error_' + key, object);
                        
                        if (manual_target.length) {
                            manual_target.find('span.help-block.error').remove();
                            manual_target.html('<span class="help-block error"> ' + value + ' </span>');
                        } else {

                          field.closest('.form-group').addClass('has-error').find('span.help-block.error').remove();

                          if (options.messages.validation.titlePosition == 'top' || options.messages.validation.titlePosition == 'before') {
                          	  if (_group.length) {
	                              _group.before('<span class="help-block error"> ' + value + ' </span>');
	                          } else if (_selectize.length) {
	                              _selectize.before('<span class="help-block error"> ' + value + ' </span>');
	                          } else if (_select2.length) {
	                              _select2.before('<span class="help-block error"> ' + value + ' </span>');
	                          } else if (_div.length) {
	                              _div.before('<span class="help-block error"> ' + value + ' </span>');
	                          } else {
	                              field.before('<span class="help-block error"> ' + value + ' </span>');
	                          }
                          } else {
	                          if (_group.length) {
	                              _group.after('<span class="help-block error"> ' + value + ' </span>');
	                          } else if (_selectize.length) {
	                              _selectize.after('<span class="help-block error"> ' + value + ' </span>');
	                          } else if (_select2.length) {
	                              _select2.after('<span class="help-block error"> ' + value + ' </span>');
	                          } else if (_div.length) {
	                              _div.after('<span class="help-block error"> ' + value + ' </span>');
	                          } else {
	                              field.after('<span class="help-block error"> ' + value + ' </span>');
	                          }
                          }
                        }
                    }
				});
			}
		};

		var ajaxSubmit = function() {
			object.ajaxSubmit({
				type: options.type,
                url: options.url,
                data: options.data,
                beforeSubmit: function (arr, form, settings) {
                	options.before.call(this);
                }, 
                success: function (data) {
					swal(
				      options.messages.success.title,
				      options.messages.success.text,
				      options.messages.success.type
				    ).then((result) => {
					  if (result.value) {
                		options.success.call(this);
					  }
					});
                },
                error: function (data) {
					errorMessage(data);
                	options.error.call(this);
                }
			}); 
		};

		return {
			submit: function() {
				swal(options.messages.confirm).then((result) => {
				  if (result.value) {
				  	ajaxSubmit();
				  }
				})
			},
			reset: function() {
				object.clearForm();
			}
		};
	};

}(jQuery));