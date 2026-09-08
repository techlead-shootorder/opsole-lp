<?php
$formSubmitted = false;
$formSuccess = false;
$errorMessage = '';
$fullName = '';
$workEmail = '';
$companyName = '';
$fleetSize = '250–1,000 devices';
$identitySetup = 'Active Directory / Hybrid Join';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'assessment') {
    $formSubmitted = true;
    $fullName = trim($_POST['full_name'] ?? '');
    $workEmail = trim($_POST['work_email'] ?? '');
    $companyName = trim($_POST['company_name'] ?? '');
    $fleetSize = trim($_POST['fleet_size'] ?? '');
    $identitySetup = trim($_POST['identity_setup'] ?? '');

    if (empty($fullName) || empty($workEmail) || empty($companyName)) {
        $errorMessage = 'Please fill out all required fields (*).';
    } elseif (!filter_var($workEmail, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = 'Please enter a valid work email address.';
    } else {
        $formSuccess = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opsole - Move to Microsoft Entra ID Without the Wipe & Load</title>
    <meta name="description"
        content="Migrate Windows 10/11 devices from Active Directory or Hybrid Join to native Microsoft Entra ID in 5-6 minutes per device without wiping the device.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,500;0,600;0,700;0,800;1,500&display=swap"
        rel="stylesheet">
    <style>
        /* CSS Reset & Design System Variables */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --color-bg-light: #E7FFF1;
            --color-bg-mint: #D9FCE9;
            --color-bg-mint-light: rgba(206, 240, 221, 0.30);
            --color-bg-dark: #002013;
            --color-bg-dark-card: #113626;
            --color-primary-green: #3F6900;
            --color-bright-green: #ABF453;
            --color-accent-lime: #ADF755;
            --color-text-dark: #002013;
            --color-text-body: #414844;
            --color-text-muted: #475569;
            --color-text-subtle: #64748B;
            --color-text-card-dark: #7AA08B;
            --color-red-bg: #FFDAD6;
            --color-red-text: #93000A;
            --color-red-alert: #BA1A1A;
            --color-border: #C1C8C2;
            --color-border-nav: #E2E8F0;
            --font-heading: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
            font-family: var(--font-body);
            background-color: var(--color-bg-light);
            color: var(--color-text-dark);
            -webkit-font-smoothing: antialiased;
        }

        #assessment,
        section[id] {
            scroll-margin-top: -15px;
        }

        body {
            width: 100%;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Container helper */
        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding-left: 32px;
            padding-right: 32px;
        }

        /* Header / Navbar */
        .header {
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid var(--color-border-nav);
            backdrop-filter: blur(4px);
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: center;
        }

        .header-inner {
            width: 100%;
            max-width: 1280px;
            height: 80px;
            padding: 0 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-logo-img {
            height: 44px;
            width: auto;
            display: block;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        .nav-links a {
            color: var(--color-text-muted);
            font-size: 14px;
            font-family: var(--font-heading);
            font-weight: 500;
            line-height: 20px;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .nav-links a:hover {
            color: var(--color-primary-green);
        }

        .btn-demo-nav {
            padding: 10px 20px;
            background: #064E3B;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            border-radius: 6px;
            color: white;
            font-size: 14px;
            font-family: var(--font-heading);
            font-weight: 600;
            line-height: 20px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s ease;
        }

        .btn-demo-nav:hover {
            background: #04392b;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }

        /* Hero Section */
        .hero-section {
            width: 100%;
            background: linear-gradient(180deg, #F0F7E8 0%, #E7F4DC 20%, #E7FFF1 50%);
            padding: 96px 88px;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        .glow-circle-1 {
            width: 608px;
            height: 608px;
            right: -50px;
            top: -74px;
            position: absolute;
            background: rgba(63, 105, 0, 0.10);
            border-radius: 9999px;
            filter: blur(50px);
            pointer-events: none;
        }

        .glow-circle-2 {
            width: 512px;
            height: 512px;
            left: -128px;
            top: 196px;
            position: absolute;
            background: rgba(173, 247, 85, 0.20);
            border-radius: 9999px;
            filter: blur(45px);
            pointer-events: none;
        }

        .hero-container {
            width: 100%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: 1fr 446px;
            gap: 48px;
            align-items: flex-start;
            position: relative;
            z-index: 2;
        }

        .hero-left {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .pill-badge {
            padding: 4px 12px;
            background: rgba(255, 255, 255, 0.80);
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            border-radius: 9999px;
            backdrop-filter: blur(6px);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            align-self: flex-start;
        }

        .dot-green {
            width: 10px;
            height: 10px;
            background: var(--color-primary-green);
            border-radius: 9999px;
        }

        .pill-badge-text {
            color: var(--color-text-dark);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 16px;
            letter-spacing: 0.30px;
        }

        .hero-title {
            color: var(--color-text-dark);
            font-size: 56px;
            font-family: var(--font-heading);
            font-weight: 800;
            line-height: 64px;
        }

        .hero-title .highlight {
            color: var(--color-primary-green);
            text-decoration: underline;
        }

        .hero-description {
            max-width: 620px;
            color: var(--color-text-body);
            font-size: 18px;
            font-weight: 400;
            line-height: 28px;
        }

        .readiness-callout {
            padding: 8px 12px;
            background: rgba(173, 247, 85, 0.20);
            border-radius: 12px;
            outline: 1px rgba(63, 105, 0, 0.20) solid;
            outline-offset: -1px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            align-self: flex-start;
            margin-top: 4px;
        }

        .readiness-text {
            color: var(--color-text-dark);
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
            letter-spacing: 0.14px;
        }

        .hero-checklist {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 4px;
        }

        .check-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .check-icon-circle {
            width: 20px;
            height: 20px;
            background: var(--color-bright-green);
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .check-item-text {
            color: var(--color-text-dark);
            font-size: 16px;
            font-weight: 500;
            line-height: 24px;
        }

        .hero-tags-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .hero-tag {
            padding: 6px 10px;
            background: rgba(255, 255, 255, 0.70);
            border-radius: 8px;
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: var(--color-text-dark);
        }

        /* Hero Right Form Card */
        .hero-form-card-glow {
            position: relative;
        }

        .glow-behind-card {
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            position: absolute;
            background: linear-gradient(54deg, rgba(63, 105, 0, 0.30) 0%, rgba(173, 247, 85, 0.20) 50%, rgba(173, 247, 85, 0) 100%);
            box-shadow: 40px 40px 40px rgba(0, 0, 0, 0.05);
            border-radius: 24px;
            filter: blur(20px);
            z-index: 1;
        }

        .hero-form-card {
            position: relative;
            z-index: 2;
            padding: 32px;
            background: white;
            border-radius: 24px;
            outline: 1px rgba(193, 200, 194, 0.60) solid;
            outline-offset: -1px;
            backdrop-filter: blur(12px);
            box-shadow: 0px 25px 50px -12px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .form-top-badge {
            padding: 4px 8px;
            background: rgba(171, 244, 83, 0.80);
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            align-self: flex-start;
        }

        .form-top-badge-text {
            color: #426E00;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 16px;
            letter-spacing: 0.60px;
        }

        .form-heading {
            color: var(--color-text-dark);
            font-size: 28px;
            font-family: var(--font-heading);
            font-weight: 700;
            line-height: 36px;
        }

        .form-subtext {
            color: var(--color-text-body);
            font-size: 14px;
            font-weight: 400;
            line-height: 22.75px;
        }

        .assessment-form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .form-row-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .form-label {
            color: var(--color-text-dark);
            font-size: 12px;
            font-weight: 600;
            line-height: 16px;
            letter-spacing: 0.24px;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 9px 10px;
            background: #D9FCE9;
            border: 1px solid var(--color-border);
            border-radius: 12px;
            color: var(--color-text-dark);
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 400;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-input::placeholder {
            color: #9CA3AF;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: var(--color-primary-green);
        }

        .form-submit-btn {
            width: 100%;
            padding: 14px 16px;
            background: var(--color-bg-dark);
            border-radius: 12px;
            border: none;
            color: white;
            font-size: 14px;
            font-family: var(--font-body);
            font-weight: 700;
            line-height: 20px;
            letter-spacing: 0.14px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 6px -4px rgba(0, 0, 0, 0.10), 0px 10px 15px -3px rgba(0, 0, 0, 0.10);
            transition: background 0.2s;
        }

        .form-submit-btn:hover {
            background: #113626;
        }

        .btn-arrow-box {
            width: 32px;
            height: 32px;
            background: var(--color-primary-green);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-footer-notes {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 4px;
            padding-top: 4px;
        }

        .form-note-item {
            display: flex;
            align-items: center;
            gap: 4px;
            color: var(--color-text-body);
            font-size: 11px;
            font-weight: 400;
            line-height: 18px;
        }

        .alert-box {
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
        }

        .alert-error {
            background: #FFDAD6;
            color: #93000A;
            border: 1px solid #BA1A1A;
        }

        .alert-success {
            background: #D9FCE9;
            color: #002013;
            border: 1px solid var(--color-primary-green);
        }

        /* Section Layouts Common */
        .section-wrapper {
            width: 100%;
            padding: 72px 40px;
            display: flex;
            justify-content: center;
        }

        .section-content {
            width: 100%;
            max-width: 1200px;
            padding: 0 48px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 32px;
        }

        .section-header-center {
            max-width: 768px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .section-tag {
            color: var(--color-primary-green);
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            line-height: 20px;
            letter-spacing: 1.40px;
        }

        .section-title {
            color: var(--color-text-dark);
            font-size: 40px;
            font-family: var(--font-heading);
            font-weight: 700;
            line-height: 48px;
        }

        .section-title-large {
            font-size: 56px;
            font-weight: 800;
            line-height: 64px;
        }

        .section-subtitle {
            color: var(--color-text-body);
            font-size: 18px;
            font-weight: 400;
            line-height: 28px;
        }

        /* Section 1 - The Problem */
        .bg-problem {
            background: var(--color-bg-mint);
        }

        .cards-grid-3 {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .card-problem {
            background: white;
            padding: 24px;
            border-radius: 24px;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 24px;
        }

        .card-icon-red {
            width: 48px;
            height: 48px;
            background: var(--color-red-bg);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-problem-title {
            color: var(--color-text-dark);
            font-size: 20px;
            font-family: var(--font-heading);
            font-weight: 600;
            line-height: 28px;
            margin-top: 8px;
        }

        .card-problem-desc {
            color: var(--color-text-body);
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            margin-top: 4px;
        }

        .card-red-badge {
            padding: 10px 12px;
            background: rgba(206, 240, 221, 0.40);
            border-radius: 12px;
            color: var(--color-red-alert);
            font-size: 14px;
            font-weight: 700;
            line-height: 20px;
        }

        .problem-quote-banner {
            width: 100%;
            padding: 32px;
            background: var(--color-bg-dark-card);
            box-shadow: 0px 4px 6px -4px rgba(0, 0, 0, 0.10), 0px 10px 15px -3px rgba(0, 0, 0, 0.10);
            border-radius: 24px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 8px;
        }

        .quote-title {
            color: white;
            font-size: 24px;
            font-family: var(--font-heading);
            font-weight: 700;
            line-height: 36px;
        }

        .quote-subtext {
            color: var(--color-text-card-dark);
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
        }

        /* Section 2 - The Solution */
        .bg-solution {
            background: var(--color-bg-light);
        }

        .pipeline-card {
            width: 100%;
            padding: 32px;
            background: var(--color-bg-mint);
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .pipeline-tag {
            text-align: center;
            color: var(--color-text-dark);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 16px;
            letter-spacing: 0.60px;
        }

        .pipeline-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .pipeline-step-card {
            padding: 20px 16px;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 6px;
        }

        .step-white {
            background: white;
        }

        .step-dark {
            background: var(--color-bg-dark-card);
            box-shadow: 0px 4px 6px -1px rgba(0, 0, 0, 0.10);
        }

        .step-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
        }

        .icon-box-light {
            background: #CEF0DD;
        }

        .icon-box-green {
            background: var(--color-primary-green);
        }

        .step-title {
            font-family: var(--font-heading);
            font-size: 20px;
            font-weight: 600;
            line-height: 28px;
        }

        .step-title.light {
            color: var(--color-text-dark);
        }

        .step-title.dark {
            color: white;
        }

        .step-subtitle {
            font-size: 14px;
            font-weight: 700;
            line-height: 20px;
            letter-spacing: 0.14px;
        }

        .step-subtitle.green {
            color: var(--color-text-body);
        }

        .step-subtitle.accent {
            color: var(--color-accent-lime);
        }

        .step-desc {
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
        }

        .step-desc.muted {
            color: var(--color-text-body);
        }

        .step-desc.subtle {
            color: var(--color-text-card-dark);
        }

        .cards-grid-4 {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .card-feature {
            background: white;
            padding: 24px;
            border-radius: 24px;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .feature-icon-box {
            width: 40px;
            height: 40px;
            background: #CEF0DD;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature-title {
            color: var(--color-text-dark);
            font-size: 20px;
            font-family: var(--font-heading);
            font-weight: 600;
            line-height: 28px;
        }

        .feature-desc {
            color: var(--color-text-body);
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
        }

        /* Section 3 - The Value */
        .bg-value {
            background: var(--color-bg-mint-light);
        }

        .metrics-grid-5 {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
        }

        .card-metric {
            background: white;
            padding: 30px 20px;
            border-radius: 24px;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 6px;
        }

        .metric-value {
            font-family: var(--font-heading);
            font-size: 36px;
            font-weight: 800;
            line-height: 40px;
        }

        .metric-value.green {
            color: var(--color-primary-green);
        }

        .metric-value.dark {
            color: var(--color-text-dark);
        }

        .metric-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 16px;
            letter-spacing: 0.60px;
        }

        .metric-label.green {
            color: var(--color-primary-green);
        }

        .metric-label.dark {
            color: var(--color-text-dark);
        }

        .metric-desc {
            color: var(--color-text-body);
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
        }

        .disclaimer-text {
            color: rgba(65, 72, 68, 0.80);
            font-size: 14px;
            font-style: italic;
            font-weight: 400;
            text-align: center;
        }

        /* Section 4 - Use Cases */
        .card-pathway {
            background: var(--color-bg-mint);
            padding: 24px;
            border-radius: 24px;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 24px;
        }

        .pathway-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pathway-number {
            color: var(--color-primary-green);
            font-size: 14px;
            font-weight: 700;
            line-height: 20px;
        }

        .pathway-footer {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--color-primary-green);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.24px;
            padding-top: 12px;
        }

        .quote-footer {
            color: var(--color-text-dark);
            font-family: var(--font-heading);
            font-size: 20px;
            font-style: italic;
            font-weight: 500;
            line-height: 28px;
            text-align: center;
        }

        /* Section 5 - Deployment Readiness */
        .bg-white {
            background: white;
        }

        .readiness-grid {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            align-items: center;
        }

        .readiness-left {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .card-enterprise-max {
            background: var(--color-bg-dark-card);
            box-shadow: 0px 20px 25px -5px rgba(0, 0, 0, 0.10);
            border-radius: 24px;
            padding: 32px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 16px;
            color: white;
        }

        .tier-badge {
            padding: 4px 8px;
            background: var(--color-primary-green);
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.24px;
            align-self: flex-start;
        }

        .enterprise-title {
            font-family: var(--font-heading);
            font-size: 28px;
            font-weight: 700;
            line-height: 36px;
        }

        .enterprise-desc {
            color: var(--color-text-card-dark);
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
        }

        .enterprise-checklist {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin: 8px 0;
        }

        .btn-enterprise-inquire {
            width: 100%;
            padding: 12px;
            background: var(--color-primary-green);
            border-radius: 12px;
            border: none;
            color: white;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-enterprise-inquire:hover {
            background: #315200;
        }

        /* Section 6 - Trust & CTA */
        .trust-grid-4 {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .trust-card {
            background: var(--color-bg-mint);
            padding: 16px;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 6px;
        }

        .trust-title {
            color: var(--color-text-dark);
            font-size: 16px;
            font-family: var(--font-heading);
            font-weight: 700;
            line-height: 24px;
        }

        .trust-desc {
            color: var(--color-text-body);
            font-size: 12px;
            font-weight: 600;
            line-height: 16px;
            letter-spacing: 0.24px;
        }

        .data-security-banner {
            width: 100%;
            padding: 32px;
            background: rgba(200, 234, 216, 0.60);
            border-radius: 24px;
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .security-icon-box {
            width: 64px;
            height: 64px;
            background: var(--color-primary-green);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .security-badge {
            padding: 8px 12px;
            background: white;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: var(--color-text-dark);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.24px;
            white-space: nowrap;
        }

        .hero-cta-card {
            width: 100%;
            padding: 96px 48px 72px 48px;
            background: linear-gradient(162deg, #002013 0%, #113626 50%, #002013 100%);
            box-shadow: 0px 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-radius: 24px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 24px;
            color: white;
        }

        .cta-title {
            color: white;
            font-size: 56px;
            font-family: var(--font-heading);
            font-weight: 800;
            line-height: 64px;
        }

        .cta-desc {
            color: var(--color-text-card-dark);
            font-size: 18px;
            font-weight: 400;
            line-height: 28px;
            max-width: 576px;
        }

        .cta-btn-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-cta-green {
            padding: 14px 32px;
            background: var(--color-primary-green);
            border-radius: 12px;
            color: white;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0px 4px 6px -4px rgba(0, 0, 0, 0.10);
            transition: background 0.2s;
        }

        .btn-cta-white {
            padding: 14px 32px;
            background: white;
            border-radius: 12px;
            color: var(--color-text-dark);
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            transition: background 0.2s;
        }

        .roadmap-box {
            width: 100%;
            max-width: 720px;
            padding: 24px 16px 16px 16px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            backdrop-filter: blur(2px);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .roadmap-tag {
            color: var(--color-accent-lime);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.60px;
        }

        .roadmap-steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .roadmap-step {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 600;
            color: white;
        }

        .step-num {
            width: 20px;
            height: 20px;
            background: var(--color-primary-green);
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
        }

        .roadmap-arrow {
            color: var(--color-text-card-dark);
            font-size: 14px;
        }

        .cta-bottom-tagline {
            color: var(--color-accent-lime);
            font-size: 20px;
            font-family: var(--font-heading);
            font-weight: 700;
            line-height: 28px;
        }

        /* Footer */
        .footer {
            width: 100%;
            background: white;
            border-top: 1px solid var(--color-border-nav);
            padding: 48px 0;
            display: flex;
            justify-content: center;
        }

        .footer-inner {
            width: 100%;
            max-width: 1280px;
            padding: 0 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
        }

        .footer-copyright {
            color: var(--color-text-subtle);
            font-size: 12px;
            font-family: var(--font-heading);
            font-weight: 400;
            line-height: 16px;
        }

        .footer-links {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .footer-links a {
            color: var(--color-text-subtle);
            font-size: 12px;
            font-family: var(--font-heading);
            font-weight: 400;
            text-decoration: none;
            transition: color 0.2s;
        }

        .slider-controls-mobile,
        .slider-btn,
        .mobile-sticky-footer-cta {
            display: none !important;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .hero-container {
                grid-template-columns: 1fr;
            }

            .hero-section {
                padding: 64px 32px;
            }

            .readiness-grid {
                grid-template-columns: 1fr;
            }

            .cards-grid-3 {
                grid-template-columns: 1fr;
            }

            .pipeline-steps {
                grid-template-columns: 1fr;
            }

            .cards-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }

            .metrics-grid-5 {
                grid-template-columns: repeat(3, 1fr);
            }

            .trust-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }

            .section-content {
                padding: 0;
            }
        }

        @media (max-width: 768px) {
            .header-inner {
                padding: 0 16px;
            }

            .header-actions {
                gap: 8px;
            }

            .btn-demo-nav {
                display: none !important;
            }

            .mobile-sticky-footer-cta {
                display: flex !important;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 999;
                background: rgba(255, 255, 255, 0.96);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                padding: 12px 16px;
                border-top: 1px solid rgba(0, 32, 19, 0.1);
                box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.12);
                justify-content: center;
                align-items: center;
            }

            .mobile-sticky-cta-btn {
                width: 100%;
                max-width: 400px;
                height: 48px;
                background: #064E3B;
                color: #FFFFFF;
                font-family: var(--font-heading);
                font-size: 16px;
                font-weight: 700;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                box-shadow: 0 4px 14px rgba(6, 78, 59, 0.3);
                transition: background 0.2s, transform 0.15s;
                -webkit-tap-highlight-color: transparent;
            }

            .mobile-sticky-cta-btn:active {
                transform: scale(0.97);
                background: #04392b;
            }

            body {
                padding-bottom: 72px;
            }

            .nav-links {
                display: none;
            }

            .nav-links.mobile-open {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 80px;
                left: 0;
                width: 100%;
                background: white;
                padding: 24px;
                gap: 16px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                border-bottom: 1px solid var(--color-border-nav);
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero-title,
            .section-title-large,
            .cta-title {
                font-size: 32px;
                line-height: 40px;
            }

            .section-title {
                font-size: 26px;
                line-height: 34px;
            }

            .hero-section {
                padding: 36px 16px;
            }

            .hero-form-card {
                padding: 20px 16px;
            }

            .form-heading {
                font-size: 22px;
                line-height: 28px;
            }

            .form-submit-btn {
                font-size: 13px;
                padding: 12px 14px;
            }

            .form-footer-notes {
                flex-wrap: wrap;
                gap: 8px;
                justify-content: center;
            }

            .section-wrapper {
                padding: 40px 16px;
            }

            .slider-wrapper-mobile {
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
                width: 100%;
            }

            .slider-controls-mobile {
                display: flex !important;
                align-items: center;
                justify-content: center;
                gap: 16px;
                margin-top: 16px;
                width: 100%;
            }

            .slider-btn {
                display: flex !important;
                position: static !important;
                transform: none !important;
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: #FFFFFF;
                border: 1.5px solid rgba(0, 32, 19, 0.15);
                color: #002013;
                font-size: 22px;
                font-weight: 800;
                line-height: 1;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
                user-select: none;
                -webkit-tap-highlight-color: transparent;
            }

            .slider-btn:active {
                transform: scale(0.92) !important;
                background: var(--color-bg-mint);
            }

            .cards-grid-3,
            .cards-grid-4,
            .pipeline-steps {
                display: flex !important;
                overflow-x: auto !important;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scroll-behavior: smooth;
                padding-bottom: 8px;
                gap: 16px !important;
                width: 100%;
                scrollbar-width: none;
            }

            .cards-grid-3::-webkit-scrollbar,
            .cards-grid-4::-webkit-scrollbar,
            .pipeline-steps::-webkit-scrollbar {
                display: none;
            }

            .cards-grid-3>*,
            .cards-grid-4>*,
            .pipeline-steps>* {
                flex: 0 0 85% !important;
                max-width: 320px;
                scroll-snap-align: center;
            }

            .metrics-grid-5,
            .trust-grid-4 {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px !important;
                width: 100%;
            }

            .metrics-grid-5>*,
            .trust-grid-4>* {
                flex: unset !important;
                max-width: 100% !important;
            }

            .metrics-grid-5>*:last-child {
                grid-column: span 2;
            }

            .form-row-2col {
                grid-template-columns: 1fr;
            }

            .cta-btn-group {
                flex-direction: column;
                width: 100%;
            }

            .btn-cta-green,
            .btn-cta-white {
                width: 100%;
                justify-content: center;
            }

            .roadmap-box {
                padding: 16px 12px;
            }

            .roadmap-steps {
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }

            .roadmap-arrow {
                display: none;
            }

            .data-security-banner {
                flex-direction: column;
                text-align: center;
                padding: 20px 16px;
            }

            .footer-inner {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 16px;
            }
        }
    </style>
</head>

<body>

    <!-- Header / Navbar -->
    <header class="header">
        <div class="header-inner">
            <a href="#">
                <img src="images/logo-opsole.svg" alt="Opsole Logo" class="brand-logo-img">
            </a>

            <nav>
                <ul class="nav-links" id="navLinks">
                    <li><a href="#problem">The Problem</a></li>
                    <li><a href="#solution">Solution</a></li>
                    <li><a href="#metrics">Metrics</a></li>
                    <li><a href="#use-cases">Use Cases</a></li>
                    <li><a href="#security">Security</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <a href="#assessment" class="btn-demo-nav">Book a Demo</a>

                <button class="mobile-menu-btn" onclick="toggleMobileMenu()" aria-label="Toggle menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#002013" stroke-width="2">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="glow-circle-1"></div>
        <div class="glow-circle-2"></div>

        <div class="hero-container">
            <!-- Left Copy -->
            <div class="hero-left">
                <div class="pill-badge">
                    <span class="dot-green"></span>
                    <span class="pill-badge-text">ZERO-WIPE MIGRATION TECHNOLOGY</span>
                </div>

                <h1 class="hero-title">
                    Move to Microsoft Entra ID <span class="highlight">Without the Wipe &</span> <span
                        class="highlight">Load.</span>
                </h1>

                <p class="hero-description">
                    Migrate Windows 10/11 devices from Active Directory or Hybrid Join to native Microsoft Entra ID in
                    5–6 minutes per device without wiping the device or rebuilding the user's existing environment.
                </p>

                <div class="readiness-callout">
                    <img src="icons/Icon-25.svg" alt="Check" width="13" height="13">
                    <span class="readiness-text">Complete the form to claim your readiness audit</span>
                </div>

                <div class="hero-checklist">
                    <div class="check-item">
                        <div class="check-icon-circle">
                            <img src="icons/Icon-23.svg" alt="Check" width="9" height="9">
                        </div>
                        <span class="check-item-text">Live 5-minute in-place conversion test</span>
                    </div>
                    <div class="check-item">
                        <div class="check-icon-circle">
                            <img src="icons/Icon-23.svg" alt="Check" width="9" height="9">
                        </div>
                        <span class="check-item-text">Comprehensive device readiness assessment</span>
                    </div>
                    <div class="check-item">
                        <div class="check-icon-circle">
                            <img src="icons/Icon-23.svg" alt="Check" width="9" height="9">
                        </div>
                        <span class="check-item-text">Custom ROI & migration roadmap</span>
                    </div>
                </div>

                <div class="hero-tags-row">
                    <div class="hero-tag">
                        <img src="icons/Icon-21.svg" alt="Icon" width="11" height="13">
                        5–6 Minutes per Device
                    </div>
                    <div class="hero-tag">
                        <img src="icons/Icon-20.svg" alt="Icon" width="12" height="12">
                        In-Place Migration
                    </div>
                    <div class="hero-tag">
                        <img src="icons/Icon-19.svg" alt="Icon" width="16" height="11">
                        Remote Ready
                    </div>
                    <div class="hero-tag">
                        <img src="icons/Icon-34.svg" alt="Icon" width="14" height="14">
                        No VPN Required
                    </div>
                </div>
            </div>

            <!-- Right Assessment Form -->
            <div class="hero-form-card-glow" id="assessment">
                <div class="glow-behind-card"></div>
                <div class="hero-form-card">
                    <div class="form-top-badge">
                        <img src="icons/Icon-35.svg" alt="Badge Icon" width="10" height="13">
                        <span class="form-top-badge-text">FREE ENTERPRISE ASSESSMENT</span>
                    </div>

                    <h2 class="form-heading">Experience Zero-Wipe<br>Migration</h2>
                    <p class="form-subtext">Get a live 15-minute migration demo and personalized Entra ID readiness
                        report for your fleet.</p>

                    <?php if ($formSubmitted): ?>
                        <?php if ($formSuccess): ?>
                            <div class="alert-box alert-success">
                                Thank you, <?= htmlspecialchars($fullName) ?>! Your assessment request has been received. Our
                                team will contact you shortly at <?= htmlspecialchars($workEmail) ?>.
                            </div>
                        <?php else: ?>
                            <div class="alert-box alert-error">
                                <?= htmlspecialchars($errorMessage) ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form action="#assessment" method="POST" class="assessment-form">
                        <input type="hidden" name="action" value="assessment">

                        <div class="form-row-2col">
                            <div class="form-group">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="full_name" class="form-input" placeholder="Sarah Jenkins"
                                    value="<?= htmlspecialchars($fullName) ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Work Email *</label>
                                <input type="email" name="work_email" class="form-input"
                                    placeholder="s.jenkins@company.com" value="<?= htmlspecialchars($workEmail) ?>"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Company Name *</label>
                            <input type="text" name="company_name" class="form-input"
                                placeholder="Acme Corp / Global Logistics" value="<?= htmlspecialchars($companyName) ?>"
                                required>
                        </div>

                        <div class="form-row-2col">
                            <div class="form-group">
                                <label class="form-label">Windows Fleet Size</label>
                                <select name="fleet_size" class="form-select">
                                    <option value="50–250 devices" <?= $fleetSize === '50–250 devices' ? 'selected' : '' ?>>50–250 devices</option>
                                    <option value="250–1,000 devices" <?= $fleetSize === '250–1,000 devices' ? 'selected' : '' ?>>250–1,000 devices</option>
                                    <option value="1,000–5,000 devices" <?= $fleetSize === '1,000–5,000 devices' ? 'selected' : '' ?>>1,000–5,000 devices</option>
                                    <option value="5,000+ devices" <?= $fleetSize === '5,000+ devices' ? 'selected' : '' ?>>5,000+ devices</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Current Identity Setup</label>
                                <select name="identity_setup" class="form-select">
                                    <option value="Active Directory / Hybrid Join" <?= $identitySetup === 'Active Directory / Hybrid Join' ? 'selected' : '' ?>>Active Directory / Hybrid Join</option>
                                    <option value="On-Premises AD Only" <?= $identitySetup === 'On-Premises AD Only' ? 'selected' : '' ?>>On-Premises AD Only</option>
                                    <option value="Multi-Tenant Entra ID" <?= $identitySetup === 'Multi-Tenant Entra ID' ? 'selected' : '' ?>>Multi-Tenant Entra ID</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="form-submit-btn">
                            <span>Get Free Assessment & Live Demo</span>
                            <div class="btn-arrow-box">
                                <img src="icons/Icon-1.svg" alt="Arrow" width="12" height="12">
                            </div>
                        </button>
                    </form>

                    <div class="form-footer-notes">
                        <div class="form-note-item">
                            <img src="icons/Icon-30.svg" alt="Note Icon" width="12" height="12">
                            <span>No credit card required</span>
                        </div>
                        <div class="form-note-item">
                            <img src="icons/Icon-30.svg" alt="Note Icon" width="12" height="12">
                            <span>5-minute live pilot</span>
                        </div>
                        <div class="form-note-item">
                            <img src="icons/Icon-28.svg" alt="Security Icon" width="13" height="12">
                            <span>SOC 2 & ISO 27001</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 1: The Problem -->
    <section class="section-wrapper bg-problem" id="problem">
        <div class="section-content">
            <div class="section-header-center">
                <!-- <span class="section-tag">THE PROBLEM</span> -->
                <h2 class="section-title">Why Turn a Migration into a Rebuild?</h2>
                <p class="section-subtitle">
                    Moving to Entra ID shouldn’t mean starting over. Traditional migration can take 5–6 hours per
                    device, adding IT workload and employee disruption.
                </p>
            </div>

            <div class="slider-wrapper-mobile">
                <div class="cards-grid-3" id="problem-slider">
                    <!-- Card 1 -->
                    <div class="card-problem">
                        <div>
                            <div class="card-icon-red">
                                <img src="icons/Icon-18.svg" alt="Hours Icon" width="23" height="23">
                            </div>
                            <h3 class="card-problem-title">Hours of IT & Employee Time</h3>
                            <p class="card-problem-desc">
                                Traditional migration requires significant IT effort and employee downtime for each
                                device.
                            </p>
                        </div>
                        <div class="card-red-badge">
                            5 to 6 hrs / workstation lost
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="card-problem">
                        <div>
                            <div class="card-icon-red">
                                <img src="icons/Icon-17.svg" alt="Disruption Icon" width="22" height="17">
                            </div>
                            <h3 class="card-problem-title">Disrupted User Experience</h3>
                            <p class="card-problem-desc">
                                Wipes and rebuilds can affect local files, application settings, Outlook profiles,
                                browser
                                profiles and user preferences.
                            </p>
                        </div>
                        <div class="card-red-badge">
                            High helpdesk ticket surge
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="card-problem">
                        <div>
                            <div class="card-icon-red">
                                <img src="icons/Icon-16.svg" alt="Remote Icon" width="23" height="23">
                            </div>
                            <h3 class="card-problem-title">Remote Workforce Challenges</h3>
                            <p class="card-problem-desc">
                                Remote devices make traditional migration more difficult, especially when devices need
                                access to on-premises infrastructure.
                            </p>
                        </div>
                        <div class="card-red-badge">
                            Complex shipping & DC line-of-sight
                        </div>
                    </div>
                </div>

                <div class="slider-controls-mobile">
                    <button type="button" class="slider-btn btn-prev" onclick="scrollSlider('problem-slider', -1)"
                        aria-label="Previous">‹</button>
                    <button type="button" class="slider-btn btn-next" onclick="scrollSlider('problem-slider', 1)"
                        aria-label="Next">›</button>
                </div>
            </div>

            <!-- Quote Banner -->
            <div class="problem-quote-banner">
                <h3 class="quote-title">“What if you could change the device identity without rebuilding the device?”
                </h3>
                <p class="quote-subtext">Opsole eliminates OS wipes, preserving the exact workspace your employees rely
                    on every day.</p>
            </div>
        </div>
    </section>

    <!-- Section 2: The Solution -->
    <section class="section-wrapper bg-solution" id="solution">
        <div class="section-content">
            <div class="section-header-center">
                <!-- <span class="section-tag">THE SOLUTION</span> -->
                <h2 class="section-title section-title-large">Convert. Don't Rebuild.</h2>
                <p class="section-subtitle">
                    Opsole converts supported Windows devices from Active Directory or Hybrid Join to native Microsoft
                    Entra ID in place.
                </p>
            </div>

            <!-- Pipeline Diagram -->
            <div class="pipeline-card">
                <div class="pipeline-tag">AUTOMATED DEVICE PIPELINE • 5–6 MINUTES CUTOVER</div>
                <div class="slider-wrapper-mobile">
                    <div class="pipeline-steps" id="pipeline-slider">
                        <!-- Source State -->
                        <div class="pipeline-step-card step-white">
                            <div class="step-icon-box icon-box-light">
                                <img src="icons/Icon-15.svg" alt="Source State Icon" width="18" height="19">
                            </div>
                            <h4 class="step-title light">Source State</h4>
                            <div class="step-subtitle green">Active Directory / Hybrid Joined</div>
                            <p class="step-desc muted">Bound to legacy on-prem DC or Hybrid Sync</p>
                        </div>

                        <!-- Opsole Migrate -->
                        <div class="pipeline-step-card step-dark">
                            <div class="step-icon-box icon-box-green">
                                <img src="icons/Icon-14.svg" alt="Opsole Migrate Icon" width="17" height="24">
                            </div>
                            <h4 class="step-title dark">Opsole Migrate</h4>
                            <div class="step-subtitle accent">5–6 Mins In-Place Conversion</div>
                            <p class="step-desc subtle">Zero wiping • Zero profile relocation</p>
                        </div>

                        <!-- Target State -->
                        <div class="pipeline-step-card step-white">
                            <div class="step-icon-box icon-box-light">
                                <img src="icons/Icon-12.svg" alt="Target State Icon" width="22" height="21">
                            </div>
                            <h4 class="step-title light">Target State</h4>
                            <div class="step-subtitle green">Microsoft Entra ID Joined</div>
                            <p class="step-desc muted">Intune Autopilot ready • Cloud native</p>
                        </div>
                    </div>

                    <div class="slider-controls-mobile">
                        <button type="button" class="slider-btn btn-prev" onclick="scrollSlider('pipeline-slider', -1)"
                            aria-label="Previous">‹</button>
                        <button type="button" class="slider-btn btn-next" onclick="scrollSlider('pipeline-slider', 1)"
                            aria-label="Next">›</button>
                    </div>
                </div>
            </div>

            <!-- 4 Features Grid -->
            <div class="slider-wrapper-mobile">
                <div class="cards-grid-4" id="features-slider">
                    <div class="card-feature">
                        <div class="feature-icon-box">
                            <img src="icons/Icon-32.svg" alt="Feature Icon" width="14" height="20">
                        </div>
                        <h3 class="feature-title">No Wipe & Load</h3>
                        <p class="feature-desc">Convert the device without wiping, reinstalling the OS, or resetting the
                            hardware.</p>
                    </div>

                    <div class="card-feature">
                        <div class="feature-icon-box">
                            <img src="icons/Icon-11.svg" alt="Feature Icon" width="17" height="17">
                        </div>
                        <h3 class="feature-title">Preserve the User Environment</h3>
                        <p class="feature-desc">Keep user profiles, files, installed desktop software, and Outlook
                            profiles
                            intact.</p>
                    </div>

                    <div class="card-feature">
                        <div class="feature-icon-box">
                            <img src="icons/Icon-31.svg" alt="Feature Icon" width="18" height="16">
                        </div>
                        <h3 class="feature-title">Migrate From Anywhere</h3>
                        <p class="feature-desc">Support remote employees using a standard internet connection without
                            requiring VPN or line-of-sight to on-premises Domain Controllers.</p>
                    </div>

                    <div class="card-feature">
                        <div class="feature-icon-box">
                            <img src="icons/Icon-24.svg" alt="Feature Icon" width="20" height="15">
                        </div>
                        <h3 class="feature-title">Agentless Architecture</h3>
                        <p class="feature-desc">Manage migration through a cloud-based SaaS model without persistent
                            agents
                            to deploy, update, patch or secure.</p>
                    </div>
                </div>

                <div class="slider-controls-mobile">
                    <button type="button" class="slider-btn btn-prev" onclick="scrollSlider('features-slider', -1)"
                        aria-label="Previous">‹</button>
                    <button type="button" class="slider-btn btn-next" onclick="scrollSlider('features-slider', 1)"
                        aria-label="Next">›</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: The Value -->
    <section class="section-wrapper bg-value" id="metrics">
        <div class="section-content">
            <div class="section-header-center">
                <!-- <span class="section-tag">THE VALUE</span> -->
                <h2 class="section-title">Less Time Migrating. More Time Managing IT.</h2>
                <p class="section-subtitle">
                    From individual devices to large-scale rollouts, Opsole helps make Entra ID migration faster and
                    easier to manage.
                </p>
            </div>

            <div class="metrics-grid-5">
                <div class="card-metric">
                    <span class="metric-value green">5–6</span>
                    <span class="metric-label dark">MINUTES</span>
                    <p class="metric-desc">Per-device migration</p>
                </div>
                <div class="card-metric">
                    <span class="metric-value dark">87%</span>
                    <span class="metric-label green">REDUCTION</span>
                    <p class="metric-desc">In lost user productivity</p>
                </div>
                <div class="card-metric">
                    <span class="metric-value green">80%+</span>
                    <span class="metric-label dark">SAVINGS</span>
                    <p class="metric-desc">Potential direct cost reduction</p>
                </div>
                <div class="card-metric">
                    <span class="metric-value dark">20 → 6</span>
                    <span class="metric-label green">WEEKS</span>
                    <p class="metric-desc">Potential project acceleration</p>
                </div>
                <div class="card-metric">
                    <span class="metric-value green">96%</span>
                    <span class="metric-label dark">SATISFACTION</span>
                    <p class="metric-desc">Positive employee experience</p>
                </div>
            </div>

            <p class="disclaimer-text">*Results may vary based on environment, device configuration and deployment
                conditions.</p>
        </div>
    </section>

    <!-- Section 4: Use Cases -->
    <section class="section-wrapper bg-solution" id="use-cases">
        <div class="section-content">
            <div class="section-header-center">
                <!-- <span class="section-tag">USE CASES</span> -->
                <h2 class="section-title">One Solution. Three Migration Paths.</h2>
                <p class="section-subtitle">
                    Comprehensive coverage for all legacy Windows enterprise transition scenarios.
                </p>
            </div>

            <div class="slider-wrapper-mobile">
                <div class="cards-grid-3" id="usecases-slider">
                    <!-- Pathway 1 -->
                    <div class="card-pathway">
                        <div>
                            <div class="pathway-top">
                                <span class="pathway-number">PATHWAY 01</span>
                                <img src="icons/Icon-10.svg" alt="Pathway Icon" width="18" height="18">
                            </div>
                            <h3 class="card-problem-title">AD Joined → Entra ID Joined</h3>
                            <p class="card-problem-desc">Move AD-joined Windows devices to native Entra ID without
                                wiping or
                                rebuilding.</p>
                        </div>
                        <div class="pathway-footer">
                            <span>Direct on-prem decoupler</span>
                            <img src="icons/Icon-13.svg" alt="Check Icon" width="13" height="13">
                        </div>
                    </div>

                    <!-- Pathway 2 -->
                    <div class="card-pathway">
                        <div>
                            <div class="pathway-top">
                                <span class="pathway-number">PATHWAY 02</span>
                                <img src="icons/Icon-27.svg" alt="Pathway Icon" width="24" height="23">
                            </div>
                            <h3 class="card-problem-title">Hybrid Joined → Entra ID Joined</h3>
                            <p class="card-problem-desc">Transition Hybrid joined devices to native Entra ID while
                                preserving the user environment.</p>
                        </div>
                        <div class="pathway-footer">
                            <span>Clean hybrid detachment</span>
                            <img src="icons/Icon-13.svg" alt="Check Icon" width="13" height="13">
                        </div>
                    </div>

                    <!-- Pathway 3 -->
                    <div class="card-pathway">
                        <div>
                            <div class="pathway-top">
                                <span class="pathway-number">PATHWAY 03</span>
                                <img src="icons/Icon-9.svg" alt="Pathway Icon" width="22" height="20">
                            </div>
                            <h3 class="card-problem-title">Entra ID Tenant → Entra ID Tenant</h3>
                            <p class="card-problem-desc">Move Entra ID joined devices from one tenant to another without
                                rebuilding.</p>
                        </div>
                        <div class="pathway-footer">
                            <span>Ideal for M&A consolidations</span>
                            <img src="icons/Icon-13.svg" alt="Check Icon" width="13" height="13">
                        </div>
                    </div>
                </div>

                <div class="slider-controls-mobile">
                    <button type="button" class="slider-btn btn-prev" onclick="scrollSlider('usecases-slider', -1)"
                        aria-label="Previous">‹</button>
                    <button type="button" class="slider-btn btn-next" onclick="scrollSlider('usecases-slider', 1)"
                        aria-label="Next">›</button>
                </div>
            </div>

            <p class="quote-footer">“Whatever your migration path, start with the devices you already have.”</p>
        </div>
    </section>

    <!-- Section 5: Deployment Readiness -->
    <section class="section-wrapper bg-white">
        <div class="section-content">
            <div class="readiness-grid">
                <!-- Left -->
                <div class="readiness-left">
                    <span class="section-tag">DEPLOYMENT READINESS</span>
                    <h2 class="section-title">Choose the Support That Fits Your Rollout.</h2>
                    <p class="section-subtitle">
                        For organizations that need additional support during deployment, Enterprise Max provides
                        end-to-end assistance from setup to rollout.
                    </p>
                    <div class="hero-checklist" style="margin-top: 16px;">
                        <div class="check-item">
                            <div class="check-icon-circle">
                                <img src="icons/Icon-8.svg" alt="Check" width="11" height="8">
                            </div>
                            <span class="check-item-text">Dedicated migration architects and assigned Microsoft
                                specialists</span>
                        </div>
                        <div class="check-item">
                            <div class="check-icon-circle">
                                <img src="icons/Icon-8.svg" alt="Check" width="11" height="8">
                            </div>
                            <span class="check-item-text">Custom cutover runbooks tailored for security &
                                compliance</span>
                        </div>
                    </div>
                </div>

                <!-- Right Card -->
                <div class="card-enterprise-max">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="tier-badge">
                            <img src="icons/Icon-1.svg" alt="Star" width="12" height="11">
                            TIER 1 ENTERPRISE
                        </div>
                        <img src="icons/Icon-5.svg" alt="Enterprise Star" width="29" height="28">
                    </div>

                    <h3 class="enterprise-title">Enterprise Max</h3>
                    <p class="enterprise-desc">White-glove rollout engineering and 24/7 dedicated support for complex
                        enterprise environments.</p>

                    <div class="enterprise-checklist">
                        <div class="check-item">
                            <img src="icons/Icon-4.svg" alt="Check" width="17" height="17">
                            <span>Full Opsole Migrate License</span>
                        </div>
                        <div class="check-item">
                            <img src="icons/Icon-4.svg" alt="Check" width="17" height="17">
                            <span>24/7 Email & Remote Support</span>
                        </div>
                        <div class="check-item">
                            <img src="icons/Icon-4.svg" alt="Check" width="17" height="17">
                            <span>Full Admin Training</span>
                        </div>
                        <div class="check-item">
                            <img src="icons/Icon-4.svg" alt="Check" width="17" height="17">
                            <span>Hands-On Rollout Guidance</span>
                        </div>
                    </div>

                    <a href="#assessment" class="btn-enterprise-inquire">
                        <span>Inquire About Enterprise Max</span>
                        <img src="icons/Icon-33.svg" alt="Arrow" width="12" height="12">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 6: Trust & CTA -->
    <section class="section-wrapper bg-solution" id="security">
        <div class="section-content">
            <div class="section-header-center">
                <!-- <span class="section-tag">TRUST + CTA</span> -->
                <h2 class="section-title">Enterprise-Ready Migration. Built for Modern IT.</h2>
                <p class="section-subtitle">
                    Opsole helps organizations modernize device identity while keeping migration controlled, secure and
                    minimally disruptive.
                </p>
            </div>

            <!-- Trust Badges Grid -->
            <div class="trust-grid-4">
                <div class="trust-card">
                    <img src="icons/Icon-26.svg" alt="Microsoft Partner" width="29" height="28">
                    <h4 class="trust-title">Microsoft Partner</h4>
                    <span class="trust-desc">Validated Cloud Solutions</span>
                </div>
                <div class="trust-card">
                    <img src="icons/Icon-22.svg" alt="SOC 2" width="21" height="27">
                    <h4 class="trust-title">SOC 2 Compliant</h4>
                    <span class="trust-desc">Type II Certified Architecture</span>
                </div>
                <div class="trust-card">
                    <img src="icons/Icon-3.svg" alt="ISO 27001" width="21" height="28">
                    <h4 class="trust-title">ISO 27001:2022</h4>
                    <span class="trust-desc">Information Security Mgmt</span>
                </div>
                <div class="trust-card">
                    <img src="icons/Icon-7.svg" alt="ISO 9001" width="21" height="28">
                    <h4 class="trust-title">ISO 9001:2015</h4>
                    <span class="trust-desc">Quality Management Process</span>
                </div>
            </div>

            <!-- Data Security Banner -->
            <div class="data-security-banner">
                <div class="security-icon-box">
                    <img src="icons/Icon-6.svg" alt="Shield Icon" width="24" height="30">
                </div>
                <div style="flex: 1;">
                    <h3 class="feature-title">Your Data Stays on the Device.</h3>
                    <p class="feature-desc">With Opsole's zero-copy approach, data never leaves the local disk.
                        Permissions are updated locally during migration.</p>
                </div>
                <div class="security-badge">
                    <img src="icons/Icon.svg" alt="Transfer Icon" width="15" height="15">
                    <span>Zero Local Data Transfer</span>
                </div>
            </div>

            <!-- Final Hero CTA Block -->
            <div class="hero-cta-card">
                <h2 class="cta-title">Ready to Leave Wipe & Load<br>Behind?</h2>
                <p class="cta-desc">Move your Windows devices to Microsoft Entra ID in 5–6 minutes per device.</p>

                <div class="cta-btn-group">
                    <a href="#assessment" class="btn-cta-green">
                        <span>Book a Live Demo</span>
                        <img src="icons/Icon-13.svg" alt="Arrow" width="13" height="13">
                    </a>
                    <a href="#assessment" class="btn-cta-white">
                        <img src="icons/Icon.svg" alt="Check Icon" width="17" height="17">
                        <span>Start a Readiness Review</span>
                    </a>
                </div>

                <!-- Roadmap Box -->
                <div class="roadmap-box">
                    <span class="roadmap-tag">IMPLEMENTATION ROADMAP</span>
                    <div class="roadmap-steps">
                        <div class="roadmap-step">
                            <span class="step-num">1</span>
                            <span>Demo</span>
                        </div>
                        <span class="roadmap-arrow">→</span>
                        <div class="roadmap-step">
                            <span class="step-num">2</span>
                            <span>Readiness Review</span>
                        </div>
                        <span class="roadmap-arrow">→</span>
                        <div class="roadmap-step">
                            <span class="step-num">3</span>
                            <span>10–20 Device Pilot</span>
                        </div>
                        <span class="roadmap-arrow">→</span>
                        <div class="roadmap-step">
                            <span class="step-num">4</span>
                            <span>Production Rollout</span>
                        </div>
                    </div>
                </div>

                <div class="cta-bottom-tagline">Migrate faster. Disrupt less. Modernize with confidence.</div>
                <p class="disclaimer-text" style="color: rgba(122, 160, 139, 0.80); max-width: 512px;">
                    Supports Windows 10/11 and Microsoft Entra ID / Microsoft 365 environments. Contact us to confirm
                    compatibility.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <a href="#">
                <img src="images/logo-opsole.svg" alt="Opsole Logo" class="brand-logo-img" style="height:36px;">
            </a>

            <div class="footer-copyright">
                © 2026 Opsole Inc. All rights reserved. Microsoft and Entra ID are registered trademarks of Microsoft
                Corporation.
            </div>

            <div class="footer-links">
                <a href="https://opsole.com/privacy-policy/" target="_blank" rel="noopener noreferrer">Privacy
                    Policy</a>
                <a href="https://opsole.com/terms-of-use/" target="_blank" rel="noopener noreferrer">Terms of
                    Service</a>
                <!-- <a href="#" target="_blank" rel="noopener noreferrer">Contact IT Support</a> -->
            </div>
        </div>
    </footer>

    <!-- Mobile Sticky Footer CTA Bar -->
    <div class="mobile-sticky-footer-cta">
        <a href="#assessment" class="mobile-sticky-cta-btn">Book a Demo</a>
    </div>

    <script>
        function toggleMobileMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('mobile-open');
        }

        function scrollSlider(id, direction) {
            const container = document.getElementById(id);
            if (!container) return;
            const card = container.firstElementChild;
            const scrollAmount = card ? card.offsetWidth + 16 : 280;
            container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>