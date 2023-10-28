document.addEventListener('DOMContentLoaded', function () {
    const bookingForm = document.getElementById('booking-form');
    const qrCodeContainer = document.getElementById('qr-code');
    
    bookingForm.addEventListener('submit', function (event) {
        event.preventDefault();
        
        const contactName = document.getElementById('contactName').value;
        const visitDate = document.getElementById('visitDate').value;
        const numVisitors = document.getElementById('numVisitors').value;
        
        // Send the form data to process_booking.php using AJAX or fetch
        fetch('process_booking.php', {
            method: 'POST',
            body: JSON.stringify({
                contactName: contactName,
                visitDate: visitDate,
                numVisitors: numVisitors
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.text())
        .then(qrCodeHtml => {
            qrCodeContainer.innerHTML = qrCodeHtml;
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
