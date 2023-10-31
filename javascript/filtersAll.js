document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("department-formAll").addEventListener("change", updateTable);
    document.getElementById("user-formAll").addEventListener("change", updateTable);
    document.getElementById("status-formAll").addEventListener("change", updateTable);
    document.getElementById("priority-formAll").addEventListener("change", updateTable);
  
    function updateTable() {
        let department = document.getElementsByName("Department")[0].value;
        let user = document.getElementsByName("User")[0].value;
        let status = document.getElementsByName("Status")[0].value;
        let priority = document.getElementsByName("Priority")[0].value;
  
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);
                    let tableBody = document.getElementById("tickets-table").getElementsByTagName("tbody")[0];
                    tableBody.innerHTML = "";
  
                    for (let i = 0; i < response.length; i++) {
                        let ticket = response[i];
                        let row = "<tr>" +
                            "<td>" + ticket.title + "</td>" +
                            "<td>" + ticket.name + "</td>" +
                            "<td>" + ticket.department_name + "</td>" +
                            "<td>" + ticket.date + "</td>" +
                            "<td>" + ticket.status + "</td>" +
                            "<td>" + ticket.priority + "</td>" +
                            "<td>" +
                            "<form class=\"view-ticket-form\" method=\"get\">" +
                            "<input type=\"hidden\" name=\"id\" value=\"" + ticket.ticket_id + "\">" +
                            "<button type=\"submit\">View Ticket</button>" +
                            "<input type=\"hidden\" name=\"csrf\" value=\"<?=$_SESSION['csrf']?>\"></input>" +
                            "</form>" +
                            "</td>" +
                            "</tr>";
                        tableBody.innerHTML += row;
                    }
                } else {
                    console.error("Request failed. Status: " + xhr.status);
                }
            }
        };
  
        xhr.open("POST", "../api/filtersAll.php");
  
        let formData = new FormData();
        formData.append("department_name", department);
        formData.append("name", user);
        formData.append("status", status);
        formData.append("priority", priority);
  
        xhr.send(formData);
    }
  });