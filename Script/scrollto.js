// scroll to specific div with offset for header
// usage = scrollTowards("div id");
function scrollTowards(div) {
    window.scrollTo({top: document.getElementById(div).getBoundingClientRect().top + window.pageYOffset + -60, behavior: 'smooth'});
}