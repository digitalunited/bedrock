if (jQuery) {
    var j = jQuery;

    j('body').on('vcPanel.shown', function () {

        function format(icon) {
            return '<span class="icon icon-' + icon.text + '"> </span>' + icon.text;
        }

        var selectToActivateON;
        selectToActivateON = j('.vc_ui-panel-content-container select.icon.dropdown');
        selectToActivateON.select2({
            width: 'element',
            dropdownCss: {'z-index': '99999999'},
            formatResult: format,
            formatSelection: format
        });

    });
    j('.vc_ui-control-button').on('click', function () {
        selectToActivateON = j('.vc_ui-panel-content-container select.icon.dropdown');
        selectToActivateON.select2('close');
    });
}
