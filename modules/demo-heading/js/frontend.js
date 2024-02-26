(function($) {

    DemoHeading = function( settings ) {
        this.settings = settings;
        this.nodeClass   = settings.nodeClass;
        this._initLayout();
    };

    DemoHeading.prototype = {

        settings        : {},
		nodeClass       : '',
		currPage		: 1,
		totalPages		: 1,

        _initLayout     : function() {
            alert( this.nodeClass );
        },

    };

})(jQuery);