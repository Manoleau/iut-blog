document.addEventListener('DOMContentLoaded', function() {
    var checkbox = document.getElementById('admin-mode-switch');
    var iconAdmin = document.querySelector('.icon-admin');
    const adminElmts = document.querySelectorAll(".admin")
    
    var adminIconOn = "https://www.aht.li/3835561/admin.svg";
    var adminIconOff = "https://www.aht.li/3835562/user.svg";
    var adminMode = localStorage.getItem('adminMode');
    if(adminMode === 'true') {
        checkbox.checked = true;
        iconAdmin.src = adminIconOn;
        adminElmts.forEach(function(element) {
            if(element.tagName.toLowerCase() === "button"){
                element.style.display = 'inline-block';

            } else if (element.tagName.toLowerCase() === "a"){
                element.style.display = 'inline';
            }
        });
    } else {
        checkbox.checked = false;
        iconAdmin.src = adminIconOff;
        adminElmts.forEach(function(element) {
            element.style.display = 'none';
        });
    }

    checkbox.addEventListener('change', function() {
        if(checkbox.checked) {
            iconAdmin.src = adminIconOn;

            adminElmts.forEach(function(element) {
                if(element.tagName.toLowerCase() === "button"){
                    element.style.display = 'inline-block';

                } else if (element.tagName.toLowerCase() === "a"){
                    element.style.display = 'inline';
                }

            });
            localStorage.setItem('adminMode', 'true');
        } else {
            iconAdmin.src = adminIconOff;
            adminElmts.forEach(function(element) {
                element.style.display = 'none';
            });
            localStorage.setItem('adminMode', 'false');
        }
    });
});
