(function ($) {
	$.fn.myAjax = function (ajax_options) {
		var object = $(this);
		var defaults = {
			waitMe: '.box-widget',
			type: typeof object.attr('method') !== 'undefined' ? object.attr('method') : 'POST',
            url: typeof object.attr('action') !== 'undefined' ? object.attr('action') : null,
            data: {
            	csrf_token: $('meta[name="csrf-token"]').attr('content')
            },
            before: function (event) {},
			success: function (event, data) {},
            error: function (event, data) {},
		};

		var default_messages = {
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
        };
		
		var default_options = $.extend(true, defaults, ajax_options);

		var errorMessage = function(data, messages) {
			var errors = data.responseJSON;

			if (data.status == '404') {
            	command: toastr["error"]("Not Found");
				return false;
			}
			
            command: toastr["error"](errors.message);

			if (typeof errors.data !== 'undefined') {

				$.each(errors.data, function(key, value){
					field = $('[name = "' + key + '"]', object);
                    _div = $('.error_' + key, object);
                    _group = field.closest('.form-group').find('div.input-group');
                    _selectize = field.closest('.form-group').find('div.selectize-control');
                    _select2 = field.closest('.form-group').find('.select2-container');
                    
                    field.closest('.form-group').addClass('has-error');

                    if (messages.validation.title) {
                        var manual_target = $('#error_' + key, object);
                        
                        if (manual_target.length) {
                            manual_target.find('span.help-block.error').remove();
                            manual_target.html('<span class="help-block error"> ' + value + ' </span>');
                        } else {

                          field.closest('.form-group').addClass('has-error').find('span.help-block.error').remove();

                          if (messages.validation.titlePosition == 'top' || messages.validation.titlePosition == 'before') {
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

		var ajaxSubmit = function(options, messages) {
			object.ajaxSubmit({
				type: options.type,
                url: options.url,
                data: options.data,
                beforeSubmit: function (arr, form, settings) {
                	$(options.waitMe).waitMe();
                	options.before.call(this);
                }, 
                success: function (data) {
                	$(options.waitMe).waitMe("hide");
					swal(
				      messages.success.title,
				      messages.success.text,
				      messages.success.type
				    ).then((result) => {
					  if (result.value) {
                		options.success.call(this);
					  }
					});
                },
                error: function (data) {
                	$(options.waitMe).waitMe("hide");
                	errorMessage(data, messages);
                	options.error.call(this);
                }
			}); 
		};

		return {
			submit: function(messages) {			
				var messages = $.extend(true, default_messages, messages);
				swal(messages.confirm).then((result) => {
				  if (result.value) {
				  	ajaxSubmit(default_options, messages);
				  }
				});
			},
			reset: function() {
				object.clearForm();
			},
			delete: function(messages) {
				// refactor option
				var default_data       = default_options.data;
				default_options.method = 'POST';
				default_options.url    = object.attr('href');

				if (typeof default_data.grid_id === 'undefined') {
					default_options.data = $.extend(true, default_data, {
						grid_id: object.attr('data-grid')
					});
				}

				// console.log(default_options.data);

				// refactor messages
				default_messages.confirm.text  = "Data yang dihapus tidak dapat dikembalikan.";
				default_messages.success.title = "Terhapus!";
				default_messages.success.text  = "Data berhasil dihapus.";
				
				var messages = $.extend(true, default_messages, messages);
				
				swal(messages.confirm).then((result) => {
				  if (result.value) {
				  	ajaxSubmit(default_options, messages);
				  }
				});
			}
		};
	};
}(jQuery));