const inputs = document.querySelectorAll(".input");
const btn = document.getElementById("modalbtn");
const modal = document.getElementById("modal");

function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}


inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});

btn.addEventListener("click", function() {
	modal.style.opacity = 1;
	modal.style.visibility = "visible";
});
