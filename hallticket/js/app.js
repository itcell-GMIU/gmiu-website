async function searchHallTicket() {
    let mobile = document.getElementById("mobile").value;

    let districts = ["amreli", "surat", "mahuva"];
    let found = false;

    for (let district of districts) {
        let response = await fetch(`data/${district}.json`);
        let data = await response.json();

        let student = data.find(s => s.mobile == mobile);

        if (student) {
            localStorage.setItem("hallticket", JSON.stringify(student));
            window.location.href = "hallticket.html";
            found = true;
            break;
        }
    }

    if (!found) {
        alert("Hall Ticket Not Found ❌");
    }
}