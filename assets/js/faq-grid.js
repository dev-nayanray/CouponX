 
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.querySelector('.faq-modal');
    const modalQuestion = modal.querySelector('.modal-question');
    const modalAnswer = modal.querySelector('.modal-answer');
    const closeBtn = modal.querySelector('.modal-close');
    const overlay = modal.querySelector('.modal-overlay');
    const faqButtons = document.querySelectorAll('.faq-more');

    faqButtons.forEach(button => {
        button.addEventListener('click', () => {
            const card = button.closest('.faq-card');
            const question = card.querySelector('.faq-question').textContent;
            const answer = card.querySelector('.faq-answer').innerHTML;

            modalQuestion.textContent = question;
            modalAnswer.innerHTML = answer;
            modal.classList.add('active');
        });
    });

    // Close modal
    closeBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    overlay.addEventListener('click', () => {
        modal.classList.remove('active');
    });
});
 
