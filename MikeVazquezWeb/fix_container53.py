import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

aggressive_css_2 = '''
    @media screen and (max-width: 991px) {
        .container-53 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }
        .container-4 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }
        
        .container-53 > div, .container-4 > div {
            width: 100% !important;
            max-width: 100% !important;
            margin-bottom: 20px !important;
        }
    }
'''

content = content.replace('</style>', aggressive_css_2 + '\n</style>', 1)

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Container 53 layout fixed for mobile.")
