import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Remove the block I just added (FINAL STABLE MOBILE FIX)
content = re.sub(r'/\* FINAL STABLE MOBILE FIX \*/.*?\}\s*\}', '', content, flags=re.DOTALL)

# Also remove any leftover style tags I might have injected
content = content.replace('<style></style>', '')

# Define a truly robust mobile block
robust_mobile_css = """
    /* ROBUST MOBILE RECONSTRUCTION */
    @media screen and (max-width: 991px) {
        /* 1. Global Reset - Kill horizontal scroll and force verticality */
        body, html, .main {
            overflow-x: hidden !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        * { box-sizing: border-box !important; }

        /* 2. Hero Section (Overlap & Centering Fix) */
        .section-13.home {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: flex-start !important;
            padding-top: 120px !important; /* Give space for nav */
            padding-bottom: 60px !important;
            height: auto !important;
            min-height: 100vh !important;
            position: relative !important;
        }
        .div-block-229.home {
            position: relative !important;
            top: 0 !important;
            left: 0 !important;
            transform: none !important;
            width: 100% !important;
            max-width: 90% !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            margin: 0 auto !important;
            z-index: 5 !important;
        }
        .despre-text.home1-copy {
            font-size: 26px !important;
            line-height: 1.3 !important;
            margin: 0 0 30px 0 !important;
            width: 100% !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        .button-3 {
            margin-bottom: 40px !important;
        }
        .div-block-234 {
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            margin: 0 !important;
        }
        .subtitlu-sectiune.home1.white {
            font-size: 13px !important;
            margin: 0 0 20px 0 !important;
            width: 100% !important;
            text-align: center !important;
        }
        .text-mijloc.div-block-219._2-copy {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            width: 100% !important;
            margin: 0 !important;
        }
        .text.buton-copy.dd {
            margin-bottom: 10px !important;
        }

        /* 3. Solutions Section (Alignment Fix) */
        .demo_header {
            padding: 60px 20px !important;
            width: 100% !important;
        }
        .wrapper-3.home {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            width: 100% !important;
            margin: 0 !important;
        }
        .div-block-227, .despre-text.home {
            width: 100% !important;
            max-width: 100% !important;
            text-align: center !important;
            margin: 0 0 20px 0 !important;
            font-size: 22px !important;
        }
        .div-block-228 {
            width: 100% !important;
            max-width: 100% !important;
            text-align: center !important;
            margin: 0 auto !important;
            font-size: 16px !important;
            line-height: 1.6 !important;
        }

        /* 4. Global Block Reordering (Kill all horizontal shifts) */
        .w-row {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            margin: 0 !important;
        }
        .w-col {
            width: 100% !important;
            padding: 0 10px !important;
            margin-bottom: 30px !important;
        }
        
        /* 5. Slider Improvements */
        .div-block-225, .div-block-226 {
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
        }
        .heading { margin-bottom: 5px !important; }
        .heading-6 { margin-bottom: 15px !important; }
        
        /* 6. Navigation Bar Un-overlap */
        .c-nav {
            background-color: #000 !important;
            padding: 10px 0 !important;
        }
    }
"""

content = content.replace('</head>', '<style>' + robust_mobile_css + '</style></head>')

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Applied V2 of robust mobile reconstruction.")
