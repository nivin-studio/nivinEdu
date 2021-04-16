// Burger menus
document.addEventListener('DOMContentLoaded', function () {
    // open
    const burger = document.querySelectorAll('.navbar-burger');
    const menu = document.querySelectorAll('.navbar-menu');

    if (burger.length && menu.length) {
        for (var i = 0; i < burger.length; i++) {
            burger[i].addEventListener('click', function () {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    // close
    const close = document.querySelectorAll('.navbar-close');
    const backdrop = document.querySelectorAll('.navbar-backdrop');

    if (close.length) {
        for (var i = 0; i < close.length; i++) {
            close[i].addEventListener('click', function () {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    if (backdrop.length) {
        for (var i = 0; i < backdrop.length; i++) {
            backdrop[i].addEventListener('click', function () {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }
});

$(document).ready(() => {
    if (typeof Typed !== 'undefined') {
        var element = $('[data-toggle="typed"]');

        if (element.length && element.attr('data-options')) {
            const options = JSON.parse(element.attr('data-options'))
            options.preStringTyped = (arrayPos, self) => {
                const element = self.el;
                const curItem = self.strings[arrayPos];

                self.strings.forEach(item => {
                    if (curItem === item) {
                        element.classList.add('bg-brand-' + item.toLowerCase());
                    } else {
                        element.classList.remove('bg-brand-' + item.toLowerCase());
                    }
                });
            };

            var typed = new Typed('[data-toggle="typed"]', options);
        }
    };
});
