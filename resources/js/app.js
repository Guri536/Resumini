import './bootstrap';
import { LoremIpsum } from 'lorem-ipsum';
import { genDisplayElements } from './emdDisplay';
import { crtEleClass } from './crtEle';

window.AIRes = 0
window.UserRes = 0
// const lorem = new LoremIpsum({
//     sentencesPerParagraph: {
//         max: 8,
//         min: 4
//     },
//     wordsPerSentence: {
//         max: 16,
//         min: 4
//     }
// });

let input = document.getElementById('qInput');
if (input) {
    input.addEventListener('input', autoResize);
    function autoResize() {
        input.style.height = 'auto';
        let scrl = input.scrollHeight;
        input.style.height = Math.min(scrl, 120) + 'px';
        input.style.overflowY = scrl > 120 ? 'auto' : 'hidden';
    }
    autoResize();
    input.addEventListener('keydown', function (event) {
        if (event.key == 'Enter' && !event.shiftKey && (input.value != "" || input.value != null)) {
            updateMBox(1, input.value);
            setInput();
        }
    });
}



function setInput() {
    input.value = "";
    input.disabled = !input.disabled;
    input.placeholder = input.disabled ? "Waiting For Response" : "Converse With Reshumi";
    if (!input.disabled) input.focus();
    autoResize();
}

function getOuterTemplate(type) {
    return "flex w-full justify-" + (type == 0 ? "start" : "end");
}
function getMidTemplate(type) {
    return "p-2 min-w-[20px] w-auto max-w-6xl text-wrap mb-2 text-justify relative " + (type == 0 ? "bg-ternary text-ternary rounded-r-lg rounded-tl-lg invBor" : "bg-quat text-quat rounded-l-lg rounded-tr-lg invBor2")
}

function getAnimCircle(delay) {
    let circle = crtEleClass("div", "animCircle");
    circle.style = "animation-delay: " + delay + "s";
    return circle;
}

function addAnimEle(box, delay) {
    box.append(getAnimCircle(delay));
}

function addMessageElement(type) {
    let mBox = document.getElementById('chatBox');
    var outter = crtEleClass("div", getOuterTemplate(type))
    var mid = crtEleClass("div", getMidTemplate(type));
    var inner = crtEleClass("div", "text-gray-800");
    inner.id = (type == 0 ? "Balt" + AIRes++ : "User" + UserRes++)
    outter.appendChild(mid);
    mid.appendChild(inner);
    mBox.appendChild(outter);
    return inner;
}

function addAnimationToMessage(inner) {
    var animBox = crtEleClass("div", "flex justify-center relative");
    animBox.id = "anim1";
    inner.append(animBox);
    var animDelay = 0.0;
    for (let i = 0; i < 3; i++) {
        addAnimEle(animBox, animDelay);
        animDelay += 0.15;
    }
}

function updateMBox(type, text) {
    let inner = addMessageElement(type);
    inner.scrollIntoView({ behavior: 'smooth' })
    if (type == 1) {
        inner.append(text)
        updateMBox(0, text)
    } else {
        addAnimationToMessage(inner);
        ajaxReq(text, inner);
    }
}

async function updateResponse(res, inner) {

    inner.innerHTML = "";
    const pointer = crtEleClass("span", "");
    pointer.innerHTML = "█";
    const textBox = crtEleClass("div");
    inner.append(textBox);
    inner.append(pointer);
    for (var i in res) {
        if (res[i] == '\n') {
            textBox.innerHTML += "<br>";
        } else {
            textBox.innerHTML += res[i];
        }
        inner.scrollIntoView({ behavior: 'smooth', block: 'end' })
        await new Promise(resolve => setTimeout(resolve, 2));
    }
    pointer.remove();
    document.getElementById("chatBox").scrollTo({
        top: document.getElementById("chatBox").scrollHeight,
        behavior: 'smooth'
    });
    if (res == "Failed To Launch. Retry.") {
        input.placeholder = "Unable to Connect: Reload, and try again, or later.";
        input.style = "background-color: #AA2222; color: #FFF";
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
        success: function (res) {
            // console.log(res['original']);
            // console.log(res['original']['con']);
            updateResponse(res['original']['res'], ele);
            if ('tex' in res['original']) {
                getTex(res['original']['tex'])
            }
        }
    });
}

if (AIRes == 0 && input) {
    setInput();
    $.ajax({
        url: '/clearChat',
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: 'POST',
        success: function (res) {
            updateMBox(0, "Generate");
        }
    });
} 

function getTex(tex) {
    let inner = addMessageElement(0);
    addAnimationToMessage(inner);
    $.ajax({
        url: '/getTex',
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        data: {
            'tex': tex
        },
        method: 'POST',
        success: function (res) {
            inner.innerHTML = "";
            genDisplayElements(inner, res['pdf'], res['tex']);
        }
    })
}


