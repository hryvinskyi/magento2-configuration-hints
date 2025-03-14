/**
 * Copyright (c) 2025. Volodymyr Hryvinskyi. All rights reserved.
 * Author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 * GitHub: https://github.com/hryvinskyi
 */

define(['jquery'], function ($) {
    'use strict';

    return function (config) {
        $(document).on('click', '.copy-path-code', function(e) {
            e.preventDefault();
            const path = $(this).data('config-path');
            const code = $(this);

            navigator.clipboard.writeText(path).then(function() {
                code.addClass('success');
                // Add a success message after code element
                const successMessage = $('<span class="copy-success-message">Copied to clipboard</span>');
                code.after(successMessage);

                setTimeout(function() {
                    code.removeClass('success');
                    successMessage.remove();
                }, 2000);
            }, function(err) {
                console.error('Could not copy text: ', err);
                code.addClass('error');
                // Add an error message after code element
                const errorMessage = $('<span class="copy-error-message">Failed to copy</span>');
                code.after(errorMessage);

                setTimeout(function() {
                    code.removeClass('error');
                    errorMessage.remove();
                }, 2000);
            });
        });
    };
});