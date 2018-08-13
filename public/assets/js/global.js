(function ($, window, document) {

    'use strict';

    var constants = {
            consoleOutput: '#console-output',
            buttonBuildAll: '#console-buildall',
            buttonPurge: '#console-purge',
            iframeBuildAll: '/build',
            iframePurge: '/purge',
            loadingIcon: '<i class="fas fa-circle-notch fa-spin"></i>',
        },
        properties = {
            consoleOutput: null,
            buttonBuildAll: null,
            buttonPurge: null,
            loading: false,
        },
        methods = {
            init: function () {
                $('time').timeago();
                properties.consoleOutput = $(constants.consoleOutput);
                properties.buttonBuildAll = $(constants.buttonBuildAll);
                properties.buttonPurge = $(constants.buttonPurge);

                properties.consoleOutput.on('load', methods.triggerLoaded);
                properties.buttonBuildAll.on('click', methods.triggerBuildAll);
                if (properties.buttonPurge.length > 0) {
                    properties.buttonPurge.on('click', methods.triggerPurge);
                }
            },
            setButtonLoading: function (button) {
                button.css('width', button.outerWidth());
                button.data('previousContent', button.html())
                    .prop('disabled', true)
                    .html(constants.loadingIcon);
            },
            setButtonLoaded: function (button) {
                button.css('width', 'auto');
                button.html(button.data('previousContent'))
                    .prop('disabled', false)
                    .data('previousContent', null);
            },
            scrollOutput: function () {
                var iframe = properties.consoleOutput.contents().find('html, body');
                iframe.scrollTop(iframe.height());
                if (properties.loading) {
                    setTimeout(methods.scrollOutput, 500);
                }
            },
            triggerLoading: function () {
                properties.loading = true;
                properties.consoleOutput.css('height', 200);
                setTimeout(methods.scrollOutput, 500);

                methods.setButtonLoading(properties.buttonBuildAll);
                if (properties.buttonPurge.length > 0) {
                    methods.setButtonLoading(properties.buttonPurge);
                }
            },
            triggerLoaded: function () {
                properties.loading = false;
                methods.setButtonLoaded(properties.buttonBuildAll);
                if (properties.buttonPurge.length > 0) {
                    methods.setButtonLoaded(properties.buttonPurge);
                }
            },
            triggerBuildAll: function (event) {
                event.preventDefault();
                properties.consoleOutput.prop('src', constants.iframeBuildAll);
                methods.triggerLoading();
            },
            triggerPurge: function (event) {
                console.log(event);
                event.preventDefault();
                properties.consoleOutput.prop('src', constants.iframePurge);
                methods.triggerLoading();
            }
        };

    $(document).ready(methods.init);

})(jQuery, window, document);