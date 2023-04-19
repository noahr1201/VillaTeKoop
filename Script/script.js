window.onload = function() {
    document.getElementById("popup").classList.add("active");
    setTimeout(function(){
        document.getElementById("popup").classList.remove("active");
    }, 5000);
    var popup = document.getElementById("popup");
    popup.style.display = "block";
    setTimeout(function(){
        popup.parentNode.removeChild(popup);
    }, 5000);
 }