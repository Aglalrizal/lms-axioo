var quill,
    editorElement = document.querySelector("#editor");

// Custom image handler for Quill - converts to base64
function imageHandler() {
    const input = document.createElement("input");
    input.setAttribute("type", "file");
    input.setAttribute("accept", "image/*");
    input.click();

    input.onchange = () => {
        const file = input.files[0];
        if (file) {
            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert("Ukuran gambar terlalu besar. Maksimal 2MB.");
                return;
            }

            // Validate file type
            if (!file.type.startsWith("image/")) {
                alert("File harus berupa gambar.");
                return;
            }

            const reader = new FileReader();
            reader.onload = () => {
                const range = quill.getSelection();

                // Insert image as base64
                quill.insertEmbed(range.index, "image", reader.result, "user");
                quill.setSelection(range.index + 1);
            };
            reader.readAsDataURL(file);
        }
    };
}

editorElement &&
    (quill = new Quill(editorElement, {
        modules: {
            toolbar: {
                container: [
                    [{ header: [1, 2, false] }],
                    [{ font: [] }],
                    ["bold", "italic", "underline", "strike"],
                    [{ size: ["small", false, "large", "huge"] }],
                    [{ list: "ordered" }, { list: "bullet" }],
                    [{ color: [] }, { background: [] }, { align: [] }],
                    ["link", "image", "code-block"],
                    ["clean"],
                ],
                handlers: {
                    image: imageHandler,
                },
            },
        },
        theme: "snow",
    }));

//// Konten asli dari file
// var quill,
//     editorElement = document.querySelector("#editor");
// editorElement &&
//     (quill = new Quill(editorElement, {
//         modules: {
//             toolbar: [
//                 ["bold", "italic", "underline", "strike"], // toggled buttons
//                 ["blockquote", "code-block"],
//                 ["link", "image", "video", "formula"],

//                 [{ header: 1 }, { header: 2 }], // custom button values
//                 [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
//                 [{ script: "sub" }, { script: "super" }], // superscript/subscript
//                 [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
//                 [{ direction: "rtl" }], // text direction

//                 [{ size: ["small", false, "large", "huge"] }], // custom dropdown
//                 [{ header: [1, 2, 3, 4, 5, 6, false] }],

//                 [{ color: [] }, { background: [] }], // dropdown with defaults from theme
//                 [{ font: [] }],
//                 [{ align: [] }],

//                 ["clean"], // remove formatting button
//             ],
//         },
//         theme: "snow",
//     }));
