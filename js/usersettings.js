function openLink(event, target) {
    var i, x,y, tablinks;
    x = document.getElementsByClassName("option");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
    }

    y = document.getElementsByClassName("details")
    for(i = 0; i < y.length; i++){      //closes other details
        y[i].style.display="none";
    }

    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < x.length; i++) {
      tablinks[i].className = tablinks[i].className.replace("w3-blue", "");
    }
    
    document.getElementById(target).style.display = "block";
    event.currentTarget.className += " w3-blue";    //adds color after pressed
    
  }

 /* function onClick(){
    window.alert("Account has been deactivated successfully")
  }
*/