import './bootstrap';


window.inputEnter = function inputEnter() {
    if (event.key == 'Enter') {
        let input = document.getElementById('qInput');
        if (input.value == "" || input.value == null) {
            null
        } else {
            updateMessage();
            input.value = "";
            input.disabled = true;
            input.placeholder = "Waiting For Response";
        }
    }
}

function updateMessage() {
    let input = document.getElementById('qInput');
    updateMBox(input.value);
}

function getOuterTemplate(type){
    return "flex w-full justify-" + (type == 0? "start": "end");
}
function getMidTemplate(type){
    return "p-2 min-w-[20px] w-auto max-w-4xl text-wrap mb-2 text-justify relative " + (type == 0? "bg-ternary text-ternary rounded-r-lg rounded-tl-lg invBor" : "bg-quat text-quat rounded-l-lg rounded-tr-lg invBor2")
}

function updateMBox(text, type) {
    let mBox = document.getElementById('chatBox');
    var outter = document.createElement("div");
    var mid = document.createElement("div");
    var inner = document.createElement("div");
    outter.className = getOuterTemplate(type);
    mid.className = getMidTemplate(type);
    inner.className = "text-gray-800";
    outter.appendChild(mid);
    mid.appendChild(inner);
    inner.append(text);
    mBox.appendChild(outter);
}

window.updResponse = function updateResponse(res) {
    var addRes = "";
    for (var i in res) {
        if (res[i] == '\n') {
            addRes += '<br>';
        } else {
            addRes += res[i];
        }
    }
    document.getElementById("AI1").innerHTML = addRes;
    console.log(res);
}
window.test1 = function(){console.log(AIRes)}
window.AIRes = 0
window.UserRes = 0

window.ajaxReq = function(prompt){
    fetch('/getRes', {
        method: 'POST',
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        data: {
            'prompt': "hello"
        }
    }).then(response => response.json())
    .then(data => {
        console.log('Laravel response:', data);
    });
}

if(AIRes == 0){
    updateMBox("Wow", 0);
    updateMBox("Man", 1);
    ajaxReq("Greet the user");
}
