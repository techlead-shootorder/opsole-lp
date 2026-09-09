<?php
/*
Template Name: Thank You
Template Post Type: page
*/

require_once __DIR__ . '/inc/dynamics-lead.php';

$name = isset($_GET['name']) ? trim(strip_tags($_GET['name'])) : '';
$email = isset($_GET['email']) ? trim(strip_tags($_GET['email'])) : '';
$displayName = !empty($name) ? htmlspecialchars($name, ENT_QUOTES, 'UTF-8') : '';
$displayEmail = !empty($email) ? htmlspecialchars($email, ENT_QUOTES, 'UTF-8') : '';

$themeUri = function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.';
$campaignUrl = opsole_get_campaign_url();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-MWSC2QQV');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Opsole Zero-Wipe Migration</title>
    <meta name="description"
        content="Thank you for requesting your Zero-Wipe Entra ID Migration Assessment. Our team will contact you shortly.">
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
            --color-border: #C1C8C2;
            --color-border-nav: #E2E8F0;
            --font-heading: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
            font-family: var(--font-body);
            background-color: var(--color-bg-light);
            color: var(--color-text-dark);
            -webkit-font-smoothing: antialiased;
        }

        body {
            width: 100%;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        /* Header / Navbar */
        .header {
            position: sticky;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid var(--color-border-nav);
            backdrop-filter: blur(4px);
            z-index: 100;
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
            height: 40px;
            width: auto;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 32px;
        }

        .nav-links a {
            color: var(--color-text-body);
            font-size: 14px;
            font-family: var(--font-heading);
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
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

        /* Hero / Thank You Section */
        .thankyou-section {
            width: 100%;
            flex: 1;
            background: linear-gradient(180deg, #F0F7E8 0%, #E7F4DC 50%, #E7FFF1 100%);
            padding: 80px 24px;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .glow-circle-1 {
            width: 608px;
            height: 608px;
            right: -50px;
            top: -74px;
            position: absolute;
            background: radial-gradient(circle, rgba(171, 244, 83, 0.25) 0%, rgba(231, 255, 241, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .glow-circle-2 {
            width: 608px;
            height: 608px;
            left: -100px;
            bottom: -100px;
            position: absolute;
            background: radial-gradient(circle, rgba(171, 244, 83, 0.20) 0%, rgba(231, 255, 241, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .thankyou-container {
            width: 100%;
            max-width: 800px;
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        /* Thank You Card */
        .thankyou-card {
            background: white;
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0px 20px 25px -5px rgba(0, 0, 0, 0.08), 0px 8px 10px -6px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(193, 200, 194, 0.5);
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 24px;
        }

        .success-icon-badge {
            width: 72px;
            height: 72px;
            background: #D9FCE9;
            border: 2px solid #ABF453;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            box-shadow: 0 8px 20px rgba(6, 78, 59, 0.12);
        }

        .success-icon-badge svg {
            width: 36px;
            height: 36px;
            color: #064E3B;
        }

        .thankyou-badge {
            padding: 6px 16px;
            background: var(--color-bg-mint);
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .thankyou-badge-text {
            color: var(--color-primary-green);
            font-size: 13px;
            font-family: var(--font-heading);
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .thankyou-heading {
            color: var(--color-text-dark);
            font-size: 36px;
            font-family: var(--font-heading);
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.5px;
        }

        .thankyou-heading span {
            color: var(--color-primary-green);
        }

        .thankyou-subtext {
            color: var(--color-text-body);
            font-size: 16px;
            font-family: var(--font-body);
            line-height: 1.6;
            max-width: 620px;
        }

        .user-email-highlight {
            color: var(--color-primary-green);
            font-weight: 700;
        }

        /* Next Steps Timeline Box */
        .steps-box {
            width: 100%;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 28px;
            margin-top: 8px;
            text-align: left;
        }

        .steps-header {
            font-family: var(--font-heading);
            font-size: 16px;
            font-weight: 700;
            color: var(--color-text-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .steps-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .step-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #064E3B;
            color: #FFFFFF;
            font-family: var(--font-heading);
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .step-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .step-title {
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 700;
            color: var(--color-text-dark);
        }

        .step-desc {
            font-family: var(--font-body);
            font-size: 14px;
            color: var(--color-text-muted);
            line-height: 1.5;
        }

        /* Action Buttons */
        .btn-group-thankyou {
            display: flex;
            gap: 16px;
            margin-top: 12px;
            width: 100%;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary-thankyou {
            padding: 14px 28px;
            background: #064E3B;
            color: white;
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 700;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.25);
            transition: background 0.2s, transform 0.15s;
        }

        .btn-primary-thankyou:hover {
            background: #04392b;
            transform: translateY(-1px);
        }

        .btn-secondary-thankyou {
            padding: 14px 28px;
            background: #FFFFFF;
            border: 1.5px solid var(--color-border);
            color: var(--color-text-dark);
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: border-color 0.2s, background 0.2s;
        }

        .btn-secondary-thankyou:hover {
            border-color: var(--color-primary-green);
            background: var(--color-bg-mint-light);
        }

        /* Footer */
        .footer {
            width: 100%;
            background: var(--color-bg-dark);
            padding: 40px 32px;
            display: flex;
            justify-content: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-inner {
            width: 100%;
            max-width: 1280px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-copyright {
            color: var(--color-text-card-dark);
            font-size: 13px;
            font-family: var(--font-body);
        }

        .footer-links {
            display: flex;
            gap: 24px;
        }

        .footer-links a {
            color: var(--color-text-card-dark);
            font-size: 13px;
            font-family: var(--font-heading);
            font-weight: 400;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--color-bright-green);
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            .header-inner {
                padding: 0 16px;
            }

            .nav-links {
                display: none;
            }

            .thankyou-section {
                padding: 48px 16px;
            }

            .thankyou-card {
                padding: 32px 20px;
                gap: 20px;
            }

            .thankyou-heading {
                font-size: 26px;
            }

            .steps-box {
                padding: 20px 16px;
            }

            .btn-group-thankyou {
                flex-direction: column;
                width: 100%;
            }

            .btn-primary-thankyou,
            .btn-secondary-thankyou {
                width: 100%;
                justify-content: center;
            }

            .footer-inner {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MWSC2QQV"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Header / Navbar -->
    <header class="header">
        <div class="header-inner">
            <a href="<?= esc_url($campaignUrl) ?>">
                <img src="<?= $themeUri ?>/images/logo-opsole.svg" alt="Opsole Logo" class="brand-logo-img">
            </a>

            <nav>
                <ul class="nav-links">
                    <li><a href="<?= esc_url($campaignUrl) ?>#problem">The Problem</a></li>
                    <li><a href="<?= esc_url($campaignUrl) ?>#solution">Solution</a></li>
                    <li><a href="<?= esc_url($campaignUrl) ?>#metrics">Metrics</a></li>
                    <li><a href="<?= esc_url($campaignUrl) ?>#use-cases">Use Cases</a></li>
                    <li><a href="<?= esc_url($campaignUrl) ?>#security">Security</a></li>
                </ul>
            </nav>

            <div>
                <a href="<?= esc_url($campaignUrl) ?>#assessment" class="btn-demo-nav">Book a Demo</a>
            </div>
        </div>
    </header>

    <!-- Main Thank You Section -->
    <section class="thankyou-section">
        <div class="glow-circle-1"></div>
        <div class="glow-circle-2"></div>

        <div class="thankyou-container">
            <div class="thankyou-card">
                <div class="success-icon-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <div class="thankyou-badge">
                    <span class="thankyou-badge-text">✓ ASSESSMENT REQUEST RECEIVED</span>
                </div>

                <h1 class="thankyou-heading">
                    Thank You<?php if ($displayName): ?>, <span><?= $displayName ?></span><?php endif; ?>!
                </h1>

                <p class="thankyou-subtext">
                    Your request for a Zero-Wipe Entra ID Migration Assessment has been successfully received.
                    <?php if ($displayEmail): ?>
                        Our team will contact you shortly at <span class="user-email-highlight"><?= $displayEmail ?></span>.
                    <?php else: ?>
                        Our team will contact you shortly to schedule your personalized live demo.
                    <?php endif; ?>
                </p>

                <!-- Next Steps Box -->
                <div class="steps-box">
                    <div class="steps-header">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        What Happens Next?
                    </div>

                    <div class="steps-list">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-info">
                                <div class="step-title">Environment Readiness Review</div>
                                <div class="step-desc">Our migration engineers review your Active Directory and device fleet configuration.</div>
                            </div>
                        </div>

                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-info">
                                <div class="step-title">15-Minute Live Pilot Setup</div>
                                <div class="step-desc">We schedule a live demonstration showing in-place conversion without OS wipes.</div>
                            </div>
                        </div>

                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-info">
                                <div class="step-title">Custom Migration & ROI Plan</div>
                                <div class="step-desc">You receive a tailored roadmap detailing time savings and cost reduction metrics.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="btn-group-thankyou">
                    <a href="<?= esc_url($campaignUrl) ?>" class="btn-primary-thankyou">
                        Return to Campaign Page
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <a href="<?= esc_url($campaignUrl) ?>">
                <img src="<?= $themeUri ?>/images/logo-opsole.svg" alt="Opsole Logo" class="brand-logo-img" style="height:36px;">
            </a>

            <div class="footer-copyright">
                © 2026 Opsole Inc. All rights reserved. Microsoft and Entra ID are registered trademarks of Microsoft Corporation.
            </div>

            <div class="footer-links">
                <a href="https://opsole.com/privacy-policy/" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
                <a href="https://opsole.com/terms-of-use/" target="_blank" rel="noopener noreferrer">Terms of Service</a>
                <a href="#" target="_blank" rel="noopener noreferrer">Contact IT Support</a>
            </div>
        </div>
    </footer>

</body>

</html>
