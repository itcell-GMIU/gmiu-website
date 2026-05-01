<?php
include '../include/checklogin.php';
if ($role_id == 51) {
    $paperFormats = [

        90 => [
            [
                "Q.1",
                [
                    ['part' => 'a', 'type' => 'q']
                ]
            ],
            [
                "Q.2",
                [
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q']
                ]
            ],
            [
                "Q.3",
                [
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q']
                ]
            ]
        ],

        100 => [
            [
                "Q.1",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ],
            [
                "Q.2",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q'],
                    "OR",
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ],
            [
                "Q.3",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q'],
                    "OR",
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ]
        ],

        175 => [
            [
                "Q.1",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ],
            [
                "Q.2",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    "OR",
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q'],
                    "OR",
                    ['part' => 'c', 'type' => 'q']
                ]
            ],
            [
                "Q.3",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q'],
                    "OR",
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ],
            [
                "Q.4",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q'],
                    "OR",
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ],
            [
                "Q.5",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q'],
                    "OR",
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ]
        ],

        180 => [
            [
                "Q.1",
                [
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q']
                ]
            ],
            [
                "Q.2",
                [
                    ['part' => 'a', 'type' => 'q'],
                    "OR",
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q'],
                    "OR",
                    ['part' => 'b', 'type' => 'q']
                ]
            ],
            [
                "Q.3",
                [
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q'],
                    "OR",
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q']
                ]
            ],
            [
                "Q.4",
                [
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q'],
                    "OR",
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q']
                ]
            ],
            [
                "Q.5",
                [
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q'],
                    "OR",
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q']
                ]
            ]
        ]
    ];

    $paper_id = $_GET['id'];
    $paperInfo = $con->prepare("SELECT total_mark FROM tbl_paper WHERE id = ?");
    $paperInfo->bind_param("i", $paper_id);
    $paperInfo->execute();
    $resPaper = $paperInfo->get_result()->fetch_assoc();

    $totalMarks = $resPaper['total_mark'];

    if (!isset($paperFormats[$totalMarks])) {
        echo "<h3 style='color:red;'>This paper format is not supported for sequence.</h3>";
        exit();
    }

    // =============================
    // FETCH ONLY QUESTIONS OF THIS PAPER
    // =============================
    $qQuery = $con->prepare("
        SELECT pq.question_id, q.question, q.modify_question, q.marks
        FROM tbl_paper_question pq
        LEFT JOIN tbl_questions q ON pq.question_id = q.id
        WHERE pq.paper_id = ?
        ORDER BY q.marks ASC
    ");
    $qQuery->bind_param("i", $paper_id);
    $qQuery->execute();
    $qResult = $qQuery->get_result();

    $questions5 = [];
    $questions10 = [];

    while ($row = $qResult->fetch_assoc()) {
        $text = $row['modify_question'] ?: $row['question'];
        if ($row['marks'] == 5)
            $questions5[$row['question_id']] = $text;
        else if ($row['marks'] == 10)
            $questions10[$row['question_id']] = $text;
    }

    // =============================
    // PAPER FORMAT SLOTS (175 MARK)
    // =============================
    $slots = [];
    $format = $paperFormats[$totalMarks];

    foreach ($format as $qIndex => $qData) {

        $qLabel = $qData[0];
        $parts = $qData[1];
        $orCount = 0;

        foreach ($parts as $p) {

            if ($p === 'OR') {
                $orCount++;
                continue;
            }

            $part = $p['part'];
            $type = $p['type'];

            $marks = ($type == 'q5') ? 5 : 10;

            // GENERATE UNIQUE SLOT KEYS
            $slotKey = $qLabel . "_" . ($orCount > 0 ? "or{$orCount}_" : "") . $part;

            $slots[$slotKey] = [
                "marks" => $marks
            ];
        }
    }

    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <?php include '../include/importhead.php'; ?>
        <?php include '../include/importcss.php'; ?>

        <style>
            .sequence-box {
                background: #f7f7f7;
                padding: 25px;
                border-radius: 10px;
                width: 95%;
                margin: auto;
                box-shadow: 0px 2px 8px #ddd;
            }

            .seq-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            .seq-table th,
            .seq-table td {
                padding: 10px;
                border: 1px solid #dcdcdc;
                font-size: 15px;
            }

            .seq-table th {
                background: #e8e8e8;
                font-weight: bold;
            }

            select {
                width: 100%;
                padding: 8px;
                border-radius: 6px;
                border: 1px solid #bbb;
            }

            .clear-btn {
                font-size: 13px;
                padding: 6px 12px;
                background: #ff4d4d;
                border: none;
                color: white;
                border-radius: 5px;
                cursor: pointer;
            }

            .clear-btn:hover {
                background: #e60000;
            }

            #confirmBtn {
                background: #007bff;
                color: white;
                padding: 10px 25px;
                border: none;
                border-radius: 6px;
                font-size: 16px;
                cursor: pointer;
            }

            #confirmBtn:disabled {
                background: #a8a8a8;
                cursor: not-allowed;
            }

            .page-title {
                font-size: 22px;
                font-weight: 700;
                margin-bottom: 15px;
            }
        </style>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <?php include '../include/importnav.php'; ?>
            <?php include '../include/importsidebar.php'; ?>

            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <h3 class="page-title">Set Question Sequence</h3>
                    </div>
                </div>

                <section class="content">
                    <div class="sequence-box">

                        <form id="seqForm">

                            <table class="seq-table">
                                <tr>
                                    <th style="width: 25%">Slot</th>
                                    <th style="width: 60%">Select Question</th>
                                    <th style="width: 15%">Action</th>
                                </tr>

                                <?php foreach ($slots as $slot => $s): ?>
                                    <tr>
                                        <td><b><?= $slot ?></b> (<?= $s['marks'] ?> Marks)</td>

                                        <td>
                                            <select class="slot-select" data-slot="<?= $slot ?>"
                                                data-marks="<?= $s['marks'] ?>">
                                                <option value="">-- Select Question --</option>

                                                <?php
                                                $list = ($s['marks'] == 5) ? $questions5 : $questions10;
                                                foreach ($list as $id => $text):
                                                    ?>
                                                    <option value="<?= $id ?>"><?= $text ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>

                                        <td>
                                            <button type="button" class="clear-btn" data-slot="<?= $slot ?>">Clear</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </table>

                            <br>
                            <center>
                                <button id="confirmBtn" disabled>Confirm Sequence</button>
                                <div id="errorMsg" style="color:red; margin-top:10px; display:none;">
                                    ⚠ Please select all questions!
                                </div>
                            </center>

                        </form>

                    </div>
                </section>

            </div>

            <?php include '../include/importfooter.php'; ?>
            <?php include '../include/importjs.php'; ?>

        </div>

        <script>
            let usedQuestions = {};

            function refreshDropdowns() {
                $(".slot-select").each(function () {
                    let selected = $(this).val();

                    $(this).find("option").each(function () {
                        let qid = $(this).val();

                        if (qid === "" || qid === selected) return;

                        if (Object.values(usedQuestions).includes(qid)) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                });
            }

            $(".slot-select").on("change", function () {
                let slot = $(this).data("slot");
                let qId = $(this).val();

                usedQuestions[slot] = qId;

                refreshDropdowns();
                validateForm();
            });

            $(".clear-btn").on("click", function () {
                let slot = $(this).data("slot");

                delete usedQuestions[slot];
                $(`select[data-slot="${slot}"]`).val("");

                refreshDropdowns();
                validateForm();
            });

            function validateForm() {
                let required = $(".slot-select").length;
                let filled = Object.keys(usedQuestions).length;

                if (required === filled) {
                    $("#confirmBtn").prop("disabled", false);
                    $("#errorMsg").hide();
                } else {
                    $("#confirmBtn").prop("disabled", true);
                    $("#errorMsg").show();
                }
            }
            $("#confirmBtn").on("click", function (e) {
                e.preventDefault();

                // disable button while saving
                $("#confirmBtn").prop("disabled", true).text('Saving...');

                // ---------------------------------
                // BUILD SLOT ORDER (VERY IMPORTANT)
                // ---------------------------------
                var slotOrder = [];
                $(".slot-select").each(function () {
                    slotOrder.push($(this).data("slot"));
                });

                // SEND BOTH: selected questions + slot order
                $.post("save_sequence.php?id=<?= $paper_id ?>", {
                    selected: usedQuestions,
                    order: slotOrder
                }, function (resp) {

                    try {
                        var data = (typeof resp === 'string') ? JSON.parse(resp) : resp;
                    } catch (err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Unexpected response',
                            text: 'Server returned invalid JSON.'
                        });
                        $("#confirmBtn").prop("disabled", false).text('Confirm Sequence');
                        return;
                    }

                    if (data.status && data.status === 'ok') {
                        Swal.fire({
                            title: 'Saved',
                            text: data.message || 'Sequence updated successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "view_generate_paper.php";
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Something went wrong while updating sequence.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        $("#confirmBtn").prop("disabled", false).text('Confirm Sequence');
                    }

                }).fail(function (jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Request Failed',
                        text: (jqXHR.responseText ? jqXHR.responseText : (errorThrown || textStatus)),
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $("#confirmBtn").prop("disabled", false).text('Confirm Sequence');
                });

            });
        </script>

    </body>

    </html>
<?php } ?>