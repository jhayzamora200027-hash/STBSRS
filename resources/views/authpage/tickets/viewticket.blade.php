@extends('layouts.app')

@section('title', 'ViewTicket')

@section('content')
@php
    $resolutionLocked = in_array($ticket->ticket_status, ['completed', 'rejected'], true);
@endphp
<style>
.page-break {
    page-break-before: always;
    break-before: page;
}
.ticket-program-list {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: .35rem 1.25rem;
    margin: 0;
    padding: 0;
    list-style: none;
}
.ticket-program-list li {
    position: relative;
    padding-left: 1rem;
    overflow-wrap: anywhere;
}
.ticket-program-list li::before {
    position: absolute;
    top: .55em;
    left: .15rem;
    width: .35rem;
    height: .35rem;
    border-radius: 50%;
    background: #2563eb;
    content: '';
}
.print-program-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    column-gap: 8px;
    row-gap: 0;
    margin: 0;
    padding: 2px 6px;
    list-style: none;
    font-size: 11px;
    line-height: 1.15;
}
.print-program-list li {
    padding-left: 0;
    overflow-wrap: anywhere;
}
.print-program-list li::before {
    position: static;
    display: inline;
    width: auto;
    height: auto;
    margin-right: 3px;
    border-radius: 0;
    background: none;
    content: '•';
}
@media (max-width: 576px) {
    .ticket-program-list {
        grid-template-columns: 1fr;
    }
}
@media print {
    .print-header { display: block; position: static; }
    .print-footer { display: block; position: static; }

    .print-page {
        min-height: 264mm;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        break-inside: avoid;
        page-break-inside: avoid;
    }

    .print-page > .print-footer { margin-top: auto; }

    #printArea > section.print-page:last-of-type > .print-footer {
        margin-top: auto;
    }

    #printArea > section.print-page:last-of-type {
        min-height: 280mm;
    }

    #printArea { padding-top: 0; padding-bottom: 0; }
}
.resolution-panel {
    border-radius: 14px;
    border: 1px solid #e6e9ee;
    box-shadow: 0 8px 22px rgba(15, 23, 42, .05);
    overflow: hidden;
    height:100%;
}

.resolution-panel .card-header {
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    border-bottom: 1px solid #eef0f3;
}

.resolution-panel .card-header i {
    color: #2563eb;
    font-size: 1.05rem;
}

.resolution-panel .card-header small {
    white-space: nowrap;
}

.resolution-state {
    display: flex;
    align-items: flex-start;
    gap: .65rem;
    padding: .75rem .8rem;
    margin-bottom: 1.1rem;
    border: 1px solid #dbeafe;
    border-radius: 10px;
    background: #eff6ff;
    color: #1e3a8a;
    font-size: .82rem;
    line-height: 1.45;
}

.resolution-state i {
    margin-top: .1rem;
    color: #2563eb;
}

.resolution-state.is-locked {
    border-color: #d1fae5;
    background: #ecfdf5;
    color: #065f46;
}

.resolution-state.is-locked i {
    color: #059669;
}

.resolution-panel .form-label {
    color: #334155;
    font-size: .78rem;
    font-weight: 700;
    margin-bottom: .4rem;
}

.resolution-panel .form-control,
.resolution-panel .form-select {
    border-color: #d9dee7;
    box-shadow: none;
}

.resolution-panel .form-control:focus,
.resolution-panel .form-select:focus {
    border-color: #94a3b8;
    box-shadow: 0 0 0 .2rem rgba(100, 116, 139, .12);
}

.resolution-panel textarea {
    min-height: 7.5rem;
    resize: vertical;
}

.resolution-file-picker {
    display: flex;
    align-items: center;
    gap: .75rem;
    min-height: 3.25rem;
    padding: .45rem .65rem;
    border: 1px dashed #b9c4d4;
    border-radius: 10px;
    background: #f8fafc;
    transition: border-color .2s ease, background .2s ease;
}

.resolution-file-picker:focus-within,
.resolution-file-picker:hover {
    border-color: #2563eb;
    background: #eff6ff;
}

.resolution-file-picker input[type="file"] {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

.resolution-file-picker label {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    flex: 0 0 auto;
    padding: .45rem .65rem;
    border-radius: 7px;
    background: #1e293b;
    color: #fff;
    cursor: pointer;
    font-size: .82rem;
    font-weight: 700;
}

.resolution-file-picker input:disabled + label {
    cursor: not-allowed;
    opacity: .55;
}

.resolution-file-name {
    min-width: 0;
    overflow: hidden;
    color: #64748b;
    font-size: .82rem;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.resolution-attachments {
    display: grid;
    gap: .35rem;
    padding-top: .15rem;
}

.resolution-attachment-item {
    min-width: 0;
    padding: .45rem .55rem;
    border-radius: 7px;
    background: #f8fafc;
}

.resolution-attachment-item a {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.resolution-submit {
    min-height: 2.75rem;
    border-radius: 8px;
    font-weight: 700;
}

@media (max-width: 575.98px) {
    .resolution-panel .card-header {
        align-items: flex-start !important;
        gap: .5rem;
    }

    .resolution-panel .card-header small {
        white-space: normal;
        text-align: right;
    }
}

.resolution-attachments a {
    color: #475569;
    text-decoration: none;
}

.resolution-attachments a:hover {
    color: #0f172a;
    text-decoration: underline;
}

.back-btn{
    display: inline-flex;
    align-items: center;
    gap: .6rem;
    background: #fff;
    color: #212529;
    text-decoration: none;
    border: 1px solid #e9ecef;
    border-radius: 50px;
    font-weight: 600;
    box-shadow: 0 .25rem .75rem rgba(0,0,0,.08);
    transition: all .3s ease;
    overflow: hidden;
}

.back-btn i{
    font-size: 1.1rem;
    transition: transform .3s ease;
}

.back-btn:hover{
    background: #0d6efd;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 .75rem 1.5rem rgba(13,110,253,.25);
}

.back-btn:hover i{
    transform: translateX(-6px);
}

.back-btn:active{
    transform: scale(.96);
}

.back-btn::after{
    content:'';
    position:absolute;
    width:0;
    height:100%;
    left:0;
    top:0;
    background:rgba(255,255,255,.15);
    transition:width .4s ease;
}

.back-btn{
    position:relative;
}

.back-btn:hover::after{
    width:100%;
}

.copy-ticket{
    transition: all .2 ease;
}

.copy-ticket:hover{
    transform: scale(1.1);
    color: #fff;
}
.tab-buttons:hover{
    transform: scale(1.1);
    color:#0d6efd;
}
.ticket-tabs{

    position:relative;

    display:flex;

    background:#fff;

    border-radius:16px;

    padding:8px;

    border:1px solid #e5e7eb;

    box-shadow:0 8px 25px rgba(0,0,0,.05);

    overflow:hidden;

}

.ticket-tab{

    flex:1;

    position:relative;

    z-index:2;

    border:none;

    background:transparent;

    padding:15px 20px;

    border-radius:12px;

    color:#64748b;

    font-weight:600;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:10px;

    transition:.35s ease;

}

.ticket-tab i{

    font-size:18px;

}

.ticket-tab:hover{

    color:#2563eb;

    transform:translateY(-2px);

}

.ticket-tab.active{

    color:#2563eb;

}

.tab-indicator{

    position:absolute;

    top:8px;

    left:8px;

    width:calc(25% - 10px);

    height:calc(100% - 16px);

    background:#EEF4FF;

    border-radius:12px;

    transition:.35s cubic-bezier(.4,0,.2,1);

    z-index:1;

}

@media (max-width: 767.98px) {
    .ticket-tabs {
        padding: 6px;
    }

    .ticket-tab{
        justify-content:flex-start;
        padding:10px 12px;
        gap:8px;
        border-radius:10px;
    }

    .ticket-tab i{ margin-right:8px; }

    .tab-indicator{ display:none; }
}

.request-card{

    border-radius:20px;

    overflow:hidden;

    background:#fff;

}

.request-header{

    padding:25px 30px;

    background:linear-gradient(135deg,#2563eb,#1d4ed8);

    color:#fff;

}

.request-icon{

    width:60px;

    height:60px;

    border-radius:16px;

    background:rgba(255,255,255,.15);

    display:flex;

    justify-content:center;

    align-items:center;

    backdrop-filter:blur(10px);

}

.request-icon i{

    font-size:28px;

}

.info-box{

    background:#f8fafc;

    border:1px solid #e5e7eb;

    border-radius:16px;

    padding:22px;

    transition:.3s;

    min-height:150px;

}

.knowledge-panel {
    background: #f7f9fc;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    box-shadow: 0 10px 28px rgba(15, 23, 42, 0.04);
    overflow: hidden;
}

.knowledge-panel-header {
    display: flex;
    align-items: center;
    gap: 0.9rem;
    padding: 1.1rem 1.25rem 0.9rem;
    border-bottom: 1px solid #e7ebf1;
    background: linear-gradient(180deg, #ffffff 0%, #f5f8ff 100%);
}

.knowledge-panel-icon {
    width: 42px;
    height: 42px;
    min-width: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(37, 99, 235, 0.1);
    color: #2563eb;
    font-size: 1.3rem;
}

.knowledge-panel-kicker {
    margin: 0;
    color: #0f172a;
    font-size: 0.88rem;
    font-weight: 700;
    letter-spacing: 0.01em;
}

.knowledge-panel-subtitle {
    margin: 0.2rem 0 0;
    color: #475569;
    font-size: 0.94rem;
    font-weight: 600;
}

.knowledge-list {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.85rem 1rem;
    padding: 1.1rem 1.25rem 1.2rem;
}

.knowledge-pill {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    padding: 0.72rem 0.9rem;
    border-radius: 10px;
    background: rgba(37, 99, 235, 0.06);
    border: 1px solid rgba(37, 99, 235, 0.12);
    color: #1d4ed8;
    font-size: 0.95rem;
    font-weight: 600;
    text-align: center;
    line-height: 1.3;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.knowledge-pill:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 16px rgba(37, 99, 235, 0.08);
    border-color: rgba(37, 99, 235, 0.25);
}

.resource-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    width: 100%;
}

.resource-title {
    margin: 0;
    color: #0f172a;
    font-size: 1.05rem;
    font-weight: 700;
    letter-spacing: -0.02em;
}

.resource-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1rem;
}

.resource-card {
    display: flex;
    align-items: center;
    gap: 0.9rem;
    min-height: 118px;
    padding: 1rem 1.15rem;
    border-radius: 16px;
    border: 1px solid #dfe5ee;
    background: #f8fafc;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.02);
}

.resource-card-icon {
    width: 42px;
    height: 42px;
    min-width: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(37, 99, 235, 0.12);
    color: #2563eb;
    font-size: 1.3rem;
}

.resource-card-body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 0.25rem;
    min-width: 0;
}

.resource-label {
    margin: 0;
    color: #2563eb;
    font-size: 1.12rem;
    font-weight: 700;
    line-height: 1.2;
}

.resource-value {
    margin: 0;
    color: #111827;
    font-size: 1.02rem;
    font-weight: 500;
    line-height: 1.5;
}

.resource-date-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1rem;
}

.resource-date-card {
    min-height: 118px;
    padding: 1rem 1.15rem;
    border-radius: 16px;
    border: 1px solid #dfe5ee;
    background: #f8fafc;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.02);
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.resource-date-label {
    margin: 0 0 0.55rem;
    color: #0f172a;
    font-size: 1.12rem;
    font-weight: 700;
    line-height: 1.2;
}

.resource-date-value {
    margin: 0;
    color: #0f172a;
    font-size: 1.05rem;
    font-weight: 500;
    line-height: 1.5;
}

.info-box:hover{

    transform:translateY(-3px);

    box-shadow:0 10px 25px rgba(0,0,0,.06);

}

.info-title{

    display:flex;

    align-items:center;

    gap:10px;

    color:#2563eb;

    font-weight:700;

    margin-bottom:15px;

}

.info-title i{

    font-size:20px;

}

.info-content{

    color:#334155;

    font-size:15px;

    line-height:1.8;

}

.ticket-summary-card {
    height: 100%;
    border: 1px solid #e7ebf1 !important;
    border-radius: 18px !important;
    box-shadow: 0 10px 28px rgba(15, 23, 42, .06) !important;
}

.ticket-summary-header {
    display: flex;
    align-items: center;
    gap: .9rem;
}

.ticket-summary-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 3.5rem;
    height: 3.5rem;
    flex: 0 0 3.5rem;
    border-radius: 50%;
    background: #eef4ff;
    color: #2563eb;
    font-size: 1.65rem;
}

.ticket-summary-kicker,
.ticket-meta-label,
.requester-label {
    display: block;
    margin-bottom: .3rem;
    color: #64748b;
    font-size: .75rem;
    font-weight: 600;
    letter-spacing: .02em;
}

.ticket-number {
    display: flex;
    align-items: center;
    gap: .45rem;
    margin: 0;
    color: #0f172a;
    font-size: clamp(1.35rem, 2.5vw, 1.8rem);
    line-height: 1.15;
    overflow-wrap: anywhere;
}

.copy-ticket {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    flex: 0 0 2rem;
    padding: 0;
    border: 1px solid #dbe3ef;
    border-radius: 7px;
    background: #fff;
    color: #2563eb;
    font-size: .9rem;
    cursor: pointer;
    transition: background .2s ease, border-color .2s ease, transform .2s ease;
}

.copy-ticket:hover,
.copy-ticket:focus-visible {
    border-color: #93c5fd;
    background: #eff6ff;
    transform: translateY(-1px);
}

.ticket-summary-divider {
    margin: 1.35rem 0 1.45rem;
    border-color: #e8edf3;
    opacity: 1;
}

.ticket-meta-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0;
}

