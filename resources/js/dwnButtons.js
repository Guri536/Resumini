function getClasses(){
    return "inline-flex items-center px-3 py-1.5 mx-1 bg-green-500/50 border rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500/60 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150 hover:ring-2 hover:ring-green-300";
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

function setTex(type, base64){
    let fltype = "";
    switch(type){
        case 'html':
            fltype = 'text/html'
            break;
        default:
            fltype = 'application/x-latex'
            break;
    }
    let blob = new Blob([atob(base64)], {type: fltype});
    let Url = URL.createObjectURL(blob);
    return Url;
}

function setDoc(base64){
    let dataURI = base64;
    if (!base64.startsWith('data:')) {
        dataURI = 'data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,' + base64;
    }
    return dataURI;
};

export function setOverleaf(base64){
    const formlink = document.createElement("form");
    const input = document.createElement('input')
    const submitButton = document.createElement('button');

    formlink.method = "post";
    formlink.action = "https://www.overleaf.com/docs";
    formlink.target = "_blank";

    input.type = "text";
    input.name = "snip_uri";
    input.value = "data:application/x-tex;base64," + base64;
    input.hidden = true;

    submitButton.type = "submit";
    submitButton.className = getClasses();
    submitButton.innerHTML = "Overleaf"

    formlink.append(input);
    formlink.append(submitButton);
    return formlink;
}

export function createButton(type, base64){
    const dwnLink = document.createElement("a");
    const dwnButton = document.createElement("button");
    dwnButton.className = getClasses();
    dwnButton.innerHTML = type;
    dwnLink.append(dwnButton);

    if(type == 'PDF' || type == 'pdf'){
        dwnLink.href = setPDF(base64);
    } else if(type == 'docx'){
        dwnLink.href = setDoc(base64);
    } else {
        dwnLink.href = setTex(type, base64);
    }

    dwnLink.download = "output." + type;
    return dwnLink;
}
