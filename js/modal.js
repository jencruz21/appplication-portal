const btn = document.getElementById("modalbtn");
const submit = document.getElementById("submit");
const modal = document.getElementById("modalbox");
submit.cursor = "default";
submit.disabled = true;

btn.addEventListener("click", function() {
	modal.style.opacity = 1;
	modal.style.visibility = "visible";
	submit.disabled = false;
	submit.cursor = "pointer";
});