const modalBtn = document.querySelectorAll('[data-modal-target]');
const modalCls = document.querySelectorAll('[data-modal-close]');
var UnregisterBTN = document.querySelectorAll(".modal-button")
noBtn = document.querySelector(".noBTN")
unRegBtn = document.querySelector(".unRegBTN")
var activityName

// Spawn the correct modal when a row is clicked
modalBtn.forEach(button => {
    button.addEventListener('click', function()  {
        const modal = document.querySelector(button.dataset.modalTarget);
        spawn(modal);
    });
});

function spawn(modal){
    if(modal == null) return;
    modal.classList.add('visable');
    activityName = modal.querySelector("h5").innerHTML
    document.querySelector("#activityIDTemp").setAttribute("value", modal.querySelector("div").getAttribute("activityid"))
    document.querySelector("body").classList.add("bg-fixed");
}

// Confirmation modal
UnregisterBTN.forEach(button =>{
    button.addEventListener("click", function(){
        const modal = document.querySelector(button.dataset.modalTarget);
        var a = document.querySelector(".modal2-title")
        a.innerHTML = activityName
        spawn2(modal) 
    })
})

function spawn2(modal){
    confirmModal = document.querySelector(".modal2-bg")
    confirmModal.classList.add('visable2');
}

noBtn.addEventListener("click", function(){
    var modalbg2 = document.querySelector(".modal2-bg")
    modalbg2.classList.remove('visable2')
})

unRegBtn.addEventListener("click", function(){
    document.querySelector("#cofirmUnregister").submit();
})

// close main modal
modalCls.forEach(button => {
    button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.modalClose);
        despawn(modal);
    })
})

function despawn(modal){
    if(modal == null) return;
    modal.classList.remove('visable');
    document.querySelector("body").classList.remove("bg-fixed");
}

var btn = $('#back-to-top');

$(window).scroll(function() {
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

// Function to scroll to down when clicking button
function coverToProfile() {
    var profile = document.querySelector("#activity-nav");
    profile.scrollIntoView();
}





