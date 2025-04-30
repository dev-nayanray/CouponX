document.addEventListener('DOMContentLoaded', function() {
    // Filtering functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    const couponCards = document.querySelectorAll('.coupon-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            const filter = btn.dataset.filter;
            couponCards.forEach(card => {
                if (filter === '*' || card.classList.contains(filter)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Copy to clipboard functionality
    const copyBtns = document.querySelectorAll('.copy-btn');
    copyBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.classList.contains('disabled')) return;
            
            const code = this.dataset.clipboardText;
            navigator.clipboard.writeText(code).then(() => {
                const originalText = this.innerText;
                this.innerText = 'Copied!';
                setTimeout(() => {
                    this.innerText = originalText;
                }, 2000);
            });
        });
    });
});