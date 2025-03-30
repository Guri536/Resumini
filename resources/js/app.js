import './bootstrap';
import { LoremIpsum } from 'lorem-ipsum';
import { genDisplayElements } from './emdDisplay';

window.AIRes = 0
window.UserRes = 0
const lorem = new LoremIpsum({
    sentencesPerParagraph: {
        max: 8,
        min: 4
    },
    wordsPerSentence: {
        max: 16,
        min: 4
    }
});


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

function setInput() {
    let input = document.getElementById('qInput');
    input.value = "";
    input.disabled = !input.disabled;
    input.placeholder = input.disabled ? "Waiting For Response" : "Converse With Baltimore";
    if (!input.disabled) input.focus();
}

function updateMessage() {
    let input = document.getElementById('qInput');
    updateMBox(1, input.value);
}

function getOuterTemplate(type) {
    return "flex w-full justify-" + (type == 0 ? "start" : "end");
}
function getMidTemplate(type) {
    return "p-2 min-w-[20px] w-auto max-w-6xl text-wrap mb-2 text-justify relative " + (type == 0 ? "bg-ternary text-ternary rounded-r-lg rounded-tl-lg invBor" : "bg-quat text-quat rounded-l-lg rounded-tr-lg invBor2")
}

function getAnimCircle(delay) {
    let circle = document.createElement("div");
    circle.className = "animCircle";
    circle.style = "animation-delay: " + delay + "s";
    return circle;
}

function addAnimEle(ele, delay) {
    let box = document.getElementById(ele);
    box.append(getAnimCircle(delay));
}

function addMessageElement(type) {
    let mBox = document.getElementById('chatBox');
    var outter = document.createElement("div");
    var mid = document.createElement("div");
    var inner = document.createElement("div");
    outter.className = getOuterTemplate(type);
    mid.className = getMidTemplate(type);
    inner.className = "text-gray-800";
    inner.id = (type == 0 ? "Balt" + AIRes++ : "User" + UserRes++)
    outter.appendChild(mid);
    mid.appendChild(inner);
    mBox.appendChild(outter);
    return inner.id;
}

function addAnimationToMessage(inner) {
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
    document.getElementById(inner).scrollIntoView({ behavior: 'smooth' })
    if (type == 1) {
        document.getElementById(inner).append(text)
        updateMBox(0, text)
    } else {
        addAnimationToMessage(document.getElementById(inner));
        ajaxReq(text, inner);
    }
}

async function updateResponse(res, ele) {
    let inner = document.getElementById(ele);
    inner.innerHTML = "";
    for (var i in res) {
        if (res[i] == '\n') {
            inner.innerHTML += "<br>";
        } else {
            inner.innerHTML += res[i];
        }
        inner.scrollIntoView({ behavior: 'smooth', block: 'end' })
        await new Promise(resolve => setTimeout(resolve, 10));
    }
    document.getElementById("chatBox").scrollTo({
        top: document.getElementById("chatBox").scrollHeight,
        behavior: 'smooth'
    });
    if (res == "Failed To Launch. Retry.") {
        let ele = document.getElementById("qInput")
        ele.placeholder = "Unable to Connect: Reload, and try again, or later.";
        ele.style = "background-color: #AA2222; color: #FFF";
    } else {
        setInput();
    }
}

function ajaxReq(prompt, ele) {
    $.ajax({
        url: '/getRes',
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: 'POST',
        data: {
            'prompt': prompt,
        },
        success: res => updateResponse(res, ele)
    });
}

if (AIRes == 0) {
    setInput();
    $.ajax({
        url: '/clearChat',
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: 'POST',
        success: function () {
            updateMBox(0, "Greet the User. Keep it short");
        }
    });
}

window.getTex = function getTex(){
    let inner = addMessageElement(0);
    let dis = document.getElementById(inner);
    addAnimationToMessage(dis);
    $.ajax({
        url: '/getTex',
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: 'POST',
        success: function(res){
            dis.innerHTML = "";
            genDisplayElements(dis, res['pdf'], res['tex']);
        }
    })
}


