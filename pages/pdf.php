<?php
require_once('fpdf/fpdf.php');

class PDF extends FPDF {
    private $headerTitle;
    private $footerTitle;

    //header title
    public function setHeaderTitle($title) {
        $this->headerTitle = $title;
    }

    //footer title
    public function setFooterTitle($title) {
        $this->footerTitle = $title;
    }

    // Page header
    function Header() {
        // background color for the header
        $this->SetFillColor(240, 79, 36);
        $this->Rect(0, 0, $this->GetPageWidth(), 20, 'F');

        // font and color for the header
        $this->SetFont('Arial', 'B', 25);
        $this->SetTextColor(0);
        // Title
        $this->Cell(0, 10, $this->headerTitle, 0, 1, 'C');
        // Line break
        $this->Ln(10);
    }

    // Page footer
    function Footer() {
        //background color for the footer
        $this->SetFillColor(240, 79, 36);
        $this->Rect(0, $this->GetPageHeight() - 20, $this->GetPageWidth(), 20, 'F');

        // Position
        $this->SetY(-15);
        //font
        $this->SetFont('Arial', 'I', 15);
        // Title
        $this->Cell(0, 10, $this->footerTitle ,  0, 0, 'C');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $pdf = new PDF();
    $pdf->SetTitle('Comics Bookstore');
    $pdf->SetSubject('Form Data PDF');
    $pdf->SetKeywords('Form, Data, PDF');

    $pdf->setHeaderTitle('Comics Bookstore');
    $pdf->setFooterTitle('Developed by Duel Ninja - Comics Group - 2023');

    $pdf->AddPage();

    $pdf->SetFont('Arial', '', 15);

    $comicTitle = $_POST['comic_title'] ?? '';
    $comicPrice = $_POST['comic_price'] ?? '';
    
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $address = $_POST['address'] ?? '';
    $pincode = $_POST['pincode'] ?? '';
    $province = $_POST['province'] ?? '';

    $pdf->Cell(0, 10, 'Comic Title: ' . $comicTitle, 0, 1);
    $pdf->Cell(0, 10, 'Comic Price: $' . $comicPrice, 0, 1);

    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(255, 0, 0); 
    $pdf->Cell(0, 10, 'Customer Information:', 0, 1);
    $pdf->SetFont('Arial', '', 12); 
    $pdf->SetTextColor(0); 
    $pdf->Cell(0, 10, 'Name: ' . $username, 0, 1);
    $pdf->Cell(0, 10, 'Email: ' . $email, 0, 1);
    $pdf->Cell(0, 10, 'Mobile: ' . $mobile, 0, 1);

    
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Address: ' . $address, 0, 1);
    $pdf->Cell(0, 10, 'Pincode: ' . $pincode, 0, 1);
    $pdf->Cell(0, 10, 'Province: ' . $province, 0, 1);

    // Output PDF as a file
    $pdf->Output('orderdetails.pdf', 'D');
}
?>
