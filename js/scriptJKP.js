
const modalBtn = document.querySelectorAll('[data-modal-target]');
const modalCls = document.querySelectorAll('[data-modal-close]');
var registerBTN = document.querySelectorAll(".modal-button")

//  console.log(modalBtn);
//  console.log(modalCls);
// console.log(registerBTN);

modalBtn.forEach(button => {
    button.addEventListener('click', function()  {
        const modal = document.querySelector(button.dataset.modalTarget);
        // console.log(modal);
        spawn(modal);
    });
});

function spawn(modal){
    if(modal == null) return;
    modal.classList.add('visable');
    var a = modal.querySelector(".modal-title").firstElementChild.innerHTML
    // window.localStorage.setItem("actName", a)
    document.querySelector("body").classList.add("bg-fixed");
}


modalCls.forEach(button => {
    button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.modalClose);
        // console.log(button.dataset.modalClose);
        // console.log(modal);
        despawn(modal);
    })
})

function despawn(modal){
    if(modal == null) return;
    modal.classList.remove('visable');
    document.querySelector("body").classList.remove("bg-fixed");
}



registerBTN.forEach(button =>{
    button.addEventListener("click", function(){
        var a = button.getAttribute("activityID")
        a = "#form"+a;
        document.querySelector(a).submit()
        
    })
})



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

