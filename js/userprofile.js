window.onscroll = function() {
    scrollFunction()
};

function coverToProfile() {
    var profile = document.getElementById("profileContainer");
    // var profile = document.documentElement.scrollTop = 1128;
    profile.scrollIntoView();
}