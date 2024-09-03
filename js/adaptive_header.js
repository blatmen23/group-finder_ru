function adaptManualBlock() {
  const long_sublogo = "Сайт студентов КНИТУ-КАИ";
  const short_sublogo = "Сайт студентов";
  const sublogo = document.getElementById("sublogo-text");

  if (670 < window.innerWidth) {
    sublogo.innerText = long_sublogo;
  } else if (window.innerWidth > 428 && window.innerWidth < 670) {
    sublogo.innerText = short_sublogo;
  } else {
    sublogo.innerText = "";
  }
}

window.addEventListener("resize", adaptManualBlock);
document.addEventListener("DOMContentLoaded", adaptManualBlock);
