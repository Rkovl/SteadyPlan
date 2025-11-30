const dropDowns = document.querySelectorAll('.dropdown-content');

function showDropdown(id) {
    document.getElementById(id).classList.toggle("show");
}

window.onclick = e => {
    if (!e.target.matches('.dropbtn')) {
        dropDowns.forEach(dropdown => {
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });
    }
}