.ticket-meta-item {
    min-width: 0;
    padding: 1.05rem 0;
    border-bottom: 1px solid #eef2f7;
}

.ticket-meta-item:first-child {
    padding-top: 0;
}

.ticket-meta-item:last-child {
    padding-bottom: 0;
    border-bottom: 0;
}

.ticket-meta-value {
    margin: 0;
    color: #0f172a;
    font-size: .94rem;
    font-weight: 600;
    line-height: 1.5;
}

.ticket-meta-value.is-muted {
    color: #475569;
    font-weight: 500;
}

.ticket-meta-value .badge {
    font-size: .73rem;
    letter-spacing: .01em;
}

.ticket-attachments {
    display: grid;
    gap: .45rem;
    margin-top: .55rem;
}

.ticket-attachment-link {
    display: flex;
    align-items: center;
    gap: .5rem;
    min-width: 0;
    color: #2563eb;
    font-size: .82rem;
}

.ticket-attachment-link span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.requester-card {
    border: 1px solid #e4eaf2 !important;
    border-radius: 14px !important;
    background: #f8fafc !important;
}

.requester-card .card-body {
    padding: 1.25rem;
}

.requester-heading {
    display: flex;
    align-items: center;
    gap: .55rem;
    margin-bottom: 1.35rem;
    color: #0f172a;
}

.requester-heading i {
    color: #2563eb;
    font-size: 1.05rem;
}

.requester-item + .requester-item {
    margin-top: 1rem;
}

.requester-value {
    display: flex;
    align-items: flex-start;
    gap: .55rem;
    color: #0f172a;
    font-size: .93rem;
    line-height: 1.5;
    overflow-wrap: anywhere;
}

.requester-value i {
    width: 1rem;
    flex: 0 0 1rem;
    margin-top: .18rem;
    text-align: center;
}

@media (max-width: 575.98px) {
    .ticket-meta-grid {
        grid-template-columns: 1fr;
    }

    .ticket-summary-header {
        align-items: flex-start;
    }
}


.a4-document{

    width:210mm;
    min-height:297mm;

    margin:0 auto;

    background:#ffffff;

    padding:18mm;

    box-sizing:border-box;

    font-family:"Segoe UI", Arial, sans-serif;

    color:#222;

    box-shadow:0 15px 40px rgba(0,0,0,.15);

    border-radius:8px;
    position:relative;
    page-break-after:always;

}


.document-header{

    margin-bottom:20px;

}

.document-header img{

    max-width:70px;

}

.document-header h5{

    font-size:18px;

    font-weight:700;

    margin-bottom:3px;

}

.document-header h6{

    font-size:13px;

    margin-bottom:2px;

}

.document-header span{

    font-size:13px;

    color:#555;

}

.document-header small{

    color:#777;

    font-size:12px;

}


.a4-document h3{

    font-size:22px;

    font-weight:700;

    letter-spacing:1px;

    margin-bottom:5px;

}



.section-title{

    margin-top:28px;

    margin-bottom:12px;

    padding:10px 15px;

    background:#0d6efd;

    color:#fff;

    font-size:15px;

    font-weight:600;

    border-radius:6px;

}


.a4-document table{

    width:100%;

    border-collapse:collapse;

    margin-bottom:18px;

}

.a4-document table th{

    background:#f5f7fa;

    font-weight:600;

    color:#374151;

    width:28%;

}

.a4-document table th,
.a4-document table td{

    border:1px solid #d7dde7;

    padding:10px 12px;

    vertical-align:top;

    font-size:13px;

    line-height:1.6;

}

.a4-document table td{

    background:#fff;

}


.document-footer{

    margin-top:50px;

    font-size:11px;

    color:#666;

}

.document-footer hr{

    margin-bottom:12px;

}


hr{

    border:0;

    border-top:1px solid #d9d9d9;

}

.print-preview{

    background:#eef2f7;

    padding:30px;

    border-radius:15px;

    overflow:auto;

    max-height:900px;

}

.print-preview .a4-document{

    transform:scale(.42);

    transform-origin:top center;

    margin-bottom:-170mm;

}


#printBtn{

    border-radius:10px;

    padding:8px 18px;

    font-weight:600;

}


@page{

    size:A4 portrait;

    margin:30px 12mm 25mm 12mm;

}

@page:first{

    size:A4 portrait;

    margin:30px 12mm 25mm 12mm;

}

@media print{

    html,
    body{

        background:#fff !important;

        margin:0;

        padding:0;

        width:210mm;

        height:297mm;

    }

    html,
    body,
    #printArea,
    #printArea * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    .page-break {
    page-break-before: always;
    break-before: page;
}

    /* Prevent breaking of boxed sections across printed pages */
    #printArea .no-break,
    #printArea .info-box,
    #printArea .request-card,
    #printArea table,
    #printArea .a4-document table,
    #printArea .document-header,
    #printArea .section-title {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    /* Keep section title grouped with its following content */
    #printArea .section-title {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
        page-break-after: avoid !important;
    }

    #printArea .section-title + table,
    #printArea .section-title + .info-box,
    #printArea .section-title + .request-card {
        page-break-before: avoid !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    body *{

        visibility:hidden !important;

    }

    #printArea,
    #printArea *{

        visibility:visible !important;

    }

    #printArea{

        position:absolute;

        left:0;

        top:0;

        width:210mm;

        min-height:297mm;

        margin:0;

        padding:15mm;

        transform:none !important;

        box-shadow:none !important;

        border-radius:0;

        backsground:#fff;

    }

    .print-preview{

    display:flex;

    justify-content:center;

    align-items:flex-start;

    background:#eef3f8;

    padding:25px;

    border-radius:18px;

    overflow:hidden;

}
.print-preview .a4-document{

    transform:scale(.34);

    transform-origin:top center;

    margin-bottom:-195mm;

}

    #printBtn{

        display:none !important;

    }

    .card{

        border:none !important;

        box-shadow:none !important;

    }

}

@media(max-width:1200px){

    .print-preview .a4-document{

        transform:scale(.32);

        margin-bottom:-195mm;

    }

}

@media(max-width:992px){

    .print-preview{

        display:none;

    }

}

