import './bootstrap';

window.AIRes = 0
window.UserRes = 0

window.inputEnter = function inputEnter() {
    if (event.key == 'Enter') {
        let input = document.getElementById('qInput');
        if (input.value == "" || input.value == null) {
            null
        } else {
            updateMessage();
            setInput();
        }
    }
}

function setInput(){
    let input = document.getElementById('qInput');
    input.value = "";
    input.disabled = !input.disabled;
    input.placeholder = input.disabled? "Waiting For Response": "Converse With Baltimore";
    if(!input.disabled) input.focus();
}

function updateMessage() {
    let input = document.getElementById('qInput');
    updateMBox(1, input.value);
}

function getOuterTemplate(type) {
    return "flex w-full justify-" + (type == 0 ? "start" : "end");
}
function getMidTemplate(type) {
    return "p-2 min-w-[20px] w-auto max-w-4xl text-wrap mb-2 text-justify relative " + (type == 0 ? "bg-ternary text-ternary rounded-r-lg rounded-tl-lg invBor" : "bg-quat text-quat rounded-l-lg rounded-tr-lg invBor2")
}

function getAnimCircle(delay){
    let circle = document.createElement("div");
    circle.className = "animCircle";
    circle.style = "animation-delay: " + delay + "s";
    return circle;
}

function addAnimEle(ele, delay){
    let box = document.getElementById(ele);
    box.append(getAnimCircle(delay));
}

function addMessageElement(type){
    let mBox = document.getElementById('chatBox');
    var outter = document.createElement("div");
    var mid = document.createElement("div");
    var inner = document.createElement("div");
    outter.className = getOuterTemplate(type);
    mid.className = getMidTemplate(type);
    inner.className = "text-gray-800";
    inner.id = (type == 0? "Balt" + AIRes++ : "User" + UserRes++)
    outter.appendChild(mid);
    mid.appendChild(inner);
    mBox.appendChild(outter);
    return inner.id;
}

function addAnimationToMessage(inner){
    var animBox = document.createElement("div");
    animBox.id = "anim1";
    animBox.className = "flex justify-center relative";
    inner.append(animBox);
    var animDelay = 0.0;
    addAnimEle(animBox.id, animDelay);
    animDelay += 0.15;
    addAnimEle(animBox.id, animDelay);
    animDelay += 0.15;
    addAnimEle(animBox.id, animDelay);
}

function updateMBox(type, text) {
    let inner = addMessageElement(type);
    if(type == 1){
        document.getElementById(inner).append(text)
        updateMBox(0, "Users Response: {" + 
            text + "\
        }. Give an appropriate response."
        )
    } else{
        addAnimationToMessage(document.getElementById(inner));
        ajaxReq(text, inner);
    }
}

async function updateResponse(res, ele) {
    var addRes = "";
    let inner = document.getElementById(ele);
    inner.innerHTML = "";
    for (var i in res) {
        if (res[i] == '\n') {
            addRes += '<br>';
            inner.innerHTML += "<br>";
        } else {
            addRes += res[i];
            inner.innerHTML += res[i];
        }
        await new Promise(resolve => setTimeout(resolve, 10));
    }
    setInput();
}

function ajaxReq(prompt, ele) {
    $.ajax({
        url: '/getRes',
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: 'POST',
        data: {
            'prompt': prompt
        },
        success: res => updateResponse(res, ele)
    });
}

if (AIRes == 0) {
    setInput();
    updateMBox(0, "Greet the User. Keep it short");
}
