function isMobileDevice() {
    if (/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Kindle|NetFront|Silk-Accelerated|(hpw|web)OS|Fennec|Minimo|Opera M(obi|ini)|Dolfin|Skyfire|Zune/.test(navigator.userAgent)) {
        // alert("This is a mobile device");
        return true;
    } else {
        // alert("This is not a mobile device");
        return false;
    }
}

function adaptHTML() {
    let selectElements = document.querySelectorAll('select[multiple]');
    for (let i = 0; i < selectElements.length; i++) {
        // удаляем элемент "Выбрать всё"
        selectElements[i].removeChild(selectElements[i].firstElementChild);

        // в теге span удаляем "(_/6)"
        let spanElement = selectElements[i].parentElement.querySelector('span');
        spanElement.textContent = spanElement.textContent.slice(0, -6);

        // обновляем , условно перезагружаем элемент
        let select = selectElements[i].cloneNode(true);
        selectElements[i].parentNode.replaceChild(select, selectElements[i]);
    }
}

if (isMobileDevice()) {// || true
    adaptHTML();
}


// const divToMove = document.getElementById('movement-manual');
// const container = document.getElementById('movement-space');
//
// window.addEventListener('resize', function() {
//     console.log("resize");
//     if (window.innerWidth < 768) {
//         container.insertBefore(divToMove, container.firstChild);
//     } else {
//         container.appendChild(divToMove);
//     }
// });

function adaptManualBlock() {
    const divToMove = document.getElementById('movement-manual');
    const movementSpace = document.getElementById("movement-space")
    const moveParent_1 = document.getElementById('moving-parent_1');
    const moveParent_2 = document.getElementById('moving-parent_2');

    if (window.innerWidth < 768) {
        movementSpace.insertBefore(divToMove, moveParent_2.nextSibling);
        // console.log(moveParent_2.nextSibling);
    } else {
        moveParent_1.appendChild(divToMove);
        // console.log(moveParent_1.nextSibling);
    }
}

window.addEventListener('resize', adaptManualBlock);

document.addEventListener('DOMContentLoaded', adaptManualBlock);