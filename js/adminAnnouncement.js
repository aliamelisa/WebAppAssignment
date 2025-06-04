function toggleAnnouncementFields() {
    let slideshow = document.getElementById('r1').checked;
    let normalAnnouncement = document.getElementById('r2').checked;

    if (slideshow){
        document.getElementById('imageInput').style = 'display : block;';
        document.getElementById('announcementFields').style = 'display : none;';
    }
    else if(normalAnnouncement){
        document.getElementById('imageInput').style = 'display : none;';
        document.getElementById('announcementFields').style = 'display : block;';
    }
    else{
        document.getElementById('imageInput').style = 'display : none;';
        document.getElementById('announcementFields').style = 'display : none;';
    }
    }

    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('r1').addEventListener('change', toggleAnnouncementFields);
    document.getElementById('r2').addEventListener('change', toggleAnnouncementFields);
    toggleAnnouncementFields();
    });
