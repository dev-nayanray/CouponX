document.addEventListener('DOMContentLoaded', function() {
    // Countdown Timer Implementation
    function updateCountdowns() {
      document.querySelectorAll('.countdown-pro').forEach(timer => {
        const expiresAt = new Date(timer.dataset.expires).getTime();
        const now = new Date().getTime();
        const distance = expiresAt - now;
  
        if (distance < 0) {
          timer.innerHTML = 'EXPIRED';
          timer.parentElement.querySelector('.deal-action-pro').disabled = true;
          return;
        }
  
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
  
        timer.innerHTML = `
          <span class="countdown-segment">${days}d</span>
          <span class="countdown-segment">${hours}h</span>
          <span class="countdown-segment">${minutes}m</span>
          <span class="countdown-segment">${seconds}s</span>
        `;
      });
    }
  
    // Initial update and set interval
    updateCountdowns();
    setInterval(updateCountdowns, 1000);
  
    // Code Reveal Handling
    document.addEventListener('click', async function(e) {
      if (e.target.closest('.deal-action-pro')) {
        const button = e.target.closest('.deal-action-pro');
        const couponId = button.dataset.couponId;
        const nonce = button.dataset.nonce;
        const successMessage = button.parentElement.querySelector('.success-message');
  
        button.disabled = true;
        button.innerHTML = `<span class="dashicons dashicons-update"></span> Loading...`;
  
        try {
          const response = await fetch(
            couponx_ajax.ajax_url + '?action=couponx_reveal_code',
            {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
              },
              body: new URLSearchParams({
                coupon_id: couponId,
                nonce: nonce,
              }),
            }
          );
  
          const data = await response.json();
  
          if (data.success) {
            // Copy to clipboard
            await navigator.clipboard.writeText(data.code);
            
            // Update button state
            button.innerHTML = `
              <span class="dashicons dashicons-yes-alt"></span>
              <span class="action-text">${data.code}</span>
            `;
            button.disabled = true;
            
            // Show success message
            successMessage.classList.add('visible');
            setTimeout(() => successMessage.classList.remove('visible'), 2000);
          } else {
            throw new Error(data.data || 'Failed to reveal code');
          }
        } catch (error) {
          console.error('Error:', error);
          button.innerHTML = `
            <span class="dashicons dashicons-warning"></span>
            <span class="action-text">Error</span>
          `;
          setTimeout(() => {
            button.innerHTML = `
              <span class="dashicons dashicons-lock"></span>
              <span class="action-text">Retry</span>
            `;
            button.disabled = false;
          }, 2000);
        }
      }
    });
  
    // Mobile Menu Toggle
    window.addEventListener('resize', function() {
      const countdownSegments = document.querySelectorAll('.countdown-segment');
      if (window.innerWidth < 782) {
        countdownSegments.forEach(seg => seg.style.display = 'block');
      } else {
        countdownSegments.forEach(seg => seg.style.display = 'inline-block');
      }
    });
  });