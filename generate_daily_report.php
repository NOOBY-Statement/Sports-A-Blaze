<?php
require('fpdf/fpdf.php');

// Database connection
$conn = new mysqli("localhost", "root", "", "sports_a_blaze");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get tomorrow's date
$today = date('Y-m-d');

// Fetch records for tomorrow
$sql = "SELECT reserve_id, name, contactNumber, email, address, equipment, pickupDate, returnDate, startTime, endTime, status 
        FROM reservation 
        WHERE pickupDate = '$today'";
$result = $conn->query($sql);

// Calculate total reservations
$total_reservations = $result->num_rows;

// Create PDF in landscape orientation with A3 page size
$pdf = new FPDF('L', 'mm', 'A3');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(0, 10, 'Daily Report - ' . $today, 1, 1, 'C');
$pdf->Cell(0, 10, 'Total Reservations: ' . $total_reservations, 0, 1, 'L');

$pdf->SetFont('Arial', '', 8);

// Define column width
$column_width = 40;

// Headers
$headers = [
    'Reserve ID', 'Name', 'Contact No', 'Email', 
    'Equipment', 'Pickup Date', 'Return Date', 
    'Start Time', 'End Time', 'Status'
];

foreach ($headers as $header) {
    $pdf->Cell($column_width, 10, $header, 1);
}
$pdf->Ln();

// Data
while ($row = $result->fetch_assoc()) {
    $pdf->Cell($column_width, 10, $row['reserve_id'], 1);
    $pdf->Cell($column_width, 10, $row['name'], 1);
    $pdf->Cell($column_width, 10, $row['contactNumber'], 1);
    $pdf->Cell($column_width, 10, $row['email'], 1);
    $pdf->Cell($column_width, 10, $row['equipment'], 1);
    $pdf->Cell($column_width, 10, $row['pickupDate'], 1);
    $pdf->Cell($column_width, 10, $row['returnDate'], 1);
    $pdf->Cell($column_width, 10, $row['startTime'], 1);
    $pdf->Cell($column_width, 10, $row['endTime'], 1);
    $pdf->Cell($column_width, 10, $row['status'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'Daily_Report_' . $today . '.pdf');

$conn->close();
?>