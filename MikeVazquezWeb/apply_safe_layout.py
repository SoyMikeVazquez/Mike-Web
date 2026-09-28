import re

file_path = 'index.html'

with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Fix CSS for Overlay
overlay_fix = '''.c-nav-menu-overlay {
        position: fixed !important;
        top: 0; left: 0; width: 100%; height: 100vh !important;
        background: black !important;
        z-index: 10000 !important;
        display: none;
        overflow-y: auto !important;
        padding-top: 100px !important;
    }
    .c-nav-menu-content {
        height: auto !important;
        display: block !important;
    }'''

content = re.sub(r'\.c-nav-menu-overlay \{.*?\}', overlay_fix, content, flags=re.DOTALL)

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Layout fix applied safely.")
