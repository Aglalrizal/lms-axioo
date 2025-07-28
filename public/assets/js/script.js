function setUpPasswordToggle() {
    document
        .querySelectorAll('[data-toggle="password"]')
        .forEach((toggleIcon) => {
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
}

let quill;

function initQuillEditor() {
    const editorElement = document.querySelector("#editor");

    if (!editorElement) return;

    // Cegah duplikat Quill
    if (quill) {
        quill = null;
        editorElement.innerHTML = ""; // reset isi editor kalau perlu
    }

    quill = new Quill(editorElement, {
        modules: {
            toolbar: [
                ["bold", "italic", "underline", "strike"],
                ["blockquote", "code-block"],
                ["link", "image", "video", "formula"],
                [
                    {
                        header: 1,
                    },
                    {
                        header: 2,
                    },
                ],
                [
                    {
                        list: "ordered",
                    },
                    {
                        list: "bullet",
                    },
                    {
                        list: "check",
                    },
                ],
                [
                    {
                        script: "sub",
                    },
                    {
                        script: "super",
                    },
                ],
                [
                    {
                        indent: "-1",
                    },
                    {
                        indent: "+1",
                    },
                ],
                [
                    {
                        direction: "rtl",
                    },
                ],
                [
                    {
                        size: ["small", false, "large", "huge"],
                    },
                ],
                [
                    {
                        header: [1, 2, 3, 4, 5, 6, false],
                    },
                ],
                [
                    {
                        color: [],
                    },
                    {
                        background: [],
                    },
                ],
                [
                    {
                        font: [],
                    },
                ],
                [
                    {
                        align: [],
                    },
                ],
                ["clean"],
            ],
        },
        theme: "snow",
    });
}

document.addEventListener("DOMContentLoaded", () => {
    setUpPasswordToggle();
    initQuillEditor();
    $("#select-category").select2();
    $("#select-instructor").select2();
});
