{{-- resources/views/partials/layout.blade.php --}}
{{-- Include this in every page head --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --black: #0a0a0a;
        --white: #fafafa;
        --gray-100: #f5f5f5;
        --gray-200: #e8e8e8;
        --gray-400: #a0a0a0;
        --gray-600: #5a5a5a;
        --accent: #1a1a1a;
        --danger: #c0392b;
        --success: #27ae60;
        --warning: #e67e22;
        --info: #2980b9;
        --radius: 4px;
        --transition: 0.15s ease;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--white);
        color: var(--black);
        font-size: 15px;
        line-height: 1.6;
        min-height: 100vh;
    }

    /* Navbar */
    .nav {
        border-bottom: 1px solid var(--gray-200);
        padding: 0 24px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        background: var(--white);
        z-index: 100;
    }

    .nav-brand {
        font-family: 'DM Serif Display', serif;
        font-size: 20px;
        color: var(--black);
        text-decoration: none;
        letter-spacing: -0.3px;
    }

    .nav-brand-static {
        font-family: 'DM Serif Display', serif;
        font-size: 20px;
        color: var(--gray-400);
        letter-spacing: -0.3px;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 8px;
        list-style: none;
    }

    .nav-link {
        color: var(--gray-600);
        text-decoration: none;
        padding: 6px 12px;
        border-radius: var(--radius);
        font-size: 14px;
        font-weight: 500;
        transition: color var(--transition), background var(--transition);
    }

    .nav-link:hover { color: var(--black); background: var(--gray-100); }

    .nav-greeting {
        font-size: 14px;
        color: var(--gray-400);
        padding: 6px 12px;
    }

    .nav-btn-logout {
        background: none;
        border: 1px solid var(--gray-200);
        color: var(--gray-600);
        padding: 6px 14px;
        border-radius: var(--radius);
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: all var(--transition);
    }

    .nav-btn-logout:hover { border-color: var(--black); color: var(--black); }

    .nav-incomplete {
        font-size: 14px;
        color: var(--warning);
        padding: 6px 12px;
    }

    /* Hamburger */
    .nav-toggle {
        display: none;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
        background: none;
        border: none;
        padding: 4px;
    }

    .nav-toggle span {
        display: block;
        width: 22px;
        height: 2px;
        background: var(--black);
        border-radius: 2px;
        transition: all var(--transition);
    }

    /* Page wrapper */
    .page {
        max-width: 860px;
        margin: 0 auto;
        padding: 48px 24px 80px;
    }

    .page-sm {
        max-width: 560px;
        margin: 0 auto;
        padding: 48px 24px 80px;
    }

    /* Typography */
    h1 { font-family: 'DM Serif Display', serif; font-size: clamp(28px, 5vw, 42px); line-height: 1.15; letter-spacing: -0.5px; }
    h2 { font-family: 'DM Serif Display', serif; font-size: clamp(22px, 4vw, 30px); letter-spacing: -0.3px; }
    h3 { font-size: 18px; font-weight: 600; }
    h5 { font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray-600); }

    /* Alerts */
    .alert {
        padding: 12px 16px;
        border-radius: var(--radius);
        font-size: 14px;
        margin-bottom: 20px;
        border-left: 3px solid;
    }

    .alert-success { background: #f0faf4; border-color: var(--success); color: #1e7e44; }
    .alert-danger  { background: #fdf2f2; border-color: var(--danger); color: #9b2626; }
    .alert-info    { background: #f0f7fd; border-color: var(--info); color: #1a5f8a; }
    .alert-warning { background: #fef9f0; border-color: var(--warning); color: #9a5c00; }

    /* Cards */
    .card {
        border: 1px solid var(--gray-200);
        border-radius: var(--radius);
        background: var(--white);
        margin-bottom: 16px;
        transition: border-color var(--transition);
    }

    .card:hover { border-color: var(--gray-400); }
    .card-header { padding: 16px 20px; border-bottom: 1px solid var(--gray-200); }
    .card-body { padding: 20px; }

    /* Form elements */
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius);
        font-family: 'DM Sans', sans-serif;
        font-size: 15px;
        color: var(--black);
        background: var(--white);
        transition: border-color var(--transition);
        outline: none;
    }

    .form-control:focus { border-color: var(--black); }
    .form-control:disabled { background: var(--gray-100); color: var(--gray-400); cursor: not-allowed; }

    .form-group { margin-bottom: 20px; }

    .form-hint { font-size: 12px; color: var(--gray-400); margin-top: 4px; }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 20px;
        border-radius: var(--radius);
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all var(--transition);
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .btn-primary { background: var(--black); color: var(--white); border-color: var(--black); }
    .btn-primary:hover { background: #333; border-color: #333; color: var(--white); }

    .btn-secondary { background: var(--white); color: var(--black); border-color: var(--gray-200); }
    .btn-secondary:hover { border-color: var(--black); color: var(--black); }

    .btn-danger { background: var(--white); color: var(--danger); border-color: var(--gray-200); }
    .btn-danger:hover { background: var(--danger); color: var(--white); border-color: var(--danger); }

    .btn-success { background: var(--white); color: var(--success); border-color: var(--gray-200); }
    .btn-success:hover { background: var(--success); color: var(--white); border-color: var(--success); }

    .btn-full { width: 100%; }
    .btn-sm { padding: 6px 14px; font-size: 13px; }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.2px;
    }

    .badge-success  { background: #e8f8ef; color: #1a6b3a; }
    .badge-danger   { background: #fceaea; color: #9b2020; }
    .badge-warning  { background: #fef3e2; color: #8a4f00; }
    .badge-secondary{ background: var(--gray-100); color: var(--gray-600); }

    /* Divider */
    .divider { border: none; border-top: 1px solid var(--gray-200); margin: 36px 0; }

    /* Meta tags (location, type etc) */
    .meta { font-size: 13px; color: var(--gray-400); display: flex; flex-wrap: wrap; gap: 12px; margin-top: 6px; }
    .meta span::before { content: ''; }

    /* Section title */
    .section-title { margin-bottom: 28px; }
    .section-title p { color: var(--gray-600); margin-top: 8px; font-size: 15px; }

    /* Danger zone */
    .danger-zone { border: 1px solid #fce8e8; border-radius: var(--radius); padding: 20px; margin-top: 36px; }
    .danger-zone h5 { color: var(--danger); margin-bottom: 8px; }
    .danger-zone p { font-size: 14px; color: var(--gray-600); margin-bottom: 16px; }

    /* Job card */
    .job-card {
        border: 1px solid var(--gray-200);
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 12px;
        transition: border-color var(--transition), box-shadow var(--transition);
        background: var(--white);
    }

    .job-card:hover { border-color: var(--black); box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
    .job-card-title { font-size: 17px; font-weight: 600; color: var(--black); margin-bottom: 6px; }
    .job-card-actions { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 16px; }

    /* Profile info block */
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px 24px; }
    .info-item label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; color: var(--gray-400); display: block; margin-bottom: 2px; }
    .info-item span { font-size: 15px; color: var(--black); }

    /* Responsive */
    @media (max-width: 768px) {
        .nav-links { display: none; flex-direction: column; position: absolute; top: 60px; left: 0; right: 0; background: var(--white); border-bottom: 1px solid var(--gray-200); padding: 12px 16px; gap: 4px; }
        .nav-links.open { display: flex; }
        .nav-toggle { display: flex; }
        .page, .page-sm { padding: 32px 16px 60px; }
        .info-grid { grid-template-columns: 1fr; }
        .job-card-actions { flex-direction: column; }
        .job-card-actions .btn { width: 100%; text-align: center; }
        .btn-row { flex-direction: column; }
        .btn-row .btn { width: 100%; }
    }
</style>