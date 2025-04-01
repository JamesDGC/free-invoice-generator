<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

// Initialize invoice number if not exists
if (!isset($_SESSION['invoice_number'])) {
    $_SESSION['invoice_number'] = 1;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['generate_invoice'])) {
        // Store invoice data in session
        $_SESSION['current_invoice'] = [
            'invoice_number' => $_SESSION['invoice_number'],
            'date' => $_POST['date'],
            'due_date' => $_POST['due_date'],
            'business_name' => $_POST['business_name'],
            'business_address' => $_POST['business_address'],
            'business_abn' => $_POST['business_abn'],
            'client_name' => $_POST['client_name'],
            'client_address' => $_POST['client_address'],
            'items' => $_POST['items'],
            'total' => $_POST['total'],
            'gst' => $_POST['gst'],
            'total_with_gst' => $_POST['total_with_gst'],
            'notes' => $_POST['notes']
        ];
        
        // Increment invoice number
        $_SESSION['invoice_number']++;
        
        // Redirect to preview page
        header('Location: preview.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Free Australian invoice generator with GST calculation. Create professional invoices compliant with ATO requirements. No login required.">
    <meta name="keywords" content="invoice generator, Australian invoice, GST calculator, free invoice, ATO compliant, business invoice, invoice template, tax invoice, BAS statement, Australian business number, invoice software, invoice maker, invoice creator, invoice builder, invoice generator Australia, free invoice template, invoice format, invoice example, invoice sample, invoice requirements, invoice rules, invoice law, invoice regulations, invoice compliance, invoice system, invoice management, invoice tracking, invoice software Australia, invoice app, invoice tool, invoice solution, invoice service, invoice platform, invoice website, invoice online, invoice digital, invoice electronic, invoice paperless, invoice automation, invoice workflow, invoice process, invoice best practices, invoice tips, invoice guide, invoice help, invoice support, invoice tutorial, invoice documentation, invoice FAQ, invoice questions, invoice answers, invoice solutions, invoice problems, invoice issues, invoice errors, invoice mistakes, invoice corrections, invoice updates, invoice changes, invoice improvements, invoice features, invoice benefits, invoice advantages, invoice disadvantages, invoice pros, invoice cons, invoice comparison, invoice alternatives, invoice options, invoice choices, invoice selection, invoice decision, invoice planning, invoice strategy, invoice management, invoice organization, invoice structure, invoice design, invoice layout, invoice style, invoice format, invoice template, invoice sample, invoice example, invoice guide, invoice tutorial, invoice help, invoice support, invoice documentation, invoice FAQ, invoice questions, invoice answers, invoice solutions, invoice problems, invoice issues, invoice errors, invoice mistakes, invoice corrections, invoice updates, invoice changes, invoice improvements, invoice features, invoice benefits, invoice advantages, invoice disadvantages, invoice pros, invoice cons, invoice comparison, invoice alternatives, invoice options, invoice choices, invoice selection, invoice decision, invoice planning, invoice strategy, invoice management, invoice organization, invoice structure, invoice design, invoice layout, invoice style">
    <meta name="author" content="Free Invoice Generator">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Free Australian Invoice Generator with GST">
    <meta property="og:description" content="Create professional invoices compliant with ATO requirements. Free to use, no login required.">
    <meta property="og:type" content="website">
    <title>Free Invoice Generator | Australian GST Calculator | ATO Compliant</title>
    <link href="css/styles.css" rel="stylesheet">
    
    <!-- Structured Data for Web Application -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "Free Australian Invoice Generator",
        "description": "Create professional invoices compliant with ATO requirements. Includes GST calculation and ABN support.",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "Web Browser",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "AUD"
        },
        "featureList": [
            "GST Calculation",
            "ABN Support",
            "PDF Export",
            "ATO Compliance",
            "No Login Required"
        ]
    }
    </script>
