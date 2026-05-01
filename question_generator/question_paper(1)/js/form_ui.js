// form_ui.js
$(document).ready(function () {
  // ---------- Clock & Date Picker ----------
  $("#exam_time").clockpicker({
    donetext: "Done",
    autoclose: true,
    twelvehour: true,
  });
 
  $("#end_time").clockpicker({
    donetext: "Done",
    autoclose: true,
    twelvehour: true,
  });

  $("#exam_date").datepicker({
    dateFormat: "yy-mm-dd",
  });

  // ---------------- Faculty → Level ----------------
  $("#faculty_id").change(function () {
    const facultyId = $(this).val();
    if (!facultyId) return;

    $.ajax({
      url: window.apiConfig.apiUrl + "level.php",
      method: "POST",
      data: {
        faculty_data: facultyId, // ✅ matches PHP
        api_for: "level", // optional, add if your PHP expects it
        api_type: "dropdown", // optional, add if needed
      },
      success: function (data) {
        // console.log("Level response:", data); // debug
        $("#level_id").html(data);
      },
      error: function (xhr) {
        // console.error("Error loading levels:", xhr.responseText);
      },
    });
  });

  // ---------------- Level → Program ----------------
  $("#level_id").on("change", function () {
    const level_id = this.value;
    const faculty_id = $("#faculty_id").val();

    $.post(
      window.apiConfig.apiUrl + "program.php",
      { level_data: level_id, faculty_data: faculty_id },
      function (result) {
        $("#program_id").html(result);
      }
    );
  });

  // ---------------- Faculty/Level/Program/Sem → Subject Codes ----------------
  function loadSubjectCodes() {
    const params = {
      faculty_id: $("#faculty_id").val(),
      level_id: $("#level_id").val(),
      program_id: $("#program_id").val(),
      sem: $("#sem").val(),
    };

    $.post(
      window.apiConfig.questionUrl + "get_subject_codes.php",
      params,
      function (result) {
        $("#subject_code_id").html(result);
      }
    );
  }

  // Init & bind
  loadSubjectCodes();
  $("#faculty_id, #level_id, #program_id, #sem").on("change", loadSubjectCodes);
});