/* Mobile-friendly print preview: show phone-sized preview instead of full A4 scale */
@media (max-width: 575.98px) {
    .print-preview {
        display: block;
        padding: 8px;
        background: transparent;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .print-preview .a4-document {
        transform: none !important;
        width: min(360px, 100%) !important;
        max-width: 100% !important;
        min-height: auto !important;
        margin: 0 auto 1rem !important;
        padding: 8px !important;
        box-shadow: 0 6px 20px rgba(0,0,0,0.06) !important;
        border-radius: 12px !important;
        box-sizing: border-box !important;
    }

    #printArea { overflow-x: visible; width: 100%; }
    .a4-document { max-width: none; }

    #printBtn { position: sticky; top: 8px; z-index: 30; }
}

.comments-wrap {
            --avatar-sm: 34px;
            --avatar-md: 40px;
            --line-color: #e9ecef;
            --bg-hover: #f8f9fa;
        }

        /* ---- Composer ---- */
        .composer-card {
            border: 1px solid #eef0f2;
            border-radius: 16px;
            background: #fff;
            padding: 1rem 1.1rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 2px rgba(16, 24, 40, 0.04);
        }

        .composer-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: #1a1a1a;
            margin-bottom: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .composer-body {
            display: flex;
            gap: 0.75rem;
        }

        .avatar {
            width: var(--avatar-md);
            height: var(--avatar-md);
            min-width: var(--avatar-md);
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.95rem;
            user-select: none;
        }

        .avatar.avatar-sm {
            width: var(--avatar-sm);
            height: var(--avatar-sm);
            min-width: var(--avatar-sm);
            font-size: 0.8rem;
        }

        .composer-input-group {
            flex: 1;
        }

        .composer-textarea {
            width: 100%;
            border: 1px solid #e2e5e9;
            border-radius: 14px;
            padding: 0.65rem 0.9rem;
            font-size: 0.92rem;
            resize: none;
            min-height: 46px;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .composer-textarea:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.12);
        }

        .composer-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 0.6rem;
        }

        .attach-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.82rem;
            color: #6b7280;
            cursor: pointer;
            padding: 0.3rem 0.55rem;
            border-radius: 8px;
            transition: background 0.15s ease;
        }
        .attach-btn:hover { background: var(--bg-hover); color: #374151; }
        .attach-btn input[type="file"] { display: none; }

        .file-chip-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-top: 0.5rem;
        }

        .file-chip {
            font-size: 0.75rem;
            background: #f1f3f5;
            border-radius: 999px;
            padding: 0.2rem 0.6rem;
            color: #495057;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .char-counter {
            font-size: 0.75rem;
            color: #9ca3af;
        }
        .char-counter.limit-near { color: #f59e0b; }
        .char-counter.limit-hit { color: #ef4444; }

        .btn-post {
            background: #6d28d9;
            border: none;
            color: #fff;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.4rem 1.1rem;
            border-radius: 999px;
            transition: background 0.15s ease, transform 0.1s ease;
        }
        .btn-post:hover { background: #5b21b6; color: #fff; }
        .btn-post:active { transform: scale(0.97); }
        .btn-post:disabled { background: #c4b5fd; cursor: not-allowed; }

        .thread {
            position: relative;
        }

        .comment-node {
            position: relative;
            display: flex;
            gap: 0.75rem;
            padding: 0.9rem 0.25rem;
            border-radius: 12px;
            transition: background 0.15s ease;
            background-color:#fff;
        }
        .comment-node.comment-node-with-replies {
            margin-bottom: 0.45rem;
        }
        .comment-node + .comment-node {
            margin-top: 1rem;
        }

        .comment-node .rail {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .comment-content { flex: 1; min-width: 0; }

        .comment-meta {
            display: flex;
            align-items: baseline;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .comment-author {
            font-weight: 600;
            font-size: 0.9rem;
            color: #111827;
        }

        .comment-time {
            font-size: 0.78rem;
            color: #9ca3af;
        }

        .comment-text {
            font-size: 0.9rem;
            color: #374151;
            line-height: 1.5;
            margin-top: 0.15rem;
            word-break: break-word;
        }

        .comment-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.4rem;
        }

        .action-link {
            background: none;
            border: none;
            padding: 0;
            font-size: 0.78rem;
            font-weight: 600;
            color: #6b7280;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            cursor: pointer;
            transition: color 0.15s ease;
        }
        .action-link:hover { color: #6d28d9; }
        .action-link.text-danger-hover:hover { color: #ef4444; }

        .attachment-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.78rem;
            background: #f1f3f5;
            color: #374151;
            border-radius: 8px;
            padding: 0.3rem 0.6rem;
            margin-top: 0.5rem;
            margin-right: 0.4rem;
            text-decoration: none;
            transition: background 0.15s ease;
        }
        .attachment-chip:hover { background: #e5e7eb; color: #111827; }

        /* ---- Reply form (collapsed by default) ---- */
        .reply-form-wrap {
            display: none;
            margin-top: 0.85rem;
            padding: 0.9rem;
            gap: 0.75rem;
            align-items: flex-start;
            border: 1px solid #ece9f8;
            border-radius: 16px;
            background: #fff;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.75);
        }
        .reply-form-wrap.open {
            display: flex;
            animation: fadeSlideIn 0.15s ease;
        }

        .reply-form-main {
            flex: 1;
            min-width: 0;
        }

        .reply-form-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.55rem;
        }

        .reply-label {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            color: #6d28d9;
            text-transform: uppercase;
        }

        .reply-hint {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        @keyframes fadeSlideIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .reply-input {
            flex: 1;
            border: 1px solid #e2e5e9;
            border-radius: 14px;
            padding: 0.7rem 0.9rem;
            font-size: 0.85rem;
            min-height: 74px;
            resize: vertical;
            width: 100%;
            background: #fff;
        }
        .reply-input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.12);
        }

        .reply-form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-top: 0.7rem;
            flex-wrap: wrap;
        }

        .reply-tools {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            flex-wrap: wrap;
        }

        .reply-file-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 0.8rem;
            border-radius: 999px;
            background: var(--bg-hover);
            color: #6b7280;
            cursor: pointer;
            flex-shrink: 0;
        }
        .reply-file-btn:hover { background: #e9ecef; }
        .reply-file-btn input { display: none; }

        .reply-file-name {
            font-size: 0.76rem;
            color: #6b7280;
            max-width: 240px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .reply-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: auto;
        }

        .btn-reply-cancel {
            border: none;
            background: transparent;
            color: #6b7280;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.35rem 0.5rem;
        }

        .btn-reply-cancel:hover {
            color: #374151;
        }

        .btn-reply-send {
            min-width: 36px;
            height: 36px;
            padding: 0 0.9rem;
            border-radius: 999px;
            border: none;
            background: #6d28d9;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.15s ease;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .btn-reply-send:hover { background: #5b21b6; }

        /* ---- Replies list ---- */
        .replies-list {
            margin-left: calc(var(--avatar-md) + 0.35rem);
            margin-top: 0.15rem;
            padding-left: 0;
        }

        .replies-toggle {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6d28d9;
            background: none;
            border: none;
            padding: 0.3rem 0;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            margin-left: calc(var(--avatar-md) + 0.35rem);
        }
        .replies-toggle:hover { text-decoration: underline; }
        .replies-toggle .chevron { transition: transform 0.15s ease; font-size: 0.7rem; }
        .replies-toggle.expanded .chevron { transform: rotate(90deg); }

        .replies-list.collapsed { display: none; }

        .reply-node {
            position: relative;
            display: flex;
            gap: 0.6rem;
            padding: 0.8rem 0.9rem;
            border-radius: 14px;
            transition: background 0.15s ease, border-color 0.15s ease;
            background: #fff;
            border: 1px solid #edf0f3;
            box-shadow: 0 1px 2px rgba(16, 24, 40, 0.04);
            margin-bottom: 25px;
        }

        .reply-node + .reply-node {
            margin-top: 0.5rem;
        }
        .reply-node:hover {
            background: var(--bg-hover);
            border-color: #e2e8f0;
        }

        .reply-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            margin-bottom: 0.35rem;
            padding: 0.18rem 0.5rem;
            border-radius: 999px;
            background: #f3f0ff;
            color: #6d28d9;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        @media(max-width: 768px){
            .reply-form-wrap {
                padding: 0.8rem;
            }

            .reply-form-footer {
                align-items: flex-start;
            }

            .reply-actions {
                width: 100%;
                justify-content: flex-end;
                margin-left: 0;
            }

            .reply-file-name {
                max-width: 100%;
            }

            .replies-list {
                margin-left: calc(var(--avatar-md) + 0.2rem);
                padding-left: 0;
            }

            .replies-toggle {
                margin-left: calc(var(--avatar-md) + 0.2rem);
            }
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #9ca3af;
        }
        .empty-state i { font-size: 2.2rem; opacity: 0.5; }
        .empty-state h6 { margin-top: 0.75rem; color: #4b5563; font-weight: 600; }

        .history-card { border-radius: 12px; }
        .history-item { position: relative; display: flex; gap: 0.85rem; padding: 0 0 1.25rem; }
        .history-item:last-child { padding-bottom: 0; }
        .history-rail { display: flex; flex-direction: column; align-items: center; }
        .history-dot { width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; background: #f3f4f6; color: #4b5563; flex: 0 0 auto; }
        .history-item:not(:last-child) .history-rail::after { content: ''; width: 2px; flex: 1; background: #e5e7eb; margin-top: 0.45rem; }
        .history-content { min-width: 0; flex: 1; padding-top: 0.15rem; }
        .history-title { color: #1f2937; font-size: 0.92rem; font-weight: 700; }
        .history-description { color: #6b7280; font-size: 0.83rem; margin-top: 0.2rem; }
        .history-meta { color: #9ca3af; font-size: 0.75rem; margin-top: 0.35rem; }
        @media (max-width: 576px) { .history-card .card-body { padding: 1rem; } }

        #attachmentModal .modal-body{
        display:flex;
        align-items:center;
        justify-content:center;
        padding:1rem;
    }
    #attachmentModalImage, #attachmentModalFrame{
        margin:0 auto;
        max-width:100%;
        max-height:70vh;
    }
    .premium-btn{
    transition: all .2s ease;
    border: 1px solid transparent;
    }

    .premium-btn:hover{
        transform: translateY(-1px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.12) !important;
    }

    .premium-btn:active{
        transform: translateY(0);
    }

    .request-info-box {
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 16px;
    padding: 1.5rem;
    height: 100%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
    margin-top: 10px;
}

.request-info-box::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
}

.request-info-box:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
    border-color: #d9d9d9;
}

.request-info-box .category-icon {
    width: 55px;
    height: 55px;
    border-radius: 14px;
    background: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.request-info-box .category-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #212529;
    margin-bottom: .5rem;
}

.request-info-box .category-description {
    color: #6c757d;
    font-size: .92rem;
    line-height: 1.6;
}

.request-info-box .category-count {
    margin-top: 1rem;
    font-size: 1.75rem;
    font-weight: 700;
    color: #212529;
}

/* Acknowledge loader */
.ack-loader { 
    position: fixed; 
    inset: 0; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    z-index: 2000; 
}
.ack-loader.d-none { display: none; }
.ack-loader-backdrop { 
    position: absolute; 
    inset: 0; 
    background: rgba(15,23,42,0.45);
    backdrop-filter: blur(3px);
}
.ack-loader-panel { 
    position: relative; 
    padding: 18px 20px; 
    background: #fff; 
    border-radius: 12px; 
    box-shadow: 0 10px 30px rgba(2,6,23,0.3); 
    display: flex; 
    gap: 12px; 
    align-items: center; 
}
.ack-spinner { 
    width: 36px; 
    height: 36px; 
    border-radius: 50%; 
    border: 4px solid #eef2ff; 
    border-top-color: #2563eb; 
    animation: ack-spin 1s linear infinite; 
}
@keyframes ack-spin { to { transform: rotate(360deg); } }
.ack-loader-text { 
    font-weight: 700; 
    color: #111827; 
}

/* Full Screen Loader */
.ack-loader {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;

    background: rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(4px);
}

/* Hide Loader */
.ack-loader.d-none {
    display: none;
}

/* Loader Card */
.ack-loader-box {
    background: #ffffff;
    padding: 30px 40px;
    border-radius: 16px;
    text-align: center;

    box-shadow: 
        0 10px 30px rgba(0,0,0,0.12),
        0 2px 8px rgba(0,0,0,0.05);

    min-width: 280px;
}

/* Default Bootstrap Spinner */
.ack-spinner {
    width: 45px;
    height: 45px;
}

/* Main Text */
.ack-loader-title {
    margin-top: 18px;
    font-size: 15px;
    font-weight: 600;
    color: #212529;
}

/* Supporting Text */
.ack-loader-subtitle {
    margin-top: 6px;
    font-size: 13px;
    color: #6c757d;
}
    
.returned-ticket-btn {
    display:inline-flex;
    align-items:center;
    gap:.35rem;
    background:#fff3cd;
    color:#856404;
    border:1px solid #ffe69c;
    border-radius:10px;
    padding:.55rem 1rem;
    font-weight:600;
    transition:.25s ease;
}

.returned-ticket-btn:hover {
    background:#ffda6a;
    color:#664d03;
    transform:translateY(-2px);
    box-shadow:0 6px 15px rgba(133,100,4,.15);
}

.return-details-modal .modal-content {
    border: 0;
    border-radius: 18px;
    overflow: hidden;
}

.return-details-modal .modal-header {
    background: #fff8f0;
    border-bottom: 1px solid #f3dfc5;
}

.return-details-modal .return-detail-icon {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #fff3cd;
    color: #856404;
}

.return-details-modal .return-reason-box {
    padding: 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    background: #f8fafc;
    color: #374151;
    white-space: pre-line;
    overflow-wrap: anywhere;
}

.return-details-modal .return-meta-label {
    display: block;
    color: #6b7280;
    font-size: .75rem;
    margin-bottom: .2rem;
}

@media (max-width: 576px) {
    .ticket-header > .text-end {
        width: 100%;
        text-align: left !important;
        margin-top: 1rem;
    }

    .returned-ticket-btn {
        width: 100%;
    }
}

.resolutions-btn {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    margin-top: .5rem;
    background: #eef4ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
    border-radius: 10px;
    padding: .55rem 1rem;
    font-weight: 600;
}

.resolutions-btn:hover {
    background: #dbeafe;
    color: #1d4ed8;
}

.resolution-history-modal .modal-content {
    border: 0;
    border-radius: 18px;
    overflow: hidden;
}

.resolution-history-modal .modal-header {
    background: #eef4ff;
    border-bottom: 1px solid #dbeafe;
}

.resolution-history-modal .resolution-history-item {
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    background: #fff;
    padding: 1rem;
}

.resolution-history-modal .resolution-history-item + .resolution-history-item {
    margin-top: .8rem;
}

.resolution-history-modal .resolution-history-item.is-current {
    border: 2px solid #0d6efd;
    background: #f5f9ff;
    box-shadow: 0 6px 18px rgba(13, 110, 253, .12);
}

.resolution-history-modal .current-resolution-badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    margin-bottom: .75rem;
    border-radius: 999px;
    padding: .3rem .65rem;
    background: #0d6efd;
    color: #fff;
    font-size: .72rem;
    font-weight: 700;
}

.resolution-history-modal .resolution-transition {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    color: #475569;
    font-size: .8rem;
}

.resolution-history-modal .resolution-description {
    color: #374151;
    line-height: 1.6;
    white-space: pre-line;
    overflow-wrap: anywhere;
}

.resolution-history-modal .resolution-file {
    display: flex;
    align-items: center;
    gap: .55rem;
    padding: .6rem .7rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    color: #1d4ed8;
    background: #f8fbff;
    text-decoration: none;
    overflow-wrap: anywhere;
}

@media (max-width: 576px) {
    .ticket-header > .text-end {
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }

    .resolutions-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
<div class="row">
    <!-- Loading Overlay -->
<div id="ackLoader" class="ack-loader d-none">
    <div class="ack-loader-box">
        <div class="spinner-border text-primary ack-spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

        <div class="ack-loader-title" id="ackLoaderTitle">
            Processing action...
        </div>

        <div class="ack-loader-subtitle">
            Please wait while we complete the action.
        </div>
    </div>
</div>
    <div class="d-flex justify-content-between align-items-center w-100">
        <div class="p-2">
            <a href="{{ route('tickets') }}" class="btn back-btn border shadow-sm rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>
                Back to tickets
            </a>
        </div>
        <div class="p-2">
            @if(empty($ticket->acknowledged))
                <form id="ackForm" method="POST" action="{{ route('tickets.acknowledge', $ticket->ticket_id) }}">
                    @csrf
                    <button id="ackBtn" type="submit" class="btn btn-dark rounded-pill px-4 py-2 shadow-sm premium-btn">
                        <i class="bi bi-check2-circle me-2"></i>
                        Acknowledge Ticket
                    </button>
                </form>
            @else
                <button type="button" class="btn btn-light border rounded-pill px-4 py-2 shadow-sm" disabled>
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    <span class="text-secondary fw-medium">Ticket Acknowledged</span>
                </button>
            @endif
        </div>
    </div>
</div>
<div class="p-2">
    <div class="ticket-header d-flex justify-content-between align-items-center">

    <div>
        <h4 class="mb-1 fw-semibold">
            Ticket Details
        </h4>
        <p class="text-muted mb-0 small">
            View the status and details of your request.
        </p>
    </div>

<div>
    @if(isset($ticketReturns) && $ticketReturns->isNotEmpty())
    <div class="text-end">
    <button 
        type="button" 
        class="btn returned-ticket-btn"
        data-bs-toggle="modal"
        data-bs-target="#returnDetailsModal"
    >
        <i class="bi bi-arrow-counterclockwise me-1"></i>
        View Return Details ({{ $ticketReturns->count() }})
    </button>

</div>
    @endif

    @if(isset($resolutions) && $resolutions->isNotEmpty())
    <div class="text-end">
        <button type="button" class="btn resolutions-btn" data-bs-toggle="modal" data-bs-target="#resolutionHistoryModal">
            <i class="bi bi-check2-square"></i>
            Resolutions ({{ $resolutions->count() }})
        </button>
    </div>
    @endif
</div>

</div>
    <div class="row">
    <div class="col-md-12 mb-3">
        <div class="ticket-tabs mt-4 d-flex flex-column flex-md-row">

            <button class="ticket-tab active" id="btnRequestInfo">
                <i class="bi bi-file-earmark-text"></i>
                <span>Request Information</span>
            </button>

            <button class="ticket-tab" id="btnComment">
                <i class="bi bi-chat-dots"></i>
                <span>Comments</span>
            </button>

            <button class="ticket-tab" id="btnHistory">
                <i class="bi bi-clock-history"></i>
                <span>History</span>
            </button>
            
            <button class="ticket-tab" id="btnPrint" data-acknowledged="{{ empty($ticket->acknowledged) ? '0' : '1' }}" {{ empty($ticket->acknowledged) ? 'aria-disabled="true"' : '' }}>
                <i class="bi bi-printer"></i>
                <span>Print</span>
            </button>

            <div class="tab-indicator"></div>

        </div>
    </div>
</div>
<div class="row" id="requestInformationBody">
    <div class="col-12 col-md-8">

        <div class="card ticket-summary-card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <!-- Header -->
                <div class="ticket-summary-header">
                    <div class="ticket-summary-icon" aria-hidden="true">
                        <i class="bi bi-ticket-detailed-fill"></i>
                    </div>
                    <div class="min-w-0">
                        <span class="ticket-summary-kicker">Ticket Number</span>
                        <h3 class="ticket-number">
                            <span>{{ $ticket->ticket_id }}</span>
                            <button type="button" class="copy-ticket" data-ticket="{{ $ticket->ticket_id }}" title="Copy ticket number" aria-label="Copy ticket number">
                                <i class="bi bi-copy" aria-hidden="true"></i>
                            </button>
                        </h3>
                    </div>
                </div>

                <hr class="ticket-summary-divider">

                <div class="row g-4">

                    <!-- LEFT -->
                    <div class="col-12 col-md-6">

                        <div class="ticket-meta-grid">
                        <div class="ticket-meta-item">

                            <span class="ticket-meta-label">
                                <i class="bi bi-grid me-1"></i>
                                Category
                            </span>

                            <p class="ticket-meta-value">

                                @switch($ticket->ticket_category)

                                    @case('enhance')
                                        Technical Assistance on Program Development
                                    @break

                                    @case('completed')
                                        Technical Assistance on Completed Program
                                    @break

                                    @case('resource')
                                        Resource Person
                                    @break

                                    @case('knowledge')
                                        Knowledge Product
                                    @break

                                @endswitch

                            </p>

                        </div>

                        <div class="ticket-meta-item">

                            <span class="ticket-meta-label">
                                <i class="bi bi-diagram-3 me-1"></i>
                                Program
                            </span>

                            <ul class="ticket-meta-value ticket-program-list">
                                @foreach($ticket->program_display_items as $program)
                                    <li>{{ $program }}</li>
                                @endforeach
                            </ul>

                        </div>

                        <div class="ticket-meta-item">

                                <span class="ticket-meta-label">
                                    <i class="bi bi-flag me-1"></i>
                                    Priority
                                </span>

                                <div class="mt-2">

                                    @switch($ticket->ticket_priority)

                                        @case('low')
                                            <span class="badge bg-success px-3 py-2">
                                                Low
                                            </span>
                                        @break

                                        @case('medium')
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                Medium
                                            </span>
                                        @break

                                        @case('high')
                                            <span class="badge bg-primary px-3 py-2">
                                                High
                                            </span>
                                        @break

                                        @case('urgent')
                                            <span class="badge bg-danger px-3 py-2">
                                                Urgent
                                            </span>
                                        @break

                                    @endswitch

                                </div>

                            </div>

                        <div class="ticket-meta-item">

                                <span class="ticket-meta-label">
                                    <i class="bi bi-check2-square me-1"></i>
                                    Current Status
                                </span>

                                <div class="mt-2">

                                    @switch($ticket->ticket_status)

                                        @case('review')
                                            <span class="badge bg-light text-dark border px-3 py-2">
                                                For Review
                                            </span>
                                        @break

                                        @case('inprogress')
                                            <span class="badge bg-info px-3 py-2">
                                                In Progress
                                            </span>
                                        @break

                                        @case('resolved')
                                            <span class="badge bg-success-subtle text-dark px-3 py-2">
                                                Resolved
                                            </span>
                                        @break

                                        @case('completed')
                                            <span class="badge bg-success px-3 py-2">
                                                Completed
                                            </span>
                                        @break

                                        @case('rejected')
                                            <span class="badge bg-danger px-3 py-2">
                                                Rejected
                                            </span>
                                        @break

                                        @case('overdue')
                                            <span class="badge bg-danger px-3 py-2">
                                                Overdue
                                            </span>
                                        @break

                                    @endswitch

                                </div>

                        </div>
                        <div class="ticket-meta-item">
                                <span class="ticket-meta-label">
                                    <i class="bi bi-inbox me-1"></i>
                                    Request For
                                </span>
                                <p class="ticket-meta-value is-muted">
                                    @switch($ticket->received_ticket_to)
                                    @case('CO')
                                    Central Office
                                    @break

                                    @case('FO')
                                    Field Office
                                    @break

                                    @endswitch

                                    @if(!empty($ticket->received_ticket_to_office))
                                    , {{$ticket->requestForRegion->name}}
                                    @else
                                    
                                    @endif
                                </p>
                        </div>

                        @if($ticket->attachments->isNotEmpty())
                            <div class="ticket-meta-item">
                                <span class="ticket-meta-label">
                                    <i class="bi bi-paperclip me-1"></i>
                                    Ticket Attachment{{ $ticket->attachments->count() > 1 ? 's' : '' }}
                                </span>
                                <div class="ticket-attachments">
                                    @foreach($ticket->attachments as $attachment)
                                        <a href="{{ Storage::url($attachment->attachment_path) }}" download="{{ $attachment->attachment }}" rel="noopener" class="ticket-attachment-link text-decoration-none">
                                            <i class="bi bi-file-earmark-arrow-down"></i>
                                            <span>{{ $attachment->attachment }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="col-12 col-md-6 ps-md-4">

                        <div class="card requester-card bg-light border-0 rounded-4">

                            <div class="card-body">

                                <h6 class="requester-heading fw-bold">

                                    <i class="bi bi-person-circle me-2"></i>

                                    Requester Information

                                </h6>

                                <div class="requester-item">

                                    <span class="requester-label">Full Name</span>

                                    <div class="requester-value">
                                        <i class="bi bi-person text-primary" aria-hidden="true"></i>
                                        <span>

                                        {{ $ticket->requestor_first_name }}

                                        @if(!empty($ticket->requestor_middle_name))
                                            {{ strtoupper(substr($ticket->requestor_middle_name,0,1)) }}.
                                        @endif

                                        {{ $ticket->requestor_last_name }}

                                        </span>
                                    </div>

                                </div>

                                <div class="requester-item">

                                    <span class="requester-label">Email Address</span>

                                    <div class="requester-value">
                                        <i class="bi bi-envelope text-primary" aria-hidden="true"></i>
                                        <span>{{ $ticket->requestor_email }}</span>

                                    </div>

                                </div>

                                <div class="requester-item">

                                    <span class="requester-label">Location</span>

                                    <div class="requester-value">
                                        <i class="bi bi-geo-alt text-danger" aria-hidden="true"></i>
                                        <span>
                                        @switch($ticket->requestor_organization)
                                        @case('field_office')
                                        {{ data_get($ticket, 'requestRegion.name', '-')}},
                                        {{ data_get($ticket, 'agency.group_name')}}
                                        @break

                                        @case('offices')
                                        {{ data_get($ticket, 'agency.group_name')}}
                                        @break

                                        @case('lgu')
                                        {{ data_get($ticket, 'requestRegion.name', '-') }},
                                        {{ data_get($ticket, 'requestProvince.name', '-') }},
                                        {{ data_get($ticket, 'requestCity.name', '-') }}
                                        @break                                        
                                        @default
                                        {{ $ticket->requestor_specific_office}}
                                        @break
                                        
                                        @endswitch

                                        </span>
                                    </div>

                                </div>

                                <div class="requester-item">

                                    <span class="requester-label">Date Submitted</span>

                                    <div class="requester-value">
                                        <i class="bi bi-calendar-event text-success" aria-hidden="true"></i>
                                        <span>{{ $ticket->created_at->format('F d, Y h:i A') }}</span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Col end --}}
                </div>

            </div>
        </div>

    </div>

    <div class="col-12 col-md-4 pt-1 mt-3 mt-md-0">
        <div class="card resolution-panel sticky-top">
            <div class="card-header d-flex align-items-center justify-content-between py-3 px-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-check2-square"></i>
                    <h6 class="mb-0 fw-bold">Resolution</h6>
                </div>
                @if($latestResolution)
                    <small class="text-muted">Updated {{ $latestResolution->updated_at->format('M d, Y') }}</small>
                @endif
            </div>

            <div class="card-body p-3">
                <form id="resolutionForm" method="POST" action="{{ route('ticket.resolve', $ticket->ticket_id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="resolution-state {{ $resolutionLocked ? 'is-locked' : '' }}" role="status">
                        <i class="bi {{ $resolutionLocked ? 'bi-lock-fill' : 'bi-info-circle-fill' }}" aria-hidden="true"></i>
                        <span>{{ $resolutionLocked ? 'This ticket is closed. Its resolution can no longer be edited.' : 'Document what was done, then choose the next ticket status.' }}</span>
                    </div>

                    <div class="mb-3">
                        <label for="resolution_text" class="form-label">Resolution details</label>
                        <textarea id="resolution_text" name="resolution_text" rows="4" class="form-control" placeholder="Describe the action taken or the final resolution." {{ $resolutionLocked ? 'disabled' : '' }}>{{ old('resolution_text', $latestResolution?->resolution_text) }}</textarea>
                        @error('resolution_text')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="attachments" class="form-label">Resolution attachments</label>
                        <div class="resolution-file-picker">
                            <input id="attachments" type="file" name="attachments[]" multiple data-existing-count="{{ $latestResolution?->attachments->count() ?? 0 }}" {{ $resolutionLocked ? 'disabled' : '' }}>
                            <label for="attachments"><i class="bi bi-paperclip" aria-hidden="true"></i> Add files</label>
                            <span class="resolution-file-name" id="resolutionFileName">No new files selected</span>
                        </div>
                        <div class="form-text">Optional while reviewing. Add supporting files before resolving.</div>
                        @error('attachments')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        @error('attachments.*')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        @if($latestResolution?->attachments->isNotEmpty())
                            <div class="resolution-attachments mt-2 small">
                                @foreach($latestResolution->attachments as $attachment)
                                    <div class="resolution-attachment-item d-flex align-items-center gap-2">
                                        <i class="bi bi-paperclip"></i>
                                        <a href="{{ Storage::url($attachment->attachment_path) }}" download="{{ $attachment->attachment }}" rel="noopener">{{ $attachment->attachment }}</a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="ticket_status" class="form-label">Update ticket status</label>
                        <select id="ticket_status" name="ticket_status" class="form-select" {{ $resolutionLocked ? 'disabled' : '' }}>
                            <option value="review" @selected(old('ticket_status', $ticket->ticket_status) === 'review')>For Review</option>
                            <option value="resolved" @selected(old('ticket_status', $ticket->ticket_status) === 'resolved')>Resolved</option>
                            <option value="completed" @selected(old('ticket_status', $ticket->ticket_status) === 'completed')>Completed</option>
                            <option value="rejected" @selected(old('ticket_status', $ticket->ticket_status) === 'rejected')>Rejected</option>
                        </select>
                        @error('ticket_status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-dark w-100 resolution-submit" {{ $resolutionLocked ? 'disabled' : '' }}>
                        <i class="bi bi-check2-circle me-2"></i>
                        {{ $resolutionLocked ? 'Ticket Closed' : ($latestResolution ? 'Update Resolution' : 'Save Resolution') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 pt-4">

                        <div class="card request-card border-0 shadow-sm">
                            <div class="request-header">
                                <div class="d-flex align-items-center">
                                    <div class="request-icon">
                                        <i class="bi bi-file-earmark-text-fill"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1 fw-bold">
                                            Request Information
                                        </h4>
                                        <small class="mb-1">
                                            Details submitted by the requester
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-md-4 pt-3">
                                        <div class="request-info-box pt-3">
                                            <h5>Technical Assistance</h5>
                                            <div class="info-box mb-4">
                                                <div class="info-title">
                                                    <i class="bi bi-chat-left-text"></i>
                                                    Purpose of Request
                                                </div>
                                                <div class="info-content">
                                                    {{ $ticket->purpose_of_request }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pt-3">
                                        <div class="request-info-box">
                                            @php
                                                $kp = $ticket->type_of_knowledge_product ?? null;
                                                $kpItems = [];
                                                if($kp) {
                                                    if(is_array($kp)) {
                                                        $kpItems = $kp;
                                                    } else {
                                                        $decoded = json_decode($kp, true);
                                                        if(is_array($decoded)) {
                                                            $kpItems = $decoded;
                                                        } else {
                                                            $kpItems = array_filter(array_map('trim', explode(',', $kp)));
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <div class="knowledge-panel h-100">
                                                <div class="knowledge-panel-header">
                                                    <div class="knowledge-panel-icon">
                                                        <i class="bi bi-journal-text"></i>
                                                    </div>
                                                    <div>
                                                        <p class="knowledge-panel-kicker">Knowledge Product</p>
                                                        <p class="knowledge-panel-subtitle">Knowledge Product Requested</p>
                                                    </div>
                                                </div>

                                                <div class="knowledge-list">
                                                    @if(empty($kpItems))
                                                        <div class="knowledge-pill" style="grid-column: 1 / -1; background: rgba(148, 163, 184, 0.08); border-color: rgba(148, 163, 184, 0.25); color: #475569;">-</div>
                                                    @else
                                                        @foreach($kpItems as $item)
                                                            @php
                                                                $label = trim((string) $item);
                                                                if ($label === 'Others') {
                                                                    $label = trim((string) ($ticket->type_of_knowledge_product_others ?? 'Others'));
                                                                }
                                                            @endphp
                                                            <div class="knowledge-pill">{{ e($label) }}</div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pt-3">
                                        <div class="request-info-box">
                                            <div class="resource-section">
                                                <h5 class="resource-title">Resource Person</h5>

                                                <div class="resource-grid">
                                                    <div class="resource-card">
                                                        <div class="resource-card-icon">
                                                            <i class="bi bi-geo-alt-fill"></i>
                                                        </div>
                                                        <div class="resource-card-body">
                                                            <p class="resource-label">Venue</p>
                                                            <p class="resource-value">{{ $ticket->venue ?? '-' }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="resource-card">
                                                        <div class="resource-card-icon">
                                                            <i class="bi bi-calendar-event"></i>
                                                        </div>
                                                        <div class="resource-card-body">
                                                            <p class="resource-label">Type of activity</p>
                                                            <p class="resource-value">{{ $ticket->type_of_activity ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="resource-date-grid">
                                                    <div class="resource-date-card">
                                                        <p class="resource-date-label">Start of Activity</p>
                                                        <p class="resource-date-value">{{ $ticket->date_of_activity ?? '-' }}</p>
                                                    </div>

                                                    <div class="resource-date-card">
                                                        <p class="resource-date-label">End of Activity</p>
                                                        <p class="resource-date-value">{{ $ticket->date_of_activity_end ?? '-' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
</div>

    <div id="printBody" class="d-none mt-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <strong>Printable A4 Preview</strong>
            </div>
            <div>
                <button id="printBtn" class="btn btn-sm btn-primary">Print</button>
            </div>
        </div>

            <div id="printArea" class="a4-document">
                <section class="print-page">
                    @include('partials.print_header')

                        <div class="text-end mb-4">
                            <small>DRN: <span class="fw-bold text-decoration-underline">{{$ticket->ticket_id}}</span></small>
                        </div>
                        <div class="text-center mb-4">

                            <h3 class="fw-bold">
                                REQUEST FORM
                            </h3>


                        </div>
                        <table class="table table-bordered" style="border: 1px solid; border-color:#000">
                            <tr>
                                <td style="border:1px solid #000;">
                                    <span style="font-size:0.91rem;">
                                    By clicking this, I hereby give my consent and acknowledge that I have read, fully understood, and agree to the
                                    <a href="/privacy-policy" style="color:#0d6efd; text-decoration:underline;">
                                        DSWD Data Privacy Terms and Condition</i>.
                                    </a>
                                </td>        
                            </tr>
                        </table>
                        <table class="table table-bordered">

                            <tr>
                                    <th class="text-end" style="border:1px solid #000; background-color:#d8eaff">
                                        <i>DATE<i>
                                    </th>
                                    <td style="border:1px solid #000;">
                                        {{$ticket->created_at->format('F d, Y h:i A')}}
                                    </td>
                            </tr>
                            <tr>
                                    <th class="text-end" style="border:1px solid #000; background-color:#d8eaff">
                                        <i>NAME OF THE REQUESTOR
                                            <div>(Last Name, First Name, M.I.)</div>
                                        </i>
                                    </th>
                                    <td style="border:1px solid #000;">
                                            {{ $ticket->requestor_last_name }}

                                            {{ $ticket->requestor_first_name }}

                                            @if(!empty($ticket->requestor_middle_name))
                                            {{ strtoupper(substr($ticket->requestor_middle_name,0,1)) }}.
                                            @endif
                                    </td>
                            </tr>

                            <tr>
                                    <th class="text-end" style="border:1px solid #000; background-color:#d8eaff">
                                        <i>Position / Designation
                                        <div>(Optional)</div></i>
                                    </th>
                                    <td style="border:1px solid #000;">
                                        {{$ticket->requestor_position_title ?? 'N/A'}}
                                    </td>
                            </tr>
                            <tr>
                                    <th class="text-end" style="border:1px solid #000; background-color:#d8eaff">
                                        <i>From what Organization or office do you belong?</i>
                                    </th>
                                    <td style="border:1px solid #000;">
                                        @switch($ticket->requestor_organization)
                                            @case('offices')
                                                DSWD Offices, Bureaus, Services Units
                                            @break

                                            @case('field_office')
                                                DSWD Field Office
                                            @break

                                            @case('lgu')
                                                Local Government Unit
                                            @break

                                            @case('cso')
                                                Civil Society Organization
                                            @break

                                            @case('ngo')
                                                Non-government Organization
                                            @break

                                            @case('po')
                                                People's Organization
                                            @break

                                            @case('academe')
                                                Academe
                                            @break
                                        @endswitch
                                    </td>
                            </tr>
                            <tr>
                                    <th class="text-end" style="border:1px solid #000; background-color:#d8eaff">
                                        <i>NAME OF OFFICE <br>
                                        <small>(if from LGU, CSO, NGO, PO or Academe)</small></i>
                                    </th>
                                    <td style="border:1px solid #000;">
                                        @if($ticket->requestor_organization === 'lgu')
                                        {{($ticket->requestRegion->name)}}, {{($ticket->requestProvince->name)}}, {{($ticket->requestCity->name)}}

                                        @else
                                        {{$ticket->requestor_specific_office ?? 'N/A'}}

                                        @endif
                                    </td>
                            </tr>   
                            <tr>
                                    <th class="text-end" style="border:1px solid #000; background-color:#d8eaff">
                                        <i>DIVISION / SECTION <br>
                                        <small>(if from the DSWD Central or Field Office)</small></i>
                                    </th>
                                    <td style="border:1px solid #000;">
                                        @if($ticket->requestor_organization === 'field_office')
                                        {{$ticket->requestRegion->name ?? 'N/A'}},
                                        <div>
                                            {{$ticket->agency->group_name ?? 'N/A'}}
                                        </div>

                                        @else
                                        {{$ticket->agency->group_name ?? 'N/A'}}

                                        @endif
                                    </td>
                            </tr>  
                            <tr>
                                    <th class="text-end" style="border:1px solid #000; background-color:#d8eaff">
                                        <i>SEX
                                    </th>
                                    <td style="border:1px solid #000;">
                                        {{ucfirst($ticket->requestor_sex ?? 'N/A')}}
                                    </td>
                            </tr> 
                            <tr>
                                    <th class="text-end" style="border:1px solid #000; background-color:#d8eaff">
                                        <i>OFFICE ADDRESS
                                    </th>
                                    <td style="border:1px solid #000;">
                                        {{ucfirst($ticket->requestor_office_address ?? 'N/A')}}
                                    </td>
                            </tr>       
                            <tr>
                                    <th class="text-end" style="border:1px solid #000; background-color:#d8eaff">
                                        <i>EMAIL ADDRESS
                                    </th>
                                    <td style="border:1px solid #000;">
                                        {{$ticket->requestor_email ?? 'N/A'}}
                                    </td>
                            </tr>   
                            <tr>
                                    <th class="text-end" style="border:1px solid #000; border-bottom:1px solid #000; background-color:#d8eaff">
                                        <i>MOBILE NUMBER
                                    </th>
                                    <td style="border:1px solid #000;">
                                        {{ucfirst($ticket->requestor_mobile_number ?? 'N/A')}}
                                    </td>
                            </tr>         
                        </table>

                        @include('partials.print_footer')
                    </section>
                        <div class="page-break"></div>
                    <section class="print-page">
                        <div style="padding-top: 80px;">
                            @include('partials.print_header')
                        </div>
                        <div style="margin-top: -30px;">
                            <table class="table table-bordered" >
                                <h5><i>TYPE OF TECHNICAL ASSISTANCE(TA) REQUESTED:</i></h5> 
                                @if($ticket->ticket_category === 'completed')
                                <i class="bi bi-check-square-fill fs-5"></i> <i class="ml-6">TA on STB-developed Programs/Projects</i>
                                @else
                                <i class="bi bi-square fs-5"></i> <i class="ml-6">TA on STB-developed Programs/Projects</i>
                                @endif

                                <div  class="p-3">
                                    <span>_____________________________________</span>
                                </div>
                                <div>
                                    <span>For Request Forms received from external offices (e.g. LGUs or other intermediaries), this may be left blank and the DRN will be inputted once the Form is received by the DSWD Central Office or Field Office.</span>
                                </div>
                                <div>
                                    <i>(includes sharing of knowledge products on ST programs / projects and TA on ongoing and completed social technologies)</i>
                                </div>
                                <div class="pt-2"></div>
                                @if($ticket->ticket_category === 'enhancement')
                                <i class="bi bi-check-square-fill fs-5"></i> <i class="ml-6">TA on Program Development and Enhancement</i>
                                @else
                                <i class="bi bi-square fs-5"></i> <i class="ml-6">TA on Program Development and Enhancement</i>
                                @endif

                                <div>
                                    <i>(includes TA on the conduct of research, analysis, pilot implementation, evaluation, manualization, and social marketing)</i>
                                </div>

                            </table>
                        </div>
                        <table class="table table-bordered" style="padding-top: 30px;">
                                <tr>
                                    <th class="text-end" style="border:1px solid #000; background-color:#d8eaff">Purpose of the request</th>
                                    <td height= '80' style="border:1px solid #000;">{{$ticket->purpose_of_request}}</td>
                                </tr>
                                <tr>
                                    <th class="text-end" style="border:1px solid #000; background-color:#d8eaff">STB Developed Program / Project Requested for Technical Assistance: </th>
                                    <td style="border:1px solid #000;">
                                        <ul class="print-program-list">
                                            @foreach($ticket->program_display_items as $program)
                                                <li>{{ $program }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                        </table>
                        <table class="table-table-bordered" style="margin-top: -20px;">
                                 <tr>
                                <!-- Left blue column spanning 5 rows -->
                                <th rowspan="5"
                                    style="width:28%; background:#d8eaff; border:1px solid #000; vertical-align:top; font-style:italic; text-align:left; padding:10px;">

                                    <i>For activities that require an actual TA session / meeting / activity:</i>

                                    <br><br>

                                    <strong>Note:</strong><br>
                                    For requests that require a resource person for two (2) or more days,
                                    the request form must be signed by the Head of Office of the Requesting Party.
                                </th>

                                <td style="width:20%; background:#d8eaff; border:1px solid #000;">
                                    Title of the activity
                                </td>

                                <td style="border:1px solid #000;">
                                    {{($ticket->title_of_activity) ?? 'N/A'}}
                                </td>
                            </tr>

                            <tr>
                                <td style="background:#d8eaff; border:1px solid #000;">
                                    Date/s of conduct
                                </td>
                                <td style="border:1px solid #000;">
                                    {{
                                        ($ticket->date_of_activity && $ticket->date_of_activity_end)
                                            ? \Carbon\Carbon::parse($ticket->date_of_activity)->format('F d, Y')
                                                . ' - ' .
                                            \Carbon\Carbon::parse($ticket->date_of_activity_end)->format('F d, Y')
                                            : 'N/A'
                                    }}
                                </td>
                            </tr>

                            <tr>
                                <td style="background:#d8eaff; border:1px solid #000;">
                                    Venue
                                </td>
                                <td style="border:1px solid #000;">
                                    {{ ($ticket->venue)?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="background:#d8eaff; border:1px solid #000;">
                                    Type of Activity
                                </td>
                                <td style="border:1px solid #000;">
                                    {{($ticket->type_of_activity)?? 'N/A'}}
                                </td>
                            </tr>

                            <tr>
                                <td style="background:#d8eaff; border:1px solid #000;">
                                    Target Participants
                                </td>
                                <td style="border:1px solid #000;">
                                    {{($ticket->target_participants)?? 'N/A'}}
                                </td>
                            </tr>
                        </table>
                        <table class="table-table-bordered" style="margin-top: -25px;">
                            <tr>
                                <th width=30% rowspan="1" style="background:#d8eaff; border:1px solid #000; vertical-align:top; font-style:italic; text-align:left; padding:10px;">
                                    For Requests on sharing knowledge products
                                </th>
                                <td style="background:#d8eaff; border:1px solid #000; width:20%">Type of knowledge product requested:</td>
                                <td style="border:1px solid #000; padding:2px 6px;">
                                    <div style="
                                        display:grid;
                                        grid-template-columns:repeat(2, 1fr);
                                        column-gap:8px;
                                        row-gap:0;
                                        font-size:11px;
                                        line-height:1.15;
                                    ">
                                        @foreach($ticket->knowledge_product_display_items as $item)
                                            <div style="overflow-wrap:anywhere;">
                                                @if($item === '-')
                                                N/A

                                                @else
                                                • {{ $item }}
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div>
                        @include('partials.print_footer2')
                        </div>
                    </section>

                    <div class="page-break"></div>
                    <section class="print-page">
                        <div style="padding-top: 80px;">
                            @include('partials.print_header')
                        </div>
                        <h5><i>REMARKS / OTHER CONCERNS</i></h5> 
                        <table>
                            <tr>
                                <td style="border:1px solid #000;" width="100%" height="80"></td>
                            </tr>
                        </table>

                        <table>
                            <tr>
                                <th style="background:#d8eaff; border:1px solid #000;"><i>TO WHOM WOULD YOU LIKE TO SUBMIT THE REQUEST?</i></th>
                                <td style="border:1px solid #000;">
                                    @if($ticket->received_ticket_to === '')
                                    DSWD {{$ticket->received_ticket_to_office}}

                                    @else
                                    DSWD Central Office
                                    
                                    @endif

                                </td>
                            </tr> 
                        </table>
                        <div style="padding-top:30px;">
                            <span>Requested by: ________________________________</span>
                                    <div style="margin-left:110px;"><span>Signature over Printed Name</span></div>
                        </div>
                        @include('partials.print_footer3')
                    </section>
            </div>
        </div>
    </div>
</div>

    
    
    <div id="commentBody" class="d-none mt-4">

    <div class="comments-wrap">

        <div class="composer-card">

            <div class="composer-title">
                <i class="bi bi-chat-left-text"></i>
                Discussion
                @if(isset($ticket) && $ticket->comments->count())
                    <span class="text-muted fw-normal">({{ $ticket->comments->count() }})</span>
                @endif
            </div>


            @if($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="commentForm" enctype="multipart/form-data" method="POST"
                  action="{{ route('tickets.comments.store', $ticket->id) }}">
                @csrf
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <input type="hidden" name="parent_id" value="">

                <div class="composer-body">

                    <div class="avatar">
                        {{ strtoupper(substr(optional(auth()->user())->name ?? 'G', 0, 1)) }}
                    </div>

                    <div class="composer-input-group">
                        <textarea
                            class="composer-textarea"
                            name="comment"
                            id="main_comment"
                            rows="1"
                            maxlength="1000"
                            placeholder="Write a comment..."
                            required></textarea>

                        <div id="main_file_chips" class="file-chip-row"></div>

                        <div class="composer-footer">
                            <label class="attach-btn">
                                <i class="bi bi-paperclip"></i>
                                Attach
                                <input type="file" name="attachments[]" id="main_attachments" multiple>
                            </label>

                            <div class="d-flex align-items-center gap-3">
                                <span class="char-counter"><span id="comment_count">0</span>/1000</span>
                                <button class="btn-post" id="postCommentBtn" type="submit" disabled>
                                    <span id="postCommentSpinner" class="spinner-border spinner-border-sm me-1 d-none" role="status" aria-hidden="true"></span>
                                    Post
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <div class="thread">

            @forelse($ticket->comments as $comment)
                <div class="comment-node {{ $comment->replies->count() ? 'has-replies comment-node-with-replies' : '' }} p-3" data-comment-id="{{ $comment->id }}">
                    <div class="rail">
                        <div class="avatar">
                            {{ strtoupper(substr(optional($comment->user)->name ?? $comment->guest_name, 0, 1)) }}
                        </div>
                    </div>

                    <div class="comment-content">

                        <div class="comment-meta">
                            <span class="comment-author">
                                {{ optional($comment->user)->name ?? $comment->guest_name }}
                            </span>
                            <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="comment-text">
                            {!! nl2br(e($comment->comment)) !!}
                        </div>

                        @if($comment->attachments->count())
                            <div>
                                @foreach($comment->attachments as $file)
                                    <a href="{{ Storage::url($file->file_path) }}" download="{{ $file->original_name }}" class="attachment-chip">
                                        <i class="bi bi-paperclip"></i>
                                        {{ $file->original_name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div class="comment-actions">
                            <button type="button" class="action-link replyToggleBtn" data-target="reply-form-{{ $comment->id }}">
                                <i class="bi bi-reply"></i> Reply
                            </button>
                        </div>

                        <form id="reply-form-{{ $comment->id }}"
                              class="reply-form-wrap"
                              enctype="multipart/form-data" method="POST"
                              action="{{ route('tickets.comments.store', $ticket->id) }}">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                            <div class="avatar avatar-sm">
                                {{ strtoupper(substr(optional(auth()->user())->name ?? 'G', 0, 1)) }}
                            </div>

                            <div class="reply-form-main">
                                <div class="reply-form-top">
                                    <span class="reply-label">Replying to {{ optional($comment->user)->name ?? $comment->guest_name }}</span>
                                    <span class="reply-hint">Max 500 characters</span>
                                </div>

                                <textarea name="comment" class="reply-input"
                                          rows="3"
                                          placeholder="Write a thoughtful reply..."
                                          maxlength="500" required></textarea>

                                <div class="reply-form-footer">
                                    <div class="reply-tools">
                                        <label class="reply-file-btn" title="Attach a file">
                                            <i class="bi bi-paperclip"></i>
                                            <span>Attach</span>
                                            <input type="file" name="attachments[]" class="reply-file-input">
                                        </label>
                                        <span class="reply-file-name">No file chosen</span>
                                    </div>

                                    <div class="reply-actions">
                                        <button type="button" class="btn-reply-cancel">Cancel</button>
                                        <button type="submit" class="btn-reply-send" title="Send reply">
                                            <i class="bi bi-send-fill me-1"></i>
                                            <span>Reply</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>

                @if($comment->replies->count())

                    <button type="button" class="replies-toggle" data-target="replies-{{ $comment->id }}">
                        <i class="bi bi-chevron-right chevron"></i>
                        {{ $comment->replies->count() }} {{ Str::plural('reply', $comment->replies->count()) }}
                    </button>

                    <div class="replies-list collapsed" id="replies-{{ $comment->id }}">

                        @foreach($comment->replies as $reply)

                                    <div class="reply-node" data-comment-id="{{ $reply->id }}">

                                <div class="avatar avatar-sm">
                                    {{ strtoupper(substr(optional($reply->user)->name ?? $reply->guest_name, 0, 1)) }}
                                </div>

                                <div class="comment-content">

                                    <div class="comment-meta">
                                        <span class="reply-badge">
                                            <i class="bi bi-arrow-return-right"></i>
                                            Reply
                                        </span>
                                    </div>

                                    <div class="comment-meta">
                                        <span class="comment-author" style="font-size:0.85rem;">
                                            {{ optional($reply->user)->name ?? $reply->guest_name }}
                                        </span>
                                        <span class="comment-time">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>

                                    <div class="comment-text" style="font-size:0.85rem;">
                                        {!! nl2br(e($reply->comment)) !!}
                                    </div>

                                    @if($reply->attachments->count())
                                        <div>
                                            @foreach($reply->attachments as $file)
                                                <a href="{{ Storage::url($file->file_path) }}" download="{{ $file->original_name }}" class="attachment-chip">
                                                    <i class="bi bi-paperclip"></i>
                                                    {{ $file->original_name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                </div>
                            </div>

                        @endforeach

                    </div>

                @endif

            @empty

                <div class="empty-state">
                    <i class="bi bi-chat-left-text"></i>
                    <h6>No comments yet</h6>
                    <small>Start the discussion by posting the first comment.</small>
                </div>

            @endforelse

        </div>

    </div>

</div>
    <div id="historyBody" class="d-none mt-3">
        <div class="card history-card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between p-4 pb-3">
                <div>
                    <h5 class="mb-1 fw-bold">Ticket history</h5>
                    <small class="text-muted">A record of all ticket updates and communication.</small>
                </div>
                <span class="badge bg-light text-dark border">{{ $activities->count() + 1 }} events</span>
            </div>
            <div class="card-body p-4 pt-2">
                <div class="history-item">
                    <div class="history-rail"><span class="history-dot"><i class="bi bi-plus-circle"></i></span></div>
                    <div class="history-content">
                        <div class="history-title">Ticket submitted</div>
                        <div class="history-description">The request was submitted and is waiting for review.</div>
                        <div class="history-meta">{{ trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name) ?: 'Requester' }} &middot; {{ $ticket->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>

                @foreach($activities->where('event', '!=', 'ticket_created')->sortBy('created_at') as $activity)
                    @php
                        $icon = match($activity->event) {
                            'status_changed' => 'bi-arrow-left-right',
                            'document_printed' => 'bi-printer',
                            'comment_added', 'comment_reply' => 'bi-chat-dots',
                            'attachment_added', 'resolution_attachment_added' => 'bi-paperclip',
                            default => 'bi-check2-square',
                        };
                    @endphp
                    <div class="history-item">
                        <div class="history-rail"><span class="history-dot"><i class="bi {{ $icon }}"></i></span></div>
                        <div class="history-content">
                            <div class="history-title">{{ $activity->title }}</div>
                            @if($activity->description)<div class="history-description">{{ $activity->description }}</div>@endif
                            <div class="history-meta">{{ $activity->performed_by ?: 'System' }} &middot; {{ $activity->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@if(isset($ticketReturns) && $ticketReturns->isNotEmpty())
    <div class="modal fade return-details-modal" id="returnDetailsModal" tabindex="-1" aria-labelledby="returnDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="return-detail-icon">
                            <i class="bi bi-arrow-counterclockwise fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-1" id="returnDetailsModalLabel">Ticket returned</h5>
                            <small class="text-muted">Return details for #{{ $ticket->ticket_id }}</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @foreach($ticketReturns as $return)
                        @php
                            $returnUrgency = strtolower($return->urgency ?? 'medium');
                            $returnUrgencyClass = match($returnUrgency) {
                                'urgent' => 'bg-danger text-white',
                                'high' => 'bg-warning text-dark',
                                'low' => 'bg-success-subtle text-success',
                                default => 'bg-primary-subtle text-primary',
                            };
                        @endphp
                        <div class="return-history-item mb-4 pb-4 border-bottom">
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <span class="return-meta-label">Urgency</span>
                                    <span class="badge rounded-pill {{ $returnUrgencyClass }}">{{ ucfirst($returnUrgency) }}</span>
                                </div>
                                <div class="col-6">
                                    <span class="return-meta-label">Current status</span>
                                    <span class="badge rounded-pill bg-info-subtle text-info">{{ ucfirst($ticket->ticket_status) }}</span>
                                </div>
                                <div class="col-12">
                                    <span class="return-meta-label">Returned by</span>
                                    <strong>{{ $ticket->requestor_first_name }} {{ $ticket->requestor_last_name }}</strong>
                                    <div class="small text-muted">{{ $return->returned_at?->format('M d, Y h:i A') ?? $return->created_at->format('M d, Y h:i A') }}</div>
                                </div>
                            </div>

                            <span class="return-meta-label">Return reason</span>
                            <div class="return-reason-box">{{ $return->return_reason }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif

@if(isset($resolutions) && $resolutions->isNotEmpty())
    @php
        $currentResolutionId = $resolutions->first()->id;
    @endphp
    <div class="modal fade resolution-history-modal" id="resolutionHistoryModal" tabindex="-1" aria-labelledby="resolutionHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-1" id="resolutionHistoryModalLabel"><i class="bi bi-check2-square me-2"></i>Resolution history</h5>
                        <small class="text-muted">Descriptions, attachments, and status changes for #{{ $ticket->ticket_id }}</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @foreach($resolutions as $index => $resolution)
                        @php
                            $fromStatus = $resolutions->get($index + 1)?->resolution_status ?? 'submitted';
                            $toStatus = $resolution->resolution_status ?? 'updated';
                        @endphp
                        <article class="resolution-history-item {{ $resolution->id === $currentResolutionId ? 'is-current' : '' }}">
                            @if($resolution->id === $currentResolutionId)
                                <div class="current-resolution-badge">Current resolution</div>
                            @endif
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                                <div class="resolution-transition">
                                    <span class="badge bg-light text-dark border">{{ ucfirst($fromStatus) }}</span>
                                    <i class="bi bi-arrow-right"></i>
                                    <span class="badge bg-success-subtle text-success">{{ ucfirst($toStatus) }}</span>
                                </div>
                                <span class="small text-muted text-end">{{ ($resolution->resolved_at ?? $resolution->created_at)->format('M d, Y h:i A') }}</span>
                            </div>
                            <div class="small fw-semibold text-muted mb-2">Resolution description</div>
                            <div class="resolution-description mb-3">{{ $resolution->resolution_text ?: 'No resolution details were provided.' }}</div>
                            @if($resolution->attachments->isNotEmpty())
                                <div class="small fw-semibold text-muted mb-2">Attachments</div>
                                <div class="d-grid gap-2">
                                    @foreach($resolution->attachments as $attachment)
                                        <a href="{{ Storage::url($attachment->attachment_path) }}" download="{{ $attachment->attachment }}" rel="noopener" class="resolution-file">
                                            <i class="bi bi-paperclip"></i>
                                            <span>{{ $attachment->attachment }}</span>
                                            <i class="bi bi-box-arrow-up-right ms-auto"></i>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="small text-muted"><i class="bi bi-paperclip me-1"></i>No attachments</div>
                            @endif
                        </article>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    (function () {
            const textarea = document.getElementById('main_comment');
            const counter = document.getElementById('comment_count');
            const postBtn = document.getElementById('postCommentBtn');

            function autoGrow(el) {
                el.style.height = 'auto';
                el.style.height = Math.min(el.scrollHeight, 200) + 'px';
            }

            if (textarea) {
                textarea.addEventListener('input', function () {
                    autoGrow(this);
                    const len = this.value.length;
                    counter.textContent = len;
                    counter.classList.toggle('limit-near', len > 800 && len <= 950);
                    counter.classList.toggle('limit-hit', len > 950);
                    postBtn.disabled = len === 0;
                });
            }

            const fileInput = document.getElementById('main_attachments');
            const chipRow = document.getElementById('main_file_chips');
            if (fileInput) {
                fileInput.addEventListener('change', function () {
                    chipRow.innerHTML = '';
                    Array.from(this.files).forEach(function (file) {
                        const chip = document.createElement('span');
                        chip.className = 'file-chip';
                        const icon = document.createElement('i');
                        icon.className = 'bi bi-paperclip';
                        chip.append(icon, document.createTextNode(' ' + file.name));
                        chipRow.appendChild(chip);
                    });
                });
            }

            document.querySelectorAll('.replyToggleBtn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const target = document.getElementById(this.dataset.target);
                    if (!target) return;
                    const isOpen = target.classList.contains('open');

                    document.querySelectorAll('.reply-form-wrap.open').forEach(function (f) {
                        if (f !== target) f.classList.remove('open');
                    });

                    target.classList.toggle('open', !isOpen);
                    if (!isOpen) {
                        const input = target.querySelector('[name="comment"]');
                        if (input) input.focus();
                    }
                });
            });

            document.addEventListener('change', function (e) {
                const input = e.target.closest('.reply-file-input');
                if (!input) return;
                const form = input.closest('.reply-form-wrap');
                if (!form) return;
                const fileName = form.querySelector('.reply-file-name');
                if (!fileName) return;
                fileName.textContent = input.files && input.files.length ? input.files[0].name : 'No file chosen';
            });

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn-reply-cancel');
                if (!btn) return;
                const form = btn.closest('.reply-form-wrap');
                if (!form) return;
                form.classList.remove('open');
                form.reset();
                const fileName = form.querySelector('.reply-file-name');
                if (fileName) fileName.textContent = 'No file chosen';
            });

            document.querySelectorAll('.replies-toggle').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const target = document.getElementById(this.dataset.target);
                    if (!target) return;
                    const collapsed = target.classList.toggle('collapsed');
                    this.classList.toggle('expanded', !collapsed);
                });
            });

            const commentForm = document.getElementById('commentForm');
            const spinner = document.getElementById('postCommentSpinner');
            if (commentForm) {
                commentForm.addEventListener('submit', function () {
                    try{ localStorage.setItem('ticketActiveTab','comment'); }catch(e){}
                    postBtn.disabled = true;
                    spinner.classList.remove('d-none');
                });
            }
        })();

    document.querySelector('.copy-ticket').addEventListener('click', async function(){
        const ticketNumber = this.dataset.ticket;

        try{
            await navigator.clipboard.writeText(ticketNumber);

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Ticket number copied!',
                showConfirmButton: false,
                timer: 1800,
                timerProgressBar: true
            });
        } catch (err){
            Swal.fure({
                icon: 'error',
                title: 'Copy failed',
                text: 'Unable to copy the ticket number.'
            });
        }
    });

    document.getElementById('btnRequestInfo').addEventListener('click', function(){
        document.getElementById('requestInformationBody').classList.remove('d-none')
        document.getElementById('commentBody').classList.add('d-none');
        document.getElementById('historyBody').classList.add('d-none');
        document.getElementById('printBody').classList.add('d-none');
        try{ localStorage.setItem('ticketActiveTab','request'); }catch(e){}
    });

    document.getElementById('btnComment').addEventListener('click', function(){
        document.getElementById('requestInformationBody').classList.add('d-none')
        document.getElementById('commentBody').classList.remove('d-none');
        document.getElementById('historyBody').classList.add('d-none');
        document.getElementById('printBody').classList.add('d-none');
        try{ localStorage.setItem('ticketActiveTab','comment'); }catch(e){}
    });

    document.getElementById('btnHistory').addEventListener('click', function(){
        document.getElementById('requestInformationBody').classList.add('d-none')
        document.getElementById('commentBody').classList.add('d-none');
        document.getElementById('historyBody').classList.remove('d-none');
        document.getElementById('printBody').classList.add('d-none');
        try{ localStorage.setItem('ticketActiveTab','history'); }catch(e){}
    });

    document.getElementById('btnPrint').addEventListener('click', function(e){
        const btn = this;
        const acknowledged = btn.getAttribute('data-acknowledged') === '1';
        if(!acknowledged){
            e.stopImmediatePropagation();
            e.preventDefault();
            if(window.Swal){
                Swal.fire({
                    icon: 'warning',
                    title: 'Ticket not acknowledged',
                    text: 'Please acknowledge this ticket before printing or exporting.',
                });
            } else {
            }
            return;
        }

        document.getElementById('requestInformationBody').classList.add('d-none');
        document.getElementById('commentBody').classList.add('d-none');
        document.getElementById('historyBody').classList.add('d-none');
        document.getElementById('printBody').classList.remove('d-none');
        try{ localStorage.setItem('ticketActiveTab','print'); }catch(e){}
    });

    const tabs = document.querySelectorAll('.ticket-tab');
    const indicator = document.querySelector('.tab-indicator');

    tabs.forEach((tab, index) => {

        tab.addEventListener('click', function () {

            tabs.forEach(t => t.classList.remove('active'));

            this.classList.add('active');

            indicator.style.transform = `translateX(${index * 100}%)`;
            try{ localStorage.setItem('ticketActiveIndicatorIndex', String(index)); }catch(e){}

        });

    });

    // Print button inside printBody: record and trigger native print
    const printBtn = document.getElementById('printBtn');
    if(printBtn){
        printBtn.addEventListener('click', async function(){
            try {
                await fetch('{{ route('tickets.print.record', $ticket->ticket_id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
            } catch (error) {
                console.error('Unable to record ticket print activity.', error);
            }

            window.print();
        });
    }

    document.addEventListener('click', function(e){
        const btn = e.target.closest('.replyBtn');
        if(!btn) return;
        e.preventDefault();
        const id = btn.dataset.id;
        const parentInput = document.getElementById('parent_id');
        parentInput.value = id;
        const textarea = document.querySelector('textarea[name="comment"]');
        if(textarea){
            textarea.focus();
        }
        // Switch to comments tab
        try{ localStorage.setItem('ticketActiveTab','comment'); }catch(e){}
        document.getElementById('btnComment').click();
    });
</script>
<script>
(function(){
    try{
        const saved = localStorage.getItem('ticketActiveTab');
        if(saved){
            switch(saved){
                case 'comment': if(document.getElementById('btnComment')) document.getElementById('btnComment').click(); break;
                case 'history': if(document.getElementById('btnHistory')) document.getElementById('btnHistory').click(); break;
                case 'print': if(document.getElementById('btnPrint')) document.getElementById('btnPrint').click(); break;
                default: if(document.getElementById('btnRequestInfo')) document.getElementById('btnRequestInfo').click(); break;
            }
        } else {
            // also restore indicator position if previously stored
            const idx = localStorage.getItem('ticketActiveIndicatorIndex');
            if(idx !== null){
                const indicator = document.querySelector('.tab-indicator');
                if(indicator) indicator.style.transform = `translateX(${Number(idx) * 100}%)`;
            }
        }
const flashSuccess = @json(session('success'));
const flashSuccessTitle = @json(session('success_title', 'Success'));

if (flashSuccess) {
    const showFlash = () => {
        if (window.Swal) {
            Swal.fire({
                icon: 'success',
                title: flashSuccessTitle,
                text: flashSuccess,
                confirmButtonText: 'Continue',
                confirmButtonColor: '#212529',
                background: '#fff',
                color: '#212529',
                customClass: {
                    popup: 'rounded-4 shadow-lg',
                    confirmButton: 'rounded-pill px-4'
                }
            });
        } else {
            alert(flashSuccess);
        }
    };

    if (window.Swal) {
        showFlash();
    } else {
        // Poll briefly for Swal to become available (5s max)
        let waited = 0;
        const iv = setInterval(() => {
            if (window.Swal) {
                clearInterval(iv);
                showFlash();
                return;
            }
            waited += 100;
            if (waited >= 5000) clearInterval(iv);
        }, 100);
    }
}
    }catch(e){}
})();
</script>

<div class="modal fade" id="attachmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attachmentModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="attachmentModalImage" src="" alt="Attachment" style="max-width:100%; max-height:70vh; display:none;" />
                <iframe id="attachmentModalFrame" src="" frameborder="0" style="width:100%; height:70vh; display:none;"></iframe>
            </div>
            <div class="modal-footer">
                <a id="attachmentModalDownload" href="#" class="btn btn-primary" target="_blank">Download</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('click', function(e){
        const link = e.target.closest('.attachment-link');
        if(!link) return;
        e.preventDefault();

        const url = link.getAttribute('href');
        const filetype = (link.dataset.filetype || '').toLowerCase();
        const name = link.dataset.name || '';

        const img = document.getElementById('attachmentModalImage');
        const frame = document.getElementById('attachmentModalFrame');
        const title = document.getElementById('attachmentModalLabel');
        const download = document.getElementById('attachmentModalDownload');

        img.style.display = 'none'; img.src = '';
        frame.style.display = 'none'; frame.src = '';

        if(filetype.startsWith('image/')){
                img.src = url;
                img.style.display = '';
        } else {
                frame.src = url;
                frame.style.display = '';
        }

        title.textContent = name;
        download.href = url;
        if(name){
            download.setAttribute('download', name);
        } else {
            download.removeAttribute('download');
        }
        download.removeAttribute('target');

        const modalEl = document.getElementById('attachmentModal');
        const bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();

        modalEl.addEventListener('hidden.bs.modal', function handler(){
                img.src = '';
                frame.src = '';
                modalEl.removeEventListener('hidden.bs.modal', handler);
        });
});
(function(){
    const mainTextarea = document.getElementById('main_comment');
    const counter = document.getElementById('comment_count');
    const fileInput = document.getElementById('main_attachments');
    const fileListPreview = document.getElementById('file_list_preview');
    const postBtn = document.getElementById('postCommentBtn');
    const postSpinner = document.getElementById('postCommentSpinner');

    if(mainTextarea && counter){
        counter.textContent = mainTextarea.value.length;
        mainTextarea.addEventListener('input', function(){
            counter.textContent = this.value.length;
            postBtn.disabled = this.value.trim().length === 0;
        });
    }

    if(fileInput && fileListPreview){
        fileInput.addEventListener('change', function(){
            if(this.files.length === 0){ fileListPreview.textContent = 'No files chosen'; return; }
            const names = Array.from(this.files).map(f => f.name).join(', ');
            fileListPreview.textContent = names;
        });
    }

    const commentForm = document.getElementById('commentForm');
    if(commentForm){
        commentForm.addEventListener('submit', function(){
            if(postSpinner) postSpinner.classList.remove('d-none');
        });
    }
})();
(function(){
    const token = document.querySelector('input[name="_token"]').value;

    // Submit main comment form via AJAX (only when form has data-ajax="1")
    const commentForm = document.getElementById('commentForm');
    if(commentForm){
        commentForm.addEventListener('submit', async function(e){
            // If the form isn't opted-in for AJAX, allow normal submit (page reload)
            if (!(commentForm.dataset.ajax && commentForm.dataset.ajax === '1')) {
                return; // don't preventDefault, let the browser submit the form normally
            }
            e.preventDefault();
            const submitBtn = commentForm.querySelector('button[type="submit"]') || commentForm.querySelector('button');
            submitBtn.disabled = true;
            const spinnerEl = document.getElementById('postCommentSpinner');
            if(spinnerEl) spinnerEl.classList.remove('d-none');
            const fd = new FormData(commentForm);
            try{
                const res = await fetch(commentForm.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': token },
                    body: fd
                });
                if(!res.ok){
                    const txt = await res.text();
                    let msg = `Request failed: ${res.status} ${res.statusText}`;
                    try{
                        const j = JSON.parse(txt);
                        if(j.message) msg += '\n' + j.message;
                    }catch(_) { msg += '\n' + txt; }
                    throw new Error(msg);
                }
                const data = await res.json();
                // insert server-rendered html, or build fallback from JSON
                if(data.html){
                    insertRenderedComment(data);
                } else {
                    const html = buildFallbackHtml(data);
                    insertRenderedComment({ parent_id: data.parent_id ?? null, html });
                }
                commentForm.reset();
                // clear parent_id hidden
                const pid = document.getElementById('parent_id'); if(pid) pid.value = '';
            }catch(err){
                console.error(err);
                alert('Failed to post comment:\n' + (err.message || err));
            }finally{ submitBtn.disabled = false; if(spinnerEl) spinnerEl.classList.add('d-none'); }
        });
    }

    function insertRenderedComment(data){
        const container = document.querySelector('#commentBody');
        if(!container) return;
        const safeHtml = window.DOMPurify ? window.DOMPurify.sanitize(data.html || '') : '';
        // find the composer/form card where new comments should be inserted after
        const formCard = container.querySelector('.composer-card') || container.querySelector('#commentForm') || container.querySelector('form');

        if(!data.parent_id){
            // main comment: insert after form if available, otherwise append to container
            if(formCard && typeof formCard.insertAdjacentHTML === 'function'){
                formCard.insertAdjacentHTML('afterend', safeHtml);
            } else {
                container.insertAdjacentHTML('beforeend', safeHtml);
            }
            return;
        }

        // reply: try several targets in order: element with data-comment-id, replies list by id, or append to container
        const parentByData = document.querySelector(`[data-comment-id="${data.parent_id}"]`);
        const repliesList = document.getElementById(`replies-${data.parent_id}`);
        if(repliesList){
            repliesList.insertAdjacentHTML('beforeend', safeHtml);
            return;
        }
        if(parentByData){
            // prefer an inner replies container if present
            const innerReplies = parentByData.querySelector('.replies-container') || parentByData.querySelector('.replies-list');
            if(innerReplies){
                innerReplies.insertAdjacentHTML('beforeend', safeHtml);
                return;
            }
            // otherwise append after parent node
            parentByData.insertAdjacentHTML('afterend', safeHtml);
            return;
        }

        // fallback: append to main container
        container.insertAdjacentHTML('beforeend', safeHtml);
    }

    // Fallback: build minimal comment HTML when server returns JSON instead of rendered HTML
    function buildFallbackHtml(d){
        const user = d.user_name || d.guest_name || 'Guest';
        const avatar = (user && user.length) ? user.charAt(0).toUpperCase() : 'G';
        let attachHtml = '';
        if(d.attachments && d.attachments.length){
            attachHtml = '<div>' + d.attachments.map(a=>
                `<a href="${a.url}" download="${a.original_name}" class="attachment-chip"><i class="bi bi-paperclip"></i> ${a.original_name}</a>`
            ).join(' ') + '</div>';
        }
        return `
            <div class="comment-node" data-comment-id="${d.id}">
                <div class="rail"><div class="avatar">${avatar}</div></div>
                <div class="comment-content">
                    <div class="comment-meta"><span class="comment-author">${user}</span> <span class="comment-time">${d.created_at}</span></div>
                    <div class="comment-text">${(d.comment||'').replace(/\n/g,'<br>')}</div>
                    ${attachHtml}
                    <div class="comment-actions"><button type="button" class="action-link replyToggleBtn" data-target="reply-form-${d.id}"><i class="bi bi-reply"></i> Reply</button></div>
                </div>
            </div>
        `;
    }

    // Inline reply form handler
    document.addEventListener('click', function(e){
        const btn = e.target.closest('.replyBtn');
        if(!btn) return;
        e.preventDefault();
        const id = btn.dataset.id;
        // if reply form already exists for this comment, focus
        const commentItem = btn.closest('.comment-item');
        if(!commentItem) return;
        if(commentItem.querySelector('.inline-reply-form')){
            commentItem.querySelector('textarea').focus();
            return;
        }
        const formHtml = `
            <form class="inline-reply-form mt-3" enctype="multipart/form-data" data-parent="${id}" action="${commentForm.action}">
                <input type="hidden" name="_token" value="${token}">
                <input type="hidden" name="parent_id" value="${id}">
                <div class="mb-2"><textarea name="comment" rows="3" class="form-control" required placeholder="Write your reply..."></textarea></div>
                <div class="d-flex gap-2"><input type="file" name="attachments[]" class="form-control form-control-sm flex-grow-1"><button class="btn btn-primary btn-sm">Reply</button><button class="btn btn-secondary btn-sm btn-cancel-reply" type="button">Cancel</button></div>
            </form>
        `;
        const repliesContainer = commentItem.querySelector('.replies-container');
        repliesContainer.insertAdjacentHTML('beforeend', formHtml);
    });

    // Handle inline reply submit/cancel
    document.addEventListener('submit', async function(e){
        const form = e.target;
        if(!form.classList.contains('inline-reply-form')) return;
        e.preventDefault();
        const btn = form.querySelector('button[type=submit]') || form.querySelector('button');
        btn.disabled = true;
        const fd = new FormData(form);
        try{
            const res = await fetch(form.action, { method:'POST', headers:{ 'X-Requested-With':'XMLHttpRequest', 'X-CSRF-TOKEN': token }, body: fd });
            if(!res.ok){
                const txt = await res.text();
                let msg = `Request failed: ${res.status} ${res.statusText}`;
                try{ const j = JSON.parse(txt); if(j.message) msg += '\n'+j.message; }catch(_) { msg += '\n'+txt; }
                throw new Error(msg);
            }
            const data = await res.json();
            if(data.html){
                insertRenderedComment(data);
            } else {
                const html = buildFallbackHtml(data);
                insertRenderedComment({ parent_id: data.parent_id ?? null, html });
            }
            form.remove();
        }catch(err){
            console.error(err);
            alert('Failed to post reply:\n' + (err.message || err));
        }finally{ btn.disabled = false; }
    });

    document.addEventListener('click', function(e){
        const btn = e.target.closest('.btn-cancel-reply');
        if(!btn) return;
        const form = btn.closest('.inline-reply-form');
        if(form) form.remove();
    });

    
})();
</script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const ackForm = document.getElementById('ackForm');
    const ackLoader = document.getElementById('ackLoader');
    const ackBtn = document.getElementById('ackBtn');
    const resolutionForm = document.getElementById('resolutionForm');
    const resolutionStatus = document.getElementById('ticket_status');
    const resolutionText = document.getElementById('resolution_text');
    const resolutionAttachments = document.getElementById('attachments');
    const resolutionFileName = document.getElementById('resolutionFileName');
    const loaderTitle = document.getElementById('ackLoaderTitle');

    function requiresResolution() {
        return resolutionStatus && ['resolved', 'completed', 'rejected'].includes(resolutionStatus.value);
    }

    function requiresTerminalConfirmation() {
        return resolutionStatus && ['completed', 'rejected'].includes(resolutionStatus.value);
    }

    function updateResolutionRequirements() {
        if (!resolutionStatus) return;
        const required = requiresResolution();
        if (resolutionText) resolutionText.required = required;
        if (resolutionAttachments) {
            const hasExistingAttachment = Number(resolutionAttachments.dataset.existingCount || 0) > 0;
            resolutionAttachments.required = required && !hasExistingAttachment;
        }
    }

    if (resolutionStatus) {
        updateResolutionRequirements();
        resolutionStatus.addEventListener('change', updateResolutionRequirements);
    }

    if (resolutionAttachments && resolutionFileName) {
        resolutionAttachments.addEventListener('change', function() {
            const files = Array.from(resolutionAttachments.files || []);
            resolutionFileName.textContent = files.length
                ? `${files.length} file${files.length === 1 ? '' : 's'} selected`
                : 'No new files selected';
            resolutionFileName.title = files.map(file => file.name).join(', ');
        });
    }

    if (resolutionForm && ackLoader) {
        resolutionForm.addEventListener('submit', async function(event){
            updateResolutionRequirements();

            if (resolutionForm.dataset.confirmed !== '1' && requiresTerminalConfirmation()) {
                event.preventDefault();

                const statusLabel = resolutionStatus.value === 'completed' ? 'complete' : 'reject';
                let confirmed = false;

                if (window.Swal && Swal.fire) {
                    const result = await Swal.fire({
                        icon: 'warning',
                        title: `${statusLabel.charAt(0).toUpperCase() + statusLabel.slice(1)} this ticket?`,
                        text: `This will ${statusLabel} the ticket and it cannot be edited afterward.`,
                        showCancelButton: true,
                        confirmButtonText: `Yes, ${statusLabel} ticket`,
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#212529',
                        cancelButtonColor: '#6c757d'
                    });
                    confirmed = result.isConfirmed;
                } else {
                    confirmed = window.confirm(`This will ${statusLabel} the ticket and it cannot be edited afterward. Continue?`);
                }

                if (!confirmed) return;
                resolutionForm.dataset.confirmed = '1';
                HTMLFormElement.prototype.requestSubmit.call(resolutionForm);
                return;
            }

            ackLoader.classList.remove('d-none');
            ackLoader.setAttribute('aria-hidden','false');
            if (loaderTitle) loaderTitle.textContent = 'Saving resolution...';
            const submitButton = resolutionForm.querySelector('button[type="submit"]');
            if (submitButton) submitButton.disabled = true;
            resolutionForm.dataset.confirmed = '0';
        });
    }

    if(!ackForm || !ackLoader || !ackBtn) return;

    ackForm.addEventListener('submit', async function(e){
        e.preventDefault();
        ackLoader.classList.remove('d-none');
        ackLoader.setAttribute('aria-hidden','false');
        if (loaderTitle) loaderTitle.textContent = 'Processing acknowledgement...';
        ackBtn.disabled = true;
        const fd = new FormData(ackForm);
        try{
            const token = document.querySelector('input[name="_token"]').value;
            const res = await fetch(ackForm.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': token },
                body: fd,
                redirect: 'follow'
            });
            if(res.ok){
                let message = 'Ticket acknowledged successfully.';
                try{
                    const txt = await res.text();
                    const j = JSON.parse(txt);
                    if(j && j.message) message = j.message;
                }catch(_){}

                // hide loader before showing success modal
                try{ ackLoader.classList.add('d-none'); ackLoader.setAttribute('aria-hidden','true'); }catch(_){}

                if(typeof Swal !== 'undefined' && Swal.fire){
                    await Swal.fire({
                        icon: 'success',
                        title: 'Acknowledged',
                        text: message,
                        confirmButtonColor: '#2563eb'
                    });
                } else {
                    alert(message);
                }

                // reload to reflect acknowledged state
                location.reload();
                return;
            }
            throw new Error('Request failed: ' + res.status);
        }catch(err){
            console.error(err);
            alert('Failed to acknowledge ticket. Please try again.');
            ackLoader.classList.add('d-none');
            ackLoader.setAttribute('aria-hidden','true');
            ackBtn.disabled = false;
        }
    });
});
</script>
@endsection