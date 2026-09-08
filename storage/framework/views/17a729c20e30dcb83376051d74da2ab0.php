<style>
/******************************************************
 * أنماط العرض على الشاشة
 ******************************************************/
#report-container {
    direction: rtl;
    font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
    padding: 10px;
}

.print-header-section {
    display: none;
}

.main-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 25px;
}

.main-stat-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
    border-radius: 15px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    border: 1px solid rgba(255,255,255,0.1);
}

.main-stat-card.blue { border-right: 5px solid #2196F3; }
.main-stat-card.orange { border-right: 5px solid #FF9800; }
.main-stat-card.purple { border-right: 5px solid #9C27B0; }
.main-stat-card.green { border-right: 5px solid #4CAF50; }

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    background: rgba(255,255,255,0.1);
    color: #fff;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    color: #fff;
}

.stat-label {
    color: #aaa;
    font-size: 0.9rem;
}

.report-card {
    background: rgba(255,255,255,0.05);
    border-radius: 15px;
    margin-bottom: 25px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.1);
}

.card-header {
    padding: 15px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1.15rem;
    font-weight: 600;
    color: #fff;
}

.card-header i { font-size: 1.3rem; }
.card-header.blue { background: linear-gradient(135deg, #2196F3, #1976D2); }
.card-header.orange { background: linear-gradient(135deg, #FF9800, #F57C00); }
.card-header.purple { background: linear-gradient(135deg, #9C27B0, #7B1FA2); }
.card-header.green { background: linear-gradient(135deg, #4CAF50, #388E3C); }
.card-header.teal { background: linear-gradient(135deg, #009688, #00796B); }
.card-header.red { background: linear-gradient(135deg, #f44336, #D32F2F); }

.card-body { padding: 20px; }

.stats-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

.stats-grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
}

.stat-group h4 {
    color: #7fb069;
    font-size: 1rem;
    margin: 0 0 12px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid rgba(127,176,105,0.3);
    display: flex;
    align-items: center;
    gap: 8px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table td {
    padding: 10px 12px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    color: #e0e0e0;
    font-size: 0.95rem;
}

.data-table tfoot td {
    background: rgba(127,176,105,0.15);
    border-bottom: none;
    color: #fff;
}

.data-table .number {
    text-align: left;
    font-weight: 600;
    color: #fff;
}

.data-table .percent {
    text-align: left;
    color: #aaa;
    font-size: 0.85rem;
}

.data-table.highlight .row-success { background: rgba(76,175,80,0.1); }
.data-table.highlight .row-warning { background: rgba(255,152,0,0.1); }
.data-table.highlight .row-danger { background: rgba(244,67,54,0.1); }

.full-table {
    width: 100%;
    border-collapse: collapse;
}

.full-table th,
.full-table td {
    padding: 12px 10px;
    border: 1px solid rgba(255,255,255,0.15);
    color: #e0e0e0;
    text-align: center;
}

.full-table th {
    background: rgba(0,0,0,0.3);
    color: #fff;
    font-weight: 600;
}

.full-table .name {
    text-align: right;
    font-weight: 500;
}

.full-table .number { font-weight: 600; }

.full-table tfoot td {
    background: rgba(127,176,105,0.2);
    font-weight: 600;
    color: #fff;
}

.full-table.compact th,
.full-table.compact td {
    padding: 8px 6px;
    font-size: 0.9rem;
}

.badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 5px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge.green { background: #4CAF50; color: #fff; }
.badge.yellow { background: #FFC107; color: #000; }
.badge.red { background: #f44336; color: #fff; }
.badge.blue { background: #2196F3; color: #fff; }
.badge.gray { background: #9E9E9E; color: #fff; }

.text-success { color: #4CAF50 !important; }
.text-danger { color: #f44336 !important; }
.text-warning { color: #FF9800 !important; }
.text-info { color: #2196F3 !important; }

.report-footer {
    text-align: center;
    padding: 20px;
    color: #888;
    border-top: 1px solid rgba(255,255,255,0.1);
    margin-top: 20px;
}

.report-footer p { margin: 5px 0; }

/******************************************************
 * أنماط الطباعة
 ******************************************************/
@media print {
    @page {
        size: A4;
        margin: 10mm;
    }

    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
    }

    body {
        background: #fff !important;
        font-size: 10pt !important;
        line-height: 1.4 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .no-print,
    .sidebar,
    .main-header,
    nav,
    header,
    .breadcrumb,
    .alert {
        display: none !important;
    }

    .main-content {
        margin: 0 !important;
        padding: 0 !important;
    }

    #report-container { padding: 0 !important; }

    .print-header-section {
        display: block !important;
        text-align: center;
        padding: 15px 0 20px;
        border-bottom: 2px solid #333;
        margin-bottom: 20px;
    }

    .print-header-section h1 {
        font-size: 18pt;
        color: #000;
        margin: 0 0 5px 0;
    }

    .print-header-section h2 {
        font-size: 13pt;
        color: #444;
        margin: 0 0 10px 0;
        font-weight: normal;
    }

    .print-header-section .print-date {
        display: flex;
        justify-content: center;
        gap: 30px;
        font-size: 10pt;
        color: #666;
    }

    .main-stats-grid {
        display: table !important;
        width: 100% !important;
        margin-bottom: 15px !important;
        border: 1px solid #999 !important;
    }

    .main-stat-card {
        display: table-cell !important;
        width: 25% !important;
        padding: 12px !important;
        border-left: 1px solid #ccc !important;
        background: #fafafa !important;
        text-align: center !important;
        vertical-align: middle !important;
    }

    .main-stat-card:last-child { border-left: none !important; }
    .main-stat-card.blue { border-top: 3px solid #64B5F6 !important; }
    .main-stat-card.orange { border-top: 3px solid #FFB74D !important; }
    .main-stat-card.purple { border-top: 3px solid #BA68C8 !important; }
    .main-stat-card.green { border-top: 3px solid #81C784 !important; }

    .stat-icon { display: none !important; }
    .stat-info { display: block !important; }

    .stat-number {
        font-size: 18pt !important;
        color: #000 !important;
        display: block !important;
    }

    .stat-label {
        font-size: 9pt !important;
        color: #333 !important;
        display: block !important;
    }

    .report-card {
        background: #fff !important;
        border: 1px solid #999 !important;
        border-radius: 0 !important;
        margin-bottom: 15px !important;
        page-break-inside: avoid;
    }

    .card-header {
        padding: 8px 15px !important;
        color: #fff !important;
        font-size: 11pt !important;
    }

    .card-header.blue { background: #5C9BD1 !important; }
    .card-header.orange { background: #E8A545 !important; }
    .card-header.purple { background: #9575CD !important; }
    .card-header.green { background: #6BAF6B !important; }
    .card-header.teal { background: #4DB6AC !important; }
    .card-header.red { background: #E57373 !important; }

    .card-body { padding: 15px !important; }

    .stats-grid-3,
    .stats-grid-2 {
        display: table !important;
        width: 100% !important;
    }

    .stats-grid-3 .stat-group {
        display: table-cell !important;
        width: 33.33% !important;
        vertical-align: top !important;
        padding: 0 10px !important;
        border-left: 1px solid #e0e0e0 !important;
    }

    .stats-grid-3 .stat-group:last-child { border-left: none !important; }

    .stats-grid-2 .stat-group {
        display: table-cell !important;
        width: 50% !important;
        vertical-align: top !important;
        padding: 0 10px !important;
        border-left: 1px solid #e0e0e0 !important;
    }

    .stats-grid-2 .stat-group:last-child { border-left: none !important; }

    .stat-group h4 {
        color: #333 !important;
        font-size: 10pt !important;
        border-bottom: 1px solid #999 !important;
        margin-bottom: 8px !important;
        padding-bottom: 5px !important;
    }

    .data-table { border: 1px solid #bbb !important; }

    .data-table td {
        padding: 6px 8px !important;
        border-bottom: 1px solid #ddd !important;
        color: #000 !important;
        font-size: 9pt !important;
    }

    .data-table tfoot td {
        background: #f0f0f0 !important;
        color: #000 !important;
        font-weight: bold !important;
    }

    .data-table .number {
        color: #000 !important;
        font-weight: bold !important;
    }

    .data-table .percent { color: #666 !important; }

    .data-table.highlight .row-success { background: #E8F5E9 !important; }
    .data-table.highlight .row-warning { background: #FFF8E1 !important; }
    .data-table.highlight .row-danger { background: #FFEBEE !important; }

    .full-table { border: 1px solid #999 !important; }

    .full-table th,
    .full-table td {
        border: 1px solid #ccc !important;
        color: #000 !important;
        padding: 8px 6px !important;
        font-size: 9pt !important;
    }

    .full-table th {
        background: #f5f5f5 !important;
        font-weight: bold !important;
    }

    .full-table tfoot td {
        background: #e8e8e8 !important;
        font-weight: bold !important;
    }

    .full-table.compact th,
    .full-table.compact td {
        padding: 5px 4px !important;
        font-size: 8pt !important;
    }

    .badge {
        border: 1px solid #888 !important;
        padding: 2px 6px !important;
        font-size: 8pt !important;
    }

    .badge.green { background: #E8F5E9 !important; color: #2E7D32 !important; border-color: #81C784 !important; }
    .badge.yellow { background: #FFF8E1 !important; color: #F57F17 !important; border-color: #FFD54F !important; }
    .badge.red { background: #FFEBEE !important; color: #C62828 !important; border-color: #E57373 !important; }
    .badge.blue { background: #E3F2FD !important; color: #1565C0 !important; border-color: #64B5F6 !important; }
    .badge.gray { background: #F5F5F5 !important; color: #616161 !important; border-color: #BDBDBD !important; }

    .text-success { color: #2E7D32 !important; }
    .text-danger { color: #C62828 !important; }
    .text-warning { color: #EF6C00 !important; }
    .text-info { color: #1565C0 !important; }

    .report-footer {
        display: block !important;
        text-align: center;
        padding: 15px 0;
        border-top: 1px solid #999;
        margin-top: 15px;
        font-size: 9pt;
        color: #555;
    }

    .page-break { page-break-before: always; }
    strong { color: #000 !important; }
}
</style>
<?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/reports/partials/styles.blade.php ENDPATH**/ ?>