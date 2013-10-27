$(document).ready(function () {
    $.fn.rating.options = { required: true, readonly: true };
    $(document).ready(function ($) {
        $('.object_rating :radio.object_star').rating({
            callback: function (value, link) {
                $.ajax({
                    type: 'POST',
                    url: $(this.form).attr('action'),
                    data: $(this.form).serialize(),
                    success: function (response) {
                        $('input[type=radio]', this.form).rating('readOnly', true);
                    },
                    error: function (request, status, error) {

                    }
                });
            }
        });
    });
});


