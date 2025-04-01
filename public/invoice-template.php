<?php
session_start();
$invoice = $_SESSION['current_invoice'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tax Invoice #<?php echo $invoice['invoice_number']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .business-details {
            flex: 1;
        }
        .invoice-details {
            text-align: right;
        }
        .client-details {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .total-row.final {
            font-weight: bold;
            font-size: 1.2em;
            border-top: 2px solid #000;
            padding-top: 5px;
        }
        .notes {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
        .gst-status {
            margin-top: 10px;
            padding: 5px 10px;
            display: inline-block;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .gst-registered {
            background-color: #e6f4ea;
            color: #1e7e34;
        }
        .gst-not-registered {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="business-details">
            <h1 style="font-size: 24px; margin-bottom: 10px;">TAX INVOICE</h1>
            <h2><?php echo htmlspecialchars($invoice['business_name']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($invoice['business_address'])); ?></p>
            <p>ABN: <?php echo htmlspecialchars($invoice['business_abn']); ?></p>
            <span class="gst-status <?php echo $invoice['gst_status'] === 'registered' ? 'gst-registered' : 'gst-not-registered'; ?>">
                <?php echo $invoice['gst_status'] === 'registered' ? 'GST Registered' : 'Not GST Registered'; ?>
            </span>
        </div>
        <div class="invoice-details">
            <h2>Invoice Details</h2>
            <p>Invoice #: <?php echo $invoice['invoice_number']; ?></p>
            <p>Date: <?php echo date('d/m/Y', strtotime($invoice['date'])); ?></p>
            <p>Due Date: <?php echo date('d/m/Y', strtotime($invoice['due_date'])); ?></p>
            <p>Payment Terms: <?php echo htmlspecialchars($invoice['payment_terms']); ?></p>
        </div>
    </div>

    <div class="client-details">
        <h3>Bill To:</h3>
        <p><?php echo htmlspecialchars($invoice['client_name']); ?></p>
        <p><?php echo nl2br(htmlspecialchars($invoice['client_address'])); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoice['items'] as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['description']); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>$<?php echo number_format($item['unit_price'], 2); ?></td>
                <td>$<?php echo number_format($item['total'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="totals">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>$<?php echo number_format($invoice['total'], 2); ?></span>
        </div>
        <?php if ($invoice['gst_status'] === 'registered'): ?>
        <div class="total-row">
            <span>GST (10%):</span>
            <span>$<?php echo number_format($invoice['gst'], 2); ?></span>
        </div>
        <div class="total-row final">
            <span>Total (including GST):</span>
            <span>$<?php echo number_format($invoice['total_with_gst'], 2); ?></span>
        </div>
        <?php else: ?>
        <div class="total-row final">
            <span>Total:</span>
            <span>$<?php echo number_format($invoice['total'], 2); ?></span>
        </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($invoice['notes'])): ?>
    <div class="notes">
        <h3>Notes:</h3>
        <p><?php echo nl2br(htmlspecialchars($invoice['notes'])); ?></p>
    </div>
    <?php endif; ?>

    <div class="footer">
        <p>This is a tax invoice for GST purposes.</p>
        <?php if ($invoice['gst_status'] === 'registered'): ?>
        <p>GST has been included in the total amount.</p>
        <?php else: ?>
        <p>No GST has been included in the total amount as the business is not registered for GST.</p>
        <?php endif; ?>
        <p>Thank you for your business!</p>
    </div>
</body>
</html> 
</html> 