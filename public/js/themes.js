const htmlRootTag = document.getElementsByTagName('html')[0];
const themeButtons = document.getElementsByClassName('theme-button');

function updateThemeButtons(currentTheme) {
    for (let themeButton of themeButtons) {
        if (currentTheme === 'light') {
            themeButton.classList.remove('btn-dark');
            themeButton.classList.add('btn-light');
        } else if (currentTheme === 'dark') {
            themeButton.classList.remove('btn-light');
            themeButton.classList.add('btn-dark');
        }
    }
}

function setTheme(theme) {
    if (theme !== 'light' && theme !== 'dark') {
        console.error(`Invalid theme ${theme}`);
        return;
    }
    updateThemeButtons(theme);
    htmlRootTag.setAttribute('data-bs-theme', theme);
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

loadTheme();