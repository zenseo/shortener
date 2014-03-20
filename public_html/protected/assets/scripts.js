/**
 * Little jqueryForm plugin =)
 */
function ajaxForm(id_form, success, error) {
	var form = $("#" + id_form);
	var url = form.attr('action');
	ajax(url, form.serialize(), success, error);
}

/**
 * Make ajax
 * @param url
 * @param data
 * @param success
 * @param error
 */
function ajax(url, data, success, error) {
	'use strict';

	/**
	 * Ajax success callback
	 * @param res
	 */
	var callback = function (res) {
		if (res.status == 200) {
			success(res);
		}
		else {
			if (error) {
				error(res);
			}
			console.log(res);
		}
	};

	$.ajax({
		type: 'POST',
		dataType: 'JSON',
		url: url,
		data: data ? data : {},
		success: callback,
		error: function (xhr, ajaxOptions, thrownError) {
			if (error) {
				error(xhr.responseText || thrownError);
			}
			console.log(xhr.responseText || thrownError);
		}
	});
}



/**
 * Let's make some noise!!!
 */
function submitForm() {
	var button = $('#submit_form_button');
	var old_text = button.text();
	button
		.attr('disabled', true)
		.text(button.data('ajax')+'...');

	ajaxForm('create_link_form', function (data) {
		button
			.attr('disabled', false)
			.text(old_text);

		if (!window.location.origin) {
			window.location.origin = window.location.protocol + "//" + window.location.host;
		}
		$('#create_link_form').trigger('reset');
		$('#short_link').html(window.location.origin + '/' + data.link.id);
		$('#long_link').html(data.link.url).attr('href', data.link.url);
		$('#short_link_container').show();
	}, function () {
		button
			.attr('disabled', false)
			.text(old_text);
	});
}
