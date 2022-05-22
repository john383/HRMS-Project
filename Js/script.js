function switchForm(className, e) {
    e.preventDefault();
    const allForm = document.querySelectorAll("form");
    const form = document.querySelector("form.${className}");

    allForm.forEach((item) => {
        item.classList.remove("active");
    });
    form.classList.add("active");
}
let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
        arrowParent.classList.toggle("showMenu");
    });
}
