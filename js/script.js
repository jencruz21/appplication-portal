const link_choices = document.getElementById("link_choices");
const link_section = document.getElementById("link_section");

link_choices.onchange = function(event) {
    let value = event.target.value;

    if (value == "yes") {
        const input_node = document.createElement("input");
        input_node.id = "link_input";
        input_node.type = "text";
        input_node.className = "form-control mb-3";
        input_node.placeholder = "enter-link";
        input_node.name = "link_input";
        link_section.appendChild(input_node);
        return;
    } else {
        const link_input = document.getElementById("link_input");
        link_section.removeChild(link_input);
        return;
    } 
};