import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Define exactly where my added CSS starts and ends
start_marker = "/* RESPONSIVE TEXT & LAYOUT OPTIMIZATIONS FOR IPAD AND MOBILE */"
end_marker = "</style>"

start_idx = content.find(start_marker)
end_idx = content.rfind(end_marker)

if start_idx != -1 and end_idx != -1:
    content_before = content[:start_idx]
    
    clean_mobile_css = """/* RESPONSIVE TEXT & LAYOUT OPTIMIZATIONS FOR IPAD AND MOBILE */
    @media screen and (max-width: 991px) {
        /* Fix Horizontal Overflow */
        body, html, .main {
            overflow-x: hidden !important;
            width: 100% !important;
            max-width: 100vw !important;
            background-color: #000 !important;
        }
        * {
            box-sizing: border-box !important;
        }
        
        /* Navigation Bar un-fix */
        .c-nav {
            position: relative !important;
            background-color: #000 !important;
            height: auto !important;
            padding: 15px 0 !important;
        }
        .c-nav-content {
            display: flex !important;
            flex-direction: row !important;
            justify-content: center !important;
            position: relative !important;
        }
        .c-nav-logo, .c-nav-logo-link {
            display: flex !important;
            justify-content: center !important;
            margin: 0 auto !important;
            width: 100% !important;
            z-index: 1 !important;
        }
        .c-nav-logo-link img {
            max-width: 140px !important;
            height: auto !important;
        }
        .c-nav-menu-btn {
            display: flex !important;
            position: absolute !important;
            right: 20px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            z-index: 9999 !important;
            width: 40px !important;
            height: 40px !important;
        }
        .c-nav-items { display: none !important; }

        /* Force stacking for all major rows */
        .w-row, .container-53 > div, .container-4 > div {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }
        .w-col {
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-bottom: 25px !important;
        }

        /* Un-stack sliders */
        .slider-section .w-row, .slick-slider .w-row, .slick-track {
            flex-direction: row !important;
            justify-content: flex-start !important;
            align-items: stretch !important;
        }
        .slick-slide {
            display: block !important;
            float: left !important;
            text-align: center !important;
        }
        
        /* Centering specific text classes */
        .subtitlu-sectiune, .subtitlu-sectiune.home1, .subtitlu-sectiune.home4, .subtitlu-sectiune.home1.white {
            text-align: center !important;
            width: 100% !important;
            margin: 20px auto !important;
            display: block !important;
        }
        .div-block-227, .div-block-228, .wrapper-3, .wrapper-3.home, .wrapper-3.home1 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            width: 100% !important;
            margin: 0 auto !important;
            padding: 0 15px !important;
        }
        
        .despre-text.home1-copy, .despre-text.home, .heading-9, .paragraph-5, .text-block-26, .text-block-25, .heading-13 {
            text-align: center !important;
            width: 100% !important;
            max-width: 100% !important;
            white-space: normal !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        .despre-text.home1-copy {
            font-size: 26px !important;
            line-height: 1.3 !important;
            padding: 0 10px !important;
        }

        /* Sliders text overlap */
        .w-dyn-item {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .div-block-225 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            width: 100% !important;
            margin: 0 auto !important;
            position: relative;
            z-index: 2;
        }
        .div-block-226 {
            text-align: center !important;
            margin: 0 auto !important;
            position: relative;
            z-index: 2;
        }
        .div-block-225 .heading {
            font-size: 24px !important;
            margin-bottom: 5px !important;
            text-align: center !important;
            display: block !important;
        }
        .div-block-225 .heading-6 {
            font-size: 22px !important;
            margin-top: 5px !important;
            text-align: center !important;
            display: block !important;
        }

        /* "Que esperaras si trabajas conmigo" */
        .div-block-19, .div-block-20, .nr-articol, .div-block-23 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            width: 100% !important;
            margin: 0 auto !important;
            padding: 5px 0 !important;
        }
        .text-block-7, .text-block-10, .text-block-9, .text-block-8 {
            text-align: center !important;
            display: block !important;
            margin: 0 auto !important;
        }

        /* Footer elements */
        .heading-5, .text-block-12, .nav-social-address {
            text-align: center !important;
            display: block !important;
            margin: 0 auto 10px auto !important;
        }

        /* Buttons */
        .button, .btn, .link-buton {
            text-align: center !important;
            margin: 0 auto !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }
        
    }
"""
    new_content = content_before + clean_mobile_css + "\n</style>"
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(new_content)
    print("Clean rewrite applied.")
else:
    print("Failed to find boundaries.")
