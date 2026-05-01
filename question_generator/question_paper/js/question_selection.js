// question_selection.js
$(document).ready(function () {
  const MAX_TWO_MARK_QUESTIONS = 10;
  const totalMarks = window.examConfig?.totalMarks || 60;
  const chapterLimits = window.examConfig?.chapterLimits || {};

  // Function to count 2-mark questions
  function countTwoMarkQuestions(
    excludeCurrent = false,
    currentCheckbox = null
  ) {
    let count = 0;

    $(".q-check").each(function () {
      if (excludeCurrent && this === currentCheckbox) return;
      if (!$(this).is(":checked")) return;

      const marks = parseInt($(this).closest("tr").attr("data-marks"), 10);
      if (marks === 2) count++;
    });

    return count;
  }
  function validateTwoMarkAvailability() {
    if (totalMarks !== 60) return true; // Only enforce for 60-mark paper

    const REQUIRED_TWO_MARK_QUESTIONS = 10; // For 60-mark paper
    let totalAvailableTwoMarks = 0;
    let chapterTwoMarkAvailable = {};

    $(".q-check").each(function () {
      const row = $(this).closest("tr");
      const chapter = parseInt(row.attr("data-chapter"), 10);
      const marks = parseInt(row.attr("data-marks"), 10);

      if (marks === 2) {
        totalAvailableTwoMarks++;
        chapterTwoMarkAvailable[chapter] =
          (chapterTwoMarkAvailable[chapter] || 0) + 1;
      }
    });

    // Check total 2-mark questions
    if (totalAvailableTwoMarks < REQUIRED_TWO_MARK_QUESTIONS) {
      Swal.fire({
        icon: "error",
        title: "Not Enough 2-Mark Questions!",
        html: `<p>Total required 2-mark questions: ${REQUIRED_TWO_MARK_QUESTIONS}</p>
                   <p>Available in system: ${totalAvailableTwoMarks}</p>
                   <p style="margin-top:10px; font-size:14px; color:#666;">
                   💡 Please add more 2-mark questions in the system.</p>`,
        confirmButtonColor: "#e74c3c",
      });
      return false;
    }

    // Check per-chapter availability (if you have chapter limits for 2-mark)
    for (let chap in chapterLimits) {
      const maxTwoMarkPerChapter = chapterLimits[chap] >= 2 ? 2 : 1;
      if ((chapterTwoMarkAvailable[chap] || 0) < maxTwoMarkPerChapter) {
        Swal.fire({
          icon: "error",
          title: `Not Enough 2-Mark Questions in Chapter ${chap}!`,
          html: `<p>Required 2-mark questions for this chapter: ${maxTwoMarkPerChapter}</p>
             <p>Available: ${chapterTwoMarkAvailable[chap] || 0}</p>
             <p style="margin-top:10px; font-size:14px; color:#666;">
             💡 Please add more 2-mark questions for this chapter.</p>`,
          confirmButtonColor: "#e74c3c",
        });
        return false;
      }
    }

    return true;
  }

  // Function to update summary
  function updateSummary() {
    let usedMarks = 0;
    const chapterCount = {};
    const chapterMarks = {};

    $(".q-check:checked").each(function () {
      const row = $(this).closest("tr");
      const chap = parseInt(row.attr("data-chapter"), 10);
      const marks = parseInt(row.attr("data-marks"), 10);

      row.addClass("selected");
      chapterCount[chap] = (chapterCount[chap] || 0) + 1;
      chapterMarks[chap] = (chapterMarks[chap] || 0) + marks;
      usedMarks += marks;
    });

    // Remove selected class from unchecked rows
    $(".q-check:not(:checked)").each(function () {
      $(this).closest("tr").removeClass("selected");
    });

    // Update summary display
    $(".selected-count").each(function () {
      const chap = parseInt($(this).attr("data-chap"), 10);
      $(this).text(chapterCount[chap] || 0);
    });

    $(".selected-marks").each(function () {
      const chap = parseInt($(this).attr("data-chap"), 10);
      $(this).text(chapterMarks[chap] || 0);
    });

    // Update remaining marks
    const remaining = Math.max(totalMarks - usedMarks, 0);
    $("#remainingMarks").text(remaining);

    // Update 2-mark counter
    const twoMarkCount = countTwoMarkQuestions();
  }

  // Main checkbox event handler
  $(document).on("change", ".q-check", function (e) {
    const $checkbox = $(this);
    const $row = $checkbox.closest("tr");
    const marks = parseInt($row.attr("data-marks"), 10);
    const chapter = parseInt($row.attr("data-chapter"), 10);
    const isChecked = $checkbox.is(":checked");

    // If user is trying to CHECK a 2-mark question
    if (isChecked && marks === 2) {
      // Count currently selected 2-mark questions (excluding this one)
      const currentCount = countTwoMarkQuestions(true, this);

      if (currentCount >= MAX_TWO_MARK_QUESTIONS) {
        // Show SweetAlert error
        Swal.fire({
          icon: "error",
          title: "Selection Limit Reached!",
          html: `<div style="text-align: left;">
                   <p><strong>You can only select ${MAX_TWO_MARK_QUESTIONS} questions worth 2 marks.</strong></p>
                   <p>Currently selected: <span style="color: #e74c3c; font-weight: bold;">${currentCount}/${MAX_TWO_MARK_QUESTIONS}</span></p>
                   <p style="margin-top: 15px; font-size: 14px; color: #666;">
                     💡 <em>Please unselect some 2-mark questions first, then try again.</em>
                   </p>
                 </div>`,
          confirmButtonText: "Got it!",
          confirmButtonColor: "#e74c3c",
          allowOutsideClick: false,
        });

        // Uncheck the checkbox
        $checkbox.prop("checked", false);

        return false;
      } else {
      }
    }

    // Chapter limit validation
    if (isChecked && chapterLimits[chapter]) {
      const currentChapterMarks = calculateChapterMarks(chapter, true, this);
      if (currentChapterMarks + marks > chapterLimits[chapter]) {
        // Show SweetAlert for chapter limit
        Swal.fire({
          icon: "warning",
          title: "Chapter Limit Exceeded!",
          html: `<div style="text-align: left;">
                   <p><strong>Chapter ${chapter} marking limit exceeded!</strong></p>
                   <p>Allowed marks: <span style="color: #3498db; font-weight: bold;">${
                     chapterLimits[chapter]
                   }</span></p>
                   <p>Current usage: <span style="color: #f39c12; font-weight: bold;">${currentChapterMarks}</span></p>
                   <p>This question: <span style="color: #e74c3c; font-weight: bold;">+${marks}</span></p>
                   <p>Total would be: <span style="color: #e74c3c; font-weight: bold;">${
                     currentChapterMarks + marks
                   }</span></p>
                   <hr style="margin: 15px 0;">
                   <p style="font-size: 14px; color: #666;">
                     💡 <em>Please unselect some questions from Chapter ${chapter} first.</em>
                   </p>
                 </div>`,
          confirmButtonText: "Understood",
          confirmButtonColor: "#f39c12",
        });

        $checkbox.prop("checked", false);
        return false;
      }
    }

    // Update the summary
    updateSummary();
  });

  // Helper function to calculate chapter marks
  function calculateChapterMarks(
    targetChapter,
    excludeCurrent = false,
    currentCheckbox = null
  ) {
    let marks = 0;
    $(".q-check:checked").each(function () {
      if (excludeCurrent && this === currentCheckbox) return;

      const row = $(this).closest("tr");
      const chapter = parseInt(row.attr("data-chapter"), 10);
      if (chapter === targetChapter) {
        marks += parseInt(row.attr("data-marks"), 10);
      }
    });
    return marks;
  }

  // Initialize

  updateSummary();

  // Show success message when user makes valid selections
  $(document).on("change", ".q-check", function () {
    if ($(this).is(":checked")) {
      const marks = parseInt($(this).closest("tr").attr("data-marks"), 10);
      const currentTwoMarkCount = countTwoMarkQuestions();

      // Show encouraging message when user selects their 10th 2-mark question
      if (marks === 2 && currentTwoMarkCount === MAX_TWO_MARK_QUESTIONS) {
        Swal.fire({
          icon: "success",
          title: "Perfect!",
          text: `You've selected all ${MAX_TWO_MARK_QUESTIONS} allowed 2-mark questions!`,
          timer: 2000,
          showConfirmButton: false,
          toast: true,
          position: "top-end",
        });
      }
    }
  });

  // Debug info after load
  setTimeout(function () {
    const totalQuestions = $(".q-check").length;
    const twoMarkQuestions = $(".q-check").filter(function () {
      return parseInt($(this).closest("tr").attr("data-marks"), 10) === 2;
    }).length;
  }, 500);

  $("#showBtn").on("click", function () {
    // Check 2-mark questions first for 60-mark paper
    if (!validateTwoMarkAvailability()) return false;
    let availableMarks = 0;
    const availableChapterMarks = {};

    $(".q-check").each(function () {
      const row = $(this).closest("tr");
      const chap = parseInt(row.attr("data-chapter"), 10);
      const marks = parseInt(row.attr("data-marks"), 10);

      availableMarks += marks;
      availableChapterMarks[chap] = (availableChapterMarks[chap] || 0) + marks;
    });

    // ✅ Total pool check
    if (availableMarks < totalMarks) {
      Swal.fire({
        icon: "warning",
        title: "Not Enough Questions!",
        html: `<p><strong>Total required marks: ${totalMarks}</strong></p>
               <p><strong>Available marks: ${availableMarks}</strong></p>
               <p style="margin-top:10px; color:#666;">
               💡 Please add more questions in the system before proceeding.</p>`,
        confirmButtonColor: "#f39c12",
      });
      return false;
    }

    // ✅ Per-chapter pool check
    for (let chap in chapterLimits) {
      const required = chapterLimits[chap];
      const available = availableChapterMarks[chap] || 0;

      if (available < required) {
        Swal.fire({
          icon: "warning",
          title: `Not Enough Questions in Chapter ${chap}!`,
          html: `<p><strong>Required marks: ${required}</strong></p>
                 <p><strong>Available marks: ${available}</strong></p>
                 <p style="margin-top:10px; color:#666;">
                 💡 Please add more questions to Chapter ${chap} before proceeding.</p>`,
          confirmButtonColor: "#f39c12",
        });
        return false;
      }
    }

    // ✅ If all good → show question panel
    $("#questionContainer").show();
  });
});
