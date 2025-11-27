<style>
/* Enhanced Pagination Styles */
.pagination-neo .page-link {
    color: #6c757d;
    background-color: #fff;
    border: 1px solid #e0e6ed;
    margin: 0 2px;
    border-radius: 8px;
    padding: 8px 14px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.pagination-neo .page-link:hover {
    background-color: #f8f9fa;
    border-color: #007bff;
    color: #007bff;
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
}

.pagination-neo .page-item.active .page-link {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-color: #007bff;
    color: white;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
}

.pagination-neo .page-item.disabled .page-link {
    color: #adb5bd;
    background-color: #f8f9fa;
    border-color: #e9ecef;
    cursor: not-allowed;
}

.pagination-info {
    font-size: 0.875rem;
    font-weight: 500;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .pagination-neo .page-link {
        padding: 6px 10px;
        font-size: 0.875rem;
    }

    .d-flex.justify-content-between.align-items-center {
        flex-direction: column;
        gap: 15px;
    }

    .pagination-info {
        order: 2;
    }

    nav {
        order: 1;
    }
}
</style>
