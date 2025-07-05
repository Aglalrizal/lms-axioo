function openEditModal(el) {
    const faq = JSON.parse(el.dataset.faq); // Ambil data dari attribute
    console.log(faq); // Untuk debug

    const form = document.getElementById("faqForm");
    form.action = `/admin/faq/${faq.id}`;
    document.getElementById("formMethod").value = "PUT";

    document.getElementById("addFaqModalLabel").textContent = "Edit FAQ";
    document.getElementById("question").value = faq.question;
    document.getElementById("answer").value = faq.answer;
    document.getElementById("faq_category_id").value = faq.faq_category_id;
    document.getElementById("save-btn").textContent = "Update";

    const modal = new bootstrap.Modal(document.getElementById("addFaqModal"));
    modal.show();
}
