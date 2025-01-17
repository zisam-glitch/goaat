<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc_html(get_bloginfo('name')); ?></title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/styles/style.css">
    <link href="https://fonts.cdnfonts.com/css/helvetica-neue-55" rel="stylesheet">
    <?php wp_head(); ?>
    <?php
    // Get the selected logo size option
    $logo_size = get_theme_mod('logo_size', 'medium');

    // Define the CSS class based on the selected size
    $logo_class = 'logo-' . $logo_size;
    ?>
</head>

<body <?php body_class(); ?>>
    <header class="main-header">
        <div class="logo <?php echo esc_attr($logo_class); ?>">
            <?php if (function_exists('the_custom_logo')) {
                the_custom_logo();
            } else {
                echo '<h1>' . get_bloginfo('name') . '</h1>';
            } ?>
        </div>
        <nav>
            <a href="#" data-drawer-trigger aria-controls="drawer-name" aria-expanded="false">
                <img class="hamburgerbutton" src="<?php echo get_template_directory_uri(); ?>/img/hamburgerbutton.png" alt="-">
            </a>
        </nav>

        <section class="drawer" id="drawer-name" data-drawer-target>
            <div class="drawer__overlay" data-drawer-close tabindex="-1"></div>
            <div class="drawer__wrapper">
                <div class="drawer__header">
                    <button class="drawer__close" data-drawer-close aria-label="Close Drawer"></button>
                </div>
                <div class="drawer__content">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'main-menu',
                            'menu_class' => 'main-menu',
                            'container' => 'nav',
                            'container_class' => 'main-navigation',
                            'walker' => new Custom_Walker_Nav_Menu(),
                        )
                    );
                    ?>
                    <img class="badge" src="<?php echo get_template_directory_uri(); ?>/img/badge.png" alt="-">
                </div>
            </div>
        </section>
    </header>

    <script>
        var drawer = function() {

            if (!Element.prototype.closest) {
                if (!Element.prototype.matches) {
                    Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
                }
                Element.prototype.closest = function(s) {
                    var el = this;
                    var ancestor = this;
                    if (!document.documentElement.contains(el)) return null;
                    do {
                        if (ancestor.matches(s)) return ancestor;
                        ancestor = ancestor.parentElement;
                    } while (ancestor !== null);
                    return null;
                };
            }

            function trapFocus(element) {
                var focusableEls = element.querySelectorAll('a[href]:not([disabled]), button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])');
                var firstFocusableEl = focusableEls[0];
                var lastFocusableEl = focusableEls[focusableEls.length - 1];
                var KEYCODE_TAB = 9;

                element.addEventListener('keydown', function(e) {
                    var isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

                    if (!isTabPressed) {
                        return;
                    }

                    if (e.shiftKey) {
                        if (document.activeElement === firstFocusableEl) {
                            lastFocusableEl.focus();
                            e.preventDefault();
                        }
                    } else {
                        if (document.activeElement === lastFocusableEl) {
                            firstFocusableEl.focus();
                            e.preventDefault();
                        }
                    }
                });
            }

            var settings = {
                speedOpen: 50,
                speedClose: 350,
                activeClass: 'is-active',
                visibleClass: 'is-visible',
                selectorTarget: '[data-drawer-target]',
                selectorTrigger: '[data-drawer-trigger]',
                selectorClose: '[data-drawer-close]',
            };

            var toggleAccessibility = function(event) {
                if (event.getAttribute('aria-expanded') === 'true') {
                    event.setAttribute('aria-expanded', false);
                } else {
                    event.setAttribute('aria-expanded', true);
                }
            };

            var openDrawer = function(trigger) {
                var target = document.getElementById(trigger.getAttribute('aria-controls'));
                target.classList.add(settings.activeClass);
                document.documentElement.style.overflow = 'hidden';
                toggleAccessibility(trigger);
                setTimeout(function() {
                    target.classList.add(settings.visibleClass);
                    trapFocus(target);
                }, settings.speedOpen);
            };

            var closeDrawer = function(event) {
                var closestParent = event.closest(settings.selectorTarget),
                    childrenTrigger = document.querySelector('[aria-controls="' + closestParent.id + '"');
                closestParent.classList.remove(settings.visibleClass);
                document.documentElement.style.overflow = '';
                toggleAccessibility(childrenTrigger);
                setTimeout(function() {
                    closestParent.classList.remove(settings.activeClass);
                }, settings.speedClose);
            };

            var clickHandler = function(event) {
                var toggle = event.target,
                    open = toggle.closest(settings.selectorTrigger),
                    close = toggle.closest(settings.selectorClose);
                if (open) {
                    openDrawer(open);
                }
                if (close) {
                    closeDrawer(close);
                }
                if (open || close) {
                    event.preventDefault();
                }
            };

            var keydownHandler = function(event) {
                if (event.key === 'Escape' || event.keyCode === 27) {
                    var drawers = document.querySelectorAll(settings.selectorTarget),
                        i;
                    for (i = 0; i < drawers.length; ++i) {
                        if (drawers[i].classList.contains(settings.activeClass)) {
                            closeDrawer(drawers[i]);
                        }
                    }
                }
            };

            document.addEventListener('click', clickHandler, false);
            document.addEventListener('keydown', keydownHandler, false);

        };

        drawer();
    </script>
</body>

</html>