import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Fix overlaps in specific titles
slider_fix_css = """
        .heading {
            margin-bottom: 10px !important;
            font-size: 24px !important;
            text-align: center !important;
            display: block !important;
        }
        .heading-6 {
            line-height: 1.4 !important;
            font-size: 22px !important;
            text-align: center !important;
            margin-top: 15px !important;
            display: block !important;
        }
        .text-block {
            text-align: center !important;
        }
"""
content = content.replace('/* Fix overlaps in specific titles */', '/* Fix overlaps in specific titles */\n' + slider_fix_css)

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Slider overlap fixed.")
