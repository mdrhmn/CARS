// Function for back-to-top button to appear/disappear
var btn = $('#back-to-top');

$(window).scroll(function () {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

// Function to scroll back to the top of page
function scrollToTop() {
  window.scrollTo(0, 0);
}


function goDelete() {
  if (window.confirm('Are you sure to delete?')) {
    location.replace('helpdesk.php');
  }
}