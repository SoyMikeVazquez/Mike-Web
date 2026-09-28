import sys

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# I will find the very first marker where I started messing up.
marker_1 = "/* RESPONSIVE TEXT & LAYOUT OPTIMIZATIONS FOR IPAD AND MOBILE */"
marker_2 = "/* SAFE AND MINIMAL RESPONSIVE OPTIMIZATIONS FOR IPAD AND MOBILE */"

idx = -1
if marker_2 in content:
    idx = content.find(marker_2)
elif marker_1 in content:
    idx = content.find(marker_1)

if idx != -1:
    end_marker = "</style>"
    end_idx = content.rfind(end_marker)
    
    clean_css = """    /* FIXES FOR MOBILE (MINIMAL AND SAFE) */
    @media screen and (max-width: 991px) {
        body, html {
            background-color: #000 !important;
        }
        
        /* Force vertical layout for main sections but keep sliders row */
        .w-row {
            display: flex !important;
            flex-direction: column !important;
        }
        .slider-section .w-row {
            flex-direction: row !important;
        }
        
        .w-col {
            width: 100% !important;
        }

        /* Center texts */
        .heading-6, .heading-9, .paragraph-5, .text-block-26, .text-block-25 {
            text-align: center !important;
        }
        .despre-text {
            text-align: center !important;
            margin: 0 auto !important;
            display: block !important;
        }

        .div-block-225, .div-block-226 {
            text-align: center !important;
        }
        
        .c-nav-logo {
            margin: 0 auto !important;
        }
    }
"""
    new_content = content[:idx] + clean_css + "\n" + content[end_idx:]
    with open(file_path, 'w', encoding='utf-8') as file:
        file.write(new_content)
    print("Reset cleanly applied.")
else:
    print("Markers not found.")
