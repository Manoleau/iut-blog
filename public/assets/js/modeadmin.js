document.addEventListener('DOMContentLoaded', function() {
    var checkbox = document.getElementById('admin-mode-switch');
    var iconAdmin = document.querySelector('.icon-admin');
    var adminIconOn = "https://www.aht.li/3835561/admin.svg";
    var adminIconOff = "https://www.aht.li/3835562/user.svg";
    var adminMode = localStorage.getItem('adminMode');
    if(adminMode === 'true') {
        checkbox.checked = true;
        iconAdmin.src = adminIconOn;
    } else {
        checkbox.checked = false;
        iconAdmin.src = adminIconOff;
    }

    checkbox.addEventListener('change', function() {
        if(checkbox.checked) {
            iconAdmin.src = adminIconOn;
            localStorage.setItem('adminMode', 'true');
        } else {
            iconAdmin.src = adminIconOff;
            localStorage.setItem('adminMode', 'false');
        }
    });
});
