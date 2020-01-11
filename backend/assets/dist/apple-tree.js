/**
 * Created by Zima on 11.01.2020.
 */

(function ($) {
    var tree = {
        tree: null,
        urlDown: null,
        urlEat: null,
        urlCanEat: null,
        modalEat: null,
        modalError: null,
        init: function () {
            this.tree = $('#apple-tree');
            this.urlDown = this.tree.data('url-down');
            this.urlEat = this.tree.data('url-eat');
            this.urlCanEat = this.tree.data('url-can-eat');

            this.modalEat = $('#modalEat');
            this.modalError = $('#modalError');

            this.initHandlers();
        },
        initHandlers: function() {
            $(document).on('click', '.js-down', function(e) {
                var params = {
                    id: tree.getId($(this))
                };
                tree.down(params);
            });

            $(document).on('click', '.js-eat', function(e) {
                var params = {
                    id: tree.getId($(this)),
                    balance: $(this).data('balance'),
                };
                tree.canEat(params);
            });

            this.modalEat.find('.js-pie').on('keypress', function(e) {
                if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            this.modalEat.find('.js-pie').on('change', function(e) {
                tree.eatValidate();
            });

            this.modalEat.find('.js-submit').on('click', function(e) {
                if(tree.eatValidate()) {
                    var form = tree.modalEat.find('form');
                    var params = {
                        id: tree.modalEat.find('[name="id"]').val(),
                        pie: tree.modalEat.find('[name="pie"]').val()
                    };
                    tree.eat(params);
                }
            });

            this.modalEat.on('hidden.bs.modal', function (e) {
                tree.eatReset();
            });
        },
        down: function(params) {
            if (this.urlDown) {
                $.ajax({
                    method: 'GET',
                    data: params,
                    url: this.urlDown,
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        if(data.success) {
                            if(data.inner) {
                                tree.afterAction(params.id, data.inner);
                            }
                        } else {
                            tree.showError(data.error);
                        }
                    },
                });
            }
        },
        canEat: function(params) {
            if (this.urlCanEat) {
                $.ajax({
                    method: 'GET',
                    data: {id: params.id},
                    url: this.urlCanEat,
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        if(data.success) {
                            tree.preEat(params);
                        } else {
                            tree.showError(data.message);
                            if(data.inner) {
                                tree.afterAction(params.id, data.inner);
                            } else {
                                tree.clear(params.id);
                            }
                        }
                    },
                });
            }
        },
        preEat: function(params) {
            var eId = this.modalEat.find('[name="id"]');
            eId.val(params.id);

            var ePie = this.modalEat.find('[name="pie"]');
            ePie.attr('max', params.balance);
            this.modalEat.modal('show');
        },
        validationError: function(element, on, message) {
            if(on) {
                element.parents('.form-group').addClass('has-error');
                element.next('.help-block').html(message);
            } else {
                element.parents('.form-group').removeClass('has-error');
                element.next('.help-block').html('');
            }
        },
        eatValidate: function() {
            var ePie = this.modalEat.find('[name="pie"]');

            var min = +ePie.attr('min');
            var max = +ePie.attr('max');
            var pie = ePie.val();

            if( pie.length > 0 &&
                pie.match(/[0-9]+/gi) &&
                +pie >= min  &&
                +pie <= max
            ) {
                this.validationError(ePie, false);
                return true;
            } else {
                this.validationError(ePie, true, 'Введите число от ' + min + ' до ' + max);
                return false;
            }
        },
        eat: function(params) {
            if (this.urlEat) {
                $.ajax({
                    method: 'GET',
                    data: params,
                    url: this.urlEat,
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        tree.modalEat.modal('hide');
                        if(data.success) {
                            if(data.inner) {
                                tree.afterAction(params.id, data.inner);
                            } else {
                                tree.clear(params.id);
                            }
                        } else {
                            tree.showError(data.message);
                        }
                    }
                });
            }
        },
        eatReset: function() {
            var form = tree.modalEat.find('form');
            form.find('input').each(function() {
                $(this).val('');
                tree.validationError($(this), false);
            });
            form.find('[name="pie"]').val(1);
        },
        clear: function(id) {
            var item = this.getItem(id);
            item.remove();
        },
        afterAction: function(id, inner) {
            var item = this.getItem(id);
            item.html(inner);
        },
        showError: function(error) {
            this.modalError.find('.js-message').html(error);
            this.modalError.modal('show');
        },
        getId: function(element) {
            return element.parents('.js-item').data('id');
        },
        getItem: function(id) {
            return $('#item-' + id);
        },
        /** Utils */
        isEmpty: function (str) {
            return (
                typeof str === 'undefined' ||
                str === null ||
                0 === str.length
            );
        },
    };

    tree.init();

})(jQuery);