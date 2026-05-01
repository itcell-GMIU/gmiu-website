<?php
include __DIR__ . '/../database/connect.php';

if (isset($_POST['student_id'])) {
    $student_id = (int)$_POST['student_id'];

    $stmt = $con->prepare("SELECT * FROM tbl_gmap_payments WHERE student_id = ? AND payment_status = 'success' ORDER BY id DESC");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $html = '<div class="table-responsive"><table class="table table-bordered table-sm align-middle">';
        $html .= '<thead class="table-light"><tr><th>Txn ID</th><th>Amount</th><th>Status</th><th>Mode</th><th>Date</th></tr></thead><tbody>';
        while ($row = $res->fetch_assoc()) {
            $statusBadge = '';
            if ($row['payment_status'] === 'success') {
                $statusBadge = '<span class="badge bg-success">Success</span>';
            } elseif ($row['payment_status'] === 'failed') {
                $statusBadge = '<span class="badge bg-danger">Failed</span>';
            } else {
                $statusBadge = '<span class="badge bg-warning">Pending</span>';
            }

            $date = !empty($row['payment_date']) ? date('d-m-Y h:i A', strtotime($row['payment_date'])) : 'N/A';
            
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($row['transaction_id'] ?? 'N/A') . '</td>';
            $html .= '<td>₹' . htmlspecialchars($row['amount']) . '</td>';
            $html .= '<td>' . $statusBadge . '</td>';
            $html .= '<td>' . htmlspecialchars(ucfirst($row['mode'] ?? 'N/A')) . '</td>';
            $html .= '<td>' . $date . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table></div>';
        echo $html;
    } else {
        echo '<div class="alert alert-warning mb-0">No payment details found for this student.</div>';
    }
}
?>
