<?php
/**
 * Simple PDF Generator for Receipts
 * Uses basic HTML to PDF conversion
 */

class SimplePDF {
    private $html;
    private $title;
    
    public function __construct($title = 'Comprobante de Pago') {
        $this->title = $title;
        $this->html = '';
    }
    
    public function addContent($content) {
        $this->html .= $content;
    }
    
    public function generateReceiptPDF($receipt) {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>' . htmlspecialchars($this->title) . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
                .header h1 { color: #0d6efd; margin: 0; }
                .info-box { background: #f8f9fa; padding: 15px; margin: 20px 0; border-left: 4px solid #0d6efd; }
                .info-row { margin: 10px 0; }
                .info-label { font-weight: bold; display: inline-block; width: 200px; }
                .amount-box { background: #d1ecf1; padding: 20px; text-align: center; margin: 30px 0; border: 2px solid #0c5460; }
                .amount-box h2 { margin: 0; color: #0c5460; }
                .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; border-top: 1px solid #ddd; padding-top: 20px; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                table th, table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
                table th { background-color: #f8f9fa; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>RecaudaBot</h1>
                <p>Sistema Integral de Recaudación Municipal</p>
                <h2>Comprobante de Pago</h2>
            </div>
            
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">No. Comprobante:</span>
                    <span>' . htmlspecialchars($receipt['receipt_number']) . '</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Fecha de Emisión:</span>
                    <span>' . date('d/m/Y H:i:s', strtotime($receipt['created_at'])) . '</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ciudadano:</span>
                    <span>' . htmlspecialchars($receipt['full_name']) . '</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span>' . htmlspecialchars($receipt['email']) . '</span>
                </div>
            </div>
            
            <h3>Detalle del Pago</h3>
            <table>
                <tr>
                    <th>Concepto</th>
                    <th>Tipo de Pago</th>
                    <th>Monto</th>
                </tr>
                <tr>
                    <td>' . htmlspecialchars($receipt['description'] ?? 'Pago de obligación municipal') . '</td>
                    <td>' . htmlspecialchars($receipt['payment_type']) . '</td>
                    <td>$' . number_format($receipt['amount'], 2) . '</td>
                </tr>
            </table>
            
            <div class="amount-box">
                <h2>Total Pagado: $' . number_format($receipt['amount'], 2) . '</h2>
                <p>Método de Pago: ' . htmlspecialchars($receipt['payment_method']) . '</p>
                <p>Referencia de Transacción: ' . htmlspecialchars($receipt['transaction_id'] ?? 'N/A') . '</p>
            </div>
            
            <div class="info-box">
                <p><strong>Estado del Pago:</strong> ' . htmlspecialchars($receipt['status']) . '</p>
                <p><strong>Fecha de Pago:</strong> ' . date('d/m/Y H:i:s', strtotime($receipt['paid_at'])) . '</p>
            </div>
            
            <div class="footer">
                <p>Este comprobante es válido como prueba de pago ante las autoridades municipales.</p>
                <p>Para cualquier aclaración, favor de comunicarse al 01 800 123 4567</p>
                <p>o visitar nuestras oficinas en el Palacio Municipal</p>
                <hr>
                <p><strong>RecaudaBot</strong> - Sistema Integral de Recaudación Municipal</p>
                <p>Documento generado electrónicamente - ' . date('d/m/Y H:i:s') . '</p>
            </div>
        </body>
        </html>
        ';
        
        return $html;
    }
    
    public function output($filename = 'document.pdf', $receipt = null) {
        if ($receipt) {
            $this->html = $this->generateReceiptPDF($receipt);
        }
        
        // For modern browsers, we can use wkhtmltopdf or similar
        // For now, we'll output HTML that can be printed as PDF
        header('Content-Type: text/html; charset=utf-8');
        header('Content-Disposition: inline; filename="' . $filename . '.html"');
        echo $this->html;
    }
}
