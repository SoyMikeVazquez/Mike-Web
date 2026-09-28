import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Fix the white strip by only setting body, html background, not .main
content = content.replace('body, html, .main {\n        background-color: #000000 !important;', 'body, html {\n        background-color: #000000 !important;')

# Specifically target the slider to re-enable horizontal flow and fix slick
slider_fix_css = """
        /* REVERT VERTICAL STACKING FOR SLIDERS */
        .slider-section .w-row, .slick-slider .w-row, .slick-track {
            flex-direction: row !important;
        }
        .slick-slide {
            display: inline-block !important;
            float: none !important;
        }
        .slick-track {
            display: flex !important;
        }
        /* Fix overlaps in specific titles */
        .text-block-25 {
            margin-bottom: 20px !important;
        }
"""
content = content.replace('/* BUTTONS & OTHERS */', slider_fix_css + '\n        /* BUTTONS & OTHERS */')

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Slider layout and black text over black background fixed safely.")
