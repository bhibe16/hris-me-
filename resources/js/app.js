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


    let timeout;

    // Get CSRF token and logout URL from meta tags
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const logoutUrl = document.querySelector('meta[name="logout-url"]').content;
    
    function startTimer() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            logoutUser();
        }, 500000); // 5 minutes
    }
    
    function logoutUser() {
        fetch(logoutUrl, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json"
            },
            credentials: "same-origin"
        }).then(() => {
            window.localStorage.clear(); // Clear session storage
            window.location.href = "/login?session_expired=true"; // Redirect to login with message
        });
    }
    
    // Listen for user activity to reset the timer
    document.addEventListener("mousemove", startTimer);
    document.addEventListener("keydown", startTimer);
    document.addEventListener("click", startTimer);
    document.addEventListener("scroll", startTimer);
    
    startTimer();
    


