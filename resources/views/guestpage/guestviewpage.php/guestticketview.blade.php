@extends('layouts.app')

@section('title', 'GuestViewTicket')

@section('content')

<style>
    .section-icon {
    width:45px;
    height:45px;
    border-radius:50%;
    background:#e8eeff;
    color:#000099;
    display:flex;
    align-items:center;
    justify-content:center;
}

.section-icon i {
    font-size:22px;
}


.info-box {
    background:#f8f9fa;
    border-radius:14px;
    padding:15px;
    height:100%;
    border:1px solid #f0f0f0;
}


.info-box label {
    display:block;
    font-size:.78rem;
    color:#6c757d;
    margin-bottom:6px;
}


.info-box span,
.info-box p {
    font-size:.95rem;
    font-weight:500;
}

.program-list {
    display:grid;
    grid-template-columns:repeat(2, minmax(0, 1fr));
    gap:8px 18px;
    margin:0;
    padding:0;
    list-style:none;
}

.program-list li {
    position:relative;
    padding-left:16px;
    overflow-wrap:anywhere;
}

.program-list li::before {
    position:absolute;
    left:0;
    top:.45em;
    width:6px;
    height:6px;
    border-radius:50%;
    background:#000099;
    content:'';
}

@media (max-width: 576px) {
    .program-list {
        grid-template-columns:1fr;
    }
}

.summary-item {
    display:flex;
    align-items:center;
    gap:15px;

    padding:15px;
    height:100%;

    border:1px solid #eeeeee;
    border-radius:14px;
    background:#fff;
}


.summary-icon {
    width:55px;
    height:55px;

    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

    flex-shrink:0;

    background:#e8efff;
    color:#000099;
}


.summary-icon.success {
    background:#e9ffe8;
    color:#059900;
}


.summary-icon i {
    font-size:24px;
}


.summary-content {
    min-width:0;
    flex:1;
}


.summary-content h6 {
    font-size:.95rem;
    font-weight:600;
}


.email-text {
    display:block;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}


@media(max-width:768px){

    .summary-item {
        padding:12px;
    }

}

.summary-icon {
    width:55px;
    height:55px;

    border-radius:50%;

    display:flex;
    justify-content:center;
    align-items:center;

    background:#e8eeff;
    color:#000099;

    flex-shrink:0;
}


.summary-icon i {
    font-size:24px;
}



.ticket-number-box {
    padding:15px;
    border-radius:12px;
    background:#f8f9fa;
    border:1px solid #eeeeee;
    width:100%;
}



.ticket-number-box h5 {

    width:250px;

    max-width:250px;

    overflow:hidden;

    text-overflow:ellipsis;

    white-space:nowrap;

}
.ticket-summary-card {
    min-height: 300px;
}
.ticket-id-wrapper {

    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:10px;

}
.ticket-id {

    font-size:1.1rem;
    font-weight:700;

    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;

    max-width:230px;

}
.copy-btn {
    flex-shrink:0;
}
.status-timeline {
    position: relative;
    padding-left: 5px;
}

/* Individual step */
.status-step {
    position: relative;
    display: flex;
    gap: 18px;
    min-height: 70px;
    padding: 5px 12px 5px 0;
}

/* Vertical dashed line */
.status-step:not(:last-child)::after {
    content: "";
    position: absolute;

    left: 17px;
    top: 38px;
    bottom: -5px;

    border-left: 2px dashed #d1d5db;
}

/* Icon */
.status-icon {
    position: relative;
    z-index: 2;

    width: 36px;
    height: 36px;

    min-width: 36px;

    border-radius: 50%;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #f1f1f1;
    color: #777;

    font-size: 17px;
}

/* Completed */
.status-step.completed .status-icon {
    background: #4f7df3;
    color: #fff;
}

.status-step.completed::after {
    border-color: #4f7df3;
}

/* Active */
.status-step.active {
    background: #edf4ff;
    border-radius: 10px;
}

.status-step.active .status-icon {
    background: #073b91;
    color: #fff;
}

.status-step.active::after {
    border-color: #4f7df3;
}

/* Content */
.status-content {
    flex: 1;
    padding-top: 1px;
}

.status-content h6 {
    margin: 0 0 2px;
    font-size: 15px;
    font-weight: 500;
    color: #111827;
}

.status-date {
    display: block;
    font-size: 11px;
    color: #777;
    line-height: 1.2;
}

.status-content p {
    margin: 1px 0 0;
    font-size: 12px;
    color: #777;
    line-height: 1.3;
}

