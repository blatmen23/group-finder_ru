function selectAllElements(selectElement) {
    const options = selectElement.getElementsByTagName("option");
    for (let i = 1; i < options.length; i++) {
        options[i].setAttribute('selected', 'selected');
    }
}

function unSelectAllElements(selectElement) {
    const options = selectElement.getElementsByTagName("option");
    for (let i = 1; i < options.length; i++) {
        options[i].removeAttribute('selected');
    }
}

function getNumberSelected(selectElement) {
    const options = selectElement.getElementsByTagName("option");

    let count = 0;
    for (let i = 1; i < options.length; i++) {
        if (options[i].selected) {
            count++;
        }
    }
    return count;
}

function updateCounterText(selectElement, spanElement, number){
    let child_count = selectElement.children.length - 1; // span не считаем
    spanElement.textContent = spanElement.textContent.slice(0, -5) + `(${number}/${child_count})`;
}

window.addEventListener("mousedown", function (e) {
    let el = e.target;
    let selectElement = el.parentElement;
    let spanElement = el.parentElement.parentElement.querySelector('span');
    if (!(el.tagName.toLowerCase() === 'option' && el.parentNode.hasAttribute('multiple'))) {
        return;
    }
    if (el.value === '0') { // если нажато "выбрать всё"
        if (el.hasAttribute('selected')) unSelectAllElements(selectElement);
        else selectAllElements(selectElement);
    }
    else {
        if (selectElement.firstElementChild.hasAttribute('selected')) selectElement.firstElementChild.removeAttribute('selected');
    }
    e.preventDefault();

    if (el.hasAttribute('selected')) el.removeAttribute('selected');
    else el.setAttribute('selected', '');

    let select = el.parentNode.cloneNode(true);
    el.parentNode.parentNode.replaceChild(select, el.parentNode);

    updateCounterText(selectElement, spanElement, getNumberSelected(selectElement));
});