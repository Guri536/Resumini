import { createButton } from './dwnButtons'; 
import { crtEleClass } from './crtEle';

function createEmbed(base64) {
    const pdfEmd = document.createElement("embed");
    pdfEmd.className = "rounded-md hidden md:block"
    pdfEmd.src = "data:application/pdf;base64, " + base64 + "#toolbar=0";
    pdfEmd.type = "application/pdf";
    pdfEmd.width = "396vw";
    pdfEmd.height = "543vh";
    return pdfEmd
}

export function genDisplayElements(ele, pdf64, tex64, html64, docx64) {
    let upCont = crtEleClass("div", "parent flex rounded-md bg-backTheme w-full p-1.5 mb-2 text-gray-200");
    let btnCont = crtEleClass("div", "flex h-full w-full justify-end");
    let labelCont = crtEleClass("div", "child content-center");
    let label = crtEleClass("div", "w-full text-nowrap text-lg");

    let pdfdis = createEmbed(pdf64);
    let pdfDwnBtn = createButton('pdf', pdf64);
    let texDwnBtn = createButton('tex', tex64);
    let htmlDwnBtn = createButton('html', html64);
    let docxDwnBtn = createButton('docx', html64);
    label.innerHTML = "Download:"

    labelCont.append(label);
    btnCont.append(pdfDwnBtn);
    btnCont.append(texDwnBtn);
    btnCont.append(htmlDwnBtn);
    btnCont.append(docxDwnBtn);
    upCont.append(labelCont);
    upCont.append(btnCont);
    ele.append(upCont);
    ele.append(pdfdis);
}