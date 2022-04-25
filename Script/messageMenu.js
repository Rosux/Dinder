function openMessageMenu() {
    document.getElementById("message-menu").style.display = "flex";
}
document.getElementById("message-menu").addEventListener('click', e => {
    if(e.target == e.currentTarget) {
        document.getElementById("message-menu").style.display = "none";
    }
});