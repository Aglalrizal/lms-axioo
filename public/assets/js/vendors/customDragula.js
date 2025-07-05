"use strict";

function forcePassiveFalse(el) {
    el.addEventListener("touchstart", function () {}, { passive: false });
    el.addEventListener("touchmove", function () {}, { passive: false });
}

document.addEventListener("DOMContentLoaded", function () {
    // Loop semua container faq
    document.querySelectorAll('[id^="faqList-"]').forEach((el) => {
        forcePassiveFalse(el);

        const categoryId = el.getAttribute("data-category-id");
        const drake = dragula([el]);

        drake.on("drop", function (el, target, source, sibling) {
            const items = Array.from(target.querySelectorAll(".faq-item"));
            const orderedData = items.map((item, index) => ({
                id: item.dataset.faqId,
                order: index + 1,
                category_id: categoryId,
            }));

            fetch("/admin/faq/reorder", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({ data: orderedData }),
            }).catch((err) => {
                console.error("Failed to reorder FAQs", err);
            });
        });
    });

    // Tetap inisialisasi kanban kalau masih digunakan
    const kanbanLists = [
        "#kanbanDo",
        "#kanbanProgress",
        "#kanbanReview",
        "#kanbanDone",
    ]
        .map((id) => document.querySelector(id))
        .filter((el) => el !== null);

    if (kanbanLists.length > 0) {
        dragula(kanbanLists);
    }
});
