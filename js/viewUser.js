function updateAdmin() {
    var selected = document.querySelectorAll('input[name="selectUser[]"]:checked');
    if (selected.length === 1) {
        var ID = selected[0].value;
        window.location.href = 'updateFormAdmin.php?adminID=' + ID;
    } else {
        alert("Please select only one admin to update.");
    }
}

function updateStudent() {
    var selected = document.querySelectorAll('input[name="selectUser[]"]:checked');
    if (selected.length === 1) {
        var ID = selected[0].value;
        window.location.href = 'updateFormStudent.php?studentID=' + ID;
    } else {
        alert("Please select only one admin to update.");
    }
}

function updateSV() {
    var selected = document.querySelectorAll('input[name="selectUser[]"]:checked');
    if (selected.length === 1) {
        var ID = selected[0].value;
        window.location.href = 'updateFormSV.php?supervisorID=' + ID;
    } else {
        alert("Please select only one admin to update.");
    }
}