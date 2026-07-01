<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AutoRent - Browse premium cars and book your next adventure.">
    <title>AutoRent - Premium Car Rental</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #f0f2f5;
            --card: #ffffff;
            --shadow: 0 2px 12px rgba(0,0,0,0.08);
            --shadow-hover: 0 8px 24px rgba(0,0,0,0.14);
            --primary: #4f46e5;
            --secondary: #7c3aed;
            --gradient: var(--primary);
            --text: #1e293b;
            --text-secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --radius-card: 12px;
            --radius-input: 8px;
            --border: #e2e8f0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ───── NAVBAR ───── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--card);
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            height: 64px;
        }

        .navbar-logo {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .navbar-links {
            display: flex;
            gap: 8px;
            list-style: none;
        }

        .navbar-links a {
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: var(--radius-input);
            transition: background 0.2s, color 0.2s;
        }

        .navbar-links a:hover,
        .navbar-links a.active {
            background: #eef2ff;
            color: var(--primary);
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 4px;
        }

        .hamburger span {
            display: block;
            width: 24px;
            height: 2.5px;
            background: var(--text);
            border-radius: 2px;
            transition: transform 0.3s, opacity 0.3s;
        }

        .hamburger.open span:nth-child(1) { transform: translateY(7.5px) rotate(45deg); }
        .hamburger.open span:nth-child(2) { opacity: 0; }
        .hamburger.open span:nth-child(3) { transform: translateY(-7.5px) rotate(-45deg); }

        /* ───── HERO ───── */
        .hero {
            background: #ffffff;
            padding: 100px 32px 110px;
            text-align: center;
            border-bottom: 1px solid var(--border);
        }

        .hero-content {
            max-width: 700px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--text-secondary);
            margin-bottom: 36px;
            font-weight: 400;
        }

        .hero-btn {
            display: inline-block;
            background: var(--primary);
            color: #fff;
            font-weight: 600;
            font-size: 1rem;
            padding: 14px 36px;
            border-radius: 50px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 14px rgba(79,70,229,0.3);
        }

        .hero-btn:hover {
            transform: scale(1.04);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }

        /* ───── SHARED ───── */
        .section {
            padding: 80px 32px;
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeUp 0.6s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text);
        }

        .section-subtitle {
            color: var(--text-secondary);
            margin-bottom: 36px;
            font-size: 0.95rem;
        }

        /* ───── CAR GRID ───── */
        .car-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .car-card {
            background: var(--card);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.25s, box-shadow 0.25s;
            display: flex;
            flex-direction: column;
        }

        .car-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }

        .car-card-strip {
            height: 8px;
            width: 100%;
        }

        .car-card-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .car-card-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .car-card-meta {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 16px;
        }

        .car-card-price {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--primary);
            margin-top: auto;
            margin-bottom: 16px;
        }

        .car-card-price span {
            font-size: 0.85rem;
            font-weight: 400;
            color: var(--text-secondary);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 22px;
            border: none;
            border-radius: var(--radius-input);
            font-family: inherit;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s, filter 0.15s;
        }

        .btn:hover {
            filter: brightness(0.92);
            transform: scale(1.02);
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-primary {
            background: var(--gradient);
            color: #fff;
            box-shadow: 0 2px 8px rgba(79,70,229,0.3);
        }

        .btn-success {
            background: var(--success);
            color: #fff;
        }

        .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: #fff;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 0.82rem;
        }

        /* ───── FORMS ───── */
        .form-card {
            background: var(--card);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow);
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-card.narrow {
            max-width: 500px;
        }

        .form-card h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid var(--border);
            border-radius: var(--radius-input);
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--text);
            background: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.15);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .cost-preview {
            background: #eef2ff;
            border: 2px solid #c7d2fe;
            border-radius: var(--radius-input);
            padding: 16px 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .cost-preview .label {
            font-size: 0.82rem;
            color: var(--text-secondary);
            margin-bottom: 4px;
        }

        .cost-preview .amount {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary);
        }

        .cost-preview .detail {
            font-size: 0.82rem;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .success-card {
            background: #ecfdf5;
            border: 2px solid #a7f3d0;
            border-radius: var(--radius-card);
            padding: 32px;
            text-align: center;
            margin-top: 20px;
        }

        .success-card .icon {
            font-size: 2.5rem;
            margin-bottom: 12px;
        }

        .success-card h3 {
            color: #065f46;
            margin-bottom: 8px;
        }

        .success-card p {
            color: #047857;
            font-size: 0.9rem;
        }

        .success-card .highlight {
            font-size: 1.3rem;
            font-weight: 700;
            color: #065f46;
            margin: 8px 0;
        }

        /* ───── BOOKINGS ───── */
        .lookup-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 32px;
            max-width: 450px;
        }

        .lookup-bar input {
            flex: 1;
            padding: 10px 14px;
            border: 2px solid var(--border);
            border-radius: var(--radius-input);
            font-family: inherit;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .lookup-bar input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.15);
        }

        .customer-header {
            background: var(--card);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow);
            padding: 24px 28px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .customer-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 1.15rem;
            flex-shrink: 0;
        }

        .customer-info h3 {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .customer-info p {
            font-size: 0.84rem;
            color: var(--text-secondary);
        }

        .booking-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .booking-card {
            background: var(--card);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow);
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .booking-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .booking-details h4 {
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .booking-details p {
            font-size: 0.84rem;
            color: var(--text-secondary);
        }

        .booking-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            flex-shrink: 0;
        }

        .booking-cost {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary);
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-active {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-completed {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ───── FOOTER ───── */
        .footer {
            background: #1e293b;
            color: rgba(255,255,255,0.65);
            text-align: center;
            padding: 32px;
            font-size: 0.85rem;
        }

        .footer a {
            color: #a5b4fc;
            text-decoration: none;
            font-weight: 500;
        }

        .footer a:hover {
            color: #c7d2fe;
        }

        /* ───── TOAST ───── */
        .toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            background: var(--card);
            border-radius: var(--radius-input);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            padding: 14px 20px;
            min-width: 280px;
            max-width: 400px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.88rem;
            font-weight: 500;
            animation: slideIn 0.35s ease;
            border-left: 4px solid var(--primary);
        }

        .toast.success { border-left-color: var(--success); }
        .toast.error { border-left-color: var(--danger); }
        .toast.warning { border-left-color: var(--warning); }

        .toast.removing {
            animation: slideOut 0.3s ease forwards;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(60px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideOut {
            to { opacity: 0; transform: translateX(60px); }
        }

        /* ───── SPINNER ───── */
        .spinner-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(255,255,255,0.55);
            z-index: 8000;
            align-items: center;
            justify-content: center;
        }

        .spinner-overlay.active {
            display: flex;
        }

        .spinner {
            width: 44px;
            height: 44px;
            border: 4px solid var(--border);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ───── EMPTY STATE ───── */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--text-secondary);
        }

        .empty-state .icon {
            font-size: 3rem;
            margin-bottom: 12px;
        }

        .empty-state p {
            font-size: 0.95rem;
        }

        /* ───── RESPONSIVE ───── */
        @media (max-width: 900px) {
            .car-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .navbar {
                padding: 0 16px;
            }

            .navbar-links {
                display: none;
                position: absolute;
                top: 64px;
                left: 0;
                right: 0;
                background: var(--card);
                flex-direction: column;
                padding: 12px 16px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                gap: 4px;
            }

            .navbar-links.open {
                display: flex;
            }

            .hamburger {
                display: flex;
            }

            .hero {
                padding: 64px 20px 72px;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .section {
                padding: 48px 16px;
            }

            .car-grid {
                grid-template-columns: 1fr;
            }

            .form-card {
                padding: 24px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .booking-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .booking-right {
                align-items: flex-start;
                flex-direction: row;
                flex-wrap: wrap;
                gap: 12px;
            }

            .lookup-bar {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <a href="#" class="navbar-logo"> AutoRent</a>
    <ul class="navbar-links" id="navLinks">
        <li><a href="#browse" class="nav-link active" data-section="browse">Browse Cars</a></li>
        <li><a href="#rent" class="nav-link" data-section="rent">Rent a Car</a></li>
        <li><a href="#bookings" class="nav-link" data-section="bookings">My Bookings</a></li>
        <li><a href="#register" class="nav-link" data-section="register">Register</a></li>
    </ul>
    <button class="hamburger" id="hamburger" aria-label="Toggle navigation">
        <span></span><span></span><span></span>
    </button>
</nav>

<!-- Hero -->
<section class="hero" id="hero">
    <div class="hero-content">
        <h1>Find Your Perfect Ride</h1>
        <p>Browse our premium fleet and book your next adventure</p>
        <button class="hero-btn" onclick="scrollToSection('browse')">Browse Available Cars</button>
    </div>
</section>

<!-- Browse Cars -->
<section class="section" id="browse">
    <h2 class="section-title">Available Cars <span id="carCount" style="font-size:0.9rem;color:var(--text-secondary);font-weight:500;"></span></h2>
    <p class="section-subtitle">Choose from our wide selection of quality vehicles</p>
    <div class="car-grid" id="carGrid">
        <!-- populated by JS -->
    </div>
    <div class="empty-state" id="carsEmpty" style="display:none;">
        <div class="icon"></div>
        <p>No cars available right now. Check back soon!</p>
    </div>
</section>

<!-- Rent a Car -->
<section class="section" id="rent">
    <div class="form-card" id="rentFormCard">
        <h2> Rent a Car</h2>
        <form id="rentForm" autocomplete="off">
            <div class="form-row">
                <div class="form-group">
                    <label for="rentCustomerId">Customer ID</label>
                    <input type="number" id="rentCustomerId" min="1" required placeholder="Your customer ID">
                </div>
                <div class="form-group">
                    <label for="rentCarId">Car ID</label>
                    <input type="number" id="rentCarId" min="1" required placeholder="Car ID">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="rentStartDate">Start Date</label>
                    <input type="date" id="rentStartDate" required>
                </div>
                <div class="form-group">
                    <label for="rentEndDate">End Date</label>
                    <input type="date" id="rentEndDate" required>
                </div>
            </div>
            <div class="form-group">
                <label for="rentPayment">Payment Method</label>
                <select id="rentPayment" required>
                    <option value="">Select payment method</option>
                    <option value="Cash">Cash</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                </select>
            </div>
            <div class="cost-preview" id="costPreview" style="display:none;">
                <div class="label">Estimated Total</div>
                <div class="amount" id="costAmount">$0</div>
                <div class="detail" id="costDetail"></div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;padding:12px;">Confirm Rental</button>
        </form>
    </div>
    <div class="success-card" id="rentSuccess" style="display:none;">
        <div class="icon"></div>
        <h3>Rental Confirmed!</h3>
        <p>Your reservation has been created successfully.</p>
        <div class="highlight" id="rentResId"></div>
        <p id="rentResDetail"></p>
        <button class="btn btn-outline" style="margin-top:16px;" onclick="resetRentForm()">Rent Another Car</button>
    </div>
</section>

<!-- My Bookings -->
<section class="section" id="bookings">
    <h2 class="section-title"> My Bookings</h2>
    <p class="section-subtitle">Look up your reservations by Customer ID</p>
    <div class="lookup-bar">
        <input type="number" id="lookupCustomerId" placeholder="Enter your Customer ID" min="1">
        <button class="btn btn-primary" onclick="lookupBookings()">Look Up</button>
    </div>
    <div id="bookingsResult"></div>
</section>

<!-- Register -->
<section class="section" id="register">
    <div class="form-card narrow" id="registerFormCard">
        <h2> Create Your Account</h2>
        <form id="registerForm" autocomplete="off">
            <div class="form-group">
                <label for="regName">Full Name</label>
                <input type="text" id="regName" required placeholder="John Doe">
            </div>
            <div class="form-group">
                <label for="regEmail">Email</label>
                <input type="email" id="regEmail" required placeholder="john@example.com">
            </div>
            <div class="form-group">
                <label for="regPhone">Phone</label>
                <input type="tel" id="regPhone" required placeholder="+1 555-123-4567">
            </div>
            <div class="form-group">
                <label for="regLicense">Driver's License</label>
                <input type="text" id="regLicense" required placeholder="DL-123456789">
            </div>
            <div class="form-group">
                <label for="regAddress">Address</label>
                <input type="text" id="regAddress" required placeholder="123 Main Street, City">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;padding:12px;">Register</button>
        </form>
    </div>
    <div class="success-card" id="registerSuccess" style="display:none;">
        <div class="icon">✅</div>
        <h3>Registration Successful!</h3>
        <p>Your account has been created. Your Customer ID is:</p>
        <div class="highlight" id="regCustomerId"></div>
        <p>Save this ID to make reservations and track bookings.</p>
        <button class="btn btn-outline" style="margin-top:16px;" onclick="resetRegisterForm()">Register Another</button>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <p>&copy; 2026 AutoRent. All rights reserved. &nbsp;|&nbsp; <a href="admin.php">Admin Panel</a></p>
</footer>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- Spinner Overlay -->
<div class="spinner-overlay" id="spinnerOverlay">
    <div class="spinner"></div>
</div>

<script>
    /* ═══════════════════════════════════════════
       GLOBALS & HELPERS
       ═══════════════════════════════════════════ */
    const API = 'api.php';
    let carsCache = [];

    function $(sel) { return document.querySelector(sel); }
    function $$(sel) { return document.querySelectorAll(sel); }

    /* ── Toast ── */
    function toast(message, type = 'success') {
        const container = $('#toastContainer');
        const el = document.createElement('div');
        el.className = 'toast ' + type;
        const icons = { success: '✅', error: '❌', warning: '' };
        el.innerHTML = '<span>' + (icons[type] || '') + '</span><span>' + escapeHtml(message) + '</span>';
        container.appendChild(el);
        setTimeout(() => {
            el.classList.add('removing');
            setTimeout(() => el.remove(), 300);
        }, 3000);
    }

    function escapeHtml(str) {
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    /* ── Spinner ── */
    function showSpinner() { $('#spinnerOverlay').classList.add('active'); }
    function hideSpinner() { $('#spinnerOverlay').classList.remove('active'); }

    /* ── API fetch wrappers ── */
    async function apiGet(params) {
        const url = API + '?' + new URLSearchParams(params).toString();
        const res = await fetch(url);
        return res.json();
    }

    async function apiPost(body) {
        const res = await fetch(API, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams(body).toString()
        });
        return res.json();
    }

    /* ── Color Map ── */
    function mapColor(colorName) {
        const map = {
            'red': '#ef4444', 'blue': '#3b82f6', 'green': '#22c55e', 'black': '#1e293b',
            'white': '#e2e8f0', 'silver': '#94a3b8', 'gray': '#6b7280', 'grey': '#6b7280',
            'yellow': '#eab308', 'orange': '#f97316', 'purple': '#a855f7', 'pink': '#ec4899',
            'brown': '#92400e', 'gold': '#d97706', 'beige': '#d4c5a9', 'maroon': '#7f1d1d',
            'navy': '#1e3a5f', 'dark blue': '#1e40af', 'light blue': '#7dd3fc',
            'dark green': '#166534', 'dark red': '#991b1b', 'dark gray': '#374151',
            'dark grey': '#374151', 'light gray': '#d1d5db', 'light grey': '#d1d5db',
            'burgundy': '#800020', 'champagne': '#f7e7ce', 'bronze': '#cd7f32',
            'teal': '#14b8a6', 'cyan': '#06b6d4', 'magenta': '#d946ef',
            'turquoise': '#40e0d0', 'charcoal': '#36454f', 'ivory': '#fffff0',
            'pearl': '#eae0c8', 'midnight blue': '#191970', 'cream': '#fffdd0',
            'tan': '#d2b48c', 'metallic': '#aaa9ad', 'platinum': '#e5e4e2',
            'gunmetal': '#2a3439', 'slate': '#708090'
        };
        const lower = (colorName || '').toLowerCase().trim();
        return map[lower] || '#94a3b8';
    }

    /* ── Navigation ── */
    function scrollToSection(id) {
        const el = document.getElementById(id);
        if (el) el.scrollIntoView({ behavior: 'smooth' });
        setActiveNav(id);
        /* Close mobile nav if open */
        $('#navLinks').classList.remove('open');
        $('#hamburger').classList.remove('open');
    }

    function setActiveNav(id) {
        $$('.nav-link').forEach(a => {
            a.classList.toggle('active', a.dataset.section === id);
        });
    }

    /* ── Set min dates ── */
    function setMinDates() {
        const today = new Date().toISOString().split('T')[0];
        $('#rentStartDate').setAttribute('min', today);
        $('#rentEndDate').setAttribute('min', today);
    }

    /* ═══════════════════════════════════════════
       BROWSE CARS
       ═══════════════════════════════════════════ */
    async function loadCars() {
        showSpinner();
        try {
            const resp = await apiGet({ action: 'get_available_cars' });
            hideSpinner();
            if (resp.success && resp.data && resp.data.length > 0) {
                carsCache = resp.data;
                $('#carCount').textContent = '(' + resp.data.length + ' available)';
                $('#carsEmpty').style.display = 'none';
                renderCars(resp.data);
            } else {
                carsCache = [];
                $('#carCount').textContent = '(0 available)';
                $('#carGrid').innerHTML = '';
                $('#carsEmpty').style.display = 'block';
            }
        } catch (e) {
            hideSpinner();
            toast('Failed to load cars. Please try again.', 'error');
            $('#carGrid').innerHTML = '';
            $('#carsEmpty').style.display = 'block';
        }
    }

    function renderCars(cars) {
        const grid = $('#carGrid');
        grid.innerHTML = cars.map(car => {
            const color = mapColor(car.Color);
            return '<div class="car-card">' +
                '<div class="car-card-strip" style="background:' + color + ';"></div>' +
                '<div class="car-card-body">' +
                    '<div class="car-card-title">' + escapeHtml(car.Brand) + ' ' + escapeHtml(car.Model) + '</div>' +
                    '<div class="car-card-meta">' + escapeHtml(String(car.Year)) + ' &bull; ' + escapeHtml(car.Color) + ' &bull; ' + escapeHtml(car.License_Plate) + '</div>' +
                    '<div class="car-card-price">$' + Number(car.Rental_Price).toFixed(2) + ' <span>/day</span></div>' +
                    '<button class="btn btn-primary" onclick="selectCar(' + car.Car_ID + ')">Rent This Car</button>' +
                '</div>' +
            '</div>';
        }).join('');
    }

    function selectCar(carId) {
        scrollToSection('rent');
        $('#rentCarId').value = carId;
        calculateCost();
    }

    /* ═══════════════════════════════════════════
       RENT A CAR
       ═══════════════════════════════════════════ */
    function calculateCost() {
        const carId = parseInt($('#rentCarId').value);
        const startStr = $('#rentStartDate').value;
        const endStr = $('#rentEndDate').value;

        if (!carId || !startStr || !endStr) {
            $('#costPreview').style.display = 'none';
            return;
        }

        const start = new Date(startStr);
        const end = new Date(endStr);
        const diffTime = end - start;
        const days = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (days <= 0) {
            $('#costPreview').style.display = 'none';
            return;
        }

        const car = carsCache.find(c => c.Car_ID == carId);
        if (!car) {
            /* Try fetching from available cars to find price */
            $('#costPreview').style.display = 'none';
            return;
        }

        const total = (days * Number(car.Rental_Price)).toFixed(2);
        $('#costAmount').textContent = '$' + total;
        $('#costDetail').textContent = days + ' day' + (days !== 1 ? 's' : '') + ' × $' + Number(car.Rental_Price).toFixed(2) + '/day';
        $('#costPreview').style.display = 'block';
    }

    $('#rentCarId').addEventListener('input', calculateCost);
    $('#rentStartDate').addEventListener('change', function() {
        const startVal = this.value;
        if (startVal) {
            $('#rentEndDate').setAttribute('min', startVal);
            if ($('#rentEndDate').value && $('#rentEndDate').value < startVal) {
                $('#rentEndDate').value = '';
            }
        }
        calculateCost();
    });
    $('#rentEndDate').addEventListener('change', calculateCost);

    $('#rentForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const customerId = $('#rentCustomerId').value;
        const carId = $('#rentCarId').value;
        const startDate = $('#rentStartDate').value;
        const endDate = $('#rentEndDate').value;
        const payment = $('#rentPayment').value;

        if (!customerId || !carId || !startDate || !endDate || !payment) {
            toast('Please fill in all fields.', 'warning');
            return;
        }

        if (new Date(endDate) <= new Date(startDate)) {
            toast('End date must be after start date.', 'warning');
            return;
        }

        showSpinner();
        try {
            const resp = await apiPost({
                action: 'rent_car',
                customer_id: customerId,
                car_id: carId,
                start_date: startDate,
                end_date: endDate,
                payment_method: payment
            });
            hideSpinner();

            if (resp.success) {
                toast('Rental confirmed!', 'success');
                $('#rentFormCard').style.display = 'none';
                $('#rentResId').textContent = 'Reservation #' + resp.data.reservation_id;
                $('#rentResDetail').textContent = 'Total: $' + Number(resp.data.total_cost).toFixed(2) + ' for ' + resp.data.days + ' day' + (resp.data.days != 1 ? 's' : '');
                $('#rentSuccess').style.display = 'block';
                loadCars(); /* Refresh available cars */
            } else {
                toast(resp.message || 'Rental failed.', 'error');
            }
        } catch (e) {
            hideSpinner();
            toast('Something went wrong. Please try again.', 'error');
        }
    });

    function resetRentForm() {
        $('#rentForm').reset();
        $('#costPreview').style.display = 'none';
        $('#rentFormCard').style.display = 'block';
        $('#rentSuccess').style.display = 'none';
    }

    /* ═══════════════════════════════════════════
       MY BOOKINGS
       ═══════════════════════════════════════════ */
    async function lookupBookings() {
        const customerId = $('#lookupCustomerId').value;
        if (!customerId) {
            toast('Please enter a Customer ID.', 'warning');
            return;
        }

        showSpinner();
        try {
            /* Fetch customer info and reservations in parallel */
            const [custResp, resResp] = await Promise.all([
                apiGet({ action: 'get_customer', id: customerId }),
                apiGet({ action: 'get_customer_reservations', customer_id: customerId })
            ]);
            hideSpinner();

            const container = $('#bookingsResult');

            if (!custResp.success) {
                container.innerHTML = '';
                toast(custResp.message || 'Customer not found.', 'error');
                return;
            }

            const customer = custResp.data;
            const reservations = (resResp.success && resResp.data) ? resResp.data : [];

            /* Customer header */
            const initials = (customer.Name || 'U').split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
            let html = '<div class="customer-header">' +
                '<div class="customer-avatar">' + escapeHtml(initials) + '</div>' +
                '<div class="customer-info">' +
                    '<h3>' + escapeHtml(customer.Name || 'Customer') + '</h3>' +
                    '<p>Customer ID: ' + escapeHtml(String(customerId)) +
                    (customer.Email ? ' &bull; ' + escapeHtml(customer.Email) : '') +
                    '</p>' +
                '</div>' +
            '</div>';

            if (reservations.length === 0) {
                html += '<div class="empty-state"><div class="icon"></div><p>No bookings found for this customer.</p></div>';
            } else {
                html += '<div class="booking-list">';
                reservations.forEach((r, i) => {
                    const status = (r.Status || 'active').toLowerCase();
                    let badgeClass = 'badge-active';
                    if (status === 'completed') badgeClass = 'badge-completed';
                    else if (status === 'cancelled' || status === 'canceled') badgeClass = 'badge-cancelled';

                    const resId = r.Reservation_ID || r.reservation_id || (i + 1);

                    html += '<div class="booking-card">' +
                        '<div class="booking-details">' +
                            '<h4>' + escapeHtml(r.Car_Name || 'Car') + '</h4>' +
                            '<p>Reservation #' + escapeHtml(String(resId)) + ' &bull; ' + escapeHtml(r.Start_Date || '') + ' to ' + escapeHtml(r.End_Date || '') + '</p>' +
                        '</div>' +
                        '<div class="booking-right">' +
                            '<div class="booking-cost">$' + Number(r.Total_Cost || 0).toFixed(2) + '</div>' +
                            '<span class="badge ' + badgeClass + '">' + escapeHtml(r.Status || 'Active') + '</span>' +
                            (status === 'active' ? '<button class="btn btn-danger btn-sm" onclick="returnCar(' + resId + ', ' + customerId + ')">Return Car</button>' : '') +
                        '</div>' +
                    '</div>';
                });
                html += '</div>';
            }

            container.innerHTML = html;

        } catch (e) {
            hideSpinner();
            toast('Failed to load bookings. Please try again.', 'error');
        }
    }

    /* Allow pressing Enter in lookup field */
    $('#lookupCustomerId').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            lookupBookings();
        }
    });

    async function returnCar(reservationId, customerId) {
        if (!confirm('Are you sure you want to return this car?')) return;

        showSpinner();
        try {
            const resp = await apiPost({ action: 'return_car', reservation_id: reservationId });
            hideSpinner();

            if (resp.success) {
                toast('Car returned successfully!', 'success');
                /* Refresh bookings and cars */
                $('#lookupCustomerId').value = customerId;
                lookupBookings();
                loadCars();
            } else {
                toast(resp.message || 'Return failed.', 'error');
            }
        } catch (e) {
            hideSpinner();
            toast('Something went wrong. Please try again.', 'error');
        }
    }

    /* ═══════════════════════════════════════════
       REGISTER
       ═══════════════════════════════════════════ */
    $('#registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const name = $('#regName').value.trim();
        const email = $('#regEmail').value.trim();
        const phone = $('#regPhone').value.trim();
        const license = $('#regLicense').value.trim();
        const address = $('#regAddress').value.trim();

        if (!name || !email || !phone || !license || !address) {
            toast('Please fill in all fields.', 'warning');
            return;
        }

        showSpinner();
        try {
            const resp = await apiPost({
                action: 'add_customer',
                Name: name,
                Email: email,
                Phone: phone,
                Drivers_License: license,
                Address: address
            });
            hideSpinner();

            if (resp.success) {
                toast('Registration successful!', 'success');
                $('#registerFormCard').style.display = 'none';
                $('#regCustomerId').textContent = 'ID: ' + resp.data.id;
                $('#registerSuccess').style.display = 'block';
            } else {
                toast(resp.message || 'Registration failed.', 'error');
            }
        } catch (e) {
            hideSpinner();
            toast('Something went wrong. Please try again.', 'error');
        }
    });

    function resetRegisterForm() {
        $('#registerForm').reset();
        $('#registerFormCard').style.display = 'block';
        $('#registerSuccess').style.display = 'none';
    }

    /* ═══════════════════════════════════════════
       NAV & INIT
       ═══════════════════════════════════════════ */

    /* Nav link clicks */
    $$('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            scrollToSection(this.dataset.section);
        });
    });

    /* Hamburger toggle */
    $('#hamburger').addEventListener('click', function() {
        this.classList.toggle('open');
        $('#navLinks').classList.toggle('open');
    });

    /* Highlight active nav on scroll */
    const sections = ['browse', 'rent', 'bookings', 'register'];
    window.addEventListener('scroll', function() {
        const scrollY = window.scrollY + 120;
        for (let i = sections.length - 1; i >= 0; i--) {
            const sec = document.getElementById(sections[i]);
            if (sec && sec.offsetTop <= scrollY) {
                setActiveNav(sections[i]);
                break;
            }
        }
    });

    /* Init */
    setMinDates();
    loadCars();
</script>
</body>
</html>

