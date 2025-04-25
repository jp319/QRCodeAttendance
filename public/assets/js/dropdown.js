// Wait for the DOM to load

document.addEventListener("DOMContentLoaded", () => {
    const notificationButton = document.getElementById("user-menu-button");
    const notificationMenu = document.getElementById("notification-menu");

    notificationButton.addEventListener("click", (event) => {
        event.stopPropagation(); // Prevent event bubbling
        notificationMenu.classList.toggle("hidden");
    });

    document.addEventListener("click", () => {
        notificationMenu.classList.add("hidden"); // Hide dropdown when clicking outside
    });
});