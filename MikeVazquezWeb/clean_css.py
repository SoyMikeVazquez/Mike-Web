import sys

file_path = '/Users/mikevaz/Documents/Apps/Web mike/MikeVazquezWeb/index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

start_marker = "/* RESPONSIVE TEXT & LAYOUT OPTIMIZATIONS FOR IPAD AND MOBILE */"
end_marker = "</style>"
start_idx = content.find(start_marker)
end_idx = content.rfind(end_marker)

safe_mobile_css = """/* SAFE AND MINIMAL RESPONSIVE OPTIMIZATIONS FOR IPAD AND MOBILE */
    @media screen and (max-width: 991px) {
        /* Fix horizontal scroll only without disrupting flex layouts */
        body, html, .main {
            overflow-x: hidden !important;
            max-width: 100vw !important;
        }

        /* Navigation Bar un-fix: Prevent Logo from overlapping Hero */
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
        
        /* Force 'Ultimos Proyectos' to stack vertically on mobile as the user approved */
        .container-53 > div, .container-4 > div {
            display: flex !important;
            flex-direction: column !important;
            margin-bottom: 25px !important;
            width: 100% !important;
        }
    }
"""

if start_idx != -1 and end_idx != -1:
    new_content = content[:start_idx] + safe_mobile_css + "\n" + content[end_idx:]
    with open(file_path, 'w', encoding='utf-8') as file:
        file.write(new_content)
    print("Safely stripped buggy CSS overloads!")
else:
    print("Markers not found.")
