<!DOCTYPE html>
<html lang="<?php echo Language::getCurrentLanguage(); ?>" dir="<?php echo Language::getDirection(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'FlowTask - Manajemen Proyek'; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Error Logging for Debugging */
        .debug-info {
            position: fixed;
            top: 10px;
            right: 10px;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
            z-index: 9999;
            max-width: 300px;
        }
        
        /* Simple Two-Color Theme: White and Sky Blue */
        :root {
            --primary-color: #0ea5e9; /* Sky Blue */
            --secondary-color: #ffffff; /* White */
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --bg-light: #f8fafc;
        }
        
        /* Dark Mode Variables */
        body.dark-mode {
            --secondary-color: #334155;
            --text-dark: #e2e8f0;
            --text-muted: #94a3b8;
            --border-color: #475569;
            --bg-light: #475569;
        }
        
        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        /* PRINT GLOBAL OVERRIDES */
        @media print {
            html,
            body,
            .main-content,
            .content-wrapper {
                background-color: #ffffff !important;
                color: #000000 !important;
            }
        }
        
        /* Sidebar */
        .sidebar {
            background-color: var(--primary-color);
            color: white;
            width: 250px;
            height: 100vh; /* Fix height to viewport to ensure scroll works */
            max-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-x: hidden;
            overflow-y: auto; /* Allow sidebar to scroll vertically when content overflows */
            display: flex;
            flex-direction: column;
            padding-bottom: 1rem;
            /* Better looking scrollbars */
            scrollbar-width: thin; /* Firefox */
            scrollbar-color: rgba(255, 255, 255, 0.25) transparent; /* Firefox */
        }

        /* WebKit scrollbar styling for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.4));
            border-radius: 8px;
            border: 2px solid transparent;
            background-clip: padding-box;
            transition: all 0.3s ease;
        }

        .sidebar:hover::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.5));
            transform: scale(1.05);
        }

        .sidebar::-webkit-scrollbar-thumb:active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.6));
        }
        
        /* Dark mode sidebar scrollbar */
        body.dark-mode .sidebar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.7), rgba(14, 165, 233, 0.9));
            box-shadow: 0 0 6px rgba(14, 165, 233, 0.4);
        }
        
        body.dark-mode .sidebar:hover::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.8), rgba(14, 165, 233, 1));
            box-shadow: 0 0 10px rgba(14, 165, 233, 0.6);
            transform: scale(1.05);
        }
        
        body.dark-mode .sidebar::-webkit-scrollbar-thumb:active {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.9), rgba(14, 165, 233, 1));
            box-shadow: 0 0 12px rgba(14, 165, 233, 0.8);
        }
        
        .sidebar.collapsed {
            width: 80px;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        
        .sidebar.collapsed .nav-link {
            padding: 0.75rem 1rem;
            margin: 0.25rem 0.5rem;
            text-align: center;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }
        
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }
        
        .sidebar .nav-link span {
            transition: opacity 0.3s ease;
        }
        
        .sidebar.collapsed .nav-link span {
            opacity: 0;
            display: none;
        }
        
        .sidebar.collapsed .p-3 h4 {
            opacity: 0;
            display: none;
        }
        
        .sidebar.collapsed #sidebar-logo {
            display: block !important;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 0;
            transition: all 0.3s ease;
            min-height: 100vh;
            background-color: var(--bg-light);
        }
        
        .main-content.expanded {
            margin-left: 80px;
        }
        
        .content-wrapper {
            padding: 2rem;
        }
        
        /* Navbar */
        .navbar {
            background-color: var(--secondary-color);
            border-bottom: 2px solid var(--primary-color);
            padding: 1.25rem 2rem;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.1);
            min-height: 80px;
            position: relative;
            z-index: 1001;
        }
        
        /* Dropdown menu z-index */
        .navbar .nav-item.dropdown {
            position: static;
        }
        
        .navbar .dropdown-toggle {
            position: relative;
            z-index: 1;
            cursor: pointer;
            pointer-events: auto !important;
        }
        
        .navbar .dropdown-menu {
            z-index: 1050 !important;
            position: absolute;
            pointer-events: auto;
            display: none;
        }
        
        .navbar .dropdown-menu.show {
            display: block;
        }
        
        /* Ensure navbar container doesn't block clicks */
        .navbar .navbar-nav {
            position: relative;
            z-index: 1;
        }
        
        /* Avatar Styles */
        .avatar-sm {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            font-size: 14px;
        }
        
        .avatar-sm img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e9ecef;
        }
        
        .navbar .btn-outline-secondary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .navbar .btn-outline-secondary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }
        
        .navbar .nav-link {
            color: var(--text-dark);
            font-weight: 500;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            pointer-events: auto;
            cursor: pointer;
        }
        
        .navbar .nav-link:hover {
            background-color: rgba(14, 165, 233, 0.1);
            color: var(--primary-color);
        }
        
        .navbar .dropdown-menu {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0;
            z-index: 1050 !important;
        }
        
        .navbar .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
        }
        
        .navbar .dropdown-item:hover {
            background-color: rgba(14, 165, 233, 0.1);
            color: var(--primary-color);
        }
        
        /* Cards */
        .card {
            background-color: var(--secondary-color);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
        }
        
        .card-header {
            background-color: var(--bg-light);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem;
            border-radius: 12px 12px 0 0;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
            z-index: 1;
            pointer-events: auto;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background-color: #0284c7;
            border-color: #0284c7;
            transform: translateY(-1px);
            cursor: pointer;
        }
        
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background-color: transparent;
            border-radius: 8px;
            transition: all 0.2s ease;
            position: relative;
            z-index: 1;
            pointer-events: auto;
            cursor: pointer;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            cursor: pointer;
        }
        
        .btn-outline-secondary {
            border-color: var(--text-muted);
            color: var(--text-muted);
            background-color: transparent;
            position: relative;
            z-index: 1;
        }
        
        .btn-outline-secondary:hover {
            background-color: var(--text-muted);
            border-color: var(--text-muted);
            color: white;
        }
        
        .btn-outline-success {
            border-color: #10b981;
            color: #10b981;
            position: relative;
            z-index: 1;
        }
        
        .btn-outline-success:hover {
            background-color: #10b981;
            border-color: #10b981;
            color: white;
        }
        
        .btn-outline-danger {
            border-color: #ef4444;
            color: #ef4444;
            position: relative;
            z-index: 1;
        }
        
        .btn-outline-danger:hover {
            background-color: #ef4444;
            border-color: #ef4444;
            color: white;
        }
        
        .btn-outline-info {
            border-color: var(--primary-color);
            color: var(--primary-color);
            position: relative;
            z-index: 1;
        }
        
        .btn-outline-info:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        /* Removed SweetAlert custom theme to use Bootstrap modal only */
        
        /* Stats Cards */
        .stat-card {
            background-color: var(--secondary-color);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1;
        }
        
        /* Profile Statistics Items */
        .stat-item {
            background: var(--bg-light) !important;
            transition: all 0.2s ease;
        }
        
        .stat-item:hover {
            background: rgba(14, 165, 233, 0.05) !important;
            transform: translateY(-1px);
        }
        
        /* Tables */
        .table {
            background-color: var(--secondary-color);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table th {
            background-color: var(--bg-light);
            border-top: none;
            font-weight: 600;
            color: var(--text-dark);
            padding: 1rem;
        }
        
        .table td {
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            vertical-align: middle;
        }
        
        .table tbody tr:hover {
            background-color: rgba(14, 165, 233, 0.05);
        }
        
        /* List Groups */
        .list-group-item {
            border: none;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem;
            background-color: var(--secondary-color);
        }
        
        .list-group-item:hover {
            background-color: rgba(14, 165, 233, 0.05);
        }
        
        /* Avatars */
        .avatar-sm {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .avatar-md {
            width: 48px;
            height: 48px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .avatar-xs {
            width: 24px;
            height: 24px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Badges */
        .badge {
            border-radius: 6px;
            font-weight: 500;
        }
        
        .badge.bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        /* Form Controls */
        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem;
            color: var(--text-dark); /* Ensure input/textarea text is visible in light mode */
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.25);
        }

        /* Placeholder colors (light mode) */
        input::placeholder,
        textarea::placeholder {
            color: var(--text-muted);
            opacity: 1;
        }
        
        /* Progress Bars */
        .progress {
            background-color: var(--bg-light);
            border-radius: 4px;
        }
        
        .progress-bar {
            background-color: var(--primary-color);
        }
        
        /* Alerts */
        .alert {
            border: none;
            border-radius: 8px;
        }
        
        .alert-primary {
            background-color: rgba(14, 165, 233, 0.1);
            color: var(--primary-color);
        }
        
        /* Dashboard Header */
        .dashboard-header {
            background: none;
            padding: 2rem 0;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }
        
        /* Page Headers */
        .page-header {
            background: none;
            padding: 2rem 0;
            margin: 0 0 2rem 0;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .page-header h1 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 2.5rem;
        }
        
        .page-header p {
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-bottom: 0;
        }
        
        .page-header .btn {
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.2);
        }
        
        /* Dark Mode */
        body.dark-mode {
            background-color: #1e293b;
            color: #e2e8f0;
        }
        
        body.dark-mode .main-content {
            background-color: #1e293b;
        }
        
        body.dark-mode .content-wrapper {
            background-color: #1e293b;
        }
        
        body.dark-mode .sidebar {
            background-color: #0f172a;
        }
        
        body.dark-mode .main-content {
            background-color: #1e293b;
        }
        
        body.dark-mode .card {
            background-color: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }
        
        body.dark-mode .card-header {
            background-color: #475569;
            border-color: #64748b;
            color: #e2e8f0;
        }
        
        body.dark-mode .page-header {
            background: none;
            border-bottom-color: var(--primary-color);
        }
        
        body.dark-mode .dashboard-header {
            background: none;
            border-bottom-color: var(--border-color);
        }
        
        body.dark-mode .page-header h1 {
            color: #e2e8f0;
        }
        
        body.dark-mode .page-header p {
            color: #94a3b8;
        }
        
        body.dark-mode .navbar {
            background-color: #334155;
            border-color: #475569;
        }
        
        body.dark-mode .navbar .btn-outline-secondary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        body.dark-mode .navbar .nav-link {
            color: #e2e8f0;
        }
        
        body.dark-mode .navbar .dropdown-menu {
            background-color: #334155;
            border-color: #475569;
        }
        
        body.dark-mode .navbar .dropdown-item {
            color: #e2e8f0;
        }
        
        body.dark-mode .navbar .dropdown-item:hover {
            background-color: rgba(14, 165, 233, 0.2);
            color: var(--primary-color);
        }
        
        body.dark-mode .table {
            /* Force Bootstrap table variables for dark mode */
            --bs-table-bg: #334155;
            --bs-table-striped-bg: #2b3a4a;
            --bs-table-hover-bg: #3a4a5c;
            --bs-table-border-color: #475569;
            color: #e2e8f0;
            background-color: #334155;
        }
        
        body.dark-mode .table th {
            background-color: #475569;
            color: #e2e8f0;
            border-color: #64748b;
        }
        
        body.dark-mode .table td {
            border-color: #64748b;
            color: #e2e8f0;
        }
        
        /* Ensure tbody rows use dark background (not transparent) */
        body.dark-mode .table tbody tr {
            background-color: #334155;
        }

        /* Ensure table cells inherit dark background */
        body.dark-mode .table > :not(caption) > * > * {
            background-color: #334155;
            box-shadow: inset 0 0 0 9999px rgba(0,0,0,0); /* neutralize Bootstrap cell overlay */
        }
        
        body.dark-mode .table tbody tr:hover {
            background-color: rgba(14, 165, 233, 0.1);
        }
        
        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: #475569;
            border-color: #64748b;
            color: #e2e8f0;
        }
        
        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            border-color: var(--primary-color);
            background-color: #475569;
            box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.25);
        }
        
        body.dark-mode .text-dark {
            color: #e2e8f0 !important;
        }
        
        body.dark-mode .text-muted {
            color: #94a3b8 !important;
        }
        
        body.dark-mode .bg-light {
            background-color: #475569 !important;
        }
        
        body.dark-mode .list-group-item {
            background-color: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }
        
        body.dark-mode .list-group-item:hover {
            background-color: rgba(14, 165, 233, 0.1);
        }
        
        body.dark-mode .stat-card {
            background-color: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }
        
        /* Dark mode stat items */
        body.dark-mode .stat-item {
            background: #475569 !important;
            border-color: #64748b !important;
        }
        
        body.dark-mode .stat-item:hover {
            background: rgba(14, 165, 233, 0.2) !important;
        }
        
        body.dark-mode .badge.bg-light {
            background-color: #475569 !important;
            color: #e2e8f0 !important;
        }
        
        body.dark-mode .progress {
            background-color: #475569;
        }
        
        body.dark-mode .alert {
            background-color: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }
        
        body.dark-mode .alert-primary {
            background-color: rgba(14, 165, 233, 0.2);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* Helper text visibility in dark mode */
        body.dark-mode .form-text {
            color: #94a3b8 !important;
        }
        
        body.dark-mode .dropdown-menu {
            background-color: #334155;
            border-color: #475569;
        }
        
        body.dark-mode .dropdown-item {
            color: #e2e8f0;
        }
        
        body.dark-mode .dropdown-item:hover {
            background-color: rgba(14, 165, 233, 0.2);
            color: var(--primary-color);
        }
        
        /* Additional dark mode fixes for white backgrounds */
        body.dark-mode .bg-white {
            background-color: #334155 !important;
        }
        
        body.dark-mode .border-0 {
            border-color: #475569 !important;
        }
        
        body.dark-mode .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.3) !important;
        }
        
        body.dark-mode .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.4) !important;
        }
        
        body.dark-mode input::placeholder,
        body.dark-mode textarea::placeholder {
            color: #94a3b8 !important; /* Ensure placeholder visible in dark mode */
        }
        
        body.dark-mode .btn-group .btn {
            border-color: #64748b;
        }
        
        body.dark-mode .btn-outline-secondary {
            border-color: #64748b;
            color: #94a3b8;
        }
        
        body.dark-mode .btn-outline-secondary:disabled {
            border-color: #475569;
            color: #64748b;
            background-color: transparent;
        }
        
        /* Custom Scrollbar Styling */
        /* Global scrollbar for webkit browsers */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--bg-light);
            border-radius: 6px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color), #0284c7);
            border-radius: 6px;
            border: 2px solid var(--bg-light);
            background-clip: padding-box;
            transition: all 0.3s ease;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #0284c7, #0369a1);
            transform: scale(1.05);
        }
        
        ::-webkit-scrollbar-thumb:active {
            background: linear-gradient(135deg, #0369a1, #075985);
        }
        
        ::-webkit-scrollbar-corner {
            background: var(--bg-light);
        }
        
        /* Firefox scrollbar styling */
        * {
            scrollbar-width: thin;
            scrollbar-color: var(--primary-color) var(--bg-light);
        }
        
        /* Table responsive scrollbar */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-responsive::-webkit-scrollbar-track {
            background: var(--bg-light);
            border-radius: 4px;
        }
        
        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, var(--primary-color), #0284c7);
            border-radius: 4px;
            border: 1px solid var(--bg-light);
        }
        
        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(90deg, #0284c7, #0369a1);
        }
        
        /* Modal scrollbar */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }
        
        .modal-body::-webkit-scrollbar-track {
            background: var(--bg-light);
            border-radius: 4px;
        }
        
        .modal-body::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
            border: 1px solid var(--bg-light);
        }
        
        /* Card scrollbar */
        .card::-webkit-scrollbar {
            width: 6px;
        }
        
        .card::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .card::-webkit-scrollbar-thumb {
            background: rgba(14, 165, 233, 0.3);
            border-radius: 3px;
        }
        
        .card::-webkit-scrollbar-thumb:hover {
            background: rgba(14, 165, 233, 0.5);
        }
        
        /* Loading Overlay */
        #loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        body.dark-mode #loading {
            background: rgba(30, 41, 59, 0.9);
        }
        
        .spinner-border {
            color: var(--primary-color);
        }

        /* ===========================================
           RESPONSIVE DESIGN STYLES
           =========================================== */
        
        /* Mobile First Approach */
        
        /* Extra Small devices (phones, less than 576px) */
        @media (max-width: 575.98px) {
            /* Sidebar Mobile Styles */
            .sidebar {
                width: 100%;
                height: 100vh;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1050;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .sidebar.collapsed {
                width: 100%;
                transform: translateX(-100%);
            }
            
            .sidebar.collapsed.show {
                transform: translateX(0);
            }
            
            /* Main Content Mobile */
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .main-content.expanded {
                margin-left: 0;
            }
            
            /* Navbar Mobile */
            .navbar {
                padding: 0.75rem 1rem;
                min-height: 60px;
            }
            
            .navbar .container-fluid {
                padding: 0;
            }

            /* Prevent dropdown from expanding navbar height on mobile */
            .navbar .nav-item.dropdown {
                position: static; /* allow fixed dropdown to escape flow */
            }

            .navbar .user-dropdown-menu {
                position: fixed !important; /* float on top of content */
                top: 60px; /* just below the navbar */
                right: 12px;
                left: auto;
                transform: none !important;
                width: 240px;
                max-height: 60vh;
                overflow-y: auto;
                margin-top: 0 !important;
                box-shadow: 0 10px 24px rgba(0,0,0,0.25);
                border-radius: 12px;
            }

            /* Make trigger compact to reduce navbar growth */
            .navbar .dropdown-toggle .avatar-sm {
                width: 28px;
                height: 28px;
            }
            .navbar .dropdown-toggle span {
                max-width: 120px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                display: inline-block;
                vertical-align: middle;
            }
            
            .navbar .btn-outline-secondary {
                padding: 0.5rem;
                font-size: 0.875rem;
            }
            
            /* Content Wrapper Mobile */
            .content-wrapper {
                padding: 1rem;
            }
            
            /* Cards Mobile */
            .card {
                margin-bottom: 1rem;
            }
            
            .card-header {
                padding: 1rem;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            /* Page Headers Mobile */
            .page-header {
                padding: 1rem 0;
                margin-bottom: 1rem;
            }
            
            .page-header h1 {
                font-size: 1.75rem;
            }
            
            /* Dashboard Mobile */
            .dashboard-header h1 {
                font-size: 1.5rem;
            }
            
            /* Stats Cards Mobile */
            .stat-card {
                margin-bottom: 1rem;
                padding: 1rem;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            /* Tables Mobile */
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .table th,
            .table td {
                padding: 0.5rem;
            }
            
            /* Buttons Mobile */
            .btn-lg {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
            
            /* Forms Mobile */
            .form-control,
            .form-select {
                padding: 0.5rem;
                font-size: 0.875rem;
            }
            
            /* Modal Mobile */
            .modal-dialog {
                margin: 0.5rem;
            }
            
            .modal-content {
                border-radius: 8px;
            }
            
            /* Avatar Mobile */
            .avatar-sm {
                width: 28px;
                height: 28px;
                font-size: 12px;
            }
            
            .avatar-md {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
            
            .avatar-lg {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
            
            /* Badges Mobile */
            .badge {
                font-size: 0.7rem;
            }
            
            /* Project Items Mobile */
            .project-item {
                padding: 0.75rem;
                margin-bottom: 0.75rem;
            }
            
            .project-item h6 {
                font-size: 0.875rem;
            }
            
            /* Bug Items Mobile */
            .bug-item {
                padding: 0.75rem;
                margin-bottom: 0.75rem;
            }
            
            .bug-item h6 {
                font-size: 0.875rem;
            }
            
            /* Quick Actions Mobile */
            .btn-outline-primary,
            .btn-outline-success,
            .btn-outline-danger,
            .btn-outline-info,
            .btn-outline-secondary {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
            
            /* Hide some elements on mobile */
            .d-mobile-none {
                display: none !important;
            }
            
            /* Show mobile-specific elements */
            .d-mobile-block {
                display: block !important;
            }
            
            /* Mobile-specific spacing */
            .mb-mobile-2 {
                margin-bottom: 0.5rem !important;
            }
            
            .mb-mobile-3 {
                margin-bottom: 1rem !important;
            }
            
            .p-mobile-2 {
                padding: 0.5rem !important;
            }
            
            .p-mobile-3 {
                padding: 1rem !important;
            }
        }
        
        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .sidebar {
                width: 280px;
            }
            
            .sidebar.collapsed {
                width: 80px;
            }
            
            .main-content {
                margin-left: 280px;
            }
            
            .main-content.expanded {
                margin-left: 80px;
            }
            
            .content-wrapper {
                padding: 1.5rem;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
            
            .stat-number {
                font-size: 1.75rem;
            }
        }
        
        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .sidebar {
                width: 250px;
            }
            
            .sidebar.collapsed {
                width: 80px;
            }
            
            .main-content {
                margin-left: 250px;
            }
            
            .main-content.expanded {
                margin-left: 80px;
            }
            
            .content-wrapper {
                padding: 2rem;
            }
            
            .page-header h1 {
                font-size: 2.25rem;
            }
            
            .stat-number {
                font-size: 1.875rem;
            }
        }
        
        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) {
            .sidebar {
                width: 250px;
            }
            
            .sidebar.collapsed {
                width: 80px;
            }
            
            .main-content {
                margin-left: 250px;
            }
            
            .main-content.expanded {
                margin-left: 80px;
            }
            
            .content-wrapper {
                padding: 2rem;
            }
            
            .page-header h1 {
                font-size: 2.5rem;
            }
            
            .stat-number {
                font-size: 2rem;
            }
        }
        
        /* Mobile Sidebar Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }
        
        .sidebar-overlay.show {
            display: block;
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
        }
        
        @media (max-width: 767.98px) {
            .mobile-menu-btn {
                display: block;
            }
            
            .desktop-menu-btn {
                display: none;
            }
        }
        
        /* Responsive Grid Adjustments */
        @media (max-width: 575.98px) {
            .row > [class*="col-"] {
                margin-bottom: 1rem;
            }
            
            .col-xl-3,
            .col-xl-4,
            .col-lg-3,
            .col-lg-4,
            .col-md-6 {
                margin-bottom: 1rem;
            }
        }
        
        /* Responsive Table Improvements */
        @media (max-width: 767.98px) {
            .table-responsive {
                border: none;
            }
            
            .table {
                margin-bottom: 0;
            }
            
            .table thead {
                display: none;
            }
            
            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid var(--border-color);
                border-radius: 8px;
                padding: 1rem;
                background-color: var(--secondary-color);
            }
            
            .table tbody td {
                display: block;
                border: none;
                padding: 0.25rem 0;
                text-align: left !important;
            }
            
            .table tbody td:before {
                content: attr(data-label) ": ";
                font-weight: bold;
                color: var(--text-dark);
                display: inline-block;
                width: 120px;
            }
            
            body.dark-mode .table tbody tr {
                background-color: #334155;
                border-color: #475569;
            }
        }
        
        /* Responsive Form Improvements */
        @media (max-width: 575.98px) {
            .form-row .col {
                margin-bottom: 1rem;
            }
            
            .btn-group-vertical .btn {
                margin-bottom: 0.5rem;
            }
            
            .input-group {
                flex-direction: column;
            }
            
            .input-group .form-control {
                border-radius: 8px !important;
                margin-bottom: 0.5rem;
            }
            
            .input-group .btn {
                border-radius: 8px !important;
            }
        }
        
        /* Responsive Card Improvements */
        @media (max-width: 575.98px) {
            .card-deck {
                flex-direction: column;
            }
            
            .card-columns {
                column-count: 1;
            }
            
            .card-group {
                flex-direction: column;
            }
        }
        
        /* Responsive Navigation Improvements */
        @media (max-width: 575.98px) {
            .navbar-nav {
                flex-direction: column;
            }
            
            .navbar-nav .nav-item {
                margin-bottom: 0.5rem;
            }
            
            .dropdown-menu {
                position: static !important;
                float: none;
                width: 100%;
                margin-top: 0;
                border: none;
                box-shadow: none;
            }
        }
        
        /* Responsive Modal Improvements */
        @media (max-width: 575.98px) {
            .modal-dialog {
                margin: 0;
                max-width: 100%;
                height: 100%;
            }
            
            .modal-content {
                height: 100%;
                border-radius: 0;
            }
            
            .modal-header {
                padding: 1rem;
            }
            
            .modal-body {
                padding: 1rem;
                overflow-y: auto;
            }
            
            .modal-footer {
                padding: 1rem;
            }
        }
        
        /* Responsive Button Groups */
        @media (max-width: 575.98px) {
            .btn-group {
                flex-direction: column;
                width: 100%;
            }
            
            .btn-group .btn {
                border-radius: 8px !important;
                margin-bottom: 0.5rem;
            }
            
            .btn-group .btn:last-child {
                margin-bottom: 0;
            }
        }
        
        /* Responsive Utilities */
        @media (max-width: 575.98px) {
            .text-center-mobile {
                text-align: center !important;
            }
            
            .d-block-mobile {
                display: block !important;
            }
            
            .d-none-mobile {
                display: none !important;
            }
            
            .w-100-mobile {
                width: 100% !important;
            }
            
            .mb-0-mobile {
                margin-bottom: 0 !important;
            }
            
            .mt-0-mobile {
                margin-top: 0 !important;
            }
        }
        
        /* Responsive Image Improvements */
        @media (max-width: 575.98px) {
            .img-fluid {
                max-width: 100%;
                height: auto;
            }
            
            .rounded-circle {
                border-radius: 50% !important;
            }
        }
        
        /* Responsive Progress Bars */
        @media (max-width: 575.98px) {
            .progress {
                height: 0.5rem;
            }
            
            .progress-sm {
                height: 0.25rem;
            }
        }
        
        /* Responsive Alerts */
        @media (max-width: 575.98px) {
            .alert {
                padding: 0.75rem;
                margin-bottom: 1rem;
            }
            
            .alert-dismissible .btn-close {
                padding: 0.75rem;
            }
        }
        
        /* Responsive List Groups */
        @media (max-width: 575.98px) {
            .list-group-item {
                padding: 0.75rem;
            }
            
            .list-group-flush .list-group-item {
                border-left: 0;
                border-right: 0;
            }
        }
        
        /* Responsive Pagination */
        @media (max-width: 575.98px) {
            .pagination {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .page-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }
        }
        
        /* Responsive Breadcrumbs */
        @media (max-width: 575.98px) {
            .breadcrumb {
                padding: 0.5rem;
                font-size: 0.875rem;
            }
            
            .breadcrumb-item + .breadcrumb-item::before {
                content: ">";
                padding: 0 0.5rem;
            }
        }
        
        /* Responsive Tabs */
        @media (max-width: 575.98px) {
            .nav-tabs {
                flex-direction: column;
            }
            
            .nav-tabs .nav-link {
                border-radius: 8px !important;
                margin-bottom: 0.5rem;
            }
            
            .tab-content {
                padding: 1rem 0;
            }
        }
        
        /* Responsive Accordion */
        @media (max-width: 575.98px) {
            .accordion-item {
                margin-bottom: 0.5rem;
            }
            
            .accordion-header .accordion-button {
                padding: 0.75rem;
                font-size: 0.875rem;
            }
            
            .accordion-body {
                padding: 0.75rem;
            }
        }
        
        /* Responsive Carousel */
        @media (max-width: 575.98px) {
            .carousel-item {
                height: 200px;
            }
            
            .carousel-caption {
                padding: 0.5rem;
                font-size: 0.875rem;
            }
        }
        
        /* Responsive Offcanvas */
        @media (max-width: 575.98px) {
            .offcanvas {
                width: 100% !important;
            }
        }
        
        /* Dark Mode Responsive Adjustments */
        @media (max-width: 575.98px) {
            body.dark-mode .sidebar-overlay {
                background: rgba(0, 0, 0, 0.7);
            }
            
            body.dark-mode .table tbody tr {
                background-color: #334155;
                border-color: #475569;
            }
        }
        
        /* Print Styles */
        @media print {
            .sidebar,
            .navbar,
            .btn,
            .pagination,
            .breadcrumb {
                display: none !important;
            }
            
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }
            
            .content-wrapper {
                padding: 0 !important;
            }
            
            .card {
                border: 1px solid #000 !important;
                box-shadow: none !important;
            }
            
            .table {
                border-collapse: collapse !important;
            }
            
            .table th,
            .table td {
                border: 1px solid #000 !important;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div id="loading" class="d-none">
        <div class="spinner-border" role="status">
            <span class="visually-hidden"><?php _e('common.loading'); ?></span>
        </div>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebar-overlay" onclick="closeMobileSidebar()"></div>
    
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="p-3">
            <h4 class="text-white mb-4">
                <i class="fas fa-tasks me-2"></i>
                FlowTask
            </h4>
            <div class="text-center d-none" id="sidebar-logo">
                <i class="fas fa-tasks fa-2x text-white mb-3"></i>
            </div>
        </div>
        
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo ($_GET['url'] ?? '') === '' || ($_GET['url'] ?? '') === 'dashboard' ? 'active' : ''; ?>" 
                   href="index.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span><?php _e('nav.dashboard'); ?></span>
                </a>
            </li>
            
            <?php if (in_array($_SESSION['role'], ['super_admin', 'admin', 'project_manager', 'developer', 'qa_tester', 'client'])): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_GET['url'] ?? '', 'projects') === 0 ? 'active' : ''; ?>" 
                   href="index.php?url=projects">
                    <i class="fas fa-project-diagram"></i>
                    <span><?php _e('nav.projects'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (!in_array($_SESSION['role'], ['client'])): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo (strpos($_GET['url'] ?? '', 'tasks') === 0 && strpos($_GET['url'] ?? '', 'deleted-comments') === false) ? 'active' : ''; ?>" 
                   href="index.php?url=tasks">
                    <i class="fas fa-tasks"></i>
                    <span><?php _e('nav.tasks'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (!in_array($_SESSION['role'], ['client'])): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo (strpos($_GET['url'] ?? '', 'bugs') === 0 && strpos($_GET['url'] ?? '', 'deleted-comments') === false) ? 'active' : ''; ?>" 
                   href="index.php?url=bugs">
                    <i class="fas fa-bug"></i>
                    <span><?php _e('nav.bugs'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (in_array($_SESSION['role'], ['super_admin', 'admin', 'qa_tester', 'project_manager'])): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_GET['url'] ?? '', 'qa') === 0 ? 'active' : ''; ?>" 
                   href="index.php?url=qa">
                    <i class="fas fa-clipboard-check"></i>
                    <span><?php _e('nav.qa'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (in_array($_SESSION['role'], ['super_admin', 'admin', 'project_manager', 'developer', 'qa_tester', 'client'])): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_GET['url'] ?? '', 'reports') === 0 ? 'active' : ''; ?>" 
                   href="index.php?url=reports">
                    <i class="fas fa-chart-bar"></i>
                    <span><?php _e('nav.reports'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (in_array($_SESSION['role'], ['super_admin', 'admin'])): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_GET['url'] ?? '', 'users') === 0 ? 'active' : ''; ?>" 
                   href="index.php?url=users">
                    <i class="fas fa-users"></i>
                    <span><?php _e('nav.users'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (in_array($_SESSION['role'], ['super_admin', 'project_manager'])): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_GET['url'] ?? '', 'deleted-comments') !== false ? 'active' : ''; ?>" 
                   href="index.php?url=tasks/deleted-comments">
                    <i class="fas fa-trash-alt"></i>
                    <span>History Komentar</span>
                </a>
            </li>
            <?php endif; ?>
            
            <hr class="border-white-50 my-3">
            
            <li class="nav-item">
                <a class="nav-link <?php echo ($_GET['url'] ?? '') === 'profile' ? 'active' : ''; ?>" 
                   href="index.php?url=profile">
                    <i class="fas fa-user"></i>
                    <span><?php _e('nav.profile'); ?></span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="toggleDarkMode()">
                    <i class="fas fa-moon"></i>
                    <span><?php _e('nav.dark_mode'); ?></span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="confirmLogout(event)">
                    <i class="fas fa-sign-out-alt"></i>
                    <span><?php _e('nav.logout'); ?></span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="btn btn-outline-secondary me-3" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" 
                           data-bs-toggle="dropdown">
                            <div class="avatar-sm me-2">
                                <?php
                                // Get current user's profile photo
                                if (isset($_SESSION['user_id'])) {
                                    $database = new Database();
                                    $db = $database->getConnection();
                                    $userModel = new User($db);
                                    $currentUserHeader = $userModel->findById($_SESSION['user_id']);
                                    
                                    if ($currentUserHeader && $currentUserHeader['profile_photo']):
                                ?>
                                        <img src="<?php echo UPLOADS_URL . '/' . $currentUserHeader['profile_photo']; ?>" 
                                             class="rounded-circle" 
                                             alt="Profile Photo"
                                             style="width: 32px; height: 32px; object-fit: cover; border: 2px solid #e9ecef;">
                                <?php else: ?>
                                        <i class="fas fa-user"></i>
                                <?php 
                                    endif;
                                } else { 
                                ?>
                                    <i class="fas fa-user"></i>
                                <?php } ?>
                            </div>
                            <span>
                                <?php echo htmlspecialchars($_SESSION['username'] ?? 'Pengguna'); ?>
                                <?php if (in_array($_SESSION['role'] ?? '', ['super_admin', 'admin'])): ?>
                                    <i class="fas fa-crown text-warning ms-1" title="<?php echo ucfirst($_SESSION['role'] ?? ''); ?>"></i>
                                <?php endif; ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu user-dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="index.php?url=profile">
                                <i class="fas fa-user me-2"></i><?php _e('nav.profile'); ?>
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="confirmLogout(event)">
                                <i class="fas fa-sign-out-alt me-2"></i><?php _e('nav.logout'); ?>
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="content-wrapper">
            <div class="container-fluid">
    
    <!-- Modern Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 bg-gradient-danger text-white">
                    <div class="d-flex align-items-center">
                        <div class="avatar-lg bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="fas fa-sign-out-alt fa-lg text-white"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="logoutModalLabel"><?php _e('nav.logout_confirm_title'); ?></h5>
                            <small class="text-white-50"><?php _e('common.confirm'); ?> <?php _e('nav.logout'); ?></small>
                        </div>
                    </div>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-question-circle fa-2x text-warning"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold text-dark mb-3"><?php _e('nav.logout_confirm'); ?></h6>
                        <p class="text-muted mb-0"><?php _e('nav.logout_description'); ?></p>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end w-100">
                        <button type="button" class="btn btn-light btn-lg px-4" data-bs-dismiss="modal" id="cancelLogoutBtn">
                            <i class="fas fa-times me-2"></i><?php _e('common.cancel'); ?>
                        </button>
                        <button type="button" class="btn btn-danger btn-lg px-4" onclick="proceedLogout()" id="confirmLogoutBtn">
                            <i class="fas fa-sign-out-alt me-2"></i><?php _e('nav.logout'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Modern Modal Styles with Animations */
        .bg-gradient-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }
        
        .modal-content {
            border-radius: 16px;
            overflow: hidden;
            transform: scale(0.7) translateY(-50px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .modal.show .modal-content {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        /* Make all modal sections use the same solid background */
        .modal .modal-header,
        .modal .modal-body,
        .modal .modal-footer { background-color: inherit; }

        /* Ensure modal buttons are fully opaque and solid colored */
        .modal .btn {
            opacity: 1 !important;
            background-image: none !important;
            filter: none !important;
            backdrop-filter: none !important;
            mix-blend-mode: normal !important;
        }
        .modal .btn-danger {
            --bs-btn-bg: #dc3545;
            --bs-btn-border-color: #dc3545;
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
            color: #fff !important;
        }
        .modal .btn-secondary {
            --bs-btn-bg: #6c757d;
            --bs-btn-border-color: #6c757d;
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            color: #fff !important;
        }

        .modal-backdrop {
            background-color: #000 !important; /* ensure visible overlay */
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1050; /* keep above page but below modal */
        }
        
        .modal.show .modal-backdrop {
            opacity: 0.5;
        }
        
        .modal-header {
            padding: 2rem 2rem 1.5rem 2rem;
        }
        
        .avatar-lg {
            width: 60px;
            height: 60px;
        }
        
        .btn-lg {
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        }
        
        .btn-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Enhanced modal animations */
        .modal.fade .modal-dialog {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform: scale(0.7) translateY(-50px);
        }
        
        .modal.show .modal-dialog {
            transform: scale(1) translateY(0);
        }
        
        /* Backdrop animation */
        .modal-backdrop.fade {
            opacity: 0;
        }
        
        .modal-backdrop.show {
            opacity: 0.6; /* slightly darker for clarity */
        }
        
        /* Dark mode modal styles */
        body.dark-mode .modal-content {
            background-color: #1e293b;
            color: #e2e8f0;
        }
        body.dark-mode .modal .modal-footer { border-top: 1px solid rgba(255,255,255,0.08); }
        
        body.dark-mode .modal-body .bg-light {
            background-color: #334155 !important;
        }
        
        body.dark-mode .text-muted {
            color: #94a3b8 !important;
        }
        
        body.dark-mode .btn-light {
            background-color: #475569;
            border-color: #64748b;
            color: #e2e8f0;
        }
        
        body.dark-mode .btn-light:hover {
            background-color: #64748b;
            border-color: #64748b;
            color: #e2e8f0;
        }
        
        /* Dark Mode Scrollbar Styling */
        body.dark-mode ::-webkit-scrollbar-track {
            background: #0f172a !important;
        }
        
        body.dark-mode ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #0ea5e9, #0284c7, #0369a1);
            border: 2px solid #0f172a;
            box-shadow: 0 0 8px rgba(14, 165, 233, 0.3);
        }
        
        body.dark-mode ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #0284c7, #0369a1, #075985);
            box-shadow: 0 0 12px rgba(14, 165, 233, 0.5);
            transform: scale(1.05);
        }
        
        body.dark-mode ::-webkit-scrollbar-thumb:active {
            background: linear-gradient(135deg, #0369a1, #075985, #0c4a6e);
            box-shadow: 0 0 16px rgba(14, 165, 233, 0.7);
        }
        
        body.dark-mode ::-webkit-scrollbar-corner {
            background: #0f172a;
        }
        
        body.dark-mode * {
            scrollbar-color: #0ea5e9 #0f172a !important;
        }
        
        /* Force dark scrollbar track for all elements in dark mode */
        body.dark-mode ::-webkit-scrollbar-track {
            background: #0f172a !important;
        }
        
        body.dark-mode ::-webkit-scrollbar-corner {
            background: #0f172a !important;
        }
        
        body.dark-mode .table-responsive::-webkit-scrollbar-track {
            background: #0f172a !important;
        }
        
        body.dark-mode .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, #0ea5e9, #0284c7, #0369a1);
            border: 1px solid #0f172a;
            box-shadow: 0 0 6px rgba(14, 165, 233, 0.4);
        }
        
        body.dark-mode .table-responsive::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(90deg, #0284c7, #0369a1, #075985);
            box-shadow: 0 0 10px rgba(14, 165, 233, 0.6);
        }
        
        body.dark-mode .modal-body::-webkit-scrollbar-track {
            background: #0f172a !important;
        }
        
        body.dark-mode .modal-body::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            border: 1px solid #0f172a;
            box-shadow: 0 0 6px rgba(14, 165, 233, 0.4);
        }
        
        body.dark-mode .modal-body::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #0284c7, #0369a1);
            box-shadow: 0 0 10px rgba(14, 165, 233, 0.6);
        }
        
        body.dark-mode .card::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.6), rgba(14, 165, 233, 0.8));
            box-shadow: 0 0 4px rgba(14, 165, 233, 0.3);
        }
        
        body.dark-mode .card::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.8), rgba(14, 165, 233, 1));
            box-shadow: 0 0 8px rgba(14, 165, 233, 0.5);
        }
        
        /* Additional scrollbar styling for specific elements */
        /* List group scrollbar */
        .list-group::-webkit-scrollbar {
            width: 6px;
        }
        
        .list-group::-webkit-scrollbar-track {
            background: var(--bg-light);
            border-radius: 3px;
        }
        
        .list-group::-webkit-scrollbar-thumb {
            background: rgba(14, 165, 233, 0.3);
            border-radius: 3px;
        }
        
        .list-group::-webkit-scrollbar-thumb:hover {
            background: rgba(14, 165, 233, 0.5);
        }
        
        /* Dropdown scrollbar */
        .dropdown-menu::-webkit-scrollbar {
            width: 6px;
        }
        
        .dropdown-menu::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .dropdown-menu::-webkit-scrollbar-thumb {
            background: rgba(14, 165, 233, 0.3);
            border-radius: 3px;
        }
        
        .dropdown-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(14, 165, 233, 0.5);
        }
        
        /* Navbar scrollbar */
        .navbar::-webkit-scrollbar {
            height: 4px;
        }
        
        .navbar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .navbar::-webkit-scrollbar-thumb {
            background: rgba(14, 165, 233, 0.3);
            border-radius: 2px;
        }
        
        .navbar::-webkit-scrollbar-thumb:hover {
            background: rgba(14, 165, 233, 0.5);
        }
        
        /* Dark mode for additional elements */
        body.dark-mode .list-group::-webkit-scrollbar-track {
            background: #0f172a !important;
        }
        
        body.dark-mode .list-group::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.6), rgba(14, 165, 233, 0.8));
            box-shadow: 0 0 4px rgba(14, 165, 233, 0.3);
        }
        
        body.dark-mode .list-group::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.8), rgba(14, 165, 233, 1));
            box-shadow: 0 0 8px rgba(14, 165, 233, 0.5);
        }
        
        body.dark-mode .dropdown-menu::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.6), rgba(14, 165, 233, 0.8));
            box-shadow: 0 0 4px rgba(14, 165, 233, 0.3);
        }
        
        body.dark-mode .dropdown-menu::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.8), rgba(14, 165, 233, 1));
            box-shadow: 0 0 8px rgba(14, 165, 233, 0.5);
        }
        
        body.dark-mode .navbar::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, rgba(14, 165, 233, 0.6), rgba(14, 165, 233, 0.8));
            box-shadow: 0 0 4px rgba(14, 165, 233, 0.3);
        }
        
        body.dark-mode .navbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(90deg, rgba(14, 165, 233, 0.8), rgba(14, 165, 233, 1));
            box-shadow: 0 0 8px rgba(14, 165, 233, 0.5);
        }
        
        /* Override any white scrollbar tracks in dark mode */
        body.dark-mode ::-webkit-scrollbar-track {
            background: #0f172a !important;
            border-radius: 6px;
        }
        
        body.dark-mode ::-webkit-scrollbar-corner {
            background: #0f172a !important;
        }
        
        /* Force dark background for all scrollable elements */
        body.dark-mode .table-responsive,
        body.dark-mode .modal-body,
        body.dark-mode .card,
        body.dark-mode .list-group,
        body.dark-mode .dropdown-menu,
        body.dark-mode .navbar {
            scrollbar-color: #0ea5e9 #0f172a !important;
        }
    </style>
    <?php endif; ?>