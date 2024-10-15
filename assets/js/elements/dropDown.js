function initDropDown(button){
    const dropdown = document.querySelector("#"+button.getAttribute("data-dropdown-toggle"));
    button.addEventListener("click", () => toggleDropdown(button, dropdown));

    // Close the dropdown when clicking outside
    document.addEventListener("click", (event) => {
      if (!button.contains(event.target) && !dropdown.contains(event.target)) {
        button.setAttribute("aria-expanded", "false");
        dropdown.classList.add("hidden");
      }
    });
}

function toggleDropdown(button, dropdown){
    const expanded = button.getAttribute("aria-expanded") === "true";
    button.setAttribute("aria-expanded", !expanded);
    dropdown.classList.toggle("hidden", expanded);
}
