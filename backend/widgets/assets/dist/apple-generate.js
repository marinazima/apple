/**
 * Created by Zima on 11.01.2020.
 */

(function ($) {
    const MAX_COUNT = 10;

    var widget = {
        bGenerate: null,
        modal: null,
        form: null,
        eCount: null,
        bSend: null,
        init: function () {
            this.bGenerate = $('.js-generate');
            this.modal = $('#modalGenerate');

            this.form = $('#gen-form');
            this.eCount = this.form.find('.js-count');
            this.bSend = this.form.find('.js-submit');

            this.initHandlers();
        },
        initHandlers: function() {
            this.bGenerate.on('click', function(e) {
                var random = widget.getRandom(1, widget.getMax());
                widget.setCount(random);
                if(widget.isManual()) {
                    widget.modal.modal('show');
                } else {
                    widget.send();
                }
            });

            this.bSend.on('click', function(e) {
                if(widget.validate()) {
                    var count = widget.eCount.val();
                    widget.send(count);
                }
            });

            this.eCount.on('keypress', function(e) {
                if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            this.eCount.on('click', function(e) {
                widget.errorOff();
            });

            this.eCount.on('change', function(e) {
                widget.validate();
            });

            this.modal.on('hidden.bs.modal', function (e) {
                widget.reset();
            });
        },
        setCount: function (count) {
            widget.eCount.val(count);
        },
        errorOn: function() {
            this.eCount.parents('.form-group').addClass('has-error');
            this.eCount.next('.help-block').html('Введите число больше 1 и меньше ' + this.getMax());
        },
        errorOff: function() {
            this.eCount.parents('.form-group').removeClass('has-error');
            this.eCount.next('.help-block').html('');
        },
        validate: function() {
            var count = this.eCount.val();
            if( count.length > 0 &&
                count.match(/[0-9]+/gi) &&
                +count > 0 &&
                +count <= this.getMax()
            ) {
                this.errorOff();
                return true;
            } else {
                this.errorOn();
                return false;
            }
        },
        send: function() {
            // var action = this.form.attr('action');
            // var actionNew = action + '/' + count;
            // this.form.attr('action', actionNew);
            this.form.submit();
        },
        reset: function() {
            this.errorOff();
        },
        isManual: function() {
            var isEnable = this.bGenerate.data('enable-manual');
            return this.isEmpty(isEnable) ? 1 : isEnable;
        },
        getMax: function () {
            var max = this.bGenerate.data('max');
            return +(this.isEmpty(max) ? MAX_COUNT : max);
        },
        /** Utils */
        isEmpty: function (str) {
            return (
                typeof str === 'undefined' ||
                str === null ||
                0 === str.length
            );
        },
        getRandom: function(min, max) {
            min = this.isEmpty(min) ? 1 : min;
            max = this.isEmpty(max) ? MAX_COUNT : max;

            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        },
    };

    widget.init();

})(jQuery);