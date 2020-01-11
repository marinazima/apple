/**
 * Created by Zima on 11.01.2020.
 */

(function ($) {
    var widget = {
        form: null,
        eCount: null,
        bSend: null,
        modal: null,
        init: function () {
            this.form = $('#gen-form');
            this.eCount = this.form.find('.js-count');
            this.bSend = this.form.find('.js-submit');
            this.modal = $('#modalGenerate');

            this.initHandlers();
        },
        initHandlers: function() {
            this.bSend.on('click', function(e) {
                widget.send();
            });

            this.eCount.on('keypress', function(e) {
                if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            this.modal.on('hidden.bs.modal', function (e) {
                widget.reset();
            })
        },
        errorOn: function() {
            this.eCount.parents('.form-group').addClass('has-error');
            this.eCount.next('.help-block').html('Введите число больше 1');
        },
        errorOff: function() {
            this.eCount.parents('.form-group').removeClass('has-error');
            this.eCount.next('.help-block').html('');
        },
        validate: function() {
            var count = this.eCount.val();
            if( count.length > 0 &&
                count.match(/[0-9]+/gi) &&
                count > 0
            ) {
                this.errorOff();
                return true;
            } else {
                this.errorOn();
                return false;
            }
        },
        send: function() {
            if(this.validate()) {
                var action = this.form.attr('action');
                this.form.attr('action', action + '/' + this.eCount.val());
                this.form.submit();
            }
        },
        reset: function() {
            var defaultValue = this.eCount.data('default');
            this.eCount.val(defaultValue);
            this.errorOff();
        }
    };

    widget.init();

})(jQuery);