(function (jQuery, Drupal, drupalSettings) {
    Drupal.behaviors.customDivClickable = {

        attach: function (context, settings) {

            // const authenticationTypes = ['Role Based Restriction', 'Domain Based Restriction', 'IP Based Restriction'];


            let role_based = document.getElementById('role_based_restriction');
            let domain_based = document.getElementById('domain_based_restriction');
            let ip_based = document.getElementById('ip_based_restriction');
            let role_based_div = document.getElementById('role_based');
            let domain_based_div = document.getElementById('domain_based');
            let ip_based_div = document.getElementById('ip_based');

            const hiddenField = document.getElementById('restriction-hidden-flag');

            if(hiddenField.value === 'Role Based Restriction') {
                role_based.style.display = 'block';
                domain_based.style.display = 'none';
                ip_based.style.display = 'none';
                role_based_div.classList.add("display_style_blocks_highlight");
            }else if(hiddenField.value === 'Domain Based Restriction') {
                domain_based.style.display = 'block';
                role_based.style.display = 'none';
                ip_based.style.display = 'none';
                domain_based_div.classList.add("display_style_blocks_highlight");
            }else if(hiddenField.value === 'IP Based Restriction'){
                domain_based.style.display = 'none';
                role_based.style.display = 'none';
                ip_based.style.display = 'block';
                ip_based_div.classList.add("display_style_blocks_highlight");
            }else {
                domain_based.style.display = 'none';
                role_based.style.display = 'none';
                ip_based.style.display = 'none';
            }

            jQuery('#role_based').click(
                function () {
                    role_based_div.classList.add("display_style_blocks_highlight");
                    domain_based_div.classList.remove("display_style_blocks_highlight");
                    ip_based_div.classList.remove("display_style_blocks_highlight");

                    role_based.style.display = 'block';
                    domain_based.style.display = 'none';
                    ip_based.style.display = 'none';
                }
            );

            jQuery('#domain_based').click(
                function () {
                    const list = domain_based_div.classList;
                    list.add("display_style_blocks_highlight");

                    role_based_div.classList.remove("display_style_blocks_highlight");
                    ip_based_div.classList.remove("display_style_blocks_highlight");
                    domain_based.style.display = 'block';
                    role_based.style.display = 'none';
                    ip_based.style.display = 'none';
                }
            );

            jQuery(document).on('click', '#ip_based', function() {
                ip_based_div.classList.add("display_style_blocks_highlight");

                domain_based_div.classList.remove("display_style_blocks_highlight");
                role_based_div.classList.remove("display_style_blocks_highlight");
                ip_based.style.display = 'block';
                domain_based.style.display = 'none';
                role_based.style.display = 'none';
            });

        }
    };
})(jQuery, Drupal, drupalSettings);