.guest-comments .composer-card,
.guest-comments .comment-node,
.guest-comments .reply-node,
.guest-comments .discussion-header {
    border: 1px solid #edf0f3;
    border-radius: 14px;
    background: #fff;
}
.guest-comments {
    min-height: 240px;
    max-height: 415px;
}
.guest-comments .card-body {
    display: flex;
    flex-direction: column;
    min-height: 415px;
    overflow: hidden;
    gap: .75rem;

}
.guest-comments .discussion-header {
    display: flex;
    flex-direction: column;
    gap: .2rem;
    padding: 1rem 1.1rem;
    flex-shrink: 0;
}
.guest-comments .discussion-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #111827;
}
.guest-comments .discussion-subtitle {
    color: #6b7280;
    font-size: .8rem;
}
.guest-comments .thread {
    min-height: 0;
    max-height: 415px;
    overflow-y: auto;
    overflow-x: hidden;
    padding-right: .25rem;
}
.guest-comments.is-composer-open .discussion-header,
.guest-comments.is-composer-open .thread {
    display: none;
}
.guest-comments .new-comment-btn { align-self: flex-start; margin-bottom: .25rem; }
.guest-comments .composer-card { max-height: 0; opacity: 0; overflow: hidden; transform: translateY(-8px); padding: 0; margin: 0; border-width: 0; transition: max-height .3s ease, opacity .2s ease, transform .3s ease, padding .3s ease, margin .3s ease; }
.guest-comments .composer-card.is-open { max-height: 520px; opacity: 1; transform: translateY(0); padding: 1rem; margin-bottom: .25rem; border-width: 1px; }
.guest-comments .composer-title { font-weight: 700; margin-bottom: .75rem; }
.guest-comments .composer-meta { color: #6b7280; font-size: .8rem; margin-bottom: .7rem; }
.guest-comments .composer-form { display: flex; flex-direction: column; gap: .75rem; }
.guest-comments .composer-textarea {
    width: 100%;
    min-height: 110px;
    resize: vertical;
    border: 2px solid #2d2d2d;
    border-radius: 14px;
    padding: .8rem 1rem;
    font-size: 1.08rem;
    line-height: 1.5;
    background: #fff;
    color: #111827;
    box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.05);
}
.guest-comments .composer-textarea::placeholder {
    color: #6b7280;
    opacity: 1;
}
.guest-comments .composer-actions {
    display: flex;
    align-items: flex-end;
    gap: .75rem;
    flex-wrap: wrap;
    width: 100%;
}
.guest-comments .composer-actions .form-control {
    flex: 1 1 260px;
    min-width: 0;
    max-width: 100%;
}
.guest-comments .composer-actions .btn {
    flex-shrink: 0;
    min-width: 110px;
    height: 38px;
}
.guest-comments .comment-node { display: flex; gap: .7rem; padding: .8rem; margin-bottom: .7rem; }
.guest-comments .reply-node {
    display: flex;
    gap: .6rem;
    padding: .75rem .7rem .75rem 1rem;
    margin: .6rem 0 0 2.2rem;
    border-left: 3px solid #dbeafe;
    border-radius: 12px;
    background: #f8fbff;
}
.guest-comments .avatar { width: 34px; height: 34px; min-width: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #e8eeff; color: #000099; font-weight: 700; }
.guest-comments .comment-content { min-width: 0; flex: 1; }
.guest-comments .comment-meta { display: flex; gap: .5rem; flex-wrap: wrap; align-items: baseline; }
.guest-comments .comment-author { font-weight: 700; color: #111827; }
.guest-comments .comment-time { color: #9ca3af; font-size: .75rem;}
.guest-comments .comment-text { color: #374151; font-size: .88rem; line-height: 1.5; margin-top: .2rem; white-space: pre-line; word-break: break-word; }
.guest-comments .reply-label {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    margin-top: .45rem;
    font-size: .72rem;
    font-weight: 700;
    color: #2563eb;
    letter-spacing: .02em;
}
.guest-comments .attachment-chip { display: inline-flex; align-items: center; gap: .3rem; max-width: 100%; margin: .5rem .4rem 0 0; padding: .25rem .5rem; border-radius: 8px; background: #f1f3f5; color: #374151; font-size: .75rem; text-decoration: none; }
.guest-comments .attachment-chip > span { min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.guest-comments .reply-toggle-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    margin-top: .55rem;
    border: 1px solid #dfe3e8;
    border-radius: 10px;
    background: #fff;
    color: #1d4ed8;
    padding: .35rem .7rem;
    font-size: .76rem;
    font-weight: 600;
}
.guest-comments .reply-toggle-btn:hover {
    background: #eff6ff;
    border-color: #bfdbfe;
}
.guest-comments .reply-panel {
    display: none;
    margin-top: .65rem;
}
.guest-comments .comment-node.is-reply-open .reply-panel {
    display: block;
}
.guest-comments .reply-form { display: flex; gap: .5rem; margin-top: .7rem; }
.guest-comments .reply-form .reply-upload-label { display: inline-flex; align-items: center; gap: .35rem; flex: 0 0 auto; min-height: 40px; padding: .35rem .65rem; border: 1px solid #dfe3e8; border-radius: 10px; background: #fff; color: #1d4ed8; font-size: .75rem; cursor: pointer; }
.guest-comments .reply-form .reply-upload-label:hover { background: #eff6ff; border-color: #bfdbfe; }
.guest-comments .reply-form input[type="file"] { display: none; }
.guest-comments .reply-form textarea { flex: 1; min-height: 55px; border: 1px solid #dfe3e8; border-radius: 10px; padding: .55rem; }
.guest-comments .reply-form button { align-self: flex-end; }
.guest-comments .reply-list { display: flex; flex-direction: column; gap: .55rem; margin-top: .5rem; }
.guest-comments .empty-state { text-align: center; color: #9ca3af; padding: 1.5rem .5rem; }
.guest-comments .view-all-btn {
    align-self: flex-end;
    margin-top: .25rem;
    border: 1px solid #1d4ed8;
    color: #1d4ed8;
    background: #fff;
    border-radius: 10px;
    padding: .35rem .75rem;
    font-size: .8rem;
    font-weight: 600;
}
.guest-comments .view-all-btn:hover {
    background: #eff6ff;
}
.guest-thread-modal .modal-content {
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    background: #f8fafc;
    box-shadow: 0 24px 50px rgba(15, 23, 42, 0.18);
}
.guest-thread-modal .modal-header {
    padding: 1rem 1.1rem;
    border-bottom: 1px solid #edf0f4;
    background: #fff;
}
.guest-thread-modal .modal-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
}
.guest-thread-modal .btn-close {
    border-radius: 8px;
    background-color: #f3f4f6;
    opacity: 1;
}
.guest-thread-modal .modal-body {
    padding: 1rem;
    background: #f8fafc;
}
.guest-thread-modal .modal-composer {
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    background: #fff;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
}
.guest-thread-modal .thread-list {
    max-height: 65vh;
    overflow-y: auto;
    padding-right: .25rem;
    display: flex;
    flex-direction: column;
    gap: .85rem;
}
.guest-thread-modal .comment-node,
.guest-thread-modal .reply-node {
    display: flex;
    gap: .7rem;
    border: 1px solid #edf0f3;
    border-radius: 16px;
    background: #fff;
    padding: .9rem;
    box-shadow: 0 1px 4px rgba(15, 23, 42, 0.03);
}
.guest-thread-modal .reply-node {
    margin-left: 1.5rem;
    border-left: 3px solid #dbeafe;
    background: #f8fbff;
    padding-left: .85rem;
}
.guest-thread-modal .comment-content {
    width: 100%;
    flex: 1;
    min-width: 0;
}
.guest-thread-modal .avatar {
    width: 34px;
    height: 34px;
    min-width: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e8eeff;
    color: #000099;
    font-weight: 700;
    font-size: .9rem;
}
.guest-thread-modal .reply-label {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    margin-bottom: .25rem;
    font-size: .72rem;
    font-weight: 700;
    color: #2563eb;
    letter-spacing: .02em;
}
.guest-thread-modal .comment-meta {
    margin-bottom: .35rem;
}
.guest-thread-modal .comment-author {
    font-size: .96rem;
}
.guest-thread-modal .comment-time {
    font-size: .72rem;
}
.guest-thread-modal .comment-text {
    font-size: .94rem;
    color: #374151;
    line-height: 1.6;
}
.guest-thread-modal .reply-toggle-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    margin-top: .5rem;
    border: 1px solid #dfe3e8;
    border-radius: 10px;
    background: #fff;
    color: #1d4ed8;
    padding: .35rem .7rem;
    font-size: .76rem;
    font-weight: 600;
}
.guest-thread-modal .reply-panel {
    display: none;
    margin-top: .65rem;
}
.guest-thread-modal .comment-node.is-reply-open .reply-panel {
    display: block;
}
.guest-thread-modal .reply-form {
    display: flex;
    align-items: flex-end;
    gap: .6rem;
    margin-top: .75rem;
}
.guest-thread-modal .reply-form .reply-upload-label {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    flex: 0 0 auto;
    min-height: 46px;
    padding: .35rem .65rem;
    border: 1px solid #dfe3e8;
    border-radius: 12px;
    background: #fff;
    color: #1d4ed8;
    font-size: .75rem;
    cursor: pointer;
}
.guest-thread-modal .reply-form .reply-upload-label:hover { background: #eff6ff; border-color: #bfdbfe; }
.guest-thread-modal .reply-form input[type="file"] { display: none; }
.guest-thread-modal .reply-form textarea {
    flex: 1;
    min-height: 54px;
    border: 1px solid #dfe3e8;
    border-radius: 12px;
    padding: .6rem .75rem;
    background: #fff;
}
.guest-thread-modal .reply-form button {
    border-radius: 12px;
    min-width: 46px;
    height: 46px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #0d6efd;
    color: #0d6efd;
    background: #fff;
}
.guest-thread-modal .reply-list { display: flex; flex-direction: column; gap: .55rem; margin-top: .5rem; }
.guest-thread-modal .composer-form {
    display: flex;
    flex-direction: column;
    gap: .75rem;
}
.guest-thread-modal .composer-textarea {
    width: 100%;
    min-height: 110px;
    resize: vertical;
    border: 1px solid #cfd6de;
    border-radius: 14px;
    padding: .85rem 1rem;
    font-size: 1rem;
    background: #fff;
    color: #111827;
}
.guest-thread-modal .composer-textarea::placeholder {
    color: #6b7280;
}
.guest-thread-modal .composer-actions {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-wrap: wrap;
}
.guest-thread-modal .composer-actions .form-control {
    flex: 1 1 260px;
    min-width: 0;
    max-width: 100%;
    border-radius: 10px;
    border: 1px solid #dfe3e8;
}
.guest-thread-modal .composer-actions .btn {
    min-width: 110px;
    height: 38px;
    border-radius: 10px;
}
/* Shared Comment Action Button */
.guest-comments .card-body > .d-flex:first-child {
    flex-wrap: wrap;
    gap: .6rem;
}

.guest-comments .card-body > .d-flex:first-child > div {
    flex: 1 1 140px;
    min-width: 0;
    display: flex;
}

.thread-btn,
.comment-add-btn {
    flex: 1 1 140px;
    width: auto;
    min-width: 0;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    padding: 0 .75rem;
    border-radius: 12px;
    transition: all .25s ease;
    font-size: .9rem;
    overflow: hidden;
}

.thread-btn-text,
.thread-btn .fw-semibold,
.comment-add-btn .fw-semibold {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}


/* View All Comments Button */
.thread-btn {
    border: 1px solid #e9ecef;
    background: #ffffff;
    color: #212529;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
}

.thread-btn:hover {
    background: #f8f9fa;
    border-color: #0d6efd;
    color: #0d6efd;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(13,110,253,.12);
}


/* Add Comment Button */
.comment-add-btn {
    border: 1px solid #0d6efd;
    background: #ffffff;
    color: #0d6efd;
    box-shadow: 0 2px 8px rgba(13,110,253,.08);
}

.comment-add-btn:hover {
    background: #0d6efd;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(13,110,253,.2);
}


/* Icon Circle */
.thread-btn-icon,
.comment-add-icon {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    flex-shrink: 0;
}


/* View Comments Icon */
.thread-btn-icon {
    background: rgba(13,110,253,.1);
    color: #0d6efd;
}


/* Add Comment Icon */
.comment-add-icon {
    background: rgba(13,110,253,.1);
    color: #0d6efd;
}

.comment-add-btn:hover .comment-add-icon {
    background: rgba(255,255,255,.2);
    color:#fff;
}


/* Text Alignment */
.thread-btn-text {
    text-align: left;
    line-height: 1.2;
}

@media (max-width: 480px) {
    .guest-comments .card-body > .d-flex:first-child {
        flex-direction: column;
    }

    .guest-comments .card-body > .d-flex:first-child > div {
        flex-basis: auto;
    }

    .thread-btn,
    .comment-add-btn {
        width: 100%;
    }


.guest-feedback-modal .modal-content {
    border: 0;
    border-radius: 18px;
    overflow: hidden;
}

.guest-feedback-modal .modal-header {
    border-bottom: 1px solid #e5e7eb;
}

.guest-feedback-modal .feedback-image {
    display: block;
    width: 92px;
    height: 70px;
    object-fit: contain;
    margin: .25rem auto .5rem;
}

.guest-feedback-modal .feedback-intro {
    color: #374151;
    font-size: .88rem;
    text-align: center;
}

.guest-feedback-modal .feedback-question {
    padding: .85rem 0;
    border-bottom: 1px solid #edf0f3;
}

.guest-feedback-modal .feedback-question:last-of-type {
    border-bottom: 0;
}

.guest-feedback-modal .feedback-question label {
    color: #374151;
    font-size: .82rem;
    font-weight: 600;
}

.guest-feedback-modal .rating-options {
    display: flex;
    gap: .25rem;
    margin-top: .4rem;
}

.guest-feedback-modal .rating-options input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.guest-feedback-modal .rating-options label {
    cursor: pointer;
    color: #9ca3af;
    font-size: 1.45rem;
    line-height: 1;
    transition: color .15s ease, transform .15s ease;
}

.guest-feedback-modal .rating-options label:hover,
.guest-feedback-modal .rating-options input:checked + label {
    color: #f59e0b;
    transform: translateY(-1px);
}

.guest-feedback-modal .feedback-comment {
    min-height: 80px;
    resize: vertical;
    border-radius: 10px;
}

@media (max-width: 480px) {
    .guest-feedback-modal .modal-body,
    .guest-feedback-modal .modal-footer {
        padding: 1rem !important;
    }

    .guest-feedback-modal .modal-footer .btn {
        width: 100%;
    }
}
    .guest-comments .card-body > .d-flex:first-child > div {
        width: 100%;
        flex-basis: auto;
    }
}

.thread-btn small {
    font-size: .75rem;
}

.guest-feedback-modal .modal-dialog {
    max-width: 660px;
    max-height: calc(100vh - 2rem);
}

.guest-feedback-modal .modal-content {
    height: calc(100vh - 2rem);
    max-height: calc(100vh - 2rem);
}

.guest-feedback-modal .modal-body {
    min-height: 0;
    max-height: calc(100vh - 12rem);
    overflow-y: auto;
    overscroll-behavior: contain;
}

.guest-feedback-modal .modal-dialog-scrollable .modal-content {
    height: calc(100vh - 2rem);
}

.guest-feedback-modal .modal-dialog-scrollable .modal-body {
    overflow-y: auto;
}

@media (max-width: 575.98px) {
    .guest-feedback-modal .modal-dialog {
        max-height: calc(100vh - 1rem);
        margin: .5rem;
    }

    .guest-feedback-modal .modal-content {
        height: calc(100vh - 1rem);
        max-height: calc(100vh - 1rem);
    }

    .guest-feedback-modal .modal-body {
        max-height: calc(100vh - 9rem);
    }
}


/* Arrow Animation */
.thread-btn .bi-arrow-right-short {
    transition: transform .25s ease;
}

.thread-btn:hover .bi-arrow-right-short {
    transform: translateX(4px);
}


/* Icon Sizes */
.thread-btn-icon i,
.comment-add-icon i {
    font-size: .95rem;
}

.guest-resolution-card {
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    background: #fff;
}

.guest-resolution-card .card-body {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.guest-resolution-card .resolution-summary {
    min-width: 0;
}

.guest-resolution-card .resolution-summary h6 {
    color: #111827;
    font-weight: 700;
}

.guest-resolution-card .resolution-summary p {
    color: #6b7280;
    font-size: .82rem;
    margin: 0;
}

.guest-resolution-card .resolution-view-btn {
    flex-shrink: 0;
    border-radius: 10px;
    white-space: nowrap;
}

.guest-resolution-modal .modal-content {
    border: 0;
    border-radius: 18px;
    overflow: hidden;
}

.guest-resolution-modal .modal-header {
    color: #fff;
    border: 0;
}

.guest-resolution-modal .modal-header .btn-close {
    filter: none;
}

.guest-resolution-modal .modal-body {
    background: #f8fafc;
    padding: 1rem;
}

.guest-resolution-item {
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    background: #fff;
    padding: 1rem;
}

.guest-resolution-item.is-current {
    border: 2px solid #0d6efd;
    background: #f5f9ff;
    box-shadow: 0 6px 18px rgba(13, 110, 253, .12);
}

.guest-resolution-item .current-resolution-badge {
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

.guest-resolution-item + .guest-resolution-item {
    margin-top: .8rem;
}

.guest-resolution-item .resolution-date {
    color: #6b7280;
    font-size: .78rem;
}

.guest-resolution-item .resolution-text {
    color: #374151;
    line-height: 1.6;
    white-space: pre-line;
    word-break: break-word;
}

.guest-resolution-item .resolution-file {
    display: flex;
    align-items: center;
    gap: .55rem;
    padding: .6rem .7rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    color: #1d4ed8;
    background: #f8fbff;
    text-decoration: none;
    font-size: .84rem;
    overflow-wrap: anywhere;
}

.guest-resolution-item .resolution-file:hover {
    background: #eff6ff;
    border-color: #bfdbfe;
}

@media (max-width: 480px) {
    .guest-resolution-card .card-body {
        align-items: stretch;
        flex-direction: column;
    }

    .guest-resolution-card .resolution-view-btn {
        width: 100%;
    }
}

.return-ticket-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 14px;
    padding: 1.25rem;
    box-shadow: 0 4px 15px rgba(0,0,0,.05);
    transition: .25s ease;
}

.return-ticket-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,.08);
}


.return-ticket-icon {
    width: 48px;
    height: 48px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:#fff3cd;
    color:#b58105;
    font-size:1.3rem;
}


.return-ticket-btn {
    min-width:160px;
    height:44px;
    border-radius:10px;
    background:#fff;
    color:#dc3545;
    border:1px solid #dc3545;
    font-weight:600;
    transition:.25s ease;
}

.return-ticket-btn:hover {
    background:#dc3545;
    color:#fff;
    transform:translateY(-2px);
    box-shadow:0 6px 15px rgba(220,53,69,.25);
}

.guest-return-modal .modal-content {
    border: 0;
    border-radius: 18px;
    overflow: hidden;
}

.guest-return-modal .modal-header {
    background: #fff8f0;
    border-bottom: 1px solid #f3dfc5;
}

.guest-return-modal .return-warning {
    display: flex;
    gap: .75rem;
    padding: .85rem;
    border-radius: 12px;
    background: #fff8f0;
    color: #7c4a03;
    font-size: .88rem;
}

.guest-return-modal .form-label {
    font-weight: 600;
    color: #374151;
}

.guest-return-modal textarea,
.guest-return-modal select {
    border-radius: 10px;
    border-color: #dfe3e8;
}

.guest-return-modal .confirm-return-btn {
    background: #dc3545;
    border-color: #dc3545;
    color: #fff;
    border-radius: 10px;
}

@media (max-width: 480px) {
    .return-ticket-card > .d-flex {
        align-items: stretch !important;
        flex-direction: column;
    }

    .return-ticket-btn {
        width: 100%;
    }
}

.satisfied-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 44px;
    padding: 0 1.2rem;
    border-radius: 10px;
    background: #ffffff;
    color: #198754;
    border: 1px solid #198754;
    font-weight: 600;
    font-size: .8rem;
    transition: all .25s ease;
}

.satisfied-btn:hover {
    background: #198754;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(25,135,84,.2);
}

.satisfied-btn i {
    font-size: 1rem;
}

.feedback-card {
    border-radius: 12px;
    border:0;
    box-shadow:0 15px 40px rgba(0,0,0,.15);
}


.feedback-header img {
    width:55px;
    height:55px;
}

.feedback-header h5 {
    font-weight:700;
    margin-top:10px;
}

.feedback-header p {
    font-size:.8rem;
    color:#6c757d;
}


.ticket-reference {

    display:flex;
    align-items:center;
    gap:12px;

    background:#e7f1ff;
    padding:12px;
    border-radius:8px;

    color:#0d6efd;

}

.ticket-reference small {
    display:block;
    font-size:.7rem;
    color:#6c757d;
}

.ticket-reference strong {
    font-size:.9rem;
}


.feedback-section h6 {
    font-size:.85rem;
    margin-bottom:2px;
}

.feedback-section small,
.mini-rating small {

    color:#6c757d;
    font-size:.7rem;

}



/* Stars */

.rating-large,
.rating-small {

    display:flex;
    flex-direction:row-reverse;
    justify-content:flex-end;
    gap:3px;

}


.rating-large input,
.rating-small input {

    display:none;

}


.rating-large label,
.rating-small label {

    cursor:pointer;
    color:#adb5bd;

}


.rating-large label {

    font-size:1.6rem;

}


.rating-small label {

    font-size:.9rem;

}



.rating-large input:checked ~ label,
.rating-large label:hover,
.rating-large label:hover ~ label,

.rating-small input:checked ~ label,
.rating-small label:hover,
.rating-small label:hover ~ label {

    color:#ffc107;

}




.mini-rating {

    padding:10px;
    border:1px solid #eee;
    border-radius:8px;

}


.mini-rating label {

    display:block;
    font-size:.75rem;
    font-weight:600;

}



.feedback-comment {

    min-height:90px;
    resize:none;
    border-radius:10px;

}


.submit-feedback-btn {

    background:#0d6efd;
    color:white;
    border-radius:8px;
    height:42px;
    font-weight:600;

}


.submit-feedback-btn:hover {

    background:#0b5ed7;

}

.feedback-icon {
    width: 150px !important;
    height: 150px !important;
    max-width: none !important;
    object-fit: contain;
    display: block;
    margin: 0 auto 15px;
}

.guest-back-link {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    margin-top: .65rem;
    padding: .5rem .75rem;
    border: 1px solid #cfe0ff;
    border-radius: 10px;
    background: #f5f9ff;
    color: #1d4ed8;
    font-size: .88rem;
    font-weight: 600;
    text-decoration: none;
    transition: background-color .2s ease, border-color .2s ease, color .2s ease;
}

.guest-back-link:hover,
.guest-back-link:focus-visible {
    border-color: #93b4f8;
    background: #eaf2ff;
    color: #1640a0;
}
</style>
<div class=" p-5 ">
    <div class="row">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
            <div>
                <h3>Ticket Details</h3>

                @if(request()->query('source') === 'email')
                    <a href="{{ route('guest.tickets.list') }}" class="guest-back-link">
                        <i class="bi bi-arrow-left" aria-hidden="true"></i>
                        <span>Back to All Tickets</span>
                    </a>
                @endif
            </div>

            @if(!in_array($ticket->ticket_status, ['inprogress', 'review']))
            <div class="align-items-end">
                <div class="card shadow-sm w-100 h-100 guest-resolution-card">
                    <div class="card-body">
                        <div class="resolution-summary">
                            <h6 class="mb-1"><i class="bi bi-check2-square me-2 text-primary"></i>Resolution</h6>
                        </div>
                        <button type="button" class="btn btn-outline-primary resolution-view-btn" data-bs-toggle="modal" data-bs-target="#guestResolutionModal">
                            <i class="bi bi-eye me-1"></i>View details
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    {{-- HEADER --}}
    <div class="row">
        <div class="col-xl-8 col-lg-12 pt-3">

            <div class="card border-0 shadow-sm w-100 h-100">
                <div class="card-body">

                    <div class="row g-3">

                        {{-- REQUESTOR --}}
                        <div class="col-md-4">

                            <div class="summary-item">

                                <div class="summary-icon">
                                    <i class="bi bi-person"></i>
                                </div>


                                <div class="summary-content">

                                    <small class="text-muted">
                                        Requested by
                                    </small>

                                    <h6 class="mb-1 text-truncate"
                                        title="{{ $ticket->requestor_first_name }} {{ $ticket->requestor_last_name }}">
                                        
                                        {{ ucwords($ticket->requestor_first_name) }}
                                        {{ $ticket->requestor_middle_name 
                                            ? Str::upper(Str::substr($ticket->requestor_middle_name,0,1)).'.' 
                                            : '' 
                                        }}
                                        {{ ucwords($ticket->requestor_last_name) }}

                                    </h6>


                                    <small class="text-muted email-text">
                                        <i class="bi bi-envelope me-1"></i>
                                        {{ $ticket->requestor_email }}
                                    </small>

                                </div>

                            </div>

                        </div>



                        {{-- DATE SUBMITTED --}}
                        <div class="col-md-4">

                            <div class="summary-item">

                                <div class="summary-icon">
                                    <i class="bi bi-calendar-event"></i>
                                </div>


                                <div class="summary-content">

                                    <small class="text-muted">
                                        Date Submitted
                                    </small>

                                    <h6 class="mb-1">
                                        {{ $ticket->created_at->format('F d, Y') }}
                                    </h6>

                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $ticket->created_at->format('h:i A') }}
                                    </small>

                                </div>

                            </div>

                        </div>




                        {{-- LAST UPDATED --}}
                        <div class="col-md-4">

                            <div class="summary-item">

                                <div class="summary-icon success">
                                    <i class="bi bi-clock-history"></i>
                                </div>


                                <div class="summary-content">

                                    <small class="text-muted">
                                        Last Updated
                                    </small>

                                    <h6 class="mb-1">
                                        {{ $ticket->updated_at->format('F d, Y') }}
                                    </h6>

                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $ticket->updated_at->format('h:i A') }}
                                    </small>

                                </div>

                            </div>

                        </div>


                    </div>

                </div>
            </div>

        </div>
        <div class="col-xl-4 col-lg-12 mt-3 mt-xl-0 pt-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    {{-- HEADER --}}
                    <div class="d-flex align-items-center mb-3">
                        {{-- TICKET NUMBER + STATUS --}}
                            <div class="ticket-number-box">

                                <div class="d-flex justify-content-between align-items-center mb-2">

                                    <small class="text-muted">
                                        Ticket Number
                                    </small>


                                    @switch($ticket->ticket_status)

                                        @case('review')
                                            <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-2">
                                                <i class="bi bi-eye me-1"></i>
                                                For Review
                                            </span>
                                        @break


                                        @case('inprogress')
                                            <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                                <i class="bi bi-hourglass-split me-1"></i>
                                                In Progress
                                            </span>
                                        @break


                                        @case('resolved')
                                            <span class="badge rounded-pill bg-info-subtle text-info px-3 py-2">
                                                <i class="bi bi-check2-circle me-1"></i>
                                                Resolved
                                            </span>
                                        @break


                                        @case('completed')
                                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                                <i class="bi bi-check-circle-fill me-1"></i>
                                                Completed
                                            </span>
                                        @break


                                        @case('rejected')
                                            <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">
                                                <i class="bi bi-x-circle-fill me-1"></i>
                                                Rejected
                                            </span>
                                        @break


                                        @case('overdue')
                                            <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                                Overdue
                                            </span>
                                        @break


                                        @default
                                            <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                                                <i class="bi bi-question-circle me-1"></i>
                                                Unknown
                                            </span>

                                    @endswitch

                                </div>


                                <div class="ticket-id-wrapper">

                                    <span class="ticket-id">
                                        {{ $ticket->ticket_id }}
                                    </span>


                                    <button 
                                        type="button"
                                        class="btn btn-sm btn-light copy-btn"
                                        onclick="copyTicket('{{ $ticket->ticket_id }}')">

                                        <i class="bi bi-copy"></i>

                                    </button>

                                </div>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Body --}}
    <div class="row pt-3">
        <div class="col-md-8 pt-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    {{-- REQUEST INFORMATION --}}
                    <div class="d-flex align-items-center mb-4">
                        <div class="section-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-0">
                                Request Information
                            </h6>
                            <small class="text-muted">
                                Details and requirements of the request
                            </small>
                        </div>
                    </div>


                    {{-- PURPOSE --}}
                    <div class="info-box mb-3">
                        <label>
                            <i class="bi bi-chat-dots me-2"></i>
                            Purpose of Request
                        </label>

                        <p class="mb-0 text-muted">
                            {{$ticket->purpose_of_request}}
                        </p>
                    </div>


                    {{-- PROGRAM + PRIORITY --}}
                    <div class="row g-3">

                        <div class="col-md-7">
                            <div class="info-box">

                                <label>
                                    <i class="bi bi-briefcase me-2"></i>
                                    Program Requested
                                </label>

                                <ul class="program-list">
                                    @foreach($ticket->program_display_items as $program)
                                        <li>{{ $program }}</li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>


                        <div class="col-md-5">
                            <div class="info-box">

                                <label>
                                    <i class="bi bi-flag me-2"></i>
                                    Priority
                                </label>

                                <span class="badge rounded-pill 
                                    @if($ticket->ticket_priority == 'urgent')
                                        bg-danger-subtle text-danger
                                    @elseif($ticket->ticket_priority == 'high')
                                        bg-warning-subtle text-warning
                                    @elseif($ticket->ticket_priority == 'medium')
                                        bg-primary-subtle text-primary
                                    @else
                                        bg-secondary-subtle text-secondary
                                    @endif
                                ">
                                    {{ucfirst($ticket->ticket_priority)}}
                                </span>

                            </div>
                        </div>

                    </div>



                    {{-- KNOWLEDGE PRODUCT --}}
                    @if($ticket->type_of_knowledge_product !== null)

                    <hr class="my-4">


                    <div class="d-flex align-items-center mb-3">

                        <div class="section-icon">
                            <i class="bi bi-journal-text"></i>
                        </div>

                        <div class="ms-3">
                            <h6 class="fw-bold mb-0">
                                Knowledge Product
                            </h6>
                            <small class="text-muted">
                                Requested learning materials
                            </small>
                        </div>

                    </div>


                    <div class="info-box">

                        <label>
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Knowledge Product Requested
                        </label>


                        @php
                            $knowledgeProducts = json_decode($ticket->type_of_knowledge_product, true) ?? [];
                        @endphp


                        <div class="d-flex flex-wrap gap-2">

                            @foreach($knowledgeProducts as $product)

                                @if($product === 'Others')

                                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                        <i class="bi bi-file-earmark me-1"></i>
                                        {{$ticket->type_of_knowledge_product_others}}
                                    </span>

                                @else

                                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                        <i class="bi bi-file-earmark me-1"></i>
                                        {{$product}}
                                    </span>

                                @endif

                            @endforeach

                        </div>

                    </div>

                    @endif




                    {{-- RESOURCE PERSON --}}
                    @if($ticket->title_of_activity !== null)

                    <hr class="my-4">


                    <div class="d-flex align-items-center mb-3">

                        <div class="section-icon">
                            <i class="bi bi-person-badge"></i>
                        </div>

                        <div class="ms-3">
                            <h6 class="fw-bold mb-0">
                                Resource Person Activity
                            </h6>

                            <small class="text-muted">
                                Activity details
                            </small>
                        </div>

                    </div>



                    <div class="row g-3">


                        {{-- TITLE --}}
                        <div class="col-md-12">

                            <div class="info-box">

                                <label>
                                    <i class="bi bi-card-heading me-2"></i>
                                    Title of Activity
                                </label>

                                <span>
                                    {{$ticket->title_of_activity}}
                                </span>

                            </div>

                        </div>



                        {{-- TYPE --}}
                        <div class="col-md-6">

                            <div class="info-box">

                                <label>
                                    <i class="bi bi-calendar-event me-2"></i>
                                    Type of Activity
                                </label>

                                <span>
                                    {{$ticket->type_of_activity}}
                                </span>

                            </div>

                        </div>



                        {{-- VENUE --}}
                        @if($ticket->venue)

                        <div class="col-md-6">

                            <div class="info-box">

                                <label>
                                    <i class="bi bi-geo-alt me-2"></i>
                                    Venue
                                </label>

                                <span>
                                    {{$ticket->venue}}
                                </span>

                            </div>

                        </div>

                        @endif




                        {{-- PARTICIPANTS --}}
                        @if($ticket->target_participants)

                        <div class="col-md-6">

                            <div class="info-box">

                                <label>
                                    <i class="bi bi-people me-2"></i>
                                    Target Participants
                                </label>

                                <span>
                                    {{$ticket->target_participants}}
                                </span>

                            </div>

                        </div>

                        @endif




                        {{-- DATE --}}
                        @if($ticket->date_of_activity)

                        <div class="col-md-6">

                            <div class="info-box">

                                <label>
                                    <i class="bi bi-calendar-event me-2"></i>
                                    Date of Activity
                                </label>

                                <span>
                                    {{$ticket->date_of_activity}}
                                    @if($ticket->date_of_activity_end)
                                        - {{$ticket->date_of_activity_end}}
                                    @endif
                                </span>

                            </div>

                        </div>

                        @endif


                    </div>

                    @endif



                </div>
            </div>
        </div>
        <div class="col-md-4 pt-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <h5 class="mb-4">Status & Progress</h5>

                    <div class="status-timeline">

                        {{-- REQUEST SUBMITTED --}}
                        <div class="status-step completed"  id="submitted">

                            <div class="status-icon">
                                <i class="bi bi-calendar3"></i>
                            </div>

                            <div class="status-content">

                                <h6>Request Submitted</h6>

                                <small class="status-date">
                                    {{ $ticket->created_at->format('M d, Y • h:i A') }}
                                </small>

                                <p>
                                    Your request has been successfully submitted.
                                </p>

                            </div>

                        </div>


                        {{-- UNDER REVIEW --}}
                        <div class="status-step" id="review">

                            <div class="status-icon">
                                <i class="bi bi-search"></i>
                            </div>

                            <div class="status-content">
                                <h6 class="pt-2">Under Review</h6>
                                @if($ticket->ticket_acknowledged_at === null)
                                <p>Your ticket will be reviewed by the team.</p>
                                @else
                                <p>Your ticket has been reviewed by the team.</p>
                                @endif

                            </div>

                        </div>


                        {{-- IN PROGRESS --}}
                        <div class="status-step" id="inprogress">

                            <div class="status-icon">
                                <i class="bi bi-gear-fill"></i>
                            </div>

                            <div class="status-content">

                                <h6>In Progress</h6>

                                @if($ticket->ticket_acknowledged_at !== null)
                                <small class="status-date">
                                    {{ $ticket->ticket_acknowledged_at?->format('M d, Y • h:i A') ?? '-' }}
                                </small>

                                <p>
                                    Your request is reviewed and processing your request.
                                </p>
                                @else
                                <p>You request will be marked as inprogress once the ticket is ackowledged by the team.</p>
                                @endif



                            </div>

                        </div>


                        {{-- RESOLVED --}}
                        <div class="status-step" id="resolved">

                            <div class="status-icon">
                                <i class="bi bi-question-lg"></i>
                            </div>

                            <div class="status-content">

                                <h6>Resolved</h6>
                                @if($ticket->ticket_resolved_at !== null)
                                <p>
                                    {{$ticket->ticket_resolved_at?->format('M d, Y • h:i A') ?? '-'}}
                                </p>
                                <p>Your request has been resolved</p>

                                @else
                                <p>
                                    Your request will be marked as resolved once the request is fulfilled.
                                </p>
                                @endif
                            </div>

                        </div>


                        {{-- COMPLETED --}}
                        <div class="status-step" id="completed">

                            <div class="status-icon">
                                <i class="bi bi-check2-circle"></i>
                            </div>

                            <div class="status-content">

                                <h6>Completed</h6>
                                @if($ticket->ticket_completed_at !== null)
                                <p>{{$ticket->ticket_completed_at?->format('M d, Y • h:i A')?? '-'}}</p>
                                <p>Your request is completed</p>
                                @else
                                <p>
                                    Your request will be marked as completed once the request is verified as completed.
                                </p>
                                @endif
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <div class="pt-3">
                <div class="card border-0 shadow-sm guest-comments {{ $errors->any() ? 'is-composer-open' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex justify-content-end">
                                <button 
                                    type="button" 
                                    class="btn comment-add-btn"
                                    id="toggleGuestComment"
                                    aria-expanded="{{ $errors->any() ? 'true' : 'false' }}"
                                    aria-controls="guestCommentComposer"
                                >
                                    <span class="comment-add-icon">
                                        <i class="bi bi-plus-lg"></i>
                                    </span>

                                    <span class="fw-semibold">
                                        Add new comment
                                    </span>
                                </button>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn thread-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#guestThreadModal"
                                    aria-label="View all comments and replies"
                                >
                                    <span class="thread-btn-icon">
                                        <i class="bi bi-chat-left-text"></i>
                                    </span>

                                    <span class="thread-btn-text">
                                        <span class="fw-semibold">View all comments</span>
                                    </span>

                                    <i class="bi bi-arrow-right-short fs-4 ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <div class="composer-card {{ $errors->any() ? 'is-open' : '' }}" id="guestCommentComposer">
                            @if($errors->any())
                                <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
                            @endif
                            <form method="POST" enctype="multipart/form-data" action="{{ route('guest.tickets.comments.store', $ticket->ticket_id) }}" class="composer-form">
                                @csrf
                                <textarea class="composer-textarea" name="comment" maxlength="1000" placeholder="Write a comment..." required>{{ old('comment') }}</textarea>
                                <div class="composer-actions">
                                    <input type="file" name="attachments[]" class="form-control form-control-sm" multiple>
                                    <button class="btn btn-primary btn-sm text-nowrap" type="submit"><i class="bi bi-send me-1"></i>Post</button>
                                </div>
                            </form>
                        </div>

                        <div class="discussion-header" aria-label="Discussion">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div class="discussion-title"><i class="bi bi-chat-left-text me-2"></i>Discussion</div>
                                
                            </div>
                            <div class="discussion-subtitle">Posting as {{ trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name) }}</div>
                        </div>

                        <div class="thread">
                        @forelse($ticket->comments as $comment)
                            <div class="comment-node">
                                <div class="avatar">{{ strtoupper(substr($comment->user->name ?? $comment->guest_name ?? 'G', 0, 1)) }}</div>
                                <div class="comment-content">
                                    <div class="comment-meta"><span class="comment-author">{{ $comment->user->name ?? $comment->guest_name }}</span><span class="comment-time ps-2">{{ $comment->created_at->diffForHumans() }}</span></div>
                                    <div class="comment-text">{{ $comment->comment }}</div>
                                    @foreach($comment->attachments as $file)
                                        <a href="{{ Storage::url($file->file_path) }}" download="{{ $file->original_name }}" class="attachment-chip"><i class="bi bi-paperclip"></i><span>{{ $file->original_name }}</span></a>
                                    @endforeach

                                    <button type="button" class="reply-toggle-btn" aria-expanded="false">
                                        <i class="bi bi-reply-fill"></i>
                                        <span>Reply</span>
                                        <span class="reply-count">({{ $comment->replies->count() }})</span>
                                    </button>

                                    <div class="reply-panel">
                                        <form method="POST" enctype="multipart/form-data" action="{{ route('guest.tickets.comments.store', $ticket->ticket_id) }}" class="reply-form">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <label class="reply-upload-label" title="Attach files">
                                                <i class="bi bi-paperclip"></i>
                                                Attach
                                                <input type="file" name="attachments[]" multiple>
                                            </label>
                                            <textarea name="comment" maxlength="1000" placeholder="Write a reply..." required></textarea>
                                            <button class="btn btn-outline-primary btn-sm" type="submit" title="Reply"><i class="bi bi-reply"></i></button>
                                        </form>

                                        @if($comment->replies->isNotEmpty())
                                            <div class="reply-list">
                                                @foreach($comment->replies as $reply)
                                                    <div class="reply-node">
                                                        <div class="avatar">{{ strtoupper(substr($reply->user->name ?? $reply->guest_name ?? 'G', 0, 1)) }}</div>
                                                        <div class="comment-content">
                                                            <div class="reply-label"><i class="bi bi-reply-fill"></i>Reply</div>
                                                            <div class="comment-meta"><span class="comment-author">{{ $reply->user->name ?? $reply->guest_name }}</span><span class="comment-time ps-3">{{ $reply->created_at->diffForHumans() }}</span></div>
                                                            <div class="comment-text">{{ $reply->comment }}</div>
                                                            @foreach($reply->attachments as $file)
                                                                <a href="{{ Storage::url($file->file_path) }}" download="{{ $file->original_name }}" class="attachment-chip"><i class="bi bi-paperclip"></i><span>{{ $file->original_name }}</span></a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state"><i class="bi bi-chat-left-text fs-4"></i><div>No comments yet.</div></div>
                        @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($ticket->resolutions->isNotEmpty())
