var Select2Cascade = ( function(window, $) {
    function Select2Cascade(parent, child, url, parentOptions, childOptions={}) {
        var afterActions = [];
        var options = childOptions || {};

        // Register functions to be called after cascading data loading done
        this.then = function(callback) {
            afterActions.push(callback);
            return this;
        };

        parent.select2(parentOptions).on("change", function (e) {

            child.prop("disabled", true);

            var _this = this;
            $.getJSON(url.replace(':parentId:', $(this).val()), function(items) {
                var newOptions = '<option value="">- Select ...</option>';

                if(items.length != 0){
                    for(var id in items) {
                        newOptions += '<option value="'+ id +'">'+ items[id] +'</option>';
                    }
                    child.select2('destroy').html(newOptions).prop("disabled", false).prop("required", true)
                    .select2(options);
                } else {
                    child.select2('destroy').html(newOptions).select2(options);
                }
                
                afterActions.forEach(function (callback) {
                    callback(parent, child, items);
                });
            });
        });
    }
    return Select2Cascade;
})( window, $);