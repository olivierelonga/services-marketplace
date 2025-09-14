document.addEventListener('DOMContentLoaded', function() {
    const sameWhatsAppCheckbox = document.getElementById('same_whatsapp_number');
    const whatsappField = document.getElementById('whatsapp_field');
    const whatsappInput = document.getElementById('whatsapp_number');

    function toggleWhatsAppField() {
        if (sameWhatsAppCheckbox.checked) {
            whatsappField.style.display = 'none';
            whatsappInput.required = false;
        } else {
            whatsappField.style.display = 'block';
            whatsappInput.required = true;
        }
    }

    if (sameWhatsAppCheckbox) {
        toggleWhatsAppField();
        sameWhatsAppCheckbox.addEventListener('change', toggleWhatsAppField);
    }
});

document.getElementById('profile_picture').addEventListener('change', function(e) {
    var preview = document.getElementById('profile_picture_preview');
    var removeButton = document.getElementById('remove_profile_picture');
    var uploadIcon = document.querySelector('.upload-icon');

    if (e.target.files.length > 0) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            removeButton.style.display = 'block';
            uploadIcon.style.display = 'none';
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});

document.getElementById('remove_profile_picture').addEventListener('click', function() {
    var input = document.getElementById('profile_picture');
    var preview = document.getElementById('profile_picture_preview');
    var removeButton = document.getElementById('remove_profile_picture');
    var uploadIcon = document.querySelector('.upload-icon');

    input.value = '';
    preview.src = '#';
    preview.style.display = 'none';
    removeButton.style.display = 'none';
    uploadIcon.style.display = 'block';
});