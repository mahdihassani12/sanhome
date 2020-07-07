(function ($) {
    "use strict";

    $(function () {

        /* Apply jquery ui sortable on additional details */
        $("#inspiry-additional-details-container").sortable({
            revert: 100,
            placeholder: "detail-placeholder",
            handle: ".sort-detail",
            cursor: "move"
        });

        $('.add-detail').click(function (event) {
            event.preventDefault();
            var newInspiryDetail = '<div class="inspiry-detail inputs">' +
                '<div class="inspiry-detail-control"><span class="sort-detail dashicons dashicons-menu"></span></div>' +
                '<div class="inspiry-detail-title"><input type="text" name="detail-titles[]" /></div>' +
                '<div class="inspiry-detail-value"><input type="text" name="detail-values[]" /></div>' +
                '<div class="inspiry-detail-control"><a class="remove-detail" href="#"><span class="dashicons dashicons-dismiss"></span></a></div>' +
                '</div>';

            $('#inspiry-additional-details-container').append(newInspiryDetail);
            bindAdditionalDetailsEvents();
        });

        function bindAdditionalDetailsEvents() {

            /* Bind click event to remove detail icon button */
            $('.remove-detail').click(function (event) {
                event.preventDefault();
                var $this = $(this);
                $this.closest('.inspiry-detail').remove();
            });

        }

        bindAdditionalDetailsEvents();

        // Script for Additional Social Networks
        var fontsLink = '<div><a href="https://fontawesome.com/v4.7.0/cheatsheet/" target="_blank">' + ereSocialLinksL10n.iconLink + '</a></div>';
        $(document).on("click", "#inspiry-ere-add-sn", function (event) {
            var socialNetworksTable = $('#inspiry-ere-social-networks-table');
            var socialNetworkIndex = socialNetworksTable.find('tbody tr').last().index() + 1;
            var socialNetwork =
                '<tr class="inspiry-ere-sn-tr">' +
                '<th scope="row">' +
                '<label for="inspiry-ere-sn-title-' + socialNetworkIndex + '">' + ereSocialLinksL10n.title + '</label>' +
                '<input type="text" id="inspiry-ere-sn-title-' + socialNetworkIndex + '" name="inspiry_ere_social_networks[' + socialNetworkIndex + '][title]" class="code">' +
                '</th>' +
                '<td>' +
                '<div>' +
                '<label for="inspiry-ere-sn-url-' + socialNetworkIndex + '"><strong>' + ereSocialLinksL10n.profileURL + '</strong></label>' +
                '<input type="text" id="inspiry-ere-sn-url-' + socialNetworkIndex + '" name="inspiry_ere_social_networks[' + socialNetworkIndex + '][url]" class="regular-text code">' +
                '</div>' +
                '<div>' +
                '<label for="inspiry-ere-sn-icon-' + socialNetworkIndex + '"><strong>' + ereSocialLinksL10n.iconClass + '</strong> <small>- <em>' + ereSocialLinksL10n.iconExample + '</em></small></label>' +
                '<input type="text" id="inspiry-ere-sn-icon-' + socialNetworkIndex + '" name="inspiry_ere_social_networks[' + socialNetworkIndex + '][icon]" class="code">' +
                '<a href="#" class="inspiry-ere-remove-sn inspiry-ere-sn-btn">-</a>' +
                fontsLink +
                '</div>' +
                '</td>' +
                '</tr>';

            socialNetworksTable.append(socialNetwork);
            event.preventDefault();
        });

        $(document).on("click", ".inspiry-ere-remove-sn", function (event) {
            $(this).closest('.inspiry-ere-sn-tr').remove();
            event.preventDefault();
        });

        $(document).on("click", ".inspiry-ere-edit-sn", function (event) {
            var $this = $(this),
                tableRow = $this.closest('.inspiry-ere-sn-tr');
            tableRow.find('.inspiry-ere-sn-field').removeClass('hide');
            tableRow.find('.inspiry-ere-sn-title').hide();
            $this.siblings('.inspiry-ere-update-sn').removeClass('hide');
            $this.addClass('hide');
            event.preventDefault();
        });

        $(document).on("click", ".inspiry-ere-update-sn", function (event) {
            var $this = $(this),
                tableRow = $this.closest('.inspiry-ere-sn-tr');
            tableRow.find('.inspiry-ere-sn-field').addClass('hide');
            tableRow.find('.inspiry-ere-sn-title').show().html(tableRow.find('input[type="text"]').val());
            $this.siblings('.inspiry-ere-edit-sn').removeClass('hide');
            $this.addClass('hide');
            event.preventDefault();
        });
    });
}(jQuery));
