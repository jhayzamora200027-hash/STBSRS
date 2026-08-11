@extends('layouts.app')

@section('title', 'ViewTicket')

@section('content')
<style>
.resolution-panel {
    border: 1px solid #e6e9ee;
    box-shadow: 0 8px 22px rgba(15, 23, 42, .05);
}

.resolution-panel .card-header {
    background: #fff;
    border-bottom: 1px solid #eef0f3;
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
    min-height: 8rem;
    resize: vertical;
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

    margin:12mm;

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

        background:#fff;

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

        /* ---- Thread ---- */
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
</style>
<div class="p-2">
    <a href="{{ route('tickets') }}" class="btn back-btn border shadow-sm rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i>
        Back to tickets
    </a>
</div>
<div class="p-2">
    
    <h4>
        Ticket Details
    </h4>
    <div class="mb-2">
        <small>View the status and details of request.</small>
    </div>
    <div class="row">
    <div class="col-md-12 mb-3">
        <div class="ticket-tabs mt-4">

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

            <button class="ticket-tab" id="btnPrint">
                <i class="bi bi-printer"></i>
                <span>Print</span>
            </button>

            <div class="tab-indicator"></div>

        </div>
    </div>
</div>
<div class="row" id="requestInformationBody">
    <div class="col-8">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start mb-4">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:65px;height:65px;background:#EEF4FF;">
                            <i class="bi bi-ticket-detailed-fill text-primary fs-2"></i>
                        </div>

                        <div class="ms-3">

                            <small class="text-muted">
                                Ticket Number
                            </small>

                            <h3 class="fw-bold mb-1">

                                {{ $ticket->ticket_id }}

                                <i class="bi bi-copy copy-ticket text-muted ms-2 fs-6"
                                   role="button"
                                   data-ticket="{{ $ticket->ticket_id }}"
                                   title="Copy Ticket Number"></i>

                            </h3>

                            <small class="text-muted">
                                Created {{ $ticket->created_at->format('F d, Y h:i A') }}
                            </small>

                        </div>

                    </div>

                    <div>

                        @switch($ticket->ticket_status)

                            @case('review')
                                <span class="badge rounded-pill bg-light text-dark border px-4 py-2">
                                    <i class="bi bi-hourglass me-1"></i>
                                    For Review
                                </span>
                            @break

                            @case('inprogress')
                                <span class="badge rounded-pill bg-primary px-4 py-2">
                                    <i class="bi bi-arrow-repeat me-1"></i>
                                    In Progress
                                </span>
                            @break

                            @case('resolved')
                                <span class="badge rounded-pill bg-warning text-dark px-4 py-2">
                                    <i class="bi bi-check2-circle me-1"></i>
                                    Resolved
                                </span>
                            @break

                            @case('completed')
                                <span class="badge rounded-pill bg-success px-4 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Completed
                                </span>
                            @break

                            @case('rejected')
                                <span class="badge rounded-pill bg-danger px-4 py-2">
                                    <i class="bi bi-x-circle me-1"></i>
                                    Rejected
                                </span>
                            @break

                        @endswitch

                    </div>

                </div>

                <hr>

                <div class="row mt-4">

                    <!-- LEFT -->
                    <div class="col-md-6 border-end">

                        <div class="mb-4">

                            <small class="text-muted">
                                <i class="bi bi-grid me-1"></i>
                                Category
                            </small>

                            <h6 class="fw-semibold mt-2">

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

                            </h6>

                        </div>

                        <div class="mb-4">

                            <small class="text-muted">
                                <i class="bi bi-diagram-3 me-1"></i>
                                Program
                            </small>

                            <h6 class="fw-semibold mt-2">
                                {{ optional($ticket->programDetails)->program ?? '-' }}
                            </h6>

                        </div>

                        <div class="row">

                            <div class="col-6">

                                <small class="text-muted">
                                    <i class="bi bi-flag me-1"></i>
                                    Priority
                                </small>

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

                            <div class="col-6">

                                <small class="text-muted">
                                    <i class="bi bi-check2-square me-1"></i>
                                    Current Status
                                </small>

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
                                            <span class="badge bg-warning text-dark px-3 py-2">
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

                                    @endswitch

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="col-md-6 ps-md-4">

                        <div class="card bg-light border-0 rounded-4">

                            <div class="card-body">

                                <h6 class="fw-bold mb-4">

                                    <i class="bi bi-person-circle me-2"></i>

                                    Requester Information

                                </h6>

                                <div class="mb-3">

                                    <small class="text-muted">
                                        Full Name
                                    </small>

                                    <h6 class="mb-0">

                                        {{ $ticket->requestor_first_name }}

                                        @if(!empty($ticket->requestor_middle_name))
                                            {{ strtoupper(substr($ticket->requestor_middle_name,0,1)) }}.
                                        @endif

                                        {{ $ticket->requestor_last_name }}

                                    </h6>

                                </div>

                                <div class="mb-3">

                                    <small class="text-muted">
                                        Email Address
                                    </small>

                                    <div>

                                        <i class="bi bi-envelope text-primary me-2"></i>

                                        {{ $ticket->requestor_email }}

                                    </div>

                                </div>

                                <div class="mb-3">

                                    <small class="text-muted">
                                        Location
                                    </small>

                                    <div>

                                        <i class="bi bi-geo-alt text-danger me-2"></i>

                                        {{ data_get($ticket, 'requestRegion.name', '-') }},
                                        {{ data_get($ticket, 'requestProvince.name', '-') }},
                                        {{ data_get($ticket, 'requestCity.name', '-') }}

                                    </div>

                                </div>

                                <div>

                                    <small class="text-muted">
                                        Date Submitted
                                    </small>

                                    <div>

                                        <i class="bi bi-calendar-event text-success me-2"></i>

                                        {{ $ticket->created_at->format('F d, Y h:i A') }}

                                    </div>

                                </div>

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


                                <div class="info-box mb-4">

                                    <div class="info-title">

                                        <i class="bi bi-chat-left-text"></i>

                                        Purpose of Request

                                    </div>

                                    <div class="info-content">

                                        {{ $ticket->purpose_of_request }}

                                    </div>

                                </div>

                                @if($ticket->ticket_category === 'knowledge')

                                <div class="row g-4">


                                    <div class="col-md-12">

                                        <div class="info-box h-100">

                                            <div class="info-title">

                                                <i class="bi bi-journal-bookmark"></i>

                                                Knowledge Product Requested

                                            </div>

                                            <div class="info-content">
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

                                                @if(empty($kpItems))
                                                    -
                                                @else
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach($kpItems as $item)
                                                            <span class="badge bg-light text-dark">{{ e($item) }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                @endif

                                @if($ticket->ticket_category === 'resource')
                                <div class=row>
                                    <div class="col-md-6">
                                        <div class="info-box">

                                            <div class="info-title">

                                                <i class="bi bi-geo-alt-fill"></i>

                                                Venue

                                            </div>

                                            <div class="info-content">

                                                {{ $ticket->venue }}

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-box">

                                            <div class="info-title">

                                                <i class="bi bi-calendar-event"></i>

                                                Type of activity

                                            </div>

                                            <div class="info-content">

                                                {{$ticket->type_of_activity}}

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div style="background:#f8fafc;
                                        border:1px solid #e5e7eb;
                                        border-radius:16px;
                                        padding:22px;
                                        transition:.3s;
                                        min-height:80px;">
                                            <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>
                                                            Start of Acitivty

                                                        </h6>

                                                        <div class="info-content">

                                                            {{ $ticket->date_of_activity }}

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <h6 >
                                                            End of Activity

                                                        </h6>

                                                        <div class="info-content">

                                                            {{ $ticket->date_of_activity_end }}

                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($ticket->ticket_category === 'completed')

                                <div class="info-box">

                                    <div class="info-title">

                                        <i class="bi bi-diagram-3"></i>

                                        Program

                                    </div>

                                    <div class="info-content">

                                        {{ optional($ticket->programDetails)->program ?? '-' }}

                                    </div>

                                </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>

    <div class="col-4 pt-1">
        <div class="card resolution-panel">
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
                <form method="POST" action="{{ route('ticket.resolve', $ticket->ticket_id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="resolution_text" class="form-label">Resolution details</label>
                        <textarea id="resolution_text" name="resolution_text" class="form-control" placeholder="Describe the action taken or the final resolution.">{{ old('resolution_text', $latestResolution?->resolution_text) }}</textarea>
                        @error('resolution_text')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="attachments" class="form-label">Resolution attachments</label>
                        <input id="attachments" type="file" name="attachments[]" class="form-control" multiple>
                        <div class="form-text">You can select multiple supporting files.</div>
                        @error('attachments.*')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        @if($latestResolution?->attachments->isNotEmpty())
                            <div class="resolution-attachments mt-2 small">
                                @foreach($latestResolution->attachments as $attachment)
                                    <div class="d-flex align-items-center gap-2 py-1">
                                        <i class="bi bi-paperclip"></i>
                                        <a href="{{ Storage::url($attachment->attachment_path) }}" target="_blank" rel="noopener">{{ $attachment->attachment }}</a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="ticket_status" class="form-label">Update ticket status</label>
                        <select id="ticket_status" name="ticket_status" class="form-select">
                            <option value="review" @selected(old('ticket_status', $ticket->ticket_status) === 'review')>For Review</option>
                            <option value="inprogress" @selected(old('ticket_status', $ticket->ticket_status) === 'inprogress')>In Progress</option>
                            <option value="resolved" @selected(old('ticket_status', $ticket->ticket_status) === 'resolved')>Resolved</option>
                            <option value="completed" @selected(old('ticket_status', $ticket->ticket_status) === 'completed')>Completed</option>
                        </select>
                        @error('ticket_status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-dark w-100">
                        <i class="bi bi-check2-circle me-2"></i>
                        {{ $latestResolution ? 'Update Resolution' : 'Save Resolution' }}
                    </button>
                </form>
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


    <div class="document-header">

        <table width="100%">
            <tr>

                <td style="width:270px; text-align:center; vertical-align:middle; border:none">
                    <div class="d-flex justify-content-start align-items-start">
                        <img src="{{ asset('images/logo/DSWD&BAGONGPIL-LOGO.png') }}"
                            style="width:270px; max-width:100%;height:auto; display:block; margin:auto;">
                    </div>
                </td>

                <td class="text-center" style="border:none; padding-top: 30px;">

                    
                    <h5 class="fw-bold mb-0" style="font-family: 'Times New Roman', Times, serif; font-size:0.9rem;">
                        SOCIAL TECHNOLOGY BUREAU
                    </h5>

                    <h5 class="mb-0" style="font-family: 'Times New Roman', Times, serif; font-size:0.8rem;">
                        INNOVATIONS AND PROGRAM DEVELOPMENT GROUP
                    </h5>
                    <h6 class="mb-0" style="font-family: 'Times New Roman', Times, serif; font-size:0.8rem;">
                        DSWD-STB-GF-007 | REV 01 | 13 MAR 2023
                    </h6> 

                    <br>

                </td>

            </tr>
        </table>

    </div>
<hr style="border-top:1px solid #000; margin-top:-30px;">

    <div class="text-center mb-4">

        <h3 class="fw-bold">
            REQUEST FORM
        </h3>


    </div>
    <table class="table table-bordered" style="border: 1px solid; border-color:#000">
        <tr>
            <td style="border:1px solid #000;">
                By clicking this, I hereby give my consent and acknowledge that I have read, fully understood, and agree to the
                <i style="color:#0d6efd; text-decoration:underline;">
                    DSWD Data Privacy Terms and Condition
                </i>.
            </td>        
        </tr>
    </table>
    <table class="table table-bordered">

        <tr>
                <th class="text-end" style="border:1px solid #000;">
                    <i>DATE<i>
                </th>
                <td style="border:1px solid #000;">
                    {{$ticket->created_at->format('F d, Y h:i A')}}
                </td>
            {{--
            <th width="25%" style="border:1px solid #000;">
                Ticket Number
            </th>

            <td width="25%" style="border:1px solid #000;">
                {{ $ticket->ticket_id }}
            </td>

            <th width="25%">
                Date Submitted
            </th>

            <td>

                {{ $ticket->created_at->format('F d, Y h:i A') }}

            </td> --}}

        </tr>
        <tr>
                <th class="text-end" style="border:1px solid #000;">
                    NAME OF THE REQUESTOR
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
                <th class="text-end" style="border:1px solid #000;">
                    <i>Position / Designation
                    <div>(Optional)</div></i>
                </th>
                <td>
                    {{$ticket->requestor_position_title}}
                </td>
        <tr>
        

        {{-- <tr>

            <th>
                Status
            </th>

            <td>

                {{ ucwords($ticket->ticket_status) }}

            </td>

            <th>
                Priority
            </th>

            <td>

                {{ ucfirst($ticket->ticket_priority) }}

            </td>

        </tr> --}}

        <tr>

            <th>
                Category
            </th>

            <td colspan="3">

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

            </td>

        </tr>

        <tr>

            <th>

                Program

            </th>

            <td colspan="3">

                {{ optional($ticket->programDetails)->program ?? '-' }}

            </td>

        </tr>

    </table>
    <h5 class="section-title">

        Requester Information

    </h5>

    <table class="table table-bordered">

        <tr>

            <th width="25%">
                Full Name
            </th>

            <td>

                {{ $ticket->requestor_first_name }}

                @if(!empty($ticket->requestor_middle_name))
                    {{ strtoupper(substr($ticket->requestor_middle_name,0,1)) }}.
                @endif

                {{ $ticket->requestor_last_name }}

            </td>

        </tr>

        <tr>

            <th>

                Email Address

            </th>

            <td>

                {{ $ticket->requestor_email }}

            </td>

        </tr>

        <tr>

            <th>

                Region

            </th>

            <td>

                {{ data_get($ticket, 'requestRegion.name', '-') }}

            </td>

        </tr>

        <tr>

            <th>

                Province

            </th>

            <td>

                {{ data_get($ticket, 'requestProvince.name', '-') }}

            </td>

        </tr>

        <tr>

            <th>

                City / Municipality

            </th>

            <td>

                {{ data_get($ticket, 'requestCity.name', '-') }}

            </td>

        </tr>

    </table>

    <h5 class="section-title">

        Request Details

    </h5>

    <table class="table table-bordered">
        @if($ticket->ticket_category === "resource")
        <tr>
            
            <th>Venue</th>

            <td style="height:50px;">
                {{$ticket->venue}}
            </td>

        </tr>
        <tr>
            <th>Type of Activity</th>
            <td style="height:50px;">
                {{$ticket->type_of_activity}}
            </td>
        </tr>
        <tr>
            <th>Activity Schedule</th>
            <td style="height:50px;">{{$ticket->date_of_activity}} - {{$ticket->date_of_activity_end}}</td>
        </tr>
        @endif
        <tr>

            <th width="25%">
                Purpose of Request
            </th>

            <td style="height:120px;">

                {!! nl2br(e($ticket->purpose_of_request)) !!}

            </td>

        </tr>
        <tr>
            <th>With Attachment?</th>
            <td>
                @if($ticket->attachments && $ticket->attachments->count() > 0)
                    Yes
                    <div class="mt-2">
                        @foreach($ticket->attachments as $attachment)
                            <a href="{{ asset('storage/' . $attachment->attachment_path) }}"
                               class="d-block attachment-link"
                               data-filetype="{{ $attachment->file_type }}"
                               data-name="{{ $attachment->attachment }}">
                                {{ $attachment->attachment }}
                            </a>
                        @endforeach
                    </div>
                @else
                    No
                @endif
            </td>
        </tr>
            @if($ticket->ticket_category == 'knowledge')

            <th>

                Knowledge Product Requested

            </th>

            <td>

                @php
                    $kpPrint = $ticket->type_of_knowledge_product ?? null;
                    $kpPrintItems = [];
                    if($kpPrint) {
                        if(is_array($kpPrint)) {
                            $kpPrintItems = $kpPrint;
                        } else {
                            $decodedPrint = json_decode($kpPrint, true);
                            if(is_array($decodedPrint)) {
                                $kpPrintItems = $decodedPrint;
                            } else {
                                $kpPrintItems = array_filter(array_map('trim', explode(',', $kpPrint)));
                            }
                        }
                    }
                @endphp

                @if(empty($kpPrintItems))
                    -
                @else
                    @foreach($kpPrintItems as $item)
                        {{ e($item) }}@if(!$loop->last), @endif
                    @endforeach
                @endif

            </td>
            @endif
    </table>

    <h5 class="section-title">

        Remarks

    </h5>

    <table class="table table-bordered no-break">

        <tr>

            <td style="height:120px;"></td>

        </tr>

    </table>

    <br><br>

    <table width="100%" class="no-break"  style=" height:100px">

        <tr >

            <td width="45%" align="center" style="padding-top:40px;">

                _______________________________

                <br>
                <strong>iSTAksyon Personnel</strong>

            </td>


            <td width="45%" align="center" height:100px style="padding-top:40px;">

                _______________________________

                <br>

                <strong>Receiving Personnel</strong>

            </td>

        </tr>

    </table>




    <div class="document-footer">

        <hr>

        <table width="100%">

            <tr>

                <td>

                    Generated by

                    <strong>

                        STB Service Request System

                    </strong>

                </td>

                <td align="right">

                    Printed on

                    {{ now()->format('F d, Y h:i A') }}

                </td>

            </tr>

        </table>

    </div>

            </div>
        </div>
    </div>
</div>

    
    
    <div id="commentBody" class="d-none mt-4">

    <div class="comments-wrap">

        <!-- ===== Composer ===== -->
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
                                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="attachment-chip">
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
                                                <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="attachment-chip">
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

            // ---- File chips preview for main composer ----
            const fileInput = document.getElementById('main_attachments');
            const chipRow = document.getElementById('main_file_chips');
            if (fileInput) {
                fileInput.addEventListener('change', function () {
                    chipRow.innerHTML = '';
                    Array.from(this.files).forEach(function (file) {
                        const chip = document.createElement('span');
                        chip.className = 'file-chip';
                        chip.innerHTML = '<i class="bi bi-paperclip"></i> ' + file.name;
                        chipRow.appendChild(chip);
                    });
                });
            }

            // ---- Toggle reply form ----
            document.querySelectorAll('.replyToggleBtn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const target = document.getElementById(this.dataset.target);
                    if (!target) return;
                    const isOpen = target.classList.contains('open');

                    // close any other open reply forms
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

            // ---- Toggle replies list ----
            document.querySelectorAll('.replies-toggle').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const target = document.getElementById(this.dataset.target);
                    if (!target) return;
                    const collapsed = target.classList.toggle('collapsed');
                    this.classList.toggle('expanded', !collapsed);
                });
            });

            // ---- Submit spinner on main form ----
            const commentForm = document.getElementById('commentForm');
            const spinner = document.getElementById('postCommentSpinner');
            if (commentForm) {
                commentForm.addEventListener('submit', function () {
                    // ensure page reload will restore comments tab
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

    document.getElementById('btnPrint').addEventListener('click', function(){
        document.getElementById('requestInformationBody').classList.add('d-none')
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

    const printBtn = document.getElementById('printBtn');
    if(printBtn){
        printBtn.addEventListener('click', function(){
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

    // show spinner when AJAX main submit in progress
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
        // find the composer/form card where new comments should be inserted after
        const formCard = container.querySelector('.composer-card') || container.querySelector('#commentForm') || container.querySelector('form');

        if(!data.parent_id){
            // main comment: insert after form if available, otherwise append to container
            if(formCard && typeof formCard.insertAdjacentHTML === 'function'){
                formCard.insertAdjacentHTML('afterend', data.html);
            } else {
                container.insertAdjacentHTML('beforeend', data.html);
            }
            return;
        }

        // reply: try several targets in order: element with data-comment-id, replies list by id, or append to container
        const parentByData = document.querySelector(`[data-comment-id="${data.parent_id}"]`);
        const repliesList = document.getElementById(`replies-${data.parent_id}`);
        if(repliesList){
            repliesList.insertAdjacentHTML('beforeend', data.html);
            return;
        }
        if(parentByData){
            // prefer an inner replies container if present
            const innerReplies = parentByData.querySelector('.replies-container') || parentByData.querySelector('.replies-list');
            if(innerReplies){
                innerReplies.insertAdjacentHTML('beforeend', data.html);
                return;
            }
            // otherwise append after parent node
            parentByData.insertAdjacentHTML('afterend', data.html);
            return;
        }

        // fallback: append to main container
        container.insertAdjacentHTML('beforeend', data.html);
    }

    // Fallback: build minimal comment HTML when server returns JSON instead of rendered HTML
    function buildFallbackHtml(d){
        const user = d.user_name || d.guest_name || 'Guest';
        const avatar = (user && user.length) ? user.charAt(0).toUpperCase() : 'G';
        let attachHtml = '';
        if(d.attachments && d.attachments.length){
            attachHtml = '<div>' + d.attachments.map(a=>
                `<a href="${a.url}" target="_blank" class="attachment-chip"><i class="bi bi-paperclip"></i> ${a.original_name}</a>`
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
@endsection