<div class="modal fade guest-resolution-modal" id="guestResolutionModal" tabindex="-1" aria-labelledby="guestResolutionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-1" id="guestResolutionModalLabel" style="color:black"><i class="bi bi-check2-square me-2" style="color:black"></i>Ticket resolutions</h5>
                    <small style="color:black">Resolution history and supporting attachments</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:black"></button>
            </div>
            <div class="modal-body">
                @php
                    $currentResolutionId = $ticket->resolutions->sortByDesc('created_at')->first()?->id;
                @endphp
                @foreach($ticket->resolutions->sortByDesc('created_at') as $resolution)
                    <article class="guest-resolution-item {{ $resolution->id === $currentResolutionId ? 'is-current' : '' }}">
                        @if($resolution->id === $currentResolutionId)
                        <div class="d-flex justify-content-between p-2">
                            <div class="align-items-center">
                                <div class="current-resolution-badge">Current resolution</div>
                            </div>
                            @if($ticket->ticket_status === 'resolved')
                            <div class="align-items-end">
                                <button 
                                type="button" 
                                class="btn satisfied-btn"
                                id="completeTicketBtn"
                                data-ticket-id={{$ticket->id}}
                                >
                                    <i class="bi bi-check-circle me-2"></i>
                                    Complete Request?
                                </button>                            
                            </div>
                            @endif
                        </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            @php
                                $status = strtolower($resolution->resolution_status ?? 'updated');

                                $badgeClass = match($status) {
                                    'completed' => 'bg-success-subtle text-success',
                                    'resolved'  => 'bg-success-subtle text-success-emphasis',
                                    'rejected'  => 'bg-danger-subtle text-danger',
                                    default     => 'bg-primary-subtle text-primary',
                                };
                            @endphp

                            <span class="badge rounded-pill {{ $badgeClass }}">
                                {{ ucfirst($status) }}
                            </span>                            
                            <span class="resolution-date">{{ ($resolution->resolved_at ?? $resolution->updated_at)->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="resolution-text mb-3">{{ $resolution->resolution_text ?: 'No resolution details were provided.' }}</div>
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
            @if($ticket->ticket_status === 'resolved')
            <div class="p-3">
                <div class="return-ticket-card">
                    <div class="d-flex align-items-center justify-content-between gap-3">

                        <div class="d-flex align-items-center">
                            <div class="return-ticket-icon">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </div>

                            <div class="ms-3">
                                <h5 class="mb-1 fw-semibold">
                                    Not satisfied with your request?
                                </h5>

                                <p class="mb-0 text-muted small">
                                    You may return this ticket for further clarification or additional assistance.
                                </p>
                            </div>
                        </div>

                        <button type="button" class="btn return-ticket-btn" data-bs-toggle="modal" data-bs-target="#guestReturnModal">
                            <i class="bi bi-reply me-1"></i>
                            Return Ticket
                        </button>

                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

@if($ticket->ticket_status === 'resolved')
<div class="modal fade guest-return-modal" id="guestReturnModal" tabindex="-1" aria-labelledby="guestReturnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-1" id="guestReturnModalLabel"><i class="bi bi-arrow-counterclockwise me-2 text-danger"></i>Return ticket</h5>
                    <small class="text-muted">Request additional assistance from the team</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('guest.tickets.return', $ticket->ticket_id) }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="return-warning mb-4">
                        <i class="bi bi-info-circle-fill"></i>
                        <span>Are you sure you want to return this ticket? It will be sent back to the team for follow-up and changed to In Progress.</span>
                    </div>

                    <div class="mb-3">
                        <label for="return_reason" class="form-label">Why are you returning this ticket?</label>
                        <textarea id="return_reason" name="return_reason" class="form-control" rows="4" maxlength="2000" placeholder="Tell the team what needs clarification or additional assistance." required></textarea>
                    </div>

                    <div>
                        <label for="return_urgency" class="form-label">Urgency</label>
                        <select id="return_urgency" name="urgency" class="form-select" required>
                            <option value="medium" selected>Medium</option>
                            <option value="low">Low</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn confirm-return-btn"><i class="bi bi-check2-circle me-1"></i>Yes, return ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if(in_array($ticket->ticket_status, ['resolved', 'completed'], true) && !$ticket->feedback)
<div class="modal fade guest-feedback-modal" id="guestFeedbackModal" tabindex="-1" aria-hidden="true" data-auto-show="{{ session('open_feedback') ? 'true' : 'false' }}" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content feedback-card">

            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-semibold">
                    Satisfaction Feedback
                </h6>

            </div>


            <form id="guestFeedbackForm" method="POST" action="{{ route('guest.tickets.feedback', $ticket->ticket_id) }}" novalidate>
                @csrf

                <div class="modal-body px-4">


                    {{-- Header --}}
                    <div class="text-center feedback-header">

                        <img 
                            src="{{ asset('images/attachments/Survey Pic.png') }}"
                            class="feedback-icon d-block mx-auto"
                            alt="Feedback"
                        >

                        <h5>
                            We'd love your feedback!
                        </h5>

                        <p>
                            Your ticket has been resolved. Please take a few seconds to rate your experience.
                        </p>

                    </div>


                    {{-- Ticket --}}
                    <div class="ticket-reference">
                        <i class="bi bi-info-circle"></i>

                        <div>
                            <small>Ticket Number</small>
                            <strong>
                                {{ $ticket->ticket_id }}
                            </strong>
                        </div>
                    </div>


                    <hr>


                    {{-- Overall --}}
                    <div class="feedback-section">

                        <h6>
                            Overall Satisfaction
                        </h6>

                        <small>
                            How satisfied are you with the resolution of your request?
                        </small>


                        <div class="rating-large">
                            @for($rating = 1; $rating <= 5; $rating++)
                                <input 
                                    type="radio"
                                    id="overall_{{ $rating }}"
                                    name="overall_satisfaction"
                                    value="{{ $rating }}"
                                    required
                                >

                                <label for="overall_{{ $rating }}">
                                    ★
                                </label>
                            @endfor
                        </div>

                    </div>


                    {{-- Other ratings --}}
                    <div class="row g-3 mt-2">

                    @php
                        $feedbackQuestions = [
                            'timeliness' => 'Timeliness',
                            'professionalism' => 'Professionalism',
                            'quality_of_resolution' => 'Quality of Resolution',
                            'ease_of_process' => 'Ease of Process',
                            'communication' => 'Communication',
                        ];
                    @endphp


                    @foreach($feedbackQuestions as $field=>$question)

                        <div class="col-6">

                            <div class="mini-rating">

                                <label>
                                    {{ $question }}
                                </label>

                                <small>
                                    Rate your experience
                                </small>


                                <div class="rating-small">

                                @for($rating=1;$rating<=5;$rating++)

                                    <input 
                                        type="radio"
                                        id="{{ $field }}_{{ $rating }}"
                                        name="{{ $field }}"
                                        value="{{ $rating }}"
                                        required
                                    >

                                    <label for="{{ $field }}_{{ $rating }}">
                                        ★
                                    </label>

                                @endfor

                                </div>

                            </div>

                        </div>

                    @endforeach

                    </div>


                    {{-- Comment --}}
                    <div class="mt-3">

                        <label class="fw-semibold small">
                            Additional Comments 
                            <span class="text-muted">
                                (Optional)
                            </span>
                        </label>


                        <textarea
                            class="form-control feedback-comment"
                            name="additional_comments"
                            maxlength="2000"
                            placeholder="Share any additional feedback or suggestions..."
                        ></textarea>

                    </div>


                </div>


                <div class="modal-footer border-0 px-4 pb-4">

                    <button 
                        type="submit"
                        class="btn submit-feedback-btn w-100"
                    >
                        <i class="bi bi-send me-1"></i>
                        Submit Feedback & View Details
                    </button>

                </div>


            </form>

        </div>
    </div>
</div>
@endif

<div class="modal fade guest-thread-modal" id="guestThreadModal" tabindex="-1" aria-labelledby="guestThreadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="guestThreadModalLabel"><i class="bi bi-chat-left-text me-2"></i>Discussion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-composer">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('guest.tickets.comments.store', $ticket->ticket_id) }}" class="composer-form">
                        @csrf
                        <textarea class="composer-textarea" name="comment" maxlength="1000" placeholder="Write a comment..." required>{{ old('comment') }}</textarea>
                        <div class="composer-actions">
                            <input type="file" name="attachments[]" class="form-control form-control-sm" multiple>
                            <button class="btn btn-primary btn-sm text-nowrap" type="submit"><i class="bi bi-send me-1"></i>Post</button>
                        </div>
                    </form>
                </div>

                <div class="thread-list">
                    @forelse($ticket->comments as $comment)
                        <div class="comment-node">
                            <div class="avatar">{{ strtoupper(substr($comment->user->name ?? $comment->guest_name ?? 'G', 0, 1)) }}</div>
                            <div class="comment-content">
                                <div class="comment-meta"><span class="comment-author">{{ $comment->user->name ?? $comment->guest_name }}</span><span class="comment-time ps-3">{{ $comment->created_at->diffForHumans() }}</span></div>
                                <div class="comment-text">{{ $comment->comment }}</div>
                                @foreach($comment->attachments as $file)
                                    <a href="{{ Storage::url($file->file_path) }}" download="{{ $file->original_name }}" class="attachment-chip"><i class="bi bi-paperclip"></i><span>{{ $file->original_name }}</span></a>
                                @endforeach

                                <button type="button" class="reply-toggle-btn" aria-expanded="false">
                                    <i class="bi bi-reply-fill"></i>
                                    <span>Reply</span>
                                    <span class="reply-count">({{ $comment->replies->count() }})</span>
                                </button>

                                <div class="reply-panel">
                                    <form method="POST" enctype="multipart/form-data" action="{{ route('guest.tickets.comments.store', $ticket->ticket_id) }}" class="reply-form">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <label class="reply-upload-label" title="Attach files">
                                            <i class="bi bi-paperclip"></i>
                                            Attach
                                            <input type="file" name="attachments[]" multiple>
                                        </label>
                                        <textarea name="comment" maxlength="1000" placeholder="Write a reply..." required></textarea>
                                        <button class="btn btn-outline-primary btn-sm" type="submit" title="Reply"><i class="bi bi-reply"></i></button>
                                    </form>

                                    @if($comment->replies->isNotEmpty())
                                        <div class="reply-list">
                                            @foreach($comment->replies as $reply)
                                            <div class="reply-node">
                                                <div class="avatar">{{ strtoupper(substr($reply->user->name ?? $reply->guest_name ?? 'G', 0, 1)) }}</div>
                                                <div class="comment-content">
                                                    <div class="reply-label"><i class="bi bi-reply-fill"></i>Reply</div>
                                                    <div class="comment-meta"><span class="comment-author">{{ $reply->user->name ?? $reply->guest_name }}</span><span class="comment-time ps-3">{{ $reply->created_at->diffForHumans() }}</span></div>
                                                    <div class="comment-text">{{ $reply->comment }}</div>
                                                    @foreach($reply->attachments as $file)
                                                        <a href="{{ Storage::url($file->file_path) }}" download="{{ $file->original_name }}" class="attachment-chip"><i class="bi bi-paperclip"></i><span>{{ $file->original_name }}</span></a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state"><i class="bi bi-chat-left-text fs-4"></i><div>No comments yet.</div></div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const guestComments = document.querySelector('.guest-comments');
    const guestCommentToggle = document.getElementById('toggleGuestComment');
    const guestCommentComposer = document.getElementById('guestCommentComposer');
    const guestThreadModal = document.getElementById('guestThreadModal');
    const guestResolutionModal = document.getElementById('guestResolutionModal');
    const guestFeedbackModal = document.getElementById('guestFeedbackModal');
    const viewAllButton = document.querySelector('.thread-btn');

    function showGuestFeedback() {
        if (!guestFeedbackModal || !window.bootstrap) return;
        bootstrap.Modal.getOrCreateInstance(guestFeedbackModal).show();
    }

    function wasFeedbackDismissed() {
        try {
            return sessionStorage.getItem('guestFeedbackDismissed') === 'true';
        } catch (error) {
            return false;
        }
    }

    function setAddCommentState(isOpen) {
        if (!guestCommentToggle || !guestCommentComposer || !guestComments) return;

        guestCommentComposer.classList.toggle('is-open', isOpen);
        guestComments.classList.toggle('is-composer-open', isOpen);
        guestCommentToggle.setAttribute('aria-expanded', String(isOpen));

        const addIcon = guestCommentToggle.querySelector('.comment-add-icon i');
        const addText = guestCommentToggle.querySelector('.fw-semibold');

        if (addIcon) {
            addIcon.className = isOpen ? 'bi bi-dash-lg' : 'bi bi-plus-lg';
        }

        if (addText) {
            addText.textContent = isOpen ? 'Show Comment' : 'Add new comment';
        }
    }

    function setViewAllState(isOpen) {
        if (!viewAllButton) return;

        const viewIcon = viewAllButton.querySelector('.thread-btn-icon i');
        const viewText = viewAllButton.querySelector('.thread-btn-text .fw-semibold');

        if (viewIcon) {
            viewIcon.className = isOpen ? 'bi bi-x-lg' : 'bi bi-chat-left-text';
        }

        if (viewText) {
            viewText.textContent = isOpen ? 'Hide comments' : 'View all comments';
        }
    }

    document.querySelectorAll('.reply-toggle-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const commentNode = this.closest('.comment-node');
            if (!commentNode) return;

            const isOpen = !commentNode.classList.contains('is-reply-open');
            commentNode.classList.toggle('is-reply-open', isOpen);
            this.setAttribute('aria-expanded', String(isOpen));

            const label = this.querySelector('span');
            if (label) {
                label.textContent = isOpen ? 'Hide reply' : 'Reply';
            }

            const icon = this.querySelector('i');
            if (icon) {
                icon.className = isOpen ? 'bi bi-dash-lg' : 'bi bi-reply-fill';
            }
        });
    });

    if (guestCommentToggle && guestCommentComposer && guestComments) {
        guestCommentToggle.addEventListener('click', function () {
            const isOpen = !guestCommentComposer.classList.contains('is-open');
            setAddCommentState(isOpen);
        });
    }

    if (viewAllButton && guestThreadModal) {
        viewAllButton.addEventListener('click', function () {
            const isOpen = true;
            setViewAllState(isOpen);
        });

        guestThreadModal.addEventListener('hidden.bs.modal', function () {
            setViewAllState(false);
        });
    }

    if (guestThreadModal) {
        guestThreadModal.addEventListener('shown.bs.modal', function () {
            setViewAllState(true);
        });
    }

    if (guestResolutionModal && guestFeedbackModal) {
        guestResolutionModal.addEventListener('hidden.bs.modal', function () {
            window.setTimeout(showGuestFeedback, 150);
        });
    }

    if (guestFeedbackModal && guestFeedbackModal.dataset.autoShow === 'true') {
        window.setTimeout(showGuestFeedback, 350);
    }

    if (guestFeedbackModal) {
        guestFeedbackModal.addEventListener('hidden.bs.modal', function () {
            try {
                sessionStorage.setItem('guestFeedbackDismissed', 'true');
            } catch (error) {
            }
        });
    }

    const guestFeedbackForm = document.getElementById('guestFeedbackForm');
    if (guestFeedbackForm) {
        guestFeedbackForm.addEventListener('submit', function (event) {
            const fields = [
                ['overall_satisfaction', 'Overall Satisfaction'],
                ['timeliness', 'Timeliness'],
                ['professionalism', 'Professionalism'],
                ['quality_of_resolution', 'Quality of Resolution'],
                ['ease_of_process', 'Ease of Process'],
                ['communication', 'Communication'],
            ];
            const unanswered = fields
                .filter(function ([field]) {
                    return !guestFeedbackForm.querySelector(`input[name="${field}"]:checked`);
                })
                .map(function ([, label]) { return label; });

            if (!unanswered.length) return;

            event.preventDefault();
            const message = 'Please answer: ' + unanswered.join(', ') + '.';
            if (window.Swal && Swal.fire) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete feedback',
                    text: message,
                    confirmButtonColor: '#0d6efd',
                });
            } else {
                window.alert(message);
            }
        });
    }

    if (@json(session('feedback_submitted', false))) {
        const feedbackSuccess = function () {
            if (window.Swal && Swal.fire) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thank you!',
                    text: 'Thank you for taking the time to fill out the feedback form.',
                    confirmButtonText: 'Continue',
                    confirmButtonColor: '#0d6efd',
                });
            } else {
                window.alert('Thank you for taking the time to fill out the feedback form.');
            }
        };

        if (window.Swal && Swal.fire) {
            feedbackSuccess();
        } else {
            window.setTimeout(feedbackSuccess, 300);
        }
    }

    function copyTicket(ticketId) {
        navigator.clipboard.writeText(ticketId)
            .then(() => {

                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Ticket number copied to clipboard.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });

            })
            .catch(() => {

                Swal.fire({
                    icon: 'error',
                    title: 'Copy failed',
                    text: 'Unable to copy the ticket number.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });

            });
    }

    switch(@json($ticket->ticket_status)){
        case 'review': 
            document.getElementById('review').classList.remove('active','completed');
            document.getElementById('inprogress').classList.remove('active' , 'completed');
            document.getElementById('resolved').classList.remove('active', 'completed');
            document.getElementById('completed').classList.remove('active', 'completed');

            document.getElementById('review').classList.add('active');


            
        break;

        case 'inprogress':
            document.getElementById('review').classList.remove('active','completed');
            document.getElementById('inprogress').classList.remove('active' , 'completed');
            document.getElementById('resolved').classList.remove('active', 'completed');
            document.getElementById('completed').classList.remove('active', 'completed');

            document.getElementById('review').classList.add('completed');
            document.getElementById('inprogress').classList.add('active');
        break;

        case 'resolved':
            document.getElementById('review').classList.remove('active','completed');
            document.getElementById('inprogress').classList.remove('active' , 'completed');
            document.getElementById('resolved').classList.remove('active', 'completed');
            document.getElementById('completed').classList.remove('active', 'completed');

            document.getElementById('review').classList.add('completed');
            document.getElementById('inprogress').classList.add('completed');
            document.getElementById('resolved').classList.add('active');
        break;

        case 'completed':
            document.getElementById('review').classList.remove('active','completed');
            document.getElementById('inprogress').classList.remove('active' , 'completed');
            document.getElementById('resolved').classList.remove('active', 'completed');
            document.getElementById('completed').classList.remove('active', 'completed');

            document.getElementById('review').classList.add('completed');
            document.getElementById('inprogress').classList.add('completed');
            document.getElementById('resolved').classList.add('completed');
            document.getElementById('completed').classList.add('active');
        break;


        
        
    }

    document.getElementById('completeTicketBtn').addEventListener('click', function(){
        const ticketId= this.dataset.ticketId;

        Swal.fire({
            title: 'Complete Request?',
            text: 'Please confirm that you have reviewed and verified the provided resolution. Once completed, this ticket will be closed.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Complete Ticket',
            cancelButtonText: 'Review Again',
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if(result.isConfirmed){
                fetch(`/tickets/${ticketId}/complete`,{
                    method: 'POST',
                    headers:{
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json()).then(data=>{
                    if(data.success){
                        Swal.fire({
                            title: 'Request Completed!',
                            text: 'the ticket has been successfully marked as completed.',
                            icon: 'success',
                            confirmButtonColor: '#198754'
                        }).then(()=>{
                            location.reload();
                        });
                    }
                }).catch(()=>{
                    Swal.fire(
                        'Error',
                        'Unable to complete the ticket. please try again.',
                        'error'
                    );
                })
            }
        })
    });
    
</script>
@include('partials.govph_footer')
@endsection