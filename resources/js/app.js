import './bootstrap';

function inputEnter() {
    if (event.key == 'Enter') {
        let input = document.getElementById('qInput');
        if(input.value == "" || input.value == null ){
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
function updateMBox(text){
    let mBox = document.getElementById('chatBox');
    var outter = document.createElement("div");
    var mid = document.createElement("div");
    var inner = document.createElement("div");
    outter.className = "flex w-full justify-end";
    mid.className = "p-2 bg-quat rounded-l-lg rounded-tr-lg text-quat min-w-[20px] w-auto max-w-4xl text-wrap invBor2 mb-2 text-justify relative";
    inner.className = "text-gray-800";
    outter.appendChild(mid);
    mid.appendChild(inner);
    inner.append(text);
    mBox.appendChild(outter);
}

window.inputEnter = inputEnter;
window.updateMessage = updateMessage;