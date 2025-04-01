<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

if (!isset($_SESSION['current_invoice'])) {
    header('Location: index.php');
    exit;
}

$invoice = $_SESSION['current_invoice'];

// Handle PDF generation
if (isset($_POST['download_pdf'])) {
    $html = file_get_contents(__DIR__ . '/invoice-template.php');
    
    $dompdf = new Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    $dompdf->stream("invoice-{$invoice['invoice_number']}.pdf");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Preview</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Invoice Preview</h1>
                <div class="space-x-4">
                    <form method="POST" class="inline">
                        <button type="submit" name="download_pdf" class="btn btn-primary">Download PDF</button>
                    </form>
                    <a href="index.php" class="btn btn-primary">Create New Invoice</a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <h2 class="text-xl font-semibold mb-4">From</h2>
                        <p class="font-medium"><?php echo htmlspecialchars($invoice['business_name']); ?></p>
                        <p class="whitespace-pre-line"><?php echo htmlspecialchars($invoice['business_address']); ?></p>
                        <p>ABN: <?php echo htmlspecialchars($invoice['business_abn']); ?></p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-xl font-semibold mb-4">Invoice Details</h2>
                        <p>Invoice #: <?php echo $invoice['invoice_number']; ?></p>
                        <p>Date: <?php echo date('d/m/Y', strtotime($invoice['date'])); ?></p>
                        <p>Due Date: <?php echo date('d/m/Y', strtotime($invoice['due_date'])); ?></p>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Bill To</h2>
                    <p class="font-medium"><?php echo htmlspecialchars($invoice['client_name']); ?></p>
                    <p class="whitespace-pre-line"><?php echo htmlspecialchars($invoice['client_address']); ?></p>
                </div>

                <div class="mb-8">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2">Description</th>
                                <th class="text-right py-2">Quantity</th>
                                <th class="text-right py-2">Unit Price</th>
                                <th class="text-right py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoice['items'] as $item): ?>
                            <tr class="border-b">
                                <td class="py-2"><?php echo htmlspecialchars($item['description']); ?></td>
                                <td class="text-right py-2"><?php echo $item['quantity']; ?></td>
                                <td class="text-right py-2">$<?php echo number_format($item['unit_price'], 2); ?></td>
                                <td class="text-right py-2">$<?php echo number_format($item['total'], 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="col-span-2"></div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span>$<?php echo number_format($invoice['total'], 2); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>GST (10%):</span>
                            <span>$<?php echo number_format($invoice['gst'], 2); ?></span>
                        </div>
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total:</span>
                            <span>$<?php echo number_format($invoice['total_with_gst'], 2); ?></span>
                        </div>
                    </div>
                </div>

                <?php if (!empty($invoice['notes'])): ?>
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4">Notes</h2>
                    <p class="whitespace-pre-line"><?php echo htmlspecialchars($invoice['notes']); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html> 