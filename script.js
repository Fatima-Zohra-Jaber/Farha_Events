 // Script pour calculer le compte 
 document.addEventListener('DOMContentLoaded', function() {
    const countDownDate = new Date(eventDate).getTime();
    
    const countdownTimer = setInterval(function() {
        const now = new Date().getTime();
        const distance = countDownDate - now;
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById("days").textContent = String(days).padStart(2, '0');
        document.getElementById("hours").textContent = String(hours).padStart(2, '0');
        document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
        document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');
        
        if (distance < 0) {
            clearInterval(countdownTimer);
            document.getElementById("days").textContent = "00";
            document.getElementById("hours").textContent = "00";
            document.getElementById("minutes").textContent = "00";
            document.getElementById("seconds").textContent = "00";
        }
    }, 1000);
});




// // Modal

document.addEventListener('DOMContentLoaded', function() {
    let modal = document.getElementById('modelConfirm');
    if (modal) {
        modal.classList.remove('hidden');
    }
});

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    if (redirectUrl) {
        window.location.href = redirectUrl;
    }
}
