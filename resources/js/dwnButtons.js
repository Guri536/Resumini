function getClasses(){
    return "inline-flex items-center px-3 py-1.5 mx-1 bg-green-700 border rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-900 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150 hover:ring-2 hover:ring-green-300";
}

function setPDF(base64){
    const byteChar = atob(base64);
    const byteNum = new Array(byteChar.length);
    for(let i = 0; i < byteChar.length; i++){
        byteNum[i] = byteChar.charCodeAt(i)
    }
    const byteArray = new Uint8Array(byteNum);
    let blob = new Blob([byteArray], {type: "application/pdf"});
    let Url = URL.createObjectURL(blob);
    return Url;
}

function setTex(base64){
    let blob = new Blob([atob(base64)], {type: "application/x-latex"});
    let Url = URL.createObjectURL(blob);
    return Url;
}

export function createButton(type, base64){
    const dwnLink = document.createElement("a");
    const dwnButton = document.createElement("button");
    dwnButton.className = getClasses();
    dwnButton.innerHTML = type;
    dwnLink.append(dwnButton);

    if(type == 'PDF' || type == 'pdf'){
        dwnLink.href = setPDF(base64);
    } else {
        dwnLink.href = setTex(base64);
    }

    dwnLink.download = "output." + type;
    return dwnLink;
}
