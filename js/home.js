// Function to show/hide navbar in transition of scrolls
window.onscroll = function () {
    scrollFunction()
};

function scrollFunction() {
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        document.getElementById("navbar").style.padding = "5px 10px";
        document.getElementById("logo").style.fontSize = "25px";
        document.getElementById("navbar").classList.add("navbar-colored")
        document.getElementById("navbar").classList.remove("navbar-transparent")
    } else {
        document.getElementById("navbar").style.padding = "30px 10px";
        document.getElementById("logo").style.fontSize = "35px";
        document.getElementById("navbar").classList.add("navbar-transparent")
        document.getElementById("navbar").classList.remove("navbar-colored")
    }
}

// Function to initialise Animate on Scroll JS
AOS.init();

// Function to scroll to Services section when clicking button
function coverToProfile() {
    var profile = document.getElementById("profile");
    // var profile = document.documentElement.scrollTop = 1128;
    profile.scrollIntoView();
}

// Function for Modal - Facilities close modal
$(function () {
    $('.facilities-close').hover(function () {
        $('.facilities-modal-close').css('color', 'black');
    }, function () {
        // on mouseout, reset the background colour
        $('.facilities-modal-close').css('color', 'white');
    });
});

// Switch from Log-In to Register Modal
$(document).on("click", "#signup-link", function () {
    $('#login-modal').modal('hide');

    // Delay showing Register Modal for 500ms to load modal-open class properly
    setTimeout(function () {
        $('#register-modal').modal('show');
    }, 500);
});

// Switch from Register to Log-In Modal
$(document).on("click", "#signin-link", function () {
    $('#register-modal').modal('hide');

    // Delay showing Log-In Modal for 500ms to load modal-open class properly
    setTimeout(function () {
        $('#login-modal').modal('show');
    }, 500);
});


// Register Modal Password Functions
$(document).ready(function () {
    $('#reg_userpassword').keyup(function () {
        var password = $('#reg_userpassword').val();
        var confirmpassword = $('#reg_userpasswordconfirm').val();

        if (checkStrength(password) == false) {
            $('#reg_submit').attr('disabled', true);
        }
    });

    // password-rule divi hide/show
    $('#reg_userpassword').keyup(function () {
        if ($('#reg_userpassword').val()) {
            $('#reg_passwordrules').removeClass('hide');
            $('#reg-password-strength').removeClass('hide');
        } else {
            $('#reg_passwordrules').addClass('hide');
            $('#reg-password-quality').addClass('hide')
            $('#reg-password-quality-result').addClass('hide')
            $('#reg-password-strength').addClass('hide')

        }
    });

    // password-confirm error divi hide/show
    $('#reg_userpasswordconfirm').blur(function () {
        if ($('#reg_userpassword').val() !== $('#reg_userpasswordconfirm').val()) {
            $('#error-confirmpassword').removeClass('hide');
            $('#reg_submit').attr('disabled', true);
        } else {
            $('#error-confirmpassword').addClass('hide');
            $('#reg_submit').attr('disabled', false);
        }
    });


    $('#reg_submit').hover(function () {
        if ($('#reg_submit').prop('disabled')) {
            $('#reg_submit').popover({
                html: true,
                trigger: 'hover',
                placement: 'below',
                offset: 20,
                content: function () {
                    return $('#sign-up-popover').html();
                }
            });
        }
    });

    function checkStrength(password) {
        var strength = 0;

        //If password contains both lower and uppercase characters, increase strength value.
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
            strength += 1;

            $('.low-upper-case').addClass('text-success');
            $('.low-upper-case i').removeClass('fa-check').addClass('fa-check');
            $('#reg-password-quality').addClass('hide');


        } else {
            $('.low-upper-case').removeClass('text-success');
            $('.low-upper-case i').addClass('fa-check').removeClass('fa-check');
            $('#reg-password-quality').removeClass('hide');
        }

        //If it has numbers and characters, increase strength value.
        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
            strength += 1;
            $('.one-number').addClass('text-success');
            $('.one-number i').removeClass('fa-check').addClass('fa-check');
            $('#reg-password-quality').addClass('hide');

        } else {
            $('.one-number').removeClass('text-success');
            $('.one-number i').addClass('fa-check').removeClass('fa-check');
            $('#reg-password-quality').removeClass('hide');
        }

        //If it has one special character, increase strength value.
        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
            strength += 1;
            $('.one-special-char').addClass('text-success');
            $('.one-special-char i').removeClass('fa-check').addClass('fa-check');
            $('#reg-password-quality').addClass('hide');

        } else {
            $('.one-special-char').removeClass('text-success');
            $('.one-special-char i').addClass('fa-check').removeClass('fa-check');
            $('#reg-password-quality').removeClass('hide');
        }

        if (password.length > 7) {
            strength += 1;
            $('.eight-character').addClass('text-success');
            $('.eight-character i').removeClass('fa-check').addClass('fa-check');
            $('#reg-password-quality').removeClass('hide');

        } else {
            $('.eight-character').removeClass('text-success');
            $('.eight-character i').addClass('fa-check').removeClass('fa-check');
            $('#reg-password-quality').removeClass('hide');
        }
        // ------------------------------------------------------------------------------
        // If value is less than 2
        if (strength < 2) {
            $('#reg-password-quality-result').removeClass()
            $('#password-strength').addClass('progress-bar-danger');
            $('#reg-password-quality-result').addClass('text-danger').text('Weak');
            $('#password-strength').css('width', '10%');

        } else if (strength == 2) {
            $('#reg-password-quality-result').addClass('good');
            $('#password-strength').removeClass('progress-bar-danger');
            $('#password-strength').addClass('progress-bar-warning');
            $('#reg-password-quality-result').addClass('text-warning').text('Moderate')
            $('#password-strength').css('width', '60%');

            return 'Weak'
        } else if (strength == 4) {
            $('#reg-password-quality-result').removeClass()
            $('#reg-password-quality-result').addClass('strong');
            $('#password-strength').removeClass('progress-bar-warning');
            $('#password-strength').addClass('progress-bar-success');
            $('#reg-password-quality-result').addClass('text-success').text('Strong');
            $('#password-strength').css('width', '100%');

            return 'Strong'
        }

    }

});

// Function to view password during registration
function togglePassword() {
    var element1 = document.getElementById('reg_userpassword');
    element1.type = (element1.type == 'password' ? 'text' : 'password');
};

function togglePassword_Confirm() {
    var element2 = document.getElementById('reg_userpasswordconfirm');
    element2.type = (element2.type == 'password' ? 'text' : 'password');
};

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

// Function to display KK8 on Google Maps API
function initMap() {
    // The location of KK8
    var kk8_location = { lat: 3.1299, lng: 101.6494 };
    // The map, centered at KK8
    var map = new google.maps.Map(
        document.getElementById("google-map"), { zoom: 17, center: kk8_location });
    // The marker, positioned at K8
    var marker = new google.maps.Marker({ position: kk8_location, map: map });
}

