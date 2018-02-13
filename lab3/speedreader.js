"use strict";
//alert("LETS THE GAMES BEGIN, ok?")
var timer = null;
frames = [];
var punctuation = ",.!?;:";
var speed = 500;
var currentSpeed = 0;

window.onload = function(){
    document.getElementById("start").addEventListener("click",start);
    document.getElementById("stop").addEventListener("click",stop);
    document.getElementById("medium").addEventListener("click",fontSize);
    document.getElementById("big").addEventListener("click",fontSize);
    document.getElementById("bigger").addEventListener("click",fontSize);

};


function start(){
    //alert("*t")

    var startButton = document.getElementById("start");
    var stopButton = document.getElementById("stop");
    var textBox = document.getElementById("inputbox");
    var words = textBox.value.split(/[ \t\n]+/);
    for (var i = 0; i < words.length; i++){
        var len = words[i].length;
        var finalChar = words[i][len-1];
        for(var k = 0; k < 6; k++){
            if(finalChar === punctuation.charAt(k)){
                words[i] = words[i].slice(0,len-1);
                frames.push(words[i]);
                k = 6;
            }
        }
        frames.push(words[i]);
    }

    textBox.disabled = true;
    startButton.disabled = true;
    stopButton.disabled = false;

    speed = document.getElementById("speeds").value;
    currentSpeed = speed;
    setTimer();
}
function stop(){
    var startButton = document.getElementById("start");
    var stopButton = document.getElementById("stop");
    stopButton.disabled = true;
    startButton.disabled = false;
    document.getElementById("inputbox").disabled = false;
    frames = [];

    var output = document.getElementById("readbox");
    output.innerHTML="";
    clearInterval(timer);

}
function fontSize(){
    document.getElementById("readbox").style.fontSize = this.value;
}

function displayWord() {
    speed = document.getElementById("speeds").value;
    if(speed !== currentSpeed){
        clearInterval(timer);
        setTimer();
    }
        var output = document.getElementById("readbox");
        if (frames.length > 0) {
            output.innerHTML = frames.shift();
        } else {
            clearInterval(timer);
            var startButton = document.getElementById("start");
            var stopButton = document.getElementById("stop");
            stopButton.disabled = true;
            startButton.disabled = false;
            document.getElementById("inputbox").disabled = false;
            frames = [];
        }
}
 function setTimer(){
    currentSpeed = speed;
    timer = setInterval(displayWord,speed);

 }