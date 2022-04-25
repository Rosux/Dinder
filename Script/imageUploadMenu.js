var imageUploadMenu = document.getElementById("image-upload-menu");
function openImageUploadMenu() {
    document.getElementById("image-upload-menu").style.display = "flex";
}
imageUploadMenu.addEventListener('click', e => {
    if(e.target == e.currentTarget) {
        imageUploadMenu.style.display = "none";
    }
});