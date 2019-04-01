//Record input's max height
var inputel = document.getElementById("input").firstElementChild;
var max = window.getComputedStyle(inputel).getPropertyValue("max-height");
max = parseInt(max);

function expand_textarea(element){
    element.style.height = "5px";
    element.style.height = clampMax((element.scrollHeight + 5), max) + "px";
}

function clampMax(a, max){
    return a > max ? max : a;
}