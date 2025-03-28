 // Script pour calculer le compte à rebours
 document.addEventListener('DOMContentLoaded', function() {
    // Récupérer la date de l'événement
    const countDownDate = new Date(eventDate).getTime();
    
    // Mettre à jour le compte à rebours toutes les secondes
    const countdownTimer = setInterval(function() {
        const now = new Date().getTime();
        const distance = countDownDate - now;
        
        // Calcul des jours, heures, minutes et secondes
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Affichage du résultat
        document.getElementById("days").textContent = String(days).padStart(2, '0');
        document.getElementById("hours").textContent = String(hours).padStart(2, '0');
        document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
        document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');
        
        // Si le compte à rebours est terminé
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


// function closeModalAndRedirect() {
//     let modal = document.getElementById('modelConfirm');
//     if (modal) {
//         modal.classList.add('hidden');
//         if (redirectUrl) {
//             window.location.href = redirectUrl;
//         }
//     }
// }