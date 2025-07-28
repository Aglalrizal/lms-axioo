Dropzone.autoDiscover = !1;
const myDropzone = new Dropzone("#my-dropzone", {
    url: "/",
    maxFilesize: 5,
    acceptedFiles: "image/*",
    addRemoveLinks: !0,
    autoProcessQueue: !1,
});

myDropzone.on("addedfile", function (file) {
    if (myDropzone.files.length > 1) {
        myDropzone.removeFile(myDropzone.files[0]);
    }

    Livewire.first().upload("form.photo", file);
});

myDropzone.on("removedfile", function (file) {
    Livewire.first().set("form.photo", null);
});

myDropzone.on("complete", function (file) {
    myDropzone.removeFile(file);
});
