const modal = document.querySelector("#modal");
const modalOpener = document.querySelector("#modal-opener");
const modalCloser = document.querySelector("#modal-closer");
const notifications = document.querySelectorAll(".notification");

notifications.forEach((notification) => notification.onclick = ({ target }) => target.remove());

modalOpener.addEventListener("click", function (event) {
    event.preventDefault();
    modal.style.display = "flex";
    setTimeout(() => modal.style.opacity = 1, 1);
});

modalCloser.addEventListener("click", function (event) {
    event.preventDefault();
    modal.style.opacity = 0;
    setTimeout(() => modal.style.display = "none", 1000);
});