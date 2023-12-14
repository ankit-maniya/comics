<?php
require_once('fpdf/fpdf.php');

class PDF extends FPDF {
    private $headerTitle;
    private $footerTitle;

    // Set header title
    public function setHeaderTitle($title) {
        $this->headerTitle = $title;
    }

    // Set footer title
    public function setFooterTitle($title) {
        $this->footerTitle = $title;
    }

    // Page header
    function Header() {
        // Set font and color for the header
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(0);
        // Title
        $this->Cell(0, 10, $this->headerTitle, 0, 1, 'C');
        // Line break
        $this->Ln(10);
    }

    // Page footer
    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('Arial', 'I', 8);
        // Title
        $this->Cell(0, 10, $this->footerTitle . ' - Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (Existing code to save data to the database)

    // Create new PDF document
    $pdf = new PDF();
    $pdf->SetTitle('Comics Bookstore');
    $pdf->SetSubject('Form Data PDF');
    $pdf->SetKeywords('Form, Data, PDF');

    // Set custom titles for header and footer
    $pdf->setHeaderTitle('Comics Bookstore');
    $pdf->setFooterTitle('Developed by Duel Ninja - Comics Group - 2023');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('Arial', '', 12);

    // Retrieve comic details from the form
    $comicTitle = $_POST['comic_title'] ?? '';
    $comicPrice = $_POST['comic_price'] ?? '';

    // Retrieve form data
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $address = $_POST['address'] ?? '';
    $pincode = $_POST['pincode'] ?? '';
    $province = $_POST['province'] ?? '';

    

    // Write comic details to the PDF
    $pdf->Cell(0, 10, 'Comic Title: ' . $comicTitle, 0, 1);
    $pdf->Cell(0, 10, 'Comic Price: ' . $comicPrice, 0, 1);

    // Write content to the PDF
    $pdf->Ln();
    $pdf->Cell(0, 10, 'Username: ' . $username, 0, 1);
    $pdf->Cell(0, 10, 'Email: ' . $email, 0, 1);
    $pdf->Cell(0, 10, 'Mobile: ' . $mobile, 0, 1);
    $pdf->Cell(0, 10, 'Address: ' . $address, 0, 1);
    $pdf->Cell(0, 10, 'Pincode: ' . $pincode, 0, 1);
    $pdf->Cell(0, 10, 'Province: ' . $province, 0, 1);

    


    // Output PDF as a file
    $pdf->Output('orderdetails.pdf', 'D');
}
?>
