import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Fix sliders display and flickity viewport overflow
content = content.replace('.slider-section, .slider, .carousel, .w-dyn-list {', '.slider-section, .slider, .carousel {')
content = content.replace('overflow-x: hidden !important;', '') # Strip all overflow-x hidden for sliders
content = content.replace('.flickity-viewport {\n            overflow: hidden !important;\n        }', '.flickity-viewport {\n            overflow: visible !important;\n        }')

# Ensure body and html are black to eliminate the white stripe
global_bg_fix = '''
    body, html, .main {
        background-color: #000000 !important;
    }
'''
if 'background-color: #000000 !important;' not in content:
    content = content.replace('/* RESPONSIVE TEXT & LAYOUT OPTIMIZATIONS FOR IPAD AND MOBILE */', '/* RESPONSIVE TEXT & LAYOUT OPTIMIZATIONS FOR IPAD AND MOBILE */' + global_bg_fix)

# Center texts
content = content.replace('text-align: left !important;', 'text-align: center !important;')

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Visuals fixed.")
