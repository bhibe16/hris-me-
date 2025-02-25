import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Toggle sidebar collapse
document
    .getElementById("toggle-sidebar")
    .addEventListener("click", function () {
        const sidebar = document.getElementById("sidebar");
        const toggleIcon = document.getElementById("toggle-icon");

        // Toggle collapsed state
        sidebar.classList.toggle("collapsed");
        toggleIcon.classList.toggle("rotate-180");

        // Auto-close all dropdowns when sidebar is collapsed
        if (sidebar.classList.contains("collapsed")) {
            document.querySelectorAll(".submenu").forEach((submenu) => {
                submenu.classList.add("hidden");
            });
            document.querySelectorAll(".dropdown-icon").forEach((icon) => {
                icon.classList.remove("rotate-90");
            });
        }
    });

// Toggle dropdowns
function toggleDropdown(id) {
    const submenu = document.getElementById(`${id}-submenu`);
    const icon = document.getElementById(`${id}-icon`);

    if (submenu.classList.contains("hidden")) {
        submenu.classList.remove("hidden");
        icon.classList.add("rotate-90");
    } else {
        submenu.classList.add("hidden");
        icon.classList.remove("rotate-90");
    }
}

// Auto unhide sidebar when any icon or link is clicked
document
    .querySelectorAll("#sidebar ul li a, #sidebar ul li button")
    .forEach((element) => {
        element.addEventListener("click", function () {
            const sidebar = document.getElementById("sidebar");
            if (sidebar.classList.contains("collapsed")) {
                sidebar.classList.remove("collapsed");
                document
                    .getElementById("toggle-icon")
                    .classList.remove("rotate-180");
            }
        });
    });