</head>
<body class="bg-background">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                        <span class="text-white text-xl font-bold">FI</span>
                    </div>
                    <h1 class="text-2xl font-bold gradient-text">freeinvoicegenerator.au</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="badge badge-primary">ATO Compliant</span>
                    <span class="badge badge-success">GST Ready</span>
                </div>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column: Invoice Generator -->
            <div>
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold mb-4 gradient-text">Create Your Invoice</h2>
                    <p class="text-lg text-gray-600">Generate ATO-compliant invoices with automatic GST calculation. Free to use, no login required.</p>
                </div>

                <div class="card gradient-border mb-8">
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Quick Start Guide</h3>
                        <ol class="list-decimal list-inside space-y-2 text-gray-600">
                            <li>Enter your business details including ABN and GST status</li>
                            <li>Fill in the invoice details (number, dates, payment terms)</li>
                            <li>Add your client's information</li>
                            <li>Enter items with descriptions and prices</li>
                            <li>Add more items if needed using the "Add Item" button</li>
                            <li>Review the automatically calculated totals</li>
                            <li>Add any additional notes</li>
                            <li>Click "Generate Invoice" to create your PDF</li>
                        </ol>
                    </div>

                    <form method="POST" class="space-y-6">
                        <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="feature-card">
                                <h4 class="text-lg font-semibold mb-6">Your Business Details</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
                                        <input type="text" name="business_name" required class="input input-focus" placeholder="Enter your business name">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Business Address</label>
                                        <textarea name="business_address" required class="input input-focus" rows="3" placeholder="Enter your business address"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">ABN</label>
                                        <input type="text" name="business_abn" required class="input input-focus" placeholder="Enter your ABN">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">GST Status</label>
                                        <select name="gst_status" required class="input input-focus">
                                            <option value="registered">Registered for GST</option>
                                            <option value="not_registered">Not Registered for GST</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="feature-card">
                                <h4 class="text-lg font-semibold mb-6">Invoice Details</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Invoice Number</label>
                                        <input type="text" value="<?php echo $_SESSION['invoice_number']; ?>" readonly class="input bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                        <input type="date" name="date" required class="input input-focus" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                                        <input type="date" name="due_date" required class="input input-focus">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Terms</label>
                                        <input type="text" name="payment_terms" required class="input input-focus" placeholder="e.g., Due within 30 days" value="Due within 30 days">
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="feature-card">
                            <h4 class="text-lg font-semibold mb-6">Client Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Client Name</label>
                                    <input type="text" name="client_name" required class="input input-focus" placeholder="Enter client name">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Client Address</label>
                                    <textarea name="client_address" required class="input input-focus" rows="3" placeholder="Enter client address"></textarea>
                                </div>
                            </div>
                        </section>

                        <section class="feature-card">
                            <h4 class="text-lg font-semibold mb-6">Items</h4>
                            <div id="items-container">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                        <input type="text" name="items[0][description]" required class="input input-focus" placeholder="Item description">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                        <input type="number" name="items[0][quantity]" required class="input input-focus" min="1" value="1">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Unit Price</label>
                                        <input type="number" name="items[0][unit_price]" required class="input input-focus" step="0.01" placeholder="0.00">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                                        <input type="number" name="items[0][total]" readonly class="input bg-gray-50">
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-item" class="btn btn-secondary">Add Item</button>
                        </section>

                        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="stats-card">
                                <div class="stats-number">$<span id="subtotal">0.00</span></div>
                                <div class="stats-label">Subtotal</div>
                            </div>
                            <div class="stats-card">
                                <div class="stats-number">$<span id="gst">0.00</span></div>
                                <div class="stats-label">GST (10%)</div>
                            </div>
                            <div class="stats-card">
                                <div class="stats-number">$<span id="total">0.00</span></div>
                                <div class="stats-label">Total with GST</div>
                            </div>
                        </section>

                        <section class="feature-card">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="notes" class="input input-focus" rows="3" placeholder="Add any additional notes or terms"></textarea>
                            <p class="mt-2 text-sm text-gray-500">This invoice is a tax invoice for GST purposes. GST will be added to the total amount if you are registered for GST.</p>
                        </section>

                        <div class="flex justify-end">
                            <button type="submit" name="generate_invoice" class="btn gradient-btn">Generate Invoice</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Content & SEO -->
            <div class="space-y-8">
                <section class="card">
                    <h2 class="text-2xl font-bold mb-4 gradient-text">Australian Invoice Requirements</h2>
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-600 mb-4">According to the ATO, your tax invoice must include:</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600">
                            <li>Your business name and ABN</li>
                            <li>Invoice number and date</li>
                            <li>Description of goods/services</li>
                            <li>Quantity and unit price</li>
                            <li>Total amount</li>
                            <li>GST amount (if applicable)</li>
                            <li>Total including GST</li>
                            <li>Payment terms</li>
                        </ul>
                    </div>
                </section>

                <section class="card">
                    <h2 class="text-2xl font-bold mb-4 gradient-text">GST & Tax Invoice Information</h2>
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-600 mb-4">Important information about GST and tax invoices:</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600">
                            <li>GST-registered businesses must issue tax invoices for sales over $82.50</li>
                            <li>Tax invoices must be issued within 28 days of the sale</li>
                            <li>Digital invoices are accepted by the ATO</li>
                            <li>GST must be clearly shown on the invoice</li>
                            <li>ABN must be displayed on all invoices</li>
                        </ul>
                    </div>
                </section>

                <section class="card">
                    <h2 class="text-2xl font-bold mb-4 gradient-text">Why Choose Our Invoice Generator?</h2>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="feature-card hover-card">
                            <div class="feature-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">ATO Compliant</h3>
                            <p class="text-gray-600">Generate invoices that meet all ATO requirements</p>
                        </div>
                        <div class="feature-card hover-card">
                            <div class="feature-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">GST Ready</h3>
                            <p class="text-gray-600">Automatic GST calculation included</p>
                        </div>
                        <div class="feature-card hover-card">
                            <div class="feature-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">PDF Export</h3>
                            <p class="text-gray-600">Download your invoice as PDF</p>
                        </div>
                    </div>
                </section>

                <section class="card">
                    <h2 class="text-2xl font-bold mb-4 gradient-text">Frequently Asked Questions</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">What is a tax invoice?</h3>
                            <p class="text-gray-600">A tax invoice is a document that shows the details of a transaction and is required for GST purposes. It must include specific information as per ATO requirements.</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">When do I need to issue a tax invoice?</h3>
                            <p class="text-gray-600">You must issue a tax invoice when you make a taxable sale of more than $82.50 (including GST) to another business.</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">What information must be on a tax invoice?</h3>
                            <p class="text-gray-600">A tax invoice must include your business name, ABN, invoice number, date, description of goods/services, amounts, and GST information.</p>
                        </div>
                    </div>
                </section>

                <section class="card">
                    <h2 class="text-2xl font-bold mb-4 gradient-text">Invoice Templates & Examples</h2>
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-600 mb-4">Our invoice generator creates professional templates that include:</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600">
                            <li>Clean, professional layout</li>
                            <li>All required ATO information</li>
                            <li>Automatic GST calculations</li>
                            <li>Customizable notes section</li>
                            <li>PDF format for easy sharing</li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t mt-12">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-600 text-sm">
                    © <?php echo date('Y'); ?> freeinvoicegenerator.au - ATO Compliant | GST Ready | No Login Required
                </p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-600 hover:text-primary text-sm transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-600 hover:text-primary text-sm transition-colors">Terms of Use</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemsContainer = document.getElementById('items-container');
            const addItemButton = document.getElementById('add-item');
            let itemCount = 1;

            function updateTotals() {
                let subtotal = 0;
                document.querySelectorAll('[name^="items"][name$="[total]"]').forEach(input => {
                    subtotal += parseFloat(input.value) || 0;
                });

                const gst = subtotal * 0.1;
                const totalWithGST = subtotal + gst;

                document.getElementById('subtotal').textContent = subtotal.toFixed(2);
                document.getElementById('gst').textContent = gst.toFixed(2);
                document.getElementById('total').textContent = totalWithGST.toFixed(2);
            }

            function calculateItemTotal(row) {
                const quantity = parseFloat(row.querySelector('[name$="[quantity]"]').value) || 0;
                const unitPrice = parseFloat(row.querySelector('[name$="[unit_price]"]').value) || 0;
                const total = quantity * unitPrice;
                row.querySelector('[name$="[total]"]').value = total.toFixed(2);
                updateTotals();
            }

            addItemButton.addEventListener('click', function() {
                const newRow = document.createElement('div');
                newRow.className = 'grid grid-cols-1 md:grid-cols-4 gap-4 mb-4';
                newRow.innerHTML = `
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <input type="text" name="items[${itemCount}][description]" required class="input input-focus" placeholder="Item description">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <input type="number" name="items[${itemCount}][quantity]" required class="input input-focus" min="1" value="1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unit Price</label>
                        <input type="number" name="items[${itemCount}][unit_price]" required class="input input-focus" step="0.01" placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                        <input type="number" name="items[${itemCount}][total]" readonly class="input bg-gray-50">
                    </div>
                `;

                const inputs = newRow.querySelectorAll('input');
                inputs.forEach(input => {
                    if (input.name.includes('quantity') || input.name.includes('unit_price')) {
                        input.addEventListener('input', () => calculateItemTotal(newRow));
                    }
                });

                itemsContainer.appendChild(newRow);
                itemCount++;
            });

            // Add event listeners to the first row
            const firstRow = itemsContainer.querySelector('.grid');
            const firstRowInputs = firstRow.querySelectorAll('input');
            firstRowInputs.forEach(input => {
                if (input.name.includes('quantity') || input.name.includes('unit_price')) {
                    input.addEventListener('input', () => calculateItemTotal(firstRow));
                }
            });
        });
    </script>
</body>
</html> 