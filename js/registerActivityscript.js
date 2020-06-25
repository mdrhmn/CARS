var registrationType = 10
var biro = null


// document.querySelector(".backbtn").setAttribute("href",window.localStorage.getItem("lastpage"))
//  Question 1----------------------------------------------------------------

document.querySelector(".participant").addEventListener("click", function(){
    document.querySelector("#notice1").classList.add("hidden")
    document.querySelector(".participant").classList.add("highlight")
    document.querySelector(".volunteer").classList.remove("highlight")
    registrationType = 0
    // console.log("participant selected")

    document.querySelector("#type-desc").innerHTML = "<br>A participant is someone who joins the activity as a... well a participant!";
})

document.querySelector(".volunteer").addEventListener("click", function(){
    document.querySelector("#notice1").classList.add("hidden")
    document.querySelector(".volunteer").classList.add("highlight")
    document.querySelector(".participant").classList.remove("highlight")
    registrationType = 1
    document.querySelector("#type-desc").innerHTML = "<br>A volunteer is someone who will help with the particular event. You can help by being in a biro such as the logistics team, publicity team or even the protocol team! ";
})



var btn_1_Next = document.querySelector("#btn_1_next")
// console.log(btn_1_Next)

btn_1_Next.addEventListener("click",function(){

    if(registrationType==0||registrationType==1){//if category is selected

        document.querySelector(".step2").classList.add("done")

        if(registrationType==0){//participant path
            document.querySelector(".participantFormBox").classList.remove("hidden")
            document.querySelector(".Q2p").classList.remove("hidden")
            // console.log("removed 'hidden' from Q2p")


        }else if(registrationType==1){//volunteer path
            document.querySelector(".volunteerFormBox").classList.remove("hidden")
            document.querySelector(".Q2v").classList.remove("hidden")
            // console.log("removed 'hidden' from Q2p")
        }

        document.querySelector(".Q1").classList.add("hidden")
        // console.log("added 'hidden' to Q1")
        window.scrollTo(0,0);

    }else{
        // console.log(document.querySelector("#notice1"))
        document.querySelector("#notice1").classList.remove("hidden")
    }
})


// //  Question 2----------------------------------------------------------------

//Question 2(participant)
var btn_2p_Prev = document.querySelector("#btn_2p_prev")
//console.log(btn_2p_Prev)
btn_2p_Prev.addEventListener("click",function(){
    window.scrollTo(0,0);
    document.querySelector(".step2").classList.remove("done")
    document.querySelector(".Q2p").classList.add("hidden")
    document.querySelector(".participantFormBox").classList.add("hidden")
    // console.log("added 'hidden' to Q2p")
    document.querySelector(".Q1").classList.remove("hidden")
    // console.log("removed 'hidden' from Q1")
})

var btn_2p_Next = document.querySelector("#btn_2p_next")
//console.log(btn_2p_Next)
btn_2p_Next.addEventListener("click",function(){
    window.scrollTo(0,0);
    document.querySelector(".step3").classList.add("done")
    document.querySelector(".Q2p").classList.add("hidden")
    document.querySelector(".Q2p-nav").classList.add("hidden")
    // console.log("added 'hidden' to Q2p")
    document.querySelector(".Q3p").classList.remove("hidden")
    document.querySelector(".Q3p-nav").classList.remove("hidden")
    // console.log("removed 'hidden' from Q3p")
})

var btn_3p_Prev = document.querySelector("#btn_3p_prev")
// console.log(btn_3v_Prev)
btn_3p_Prev.addEventListener("click",function(){
    window.scrollTo(0,0);
    document.querySelector(".step3").classList.remove("done")
    document.querySelector(".Q3p").classList.add("hidden")
    // console.log("added 'hidden' to Q3p")
    document.querySelector(".Q2p").classList.remove("hidden")
    document.querySelector(".Q2p-nav").classList.remove("hidden")
    document.querySelector(".Q3p-nav").classList.add("hidden")
    // console.log("removed 'hidden' from Q2p")
})

// //  Question 3 ----------------------------------------------------------------



var btn_2v_Prev = document.querySelector("#btn_2v_prev")
// console.log(btn_2v_Prev)
btn_2v_Prev.addEventListener("click",function(){
    window.scrollTo(0,0);
    document.querySelector(".step2").classList.remove("done")
    document.querySelector(".Q2v").classList.add("hidden")
    document.querySelector(".volunteerFormBox").classList.add("hidden")
    // console.log("added 'hidden' to Q2v")
    document.querySelector(".Q1").classList.remove("hidden")
    // console.log("removed 'hidden' from Q1")
})

//Question 2(volunteer)
var btn_2v_Next = document.querySelector("#btn_2v_next")
// console.log(btn_2v_Next)
btn_2v_Next.addEventListener("click",function(){

    window.scrollTo(0,0);
    document.querySelector(".step3").classList.add("done")
    document.querySelector(".Q2v").classList.add("hidden")
    document.querySelector(".Q2v-nav").classList.add("hidden")
    // console.log("added 'hidden' to Q2v")
    document.querySelector(".Q3v").classList.remove("hidden")
    document.querySelector(".Q3v-nav").classList.remove("hidden")
    // console.log("removed 'hidden' from Q3v")
    // }
})


var btn_3v_Prev = document.querySelector("#btn_3v_prev")
// console.log(btn_3v_Prev)
btn_3v_Prev.addEventListener("click",function(){
    window.scrollTo(0,0);
    document.querySelector(".step3").classList.remove("done")
    document.querySelector(".Q3v").classList.add("hidden")
    // console.log("added 'hidden' to Q3v")
    document.querySelector(".Q2v").classList.remove("hidden")
    document.querySelector(".Q2v-nav").classList.remove("hidden")
    document.querySelector(".Q3v-nav").classList.add("hidden")
    // console.log("removed 'hidden' from Q2v")
})



function pickBiro(biroName){
    document.querySelector("#notice2").classList.add("hidden")
    removeallcheck();
    biro = "#"+biroName
    document.querySelector(biro).checked = true;
    desc_biro="#desc-"+biroName;
    document.querySelector("#biro-desc").innerHTML = document.querySelector(desc_biro).innerHTML;

}


function removeallcheck(){
    var array = document.querySelectorAll(".checkB")
    array.forEach(element => {
        // console.log(element)
        element.checked = false;
    });
}

function submitForms(){
    console.log("submit form has been clicked")
    if(registrationType==0){//participant
       console.log(document.querySelector("#formP").submit())
    }
    if(registrationType==1){//participant
        console.log(document.querySelector("#formV").submit())
    }
}

function goback(){
    history.back();
    // window.location.href = window.localStorage.getItem("lastpage")
}
