<script>
    function load_program() {
        var path = "./include/";
        var faculty_id = $("#faculty_id").val(); // Read from DOM
        var level_id = $("#level_id").val(); // Read from DOM
        var api_for = "dashboard";

        $.ajax({
            url: path + "program.php",
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_data: level_id,
                api_for: api_for,
            },
            success: function(result) {
                $("#program_id").html(result);
            },
        });
    }
    $("#new_faculty").on("change", function() {
        var faculty_id = this.value;
        $.ajax({
            url: "include/level.php",
            type: "POST",
            data: {
                faculty_data: faculty_id,
            },
            success: function(result) {
                $("#new_level_id").html(result);
            },
        });
    });

    $("#new_level_id").on("change", function() {
        var level_id = this.value;
        var faculty_id = $("select#new_faculty option:checked").val();

        $.ajax({
            url: "include/program.php",
            type: "POST",
            data: {
                level_data: level_id,
                faculty_data: faculty_id,
            },
            cache: false,
            success: function(data) {
                $("#new_program_id").html(data);
            },
        });
    });
    
    $(document).ready(function() {
    $('#pac_id').select2({
        placeholder: "-- Select PAC ID --",
        allowClear: true
    });


    $('#pac_id').on('change', function () {
        let id = this.value;
        if (id) {
            fetch("fetch_student_details.php?student_id=" + id)
                .then((res) => res.json())
                .then((data) => {
                    // Basic info
                    document.getElementById("gr_number").textContent = data.gr_number;
                    document.getElementById("faculty").innerHTML = data.faculty_name;
                    document.getElementById("level").textContent = data.level_name;
                    document.getElementById("program").textContent = data.program_name;
                    document.getElementById("program_id_b").value = data.program_id;

                    document.getElementById("student-data-section").style.display = "block";
                    // Assume currentProgram is filled somewhere in your JS


                    // Set hidden select faculty_id
                    const facultySelect = document.getElementById("faculty_id");
                    facultySelect.innerHTML = ""; // Clear existing options
                    let facultyOption = document.createElement("option");
                    facultyOption.value = data.faculty_id;
                    facultyOption.text = data.faculty_name;
                    facultyOption.selected = true;
                    facultySelect.appendChild(facultyOption);

                    // Set hidden select level_id
                    const levelSelect = document.getElementById("level_id");
                    levelSelect.innerHTML = ""; // Clear existing options
                    let levelOption = document.createElement("option");
                    levelOption.value = data.level_id;
                    levelOption.text = data.level_name;
                    levelOption.selected = true;
                    levelSelect.appendChild(levelOption);
                    load_program();



                    const modeMap = {
                        R: "R",
                        SM: "SM",
                        CBPA: "CBPA",
                    };
                    // Transfer: MODE
                    const modeSection = document
                        .querySelector('input[data-target="#modeTransfer"]')
                        .closest("tr");
                    if (data.pac_mode) {
                        const modeValue = data.pac_mode.trim().toUpperCase();
                        const fullMode = modeMap[modeValue] || modeValue;
                        document.getElementById("current_mode").textContent = fullMode;
                        modeSection.style.display = "";
                    } else {
                        modeSection.style.display = "";
                        document.getElementById("modeTransfer").innerHTML =
                            '<div class="text-danger">No data found. Mode transfer not allowed.</div>';
                        modeSection.querySelector(".transfer-toggle").disabled = true;
                    }

                    // Transfer: PROGRAM
                    const programSection = document
                        .querySelector('input[data-target="#branchTransfer"]')
                        .closest("tr");
                    if (data.program_name) {
                        document.getElementById("current_program").textContent =
                            data.program_name;
                        programSection.style.display = "";
                    } else {
                        programSection.style.display = "";
                        document.getElementById("branchTransfer").innerHTML =
                            '<div class="text-danger">No data found. Branch transfer not allowed.</div>';
                        programSection.querySelector(".transfer-toggle").disabled = true;
                    }

                    // Transfer: FACULTY
                    const facultySection = document
                        .querySelector('input[data-target="#facultyTransfer"]')
                        .closest("tr");
                    if (data.faculty_name) {
                        document.getElementById("current_faculty").textContent =
                            data.faculty_name;
                        facultySection.style.display = "";
                    } else {
                        facultySection.style.display = "";
                        document.getElementById("facultyTransfer").innerHTML =
                            '<div class="text-danger">No data found. Faculty transfer not allowed.</div>';
                        facultySection.querySelector(".transfer-toggle").disabled = true;
                    }
                });
        }
    });
});
    // Toggle editable sections

    document.querySelectorAll(".transfer-toggle").forEach((cb) => {
        cb.addEventListener("change", function() {
            const target = document.querySelector(this.dataset.target);
            const facultyTransferSection = document.querySelector("#facultyTransfer");
            const branchTransferSection = document.querySelector("#branchTransfer");

            // Reset remaining fee (always when checkbox is toggled)
            document.getElementById("remaining_fee").value = "";

            if (this.checked) {
                // If Faculty Transfer is selected, disable Branch Transfer
                if (this.dataset.target === "#facultyTransfer") {
                    branchTransferSection.style.display = "none";
                    document.querySelector(
                        'input[data-target="#branchTransfer"]'
                    ).disabled = true;
                }

                // If Branch Transfer is selected, disable Faculty Transfer
                if (this.dataset.target === "#branchTransfer") {
                    facultyTransferSection.style.display = "none";
                    document.querySelector(
                        'input[data-target="#facultyTransfer"]'
                    ).disabled = true;
                }

                target.style.display = "block"; // Show the selected target
            } else {
                // Reset when unchecked
                if (this.dataset.target === "#facultyTransfer") {
                    document.querySelector(
                        'input[data-target="#branchTransfer"]'
                    ).disabled = false;
                }

                if (this.dataset.target === "#branchTransfer") {
                    document.querySelector(
                        'input[data-target="#facultyTransfer"]'
                    ).disabled = false;
                }

                target.style.display = "none"; // Hide the selected target

                // If both checkboxes are now unchecked, reset remaining fee
                const bothUnchecked = [...document.querySelectorAll(".transfer-toggle")].every(cb => !cb.checked);
                if (bothUnchecked) {
                    document.getElementById("remaining_fee").value = "";
                }
            }
        });
    });

    function fetchRemainingFee(programId) {
        let pacId = document.getElementById("pac_id").value;

        if (programId && pacId) {
            fetch(`get_remaining_fee.php?new_program_id=${programId}&pac_id=${pacId}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById("remaining_fee").value = data.remaining_fee ?? "";
                })
                .catch(err => {
                    console.error("Failed to fetch remaining fee:", err);
                    document.getElementById("remaining_fee").value = "Error";
                });
        } else {
            document.getElementById("remaining_fee").value = "";
        }
    }

    // Event for Branch Transfer <select>
    document.getElementById("program_id").addEventListener("change", function() {
        fetchRemainingFee(this.value);
    });

    // Event for Faculty Transfer <select>
    document.getElementById("new_program_id").addEventListener("change", function() {

        fetchRemainingFee(this.value);
    });


    // For Mode checkboxes (simulate radio)
    document.querySelectorAll(".group-mode").forEach(function(checkbox) {
        checkbox.addEventListener("change", function() {
            if (this.checked) {
                document.querySelectorAll(".group-mode").forEach(function(other) {
                    if (other !== checkbox) other.checked = false;
                });
            }
        });
    });

    document.querySelector("#transferForm").addEventListener("submit", function(e) {
        const pacId = document.getElementById("pac_id").value;
        const confirmed = document.getElementById("confirmed_duplicate").value;

        // ✅ 1. Check if any transfer is selected
        let isAnyTransferChecked = false;
        let errors = [];
        const transferData = {};
        const selectedTransfers = [];

        // Collect selected transfer options like "branch", "faculty", etc.
        document.querySelectorAll(".transfer-toggle").forEach(function(checkbox) {
            if (checkbox.checked) {
                isAnyTransferChecked = true;
                selectedTransfers.push(checkbox.value); // Collect values like "mode", "branch", etc.
            }
        });
        // Collect selected 'new_mode' values if 'modeTransfer' is visible
        if (document.querySelector('#modeTransfer').style.display !== 'none') {
            const selectedModes = [];
            document.querySelectorAll('.group-mode:checked').forEach(function(checkbox) {
                selectedModes.push(checkbox.value); // Add the checked 'new_mode' values to selectedModes
            });

            // If any mode is selected, add those modes individually to selectedTransfers
            if (selectedModes.length > 0) {
                selectedTransfers.push(...selectedModes); // Spread the selectedModes array directly into selectedTransfers
            }
        }
        // Check if no transfers are selected
        if (!isAnyTransferChecked) {
            e.preventDefault();
            Swal.fire({
                title: "Error!",
                text: "Please select at least one transfer option before submitting.",
                icon: "error",
                confirmButtonText: "OK",
            });
            return;
        }

        // ✅ 2. 🆕 Add this block here — Validate new data is not same as current
        // Validate each transfer field
        if (document.querySelector("#modeTransfer").style.display !== "none") {
            const currentMode = document
                .getElementById("current_mode")
                .innerText.trim();
            const newMode = document.querySelector('input[name="new_mode"]:checked');
            if (newMode) {
                transferData["mode"] = newMode.value;
            }
            if (newMode && newMode.value === currentMode) {
                errors.push("New Mode is same as current mode.");
            }
        }

        if (document.querySelector("#branchTransfer").style.display !== "none") {
            const programSelect = document.getElementById("program_id");
            const selectedProgramName =
                programSelect.options[programSelect.selectedIndex].text.trim();
            const currentProgram = document
                .getElementById("current_program")
                .innerText.trim();
            if (programSelect) {
                transferData["branch"] = programSelect.value; // or use program name if needed
            }
            if (selectedProgramName === currentProgram) {
                errors.push("New Program is same as current program.");
            }
        }

        if (document.querySelector("#facultyTransfer").style.display !== "none") {
            const currentFaculty = document
                .getElementById("current_faculty")
                .innerText.trim();
            const newFacultySelect = document.getElementById("new_faculty");
            const newFaculty =
                newFacultySelect.options[newFacultySelect.selectedIndex].text.trim();
            if (newFaculty && newFaculty === currentFaculty) {
                errors.push("New Faculty is same as current faculty.");
            }
            if (newFacultySelect) {
                transferData["faculty"] = newFacultySelect.value; // or use text if needed
            }
        }

        // Show all errors together if any
        if (errors.length > 0) {
            e.preventDefault();
            Swal.fire({
                title: "Request Cancelled",
                html: errors.map((e) => `<p>• ${e}</p>`).join(""),
                icon: "error",
                confirmButtonText: "OK",
            });
            return;
        }

        // ✅ 3. Send data for duplicate check if needed
        // ✅ 3. Send data for duplicate check if needed
        if (confirmed !== "1") {
            e.preventDefault(); // Stop form for now

            fetch('check_duplicate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'pac_id=' + pacId
                })
                .then(response => response.text())
                .then(data => {
                    if (data === '1') {
                        Swal.fire({
                            title: 'Duplicate Found!',
                            text: 'A previous transfer request already exists. You cannot submit another one.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // No duplicate, allow form submission
                        document.querySelector('form').submit();
                    }
                })
                .catch((error) => {
                    console.error('Error during duplicate check:', error);
                });
        }

    });
</script>