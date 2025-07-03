document.querySelectorAll('[data-toggle="password"]').forEach((toggleIcon) => {
    toggleIcon.addEventListener("click", function () {
        const targetSelector = this.getAttribute("data-target");
        const passwordField = document.querySelector(targetSelector);

        if (!passwordField) return;

        const type =
            passwordField.getAttribute("type") === "password"
                ? "text"
                : "password";
        passwordField.setAttribute("type", type);

        // Toggle eye icon
        this.classList.toggle("bi-eye");
        this.classList.toggle("bi-eye-slash");
    });
});
