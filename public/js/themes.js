/*
 * Theme toggle JS.
 */
const $htmlRootTag = $('html');
const $themeButtons = $('.theme-button');
const $themeReactiveButtons = $('.theme-reactive-btn');

function updateThemeButtons(currentTheme) {
    if (currentTheme === 'dark') {
        $themeButtons.removeClass('btn-light');
        $themeReactiveButtons.removeClass('btn-light');
        $themeButtons.addClass('btn-dark');
        $themeReactiveButtons.addClass('btn-dark');
    } else {
        $themeButtons.removeClass('btn-dark');
        $themeReactiveButtons.removeClass('btn-dark');
        $themeButtons.addClass('btn-light');
        $themeReactiveButtons.addClass('btn-light');
    }
}

function setTheme(theme) {
    if (theme !== 'light' && theme !== 'dark') {
        console.error(`Invalid theme ${theme}`);
        theme = 'light';
    }
    updateThemeButtons(theme);
    $htmlRootTag.attr('data-bs-theme', theme);
    localStorage.setItem('theme', theme);
}

function getTheme() {
    return localStorage.getItem("theme");
}

function toggleTheme() {
    const currentTheme = getTheme();
    if (currentTheme === 'light') {
        setTheme('dark');
    } else {
        setTheme('light');
    }
}

function loadTheme() {
    setTheme(getTheme());
}

$themeButtons.on('click', () => {
    toggleTheme();
});

loadTheme();