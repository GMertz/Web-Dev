"use strict";

var blank = null;
window.onload = function(){
    var puz = document.getElementById("puzzlearea");
    document.getElementById("shufflebutton").addEventListener("click",shuffle);
    for(var x = 0; x < 4; x++){
        for(var y = 0; y < 4; y++){
            var blok = document.createElement('div');
            var number = (y*4)+x + 1;
            if(number === 16){
                blok.classList.add('blank');
                blok.id = String(x)+String(y);
            }else{
                blok.className = 'pieces';
                blok.innerHTML = number;
                blok.id = String(x)+String(y);
                blok.addEventListener("mouseover",check);
                blok.addEventListener("click",move);

            }
            blok.style.backgroundPosition = String(-100*x) + "px" + " " + String(-100*y) + "px";
            blok.style.top = 100*y + 'px';
            blok.style.left = 100*x + 'px';

            puz.append(blok);
        }
    }
    blank = document.querySelector("div.blank");
};

function moveTile(tile){
    tile.style.top = (parseInt(blank.id[1])*100) + 'px';
    tile.style.left = (parseInt(blank.id[0])*100)+ 'px';
    blank.style.top= (parseInt(tile.id[1])*100) + 'px';
    blank.style.left= (parseInt(tile.id[0])*100) + 'px';
    var temp = new String(tile.id);
    tile.id = new String(blank.id);
    blank.id = temp;
}
function check(){
    var diffx = Math.abs(parseInt(this.id[0])- blank.id[0]);
    var diffy = Math.abs(parseInt(this.id[1])- blank.id[1]);
    if((diffy == 1 && diffx == 0) || (diffx ==1 && diffy == 0)){
        this.classList.add("moveable");

    }else{
        this.classList.remove("moveable");
    }
}
function move(){
    var diffx = Math.abs(parseInt(this.id[0]) - blank.id[0]);
    var diffy = Math.abs(parseInt(this.id[1]) - blank.id[1]);
    if((diffy == 1 && diffx == 0) || (diffx ==1 && diffy == 0)){
        moveTile(this);
    }
}
function shuffle(){
    var blocks = document.querySelector("div.pieces");

    for(var i = 0; i < 1000; i++){
        var x = parseInt(blank.id[0]);
        var y = parseInt(blank.id[1]);
        var moves = [];
        if(x+1 < 4){moves.push([x+1,y]);}
        if(x-1 >= 0){moves.push([x-1,y]);}
        if(y+1 < 4){moves.push([x,y+1]);}
        if(y-1 >= 0){moves.push([x,y-1]);}
        var move = Math.floor(Math.random() * moves.length);
        moveTile(document.getElementById(String(moves[move][0])+String(moves[move][1])));
    }
}