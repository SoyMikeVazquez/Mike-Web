import re

file_path = 'index.html'

with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# 1. Rearrange HTML: Move the hamburger menu button out of c-nav-items
# Original structure had it inside c-nav-items -> cloneable-area
nav_items_pattern = re.compile(r'(<div class="c-nav-items">.*?)(<div class="cloneable-area">.*?</div>.*?)(</div>)', re.DOTALL)
# Extract pieces
match = nav_items_pattern.search(content)
if match:
    desktop_links = match.group(1)
    cloneable_area = match.group(2)
    end_div = match.group(3)
    
    # New structure: Links first, then Cloneable Area (with button)
    # But wait, desktop_links already includes the opening <div class="c-nav-items">
    # The end_div is just </div>
    new_nav_structure = desktop_links + "</div>" + cloneable_area
    content = content.replace(match.group(0), new_nav_structure)

# 2. Fix CSS for Overlay
# Find the MOBILE OVERLAY FIX block and fix height
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

print("Final layout fix completed.")
