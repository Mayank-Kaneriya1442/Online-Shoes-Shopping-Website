<?php
    // Set the timezone to India Standard Time
    date_default_timezone_set('Asia/Kolkata');
?>

<style>
    /* --- Google Font & Global Styles --- */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap');

    :root {
        --footer-bg: #1a1a1a; /* Matches primary-dark */
        --footer-text: #b3b3b3;
        --footer-heading: #ffffff;
        --brand-accent: #c0392b; /* Matches accent-red */
        --brand-accent-hover: #a93226;
        --border-color: #333;
    }

    /* --- Main Footer Container --- */
    .site-footer {
        background-color: var(--footer-bg);
        color: var(--footer-text);
        padding: 80px 0 30px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        line-height: 1.7;
        position: relative;
        overflow: hidden;
    }

    .container-footer {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* --- 4-Column Grid Layout --- */
    .footer-main {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        padding-bottom: 50px;
        margin-bottom: 30px;
        border-bottom: 1px solid var(--border-color);
    }

    .footer-column h3 {
        color: var(--footer-heading);
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 25px;
        position: relative;
        display: inline-block;
    }
    
    /* Animation for heading underline */
    .footer-column h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -8px;
        width: 30px;
        height: 2px;
        background-color: var(--brand-accent);
        transition: width 0.3s ease;
    }
    
    .footer-column:hover h3::after {
        width: 50px;
    }

    .footer-column p {
        margin-bottom: 20px;
    }

    .footer-column ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-column li {
        margin-bottom: 12px;
    }

    .footer-column a {
        color: var(--footer-text);
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
        position: relative;
    }

    .footer-column a:hover {
        color: var(--brand-accent);
        transform: translateX(5px);
    }

    /* --- Newsletter Form Styling --- */
    .newsletter-form {
        display: flex;
        border-radius: 30px;
        overflow: hidden;
        background: #252525;
        padding: 5px;
        border: 1px solid transparent;
        transition: border-color 0.3s;
    }
    
    .newsletter-form:focus-within {
        border-color: var(--brand-accent);
    }

    .newsletter-form input {
        flex-grow: 1;
        border: none;
        background-color: transparent;
        color: var(--footer-heading);
        padding: 10px 15px;
        outline: none;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
    }

    .newsletter-form button {
        background-color: var(--brand-accent);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .newsletter-form button:hover {
        background-color: var(--brand-accent-hover);
        transform: scale(1.05);
    }

    /* --- Social Media Icons --- */
    .social-links {
        display: flex;
        gap: 15px;
        margin-top: 25px;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        
    }

    .social-link-item {
        width: 40px;
        height: 40px;
        background: #252525;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .social-link-item svg {
        width: 18px;
        height: 18px;
        fill: var(--footer-text);
        transition: fill 0.3s ease;
    }

    .social-link-item:hover {
        background-color: var(--brand-accent);
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(192, 57, 43, 0.3);
    }

    .social-link-item:hover svg {
        fill: #fff;
    }

    /* --- Bottom Bar --- */
    .footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        padding-top: 20px;
    }
    
    .footer-bottom .copyright {
        margin: 0;
        font-size: 13px;
    }

    .footer-legal {
        display: flex;
        gap: 20px;
    }

    .footer-legal a {
        color: var(--footer-text);
        text-decoration: none;
        font-size: 13px;
        transition: color 0.3s ease;
    }

    .footer-legal a:hover {
        color: var(--brand-accent);
        text-decoration: underline;
    }
    
    /* --- Brand Logo in Footer --- */
    .footer-brand {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        color: #fff;
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        font-weight: 700;
    }
    
    .footer-brand svg {
        margin-right: 10px;
    }

    /* --- Responsive Design --- */
    @media (max-width: 768px) {
        .footer-main {
            grid-template-columns: 1fr;
            text-align: center;
        }
        
        .footer-column h3::after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .footer-brand {
            justify-content: center;
        }
        
        .social-links {
            justify-content: center;
        }
        
        .footer-bottom {
            flex-direction: column-reverse;
            text-align: center;
        }
        
        .footer-legal {
            justify-content: center;
        }
    }
</style>

<footer class="site-footer">
    <div class="container-footer">
        <div class="footer-main">
            <!-- Column 1: Brand & About -->
            <div class="footer-column">
                <div class="footer-brand">
                    <svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="12" fill="#c0392b"/>
                        <path d="M11 22.5C11 22.5 13 27.5 19 27.5C25 27.5 29 20 29 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13 17.5C13 17.5 17 12.5 23 12.5C29 12.5 29 15 29 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11 22.5L29 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    SoleStyle
                </div>
                <p>Elevating your steps with premium footwear designed for comfort and style. Walk the talk with SoleStyle.</p>
             
            </div>

            <!-- Column 2: Shop -->
            <div class="footer-column">
                <h3>Shop</h3>
                <ul>
                    <li><a href="men_sneaker.php">Men's Collection</a></li>
                    <li><a href="women_sneaker.php">Women's Collection</a></li>
                    <li><a href="children_clog.php">Kids' Zone</a></li>
                    <li><a href="men_walking_shoes.php">Sale & Offers</a></li>
                    <li><a href="new_arrivals.php">New Arrivals</a></li>
                </ul>
            </div>

            <!-- Column 3: Support -->
            <div class="footer-column">
                <h3>Support</h3>
                <ul>
                    <li><a href="contact_us.php">Contact Us</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="clientsideorder.php">Track Order</a></li>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Returns & Exchange</a></li>
                </ul>
            </div>

            <!-- Column 4: Newsletter -->
            <div class="footer-column">
                <h3>Newsletter</h3>
                <p>Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.</p>
                <form class="newsletter-form" action="#" method="post">
                    <input type="email" name="email" placeholder="Your email address" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <p class="copyright">&copy; <?php echo date("Y"); ?> SoleStyle. All rights reserved.</p>
            <div class="footer-legal">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>
