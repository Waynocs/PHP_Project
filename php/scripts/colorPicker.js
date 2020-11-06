function onColorChange() {
    var blank = document.getElementById("preview-blank");
    var theme = document.getElementById("preview-theme");
    var picker = document.getElementById("color-picker");
    blank.style.backgroundColor = picker.value;
    theme.style.backgroundColor = picker.value;
}

function onThemeChange() {
    var theme = document.getElementById("preview-theme");
    var title = document.getElementById("theme-title");
    theme.innerHTML = title.value;
}