document.querySelectorAll('.cx-reveal-code').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const mask = this.previousElementSibling;
        const fullCode = mask.dataset.fullcode;
        
        if (!this.classList.contains('revealed')) {
            mask.innerHTML = fullCode;
            this.textContent = 'Hide Code';
            this.classList.add('revealed');
            mask.classList.add('cx-code-revealed');
        } else {
            const visibleChars = Math.ceil(fullCode.length * 0.3);
            const visiblePart = fullCode.substring(0, visibleChars);
            const maskedPart = '•'.repeat(fullCode.length - visibleChars);
            mask.innerHTML = `
                <span class="cx-visible-part">${visiblePart}</span>
                <span class="cx-masked-part">${maskedPart}</span>
            `;
            this.textContent = 'Reveal Code';
            this.classList.remove('revealed');
            mask.classList.remove('cx-code-revealed');
        }
    });
});