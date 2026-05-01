// fetch_questions.js
$(document).ready(function () {
  $('button[name="show"]').on("click", function (event) {
    event.preventDefault();
    const errors = [];

    const clgName = $("#clg_name").val();
    const examName = $("#exam_name").val();
    const examDate = $("#exam_date").val();
    const examTime = $("#exam_time").val();
    const endTime = $("#end_time").val();
    const facultyId = $("#faculty_id").val();
    const levelId = $("#level_id").val();
    const programId = $("#program_id").val();
    const sem = $("#sem").val();
    const subjectCode = $("#subject_code_id").val();
    const totalMarks = $("#t_marks").val();

    if (!clgName) errors.push("College Name");
    if (!examName) errors.push("Exam Name");
    if (!examDate) errors.push("Exam Date");
    if (!examTime) errors.push("Exam Start Time");
    if (!endTime) errors.push("Exam End Time");
    if (!facultyId) errors.push("Faculty");
    if (!levelId) errors.push("Level");
    if (!programId) errors.push("Program");
    if (!sem) errors.push("Semester");
    if (!subjectCode) errors.push("Subject Code");
    if (!totalMarks) errors.push("Total Marks");

    if (errors.length > 0) {
      Swal.fire({
        icon: "warning",
        title: "Missing Information",
        html:
          "Please fill in the following fields:<br><b>" +
          errors.join(", ") +
          "</b>",
      });
      return;
    }

    if (!totalMarks) {
      alert("Please enter total marks.");
      return;
    }

    // ✅ Now make the request
    $.post(window.apiConfig.questionUrl + "fetch_bank_questions.php", {
      faculty_id: facultyId,
      level_id: levelId,
      program_id: programId,
      sem: sem,
      subject_code: subjectCode,
      t_marks: totalMarks,
    })
      .done(function (response) {
        // 1️⃣ Add table HTML
        $("#questionContainer").html(response);

        // 2️⃣ Run availability checks AFTER table exists
        if (typeof window.validateAndGateSelection === "function") {
          const result = window.validateAndGateSelection();

          if (!result.ok) {
            const y =
              $(".summary-container").offset()?.top ||
              $("#questionContainer").offset()?.top ||
              0;
            window.scrollTo({ top: y - 80, behavior: "smooth" });
          }
        }
      })
      .fail(function (xhr, status, error) {
        console.error("Error fetching questions:", error, xhr.responseText);
        alert("Failed to fetch questions. Please try again.");
      });
  });
});
