    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(event) {
            let target = event.target;
            if (target.matches('.view-ticket-form button')) {
                event.preventDefault(); 
                let form = target.closest('.view-ticket-form');
                let ticketId = form.querySelector('input[name="id"]').value;
                let redirectUrl = 'ticket.php?id=' + ticketId;
                window.location.href = redirectUrl;
            }
        });
        let dynamicButtonContainer = document.querySelector('#dynamic-button-container');
        dynamicButtonContainer.addEventListener('click', function(event) {
            let target = event.target;
            if (target.matches('.view-ticket-form button')) {
                event.preventDefault(); 
                let form = target.closest('.view-ticket-form');
                let ticketId = form.querySelector('input[name="id"]').value;
                let redirectUrl = 'ticket.php?id=' + ticketId;
                window.location.href = redirectUrl;
            }
        });
    });
