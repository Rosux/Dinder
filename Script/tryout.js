function like(div) {
    $('#' + div).css("transition", "1s linear");
    $('#' + div).addClass("accept-card");
    $('#' + div).css("opacity", "0%");
    $('#' + div).css("transform", "rotate(25deg)");
    setTimeout(function(){ $('#' + div).css("display", "none") }, 1000);
    $('#' + div).prop("onclick", null).off("click");
}
function deny(div) {
    $('#' + div).css("transition", "1s linear");
    $('#' + div).addClass("deny-card");
    $('#' + div).css("opacity", "0%");
    $('#' + div).css("transform", "rotate(-25deg)");
    setTimeout(function(){ $('#' + div).css("display", "none") }, 1000);
    $('#' + div).prop("onclick", null).off("click");
}

let x = true;
function lastcard(){
    // set messages in the chatbox
    // leuk je te ontmoeten
    if (x === true){
        x = false;
        animatechat();
        setTimeout(function(){
            addElement("Leuk je te zien. Zou je een lange gezelige wandeling willen maken?");
            animatechat();
        }, 2500);
        setTimeout(function(){
            addElement("Ikke wel hoor! Gezelig met de hond op pad. Kom en doe mee!");
            animatechat();
        }, 6000);
        setTimeout(function(){
            addElement("Schrijf jezelf <a href='aanmelden.php'>hier</a> in en mischien kunnen wij samen wel op pad :).");
            $("#chat-window").scrollTop($("#chat-window")[0].scrollHeight);
            animatechat();
        }, 10000);
    }
}

function animatechat(){
    setTimeout(function(){
        $('.chat-element').each(function(i, obj){
            obj.classList.add("chat-element-visible");
        });
    }, 20);
}

function addElement(text) {
    // create a new div element
    const chatdiv = document.createElement("div");
    chatdiv.classList.add("chat-element");
  
    const chatpic = document.createElement("div");
    chatpic.classList.add("chat-pic");
    chatdiv.appendChild(chatpic);
    
    // chat text
    const chattext = document.createElement("div");
    chattext.classList.add("chat-text");
    chatdiv.appendChild(chattext);
    
    chattext.innerHTML = text;
  
    // add the newly created element and its content into the DOM
    const chatwindow = document.getElementById("chat-window");
    chatwindow.appendChild(chatdiv);
}